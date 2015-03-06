<?php
// ###############################################################
// ##                                                           ##
// ##   http://sites.google.com/site/pavelbaco/                 ##
// ##   Copyright (C) 2012  Pavel Baèo   (killerman)            ##
// ##                                                           ##
// ###############################################################
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.tvmedicina.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

$link = $_GET["link"];
if (($html = openpage($link) ) != FALSE) {
  
    $t1 = explode("so.addVariable('hd.file','", $html);
    $t2 = explode("'", $t1[1]);
    $server = $t2[0];
	
	$t1 = explode('sessvars.movie="', $html);
    $t2 = explode('"', $t1[1]);
    $file = $t2[0];
	
    $link = $server.$file."_hq.mp4";

print $link;
die();
}
?>