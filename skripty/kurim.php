<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.ktn.directfilm.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
//$link= $_GET["link"];
$URL = "http://www.ktn.directfilm.cz/cs/vysilani/2011";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Kuřim</title>";

	
	$videos = explode('<li><a', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode(' href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode(' href="http://www.ktn.directfilm.cz/cs/vysilani', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
	$pole = explode("/", $title);
	
	$find = "ktn-";
    $pos = strpos($link, $find);
    if ($pos != false) {

			$ItemsOut .= "
			<item>
				<title>".$pole[1]." - ".$pole[2]." - ".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/kurim_link.php?file=".$link."</link>
			</item>\n";
    	}
    
	}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>