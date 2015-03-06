<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.muvi.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
//$link= $_GET["link"];
$URL = "http://www.muvi.cz/porady/vsechny";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Muvi.cz</title>";

	
	$videos = explode('<div class="item_2col">', $html);
    
	unset($videos[0]);
		
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.muvi.cz".$t2[0];
	
    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.muvi.cz".$t2[0];
	//
	 /*IF ($titulek != ("") AND $link != ("http://www.muvi.cz/zmena-je-zivot/")AND $link != ("http://www.muvi.cz/muvi-promeny/")AND $link != ("http://www.muvi.cz/samerova-seznamka/")AND $link != ("http://www.muvi.cz/digit/")
	 AND $link != ("http://www.muvi.cz/vari-savi/")AND $link != ("http://www.muvi.cz/mame-radi-zvirata/")AND $link != ("http://www.muvi.cz/duel/")AND $link != ("http://www.muvi.cz/")AND $link != ("http://www.muvi.cz/aerokratas-2010/")){  */
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/muvi_parser.php?query=1,".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
    	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>