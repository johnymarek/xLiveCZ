<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.b-tv.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
//$link = $_GET["file"];
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $link = $queryArr[0];
   $datum = $queryArr[1];
   
}   
	
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";


if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Brno TV</title>";

	
	$t1 = explode('<h2 class="bordered-title red-title"><span>', $html);
    $t2 = explode('</span></h2>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('&image=', $html);
    $t2 = explode('&', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('http://www.b-tv.cz/', $link);
    $t2 = explode(',', $t1[1]);
    $pom = $t2[0];
	

    $t1 = explode('"flashvars","file=', $html);
    $t2 = explode('&', $t1[2]);
    $link1 = $t2[0];
	
	$find = ".flv";
	$string = strpos($link1, $find);
	
	//print_r($html);
	
	if ($string === false) {
    	
	$t1 = explode('"flashvars","file=', $html);
    $t2 = explode('"', $t1[2]);
    $pom2 = $t2[0];
	
	
	if (($html = openpage($pom2) ) != FALSE) {
	
	$videos = explode('<track>', $html);
  
	unset($videos[0]);
	foreach($videos as $video) {
	$t1 = explode('<title>', $video);
    $t2 = explode('</title>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<annotation>', $video);
    $t2 = explode('</annotation>', $t1[1]);
    $popis = $t2[0];
	
	$t1 = explode('<image>', $video);
    $t2 = explode('</image>', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<location>', $video);
    $t2 = explode('</location>', $t1[1]);
    $link1 = $t2[0];
	
	$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link1."</link>
				<media:thumbnail url=\"http://www.b-tv.cz".$nahled."\" />
				<pubDate>".$datum."</pubDate>
				<description>".$popis."</description>
				<enclosure type=\"video/flv\" url=\"".$link1."\"/>
			</item>\n";
	
	}}}
	
	ELSE {
	$t1 = explode($pom, $html);
	$t2 = explode('</p></span>', $t1[2]);
    $popis1 = $t2[0];
	
    $t1 = explode('<span class="small"><p>', $popis1);
	$t2 = explode('.', $t1[1]);
    $popis = $t2[0];
	
	
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link1."</link>
				<media:thumbnail url=\"http://www.b-tv.cz".$nahled."\" />
				<pubDate>".$datum."</pubDate>
				<description>".$popis."</description>
				<enclosure type=\"video/flv\" url=\"".$link1."\"/>
			</item>\n";
			
	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>