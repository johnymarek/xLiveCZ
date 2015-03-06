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

$URL = "http://www.tv.strakonice.eu/tv/tv.php";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Strakonice</title>";

	
	$videos = explode('<OPTION', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('VALUE=', $video);
    $t2 = explode('>', $t1[1]);
    $rok = $t2[0];
	
    $t1 = explode('>', $video);
    $t2 = explode('<', $t1[1]);
    $titulek = $t2[0];
	
	$find = "wmv";
    $pos = strpos($rok, $find);
    if ($pos === false) {
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/strakonice_link.php?file=http://www.tv.strakonice.eu/tv/tv.php?rok=".$rok."</link>
			</item>\n";
    	}
    
	}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>