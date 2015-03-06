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
$link = $_GET["file"];

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>NOVA Archiv</title>";

    $t1 = explode('media_id = "', $html);
    $t2 = explode('"', $t1[1]);
    $mediaid = $t2[0];
	
	$t1 = explode('site_id = ', $html);
    $t2 = explode(';', $t1[1]);
    $siteid = $t2[0];
	
	$config = "http://tn.nova.cz/bin/player/serve.php?media_id=".$mediaid."&site_id=".$siteid;
	if (($html = openpage($config) ) != FALSE) {
	
	$t1 = explode('src="', $html);
    $t2 = explode('"', $t1[1]);
    $videosrc = $t2[0];
	
	$t1 = explode('server="', $html);
    $t2 = explode('"', $t1[1]);
    $videoserver = $t2[0];
	
	$urlhq = "rtmp://flash".$videoserver.".nova.nacevi.cz:80/vod?slist=mp4:".$videosrc;
	    
			$ItemsOut .= "
			<item>
				<title>Přehrát</title>
				<link>http://127.0.0.1/nova.sh?url=".$urlhq."</link>
				<enclosure type=\"video/mp4\" url=\"http://127.0.0.1/nova.sh?url=".$urlhq."\"/>
				
			</item>\n";
    	
	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>