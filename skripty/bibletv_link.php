<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.joj.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $URL = $queryArr[0];
   $casti = $queryArr[1];
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

    
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>BibleTV archiv</title>";
	
	//zjisteni zda je vice casti videa
	$t1 = explode('<div class="box-item first">', $html);
    $t2 = explode('<h2 class="title">', $t1[1]);
	$t3 = explode('</h2>', $t2[1]);
    $vice_casti = $t3[0];
    
	IF (($vice_casti=="Další části")AND($casti!="1")){
	
	$link = $URL;
	
	$t1 = explode('<h2>', $html);
    $t2 = explode('</h2>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode("'image': '/", $html);
    $t2 = explode("'", $t1[1]);
    $nahled = "http://www.bibletv.cz".$t2[0];
	
	$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/bibletv_link.php?query=".$link.",1</link>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	
	$t1 = explode('<div class="box-item first">', $html);
    $t2 = explode('<div class="box-item second">', $t1[1]);
    $pom = $t2[0];
	
	$videos = explode('<a class="left" ', $pom);
  
	unset($videos[0]);

	$videos = array_values($videos);

	foreach($videos as $video) {
	
	$t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.bibletv.cz".$t2[0];
	
	$t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.bibletv.cz".$t2[0];
	
	$t1 = explode('<span>', $video);
    $t2 = explode('</span>', $t1[1]);
    $datum = $t2[0];


	$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/bibletv_link.php?query=".$link.",1</link>
				<media:thumbnail url='".$nahled."' />
				<pubDate>".$datum."</pubDate>
			</item>\n";
    	}}
	
	ELSE{
	$t1 = explode('<h2>', $html);
    $t2 = explode('</h2>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode("'image': '", $html);
    $t2 = explode("',", $t1[1]);
    $nahled = "http://www.bibletv.cz".$t2[0];
	
	$t1 = explode('<h3>Informace o akci</h3><div class="strip-par">', $html);
    $t2 = explode('<!-- FOTO -->', $t1[1]);
    $pom = $t2[0];

	$videos = explode('<a href', $html);
	
unset($videos[0]);

$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode('="', $video);
    $t2 = explode('"', $t1[1]);
    $link_final = "http://www.bibletv.cz".$t2[0];
	
	$t1 = explode('<span class="desc">(kvalita: ', $video);
    $t2 = explode(',', $t1[1]);
    $kvalita = $t2[0];
	
    $hledej = ".mp3";
	$pos = strpos($link_final, $hledej);
	
	//print_r($html);
	
	
	
		
	if ($pos === false) {
		IF ($kvalita!=""){
			$ItemsOut .= "
			<item>
				<title>".$titulek."-".$kvalita."</title>
				<link>".$link_final."</link>
				<media:thumbnail url='".$nahled."' />
				<pubDate>".$kvalita."</pubDate>
				<enclosure type=\"video/mp4\" url=\"".$link_final."\" />
			</item>\n";
    	}}}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>