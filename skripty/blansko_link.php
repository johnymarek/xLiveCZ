<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.blansko.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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

    $t1 = explode('<script type="text/javascript" src="/js/flowplayer/flowplayer.min.js"></script>', $html);
    $t2 = explode('flowplayer', $t1[1]);
    $pom = $t2[0];
	 
    $t1 = explode('<a href="', $pom);
    $t2 = explode('"', $t1[1]);
	$link = "http://www.blansko.cz".$t2[0];

	print $link;
	die();
	}
?>