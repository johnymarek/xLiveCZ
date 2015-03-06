<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://tv.nova.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
// ###############################################################
// ##                                                           ##
// ##   Copyright (C) 2011  Pavel Bačo (killerman)              ##
// ##                                                           ##
// ###############################################################
$link = $_GET["file"];

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>NOVA Archiv</title>";

  	$t1 = explode('mainVideo = new mediaData(', $html);
    $t2 = explode(',', $t1[1]);
    $Media_ID = $t2[2];
	
	$original=time($date);//jsem lama a neprisel jsem na to jak udelat pozadovany timestamp aktualni v potrebne podobe: $hr  = 2; -letni cas $hr  = 1; - zimni cas
	$hr  = 0;
	$min = 0;
	$sec = 0;
	$modified = $original+$sec+($min*60)+($hr*60*60);
	$Timestamp = date("YmdHis",$modified);
	$NOVA_APP_ID = 'nova-vod';
	$NOVA_SERVICE_URL = 'http://master-ng.nacevi.cz/cdn.server/PlayerLink.ashx';
	$ID = urlencode($NOVA_APP_ID.'|'.$Media_ID);
	$Secret = 'tajne.heslo';
	$data = ($NOVA_APP_ID.'|'.$Media_ID.'|'.$Timestamp.'|'.$Secret);
	$Signature = urlencode(base64_encode(md5($data, $raw_output = true )));
	$Url = $NOVA_SERVICE_URL."?t=".$Timestamp."&c=".$ID."&h=0&d=1&s=".$Signature."&tm=nova";
	
	if (($html_new = openpage($Url) ) != FALSE) {
	
	$t1 = explode('<baseUrl>', $html_new);
    $t2 = explode('</baseUrl>', $t1[1]);
    $baseUrl = $t2[0];
	
	$t1 = explode('<url>mp4:', $html_new);
    $t2 = explode('</url>', $t1[1]);
    $playpath = "mp4:".$t2[0];
	
	$url = $baseUrl."/".$playpath;
	
	IF ($quality=="flv") {
						}
		ELSE 
		$ItemsOut .= "
			<item>
				<title>Přehrát v HQ</title>
				<link>http://127.0.0.1/cgi-bin/play.cgi?type=mp4nova&amp;url=".$url."&amp;y=".$playpath."</link>
				<enclosure type=\"video/mp4\" url=\"http://127.0.0.1/cgi-bin/play.cgi?type=mp4nova&amp;url=".$url."&amp;y=".$playpath."\"/>
			</item>\n";
    	
	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>