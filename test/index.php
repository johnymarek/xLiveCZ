<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.piratskefilmy.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$URL = "http://www.piratskefilmy.cz/";

if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>Piratske filmy</title>";
	
	$videos = explode('<li class="cat-item', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {


    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
		
    
    $t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[2]);
    $titulek = $t2[0]; 
	
	
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/parser.php?query=1,".$link."</link>
			</item>\n";
  	
	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>