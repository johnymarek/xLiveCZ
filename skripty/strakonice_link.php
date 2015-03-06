<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.tv.strakonice.eu");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
$t1 = explode('=', $link);
$t2 = explode(' ', $t1[1]);
$rok = $t2[0];


if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Strakonice 20".$rok."</title>";

   	
$videos = explode('<OPTION VALUE', $html);

unset($videos[0]);

$videos = array_values($videos);

foreach($videos as $video) {
   
    $t1 = explode('=', $video);
    $t2 = explode('>', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('> ', $video);
    $t2 = explode('<', $t1[1]);
    $titulek = $t2[0];
	
	 IF ($titulek!="") { 
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://www.tv.strakonice.eu/tv/".$link."</link>
				<enclosure type=\"video/x-ms-wmv\" url=\"http://www.tv.strakonice.eu/tv/".$link."\"/>
			</item>\n";
		}	    	
	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>