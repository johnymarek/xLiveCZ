<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.slevydnes.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$link= $_GET["link"];

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
   
if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Slevy</title>";

$ItemsOut .= "	<item>
				<title>Pro info o slevě použij tlačítko 'Do prava'</title>
				<media:thumbnail url=\"http://www.hpi-cz.cz/aktuality/imagesmall/vyk%C5%99i%C4%8Dn%C3%ADk%20axd.jpg\" />
			</item>\n";

$videos = explode('<div class="sleva-count">', $html);

unset($videos[0]);

$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {
//print_r($video);
	$t1 = explode('data-href="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
   	$t1 = explode('return true;">', $video);
    $t2 = explode("</a></h3>", $t1[2]);
    $tit = $t2[0];
	$titulek = str_ireplace( array("&hellip;"), array("..."), $tit);
	
	$t1 = explode(' <div class="cas">', $video);
    $t2 = explode(' </div>', $t1[1]);
    $date = $t2[0];
	
	/*$t1 = explode('<p class="description">', $video);
    $t2 = explode("</p>", $t1[1]);
    $pop = $t2[0];
	$popis = str_ireplace( array("&nbsp;","<strong>","</strong>"), array(" ","",""), $pop);*/
	
	$t1 = explode('<p class="cena">', $video);
    $t2 = explode("&nbsp;", $t1[1]);
    $cena = "Původní cena : ".$t2[0].",- Kč";
	
	$t1 = explode('<p class="akcnicena">', $video);
    $t2 = explode("&nbsp;", $t1[1]);
    $acena = "Akční cena : ".$t2[0].",- Kč";
		
	$t1 = explode('<span class="slv">', $video);
    $t2 = explode("</span>", $t1[1]);
    $sleva = "Sleva: ".$t2[0];
		
	    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<pubDate>".$date."</pubDate>
				<description>".$titulek."\n".$popis."\n".$cena."\n".$acena."\n".$sleva."\n</description>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>