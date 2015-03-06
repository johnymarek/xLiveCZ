<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.b-tv.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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

$ItemsOut .= "<channel>\n<title>Brno TV</title>";
    
		
	$videos = explode('<td><a', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $odkaz = ('http://www.b-tv.cz'.$t2[0]);
	
	$t1 = explode('">', $video);
    $t2 = explode('</a><br />', $t1[3]);
    $title = $t2[0];
	
	$t1 = explode('<td align="center">', $video);
    $t2 = explode('</td>', $t1[1]);
    $datum = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
   			$ItemsOut .= "
			<item>
				<title>".$title."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/brnotv_parser_link.php?query=".$odkaz.",".$datum."</link>
				<pubDate>".$datum."</pubDate>
				<media:thumbnail url=\"http://www.b-tv.cz".$nahled."\" />
			</item>\n";
    	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>