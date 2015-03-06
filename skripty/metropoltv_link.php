<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.metropol.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query=$_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $URL = $queryArr[0];
   $disk = $queryArr[1];
}
if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>Metropol TV</title>";
		
	$t1 = explode('file: "', $html);
	$t2 = explode('"', $t1[1]);
	//$link = "mp4:".$t2[0];
	$link = $t2[0];
	
	/*$t1 = explode('streamer: "', $html);
	$t2 = explode('"', $t1[1]);
	$rtmp = $t2[0];*/

	//print $disk."xLiveCZ/nova.sh?type=metropol&url=".$rtmp."&y=".$link."&p=".$URL."&w=http://www.metropol.cz/public/jwplayer/player.swf";
	print "http://www.metropol.cz/public/video/".$link;
	die();
	}
?>