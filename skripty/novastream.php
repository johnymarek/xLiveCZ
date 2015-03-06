<?php
require_once ("./include/browseremulator.class.php");
// ###############################################################
// ##                                                           ##
// ##   http://sites.google.com/site/pavelbaco/                 ##
// ##   Copyright (C) 2012  Pavel Baèo   (killerman)            ##
// ##                                                           ##
// ###############################################################
function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://testtbj.mzf.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$DIR_SCRIPT_ROOT  = current(explode('xLiveCZ/', dirname(__FILE__).'/')).'xLiveCZ/';
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
$URL = $_GET["file"];

if (($html = openpage($URL) ) != FALSE) {

    $t1 = explode('<a href="', $html);
    $t2 = explode('"', $t1[1]);
    $final = $HTTP_SCRIPT_ROOT."xLiveCZ/msdl.sh?type=test&amp;url=".$t2[0];
 	
}
print $final;
?>