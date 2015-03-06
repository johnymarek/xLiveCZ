<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://voyo.nova.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
// ###############################################################
// ##                                                           ##
// ##   Copyright (C) 2011  Pavel Bačo (killerman)              ##
// ##                                                           ##
// ###############################################################
//$link= $_GET["link"];

$url = "http://tv.nova.cz/porady";
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($url) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Nova archiv</title>";

//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<li><span>', $html);

unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode('><a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $t1 = explode('<img class="img" src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];

    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}
		}



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>