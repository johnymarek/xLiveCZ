<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.zzip.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$link= $_GET["link"];
$URL = "http://www.zzip.cz/?loadsec=".$link;

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Olomouc a Prostějov</title>";

	
	$videos1 = explode('<div id="page">', $html);
	    
	unset($videos1[0]);
	$videos = explode('<a href', $videos1[1]);
	
	$videos = array_values($videos);
//print_r($videos);
	foreach($videos as $video) {

    
	
    $t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('="', $video);
    $t2 = explode('"', $t1[1]);
    $lnk = "http://www.zzip.cz/".$t2[0];
	$link = str_ireplace(array("&amp;"), array("&"), $lnk);
	
	if (($html = openpage($link) ) != FALSE) {

	$t1 = explode("var flashvars = { file:'", $html);
    $t2 = explode("'", $t1[1]);
    $link1 = "http://www.zzip.cz".$t2[0];
	$link2 = str_ireplace(array(" "), array("%20"), $link1);
	
	if (($titulek != "")AND($link2 != "http://www.zzip.cz")){    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link2."</link>
				<enclosure type=\"video/flv\" url=\"".$link2."\"/>
			</item>\n";
    
	}}}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>