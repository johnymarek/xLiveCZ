<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.markiza.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$link = $_GET["file"];

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Markiza Archiv</title>";

    $t1 = explode("playlist: '", $html);
    $t2 = explode("'", $t1[1]);
    $config = "http://www.markiza.sk".$t2[0];
			
	if (($html = openpage($config) ) != FALSE) {
	
	$videos = explode('<item>', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

	
	$t1 = explode('<title>', $video);
    $t2 = explode('</title>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<media:thumbnail url="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<media:player url="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('<pubDate>', $video);
    $t2 = explode('</pubDate>', $t1[1]);
    $datum = $t2[0];
	
	$t1 = explode('duration="', $video);
    $t2 = explode('"', $t1[1]);
    $time = $t2[0];
	
	$find   = "Reklama";
    $pos = strpos($titulek, $find);
    if ($pos === false) {
		    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<pubDate>".$datum."</pubDate>
				<description>Délka videa: ".$time."</description>
				<enclosure type=\"video/mp4\" url=\"".$link."\"/>
				<media:thumbnail url=\"".$nahled."\" />
				
			</item>\n";
    	}
	}
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>