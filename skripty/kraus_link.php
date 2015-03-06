<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.iprima.cz/showjanakrause/videoarchiv");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

$search = $_GET["link"];

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

echo "<channel>";

if (($html = openpage($search) ) != FALSE) {

$videos = explode('LiveboxPlayer.init(', $html);

unset($videos[0]);

$videos = array_values($videos);
//print_r($videos);
foreach($videos as $video) {


    $t1 = explode("jpg','", $video);
    $t2 = explode("');", $t1[1]);
    $titulek = $t2[0];

    $t1 = explode('Kraus', $video);
    $t2 = explode("'", $t1[1]);
    //$link = $t2[0];
	$link = str_ireplace(array("HQ"), array("LQ"), $t2[0]);
	
	$t1 = explode('Kraus', $video);
    $t2 = explode("'", $t1[3]);
    $nahled = $t2[0];


		
		$ItemsOut .= "
			<item>
				<title>Kraus ".$titulek."</title>
				<link>http://127.0.0.1/media/sda1/scripts/xLiveCZ/nova.sh?type=flvocko&amp;url=rtmp://iprima.livebox.cz/iprima/Kraus".$link."</link>
				<enclosure type=\"video/flv\" url=\"http://127.0.0.1/media/sda1/scripts/xLiveCZ/nova.sh?type=flvocko&amp;url=rtmp://iprima.livebox.cz/iprima/Kraus".$link."\"/>
				<media:thumbnail url='http://embed.livebox.cz/iprima/Kraus".$nahled."' />
				<pubDate>".$titulek."</pubDate>
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>