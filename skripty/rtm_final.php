<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.mojevideo.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$URL = $_GET["link"];
    
if (($html = openpage($URL) ) != FALSE) {

    $t1 = explode('<script type="text/javascript" src="flowplayer-3.2.4.min.js"></script>', $html);
    $t2 = explode('<script type="text/javascript">', $t1[1]);
    $pom = $t2[0];
	
    $t1 = explode('<a href="', $pom);
    $t2 = explode('"', $t1[1]);
    $lnk = $t2[0];
	
	IF 	($lnk=="")	{
	$t1 = explode('<embed id="player01"', $html);
     $t2 = explode('src="', $t1[1]);
	$t3 = explode('"', $t2[1]);
    $lnk = str_replace(" ","%20",$t3[0]);}
	
	print $lnk;
	die();
	}
?>