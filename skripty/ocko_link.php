<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://ocko.tv");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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

    $t1 = explode('<div class="nettv-archive-video">', $html);
    $t2 = explode('preload="none"', $t1[1]);
    $pom = $t2[0];
	
	
    $t1 = explode('src="', $pom);
    $t2 = explode('"', $t1[1]);
    $lnk = "http://ocko.tv/".$t2[0];


	print $lnk;
	die();
	}
?>