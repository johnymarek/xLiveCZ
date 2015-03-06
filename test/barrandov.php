<?php
require_once ("./include/browseremulator.class.php");
// ###############################################################
// ##                                                           ##
// ##   http://sites.google.com/site/pavelbaco/                 ##
// ##   Copyright (C) 2012  Pavel Bačo   (killerman)            ##
// ##                                                           ##
// ###############################################################
function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.barrandov.tv");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

echo "<?xml version='1.0' ?>\n";
$DIR_SCRIPT_ROOT  = current(explode('xLiveCZ/', dirname(__FILE__).'/')).'xLiveCZ/';
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$URL = "http://www.barrandov.tv/video";

if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>Barrandov archiv</title>";
	
	$videos = explode('<div class="genreDetail">', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {


    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.barrandov.tv".$t2[0];
		
    
    $t1 = explode('<h3>', $video);
    $t2 = explode('</h3>', $t1[1]);
    $titulek = $t2[0]; 
	
	IF ( $titulek != "Mayové léto"){
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$HTTP_SCRIPT_ROOT."xLiveCZ/category/barrandov/barrandov_parser.php?query=1,".$link."</link>
			</item>\n";
  	
	}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>