<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.hejbejse.tv");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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

    $t1 = explode('url: "', $html);
    $t2 = explode('"', $t1[1]);
    $lnk = $t2[0];
	print "http://127.0.0.1/media/sda1/scripts/xLiveCZ/msdl.sh?type=test&url=".$lnk;
	die();
	}
?>