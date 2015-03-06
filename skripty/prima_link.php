<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.stream.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

$link = $_GET["link"];


echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>PRIMA TV</title>";

	$t1 = explode('<meta name="title" content="', $html);
    $t2 = explode('-', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<link rel="image_src" href="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<meta name="description" content="', $html);
    $t2 = explode('"', $t1[1]);
    $popis = $t2[0];
	
		
	$t1 = explode('<div id="video_popisek">', $html);
    $t2 = explode('-', $t1[1]);
    $datum = $t2[0];
	
   $t1 = explode('&cdnHQ=', $html);
   $t2 = explode('&', $t1[1]);
   $hq = $t2[0];
   
   $t1 = explode('&cdnLQ=', $html);
   $t2 = explode('&', $t1[1]);
   $lq = $t2[0];
   
   $t1 = explode('&cdnHD=', $html);
   $t2 = explode('&', $t1[1]);
   $hd = $t2[0];
   
   
   IF ($hd!="") {
	$lhd = "http://cdn-dispatcher.stream.cz/getSource?id=".$hd."&proto=rtmp";
	if (($html2 = openpage($lhd) ) != FALSE) {
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
		$ItemsOut .= "
			<item>
				<title>Přehrát v HD kvalitě</title>
				<link>http://".$server."/".$cesta."</link>
				<enclosure type=\"video/mp4\" url=\"http://".$server."/".$cesta."\" />
				<pubDate>".$datum."</pubDate>
				<description>Popis:".$popis."</description>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}
	IF ($hq!="") {
	$lhq = "http://cdn-dispatcher.stream.cz/getSource?id=".$hq."&proto=rtmp";
	if (($html2 = openpage($lhq) ) != FALSE) {
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
	
		$ItemsOut .= "
			<item>
				<title>Přehrát v HQ kvalitě</title>
				<link>http://".$server."/".$cesta."</link>
				<enclosure type=\"video/mp4\" url=\"http://".$server."/".$cesta."\" />
				<pubDate>".$datum."</pubDate>
				<description>Popis:".$popis."</description>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}
	IF ($lq!="") {
	$llq = "http://cdn-dispatcher.stream.cz/getSource?id=".$lq."&proto=rtmp";
	if (($html2 = openpage($llq) ) != FALSE) {
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
	
		$ItemsOut .= "
			<item>
				<title>Přehrát v LQ kvalitě</title>
				<link>http://".$server."/".$cesta."</link>
				<enclosure type=\"video/flv\" url=\"http://".$server."/".$cesta."\" />
				<pubDate>".$datum."</pubDate>
				<description>Popis:".$popis."</description>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}
	
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>