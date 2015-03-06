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
$link = $_GET["file"];
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";


if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Kuřim</title>";

   	
	$videos = explode('<div class="item_short">', $html);

unset($videos[0]);

$videos = array_values($videos);

foreach($videos as $video) {
   
    $t1 = explode('<img src="', $video);
    $t2 = explode('.jpg', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('<h2>', $video);
    $t2 = explode('</h2>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link.".flv</link>
				<enclosure type=\"video/flv\" url=\"".$link.".flv\"/>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
			    	
	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>