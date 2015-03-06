<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.tvlux.sk");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$disk = $_GET["disk"];
$URL = "http://www.tvlux.sk/relacie/show_relacie/";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$ItemsOut .= "<channel>\n<title>TV LUX archiv</title>";
if (($html = openpage($URL) ) != FALSE) {


	$videos = explode('<div style="margin-top: 10px;">', $html);
    unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[4]);
    $titulek = $t2[0];
	
	$t1 = explode('<a href="http://www.tvlux.sk/relacie/relacia_detail/', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/lux_link.php?query=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"".$nahled."\" />
		     </item>\n";

   
 }   
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>