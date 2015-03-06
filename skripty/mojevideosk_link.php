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

    $t1 = explode('plv', $html);
    $t2 = explode(');', $t1[1]);
    $pom = $t2[0];
	$t1 = explode(',', $pom);
	$ishd = $t1[10];
 
    $t1 = explode('var rvid=', $html);
    $t2 = explode(';', $t1[1]);
	IF ($ishd == "2") {$id = "http://fs5.mojevideo.sk/videos/".$t2[0]."_hd.mp4";}
	ELSE {$id = "http://fs5.mojevideo.sk/videos/".$t2[0].".mp4";}

	print $id;
	die();
	}
?>