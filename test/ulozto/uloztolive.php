<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://uloz.to");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$be->addHeaderLine("X-Requested-With", "XMLHttpRequest");
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
$akce= $_GET["action"];
echo "<?xml version='1.0' encoding='utf-8' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 
$URL = ("http://www.uloz.to/live/");

if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Ulož.to LIVE kategorie</title>";

	//nastaveni bloku pro vyhledani pole polozek
$videos1 = explode('<aside class="wp190 searchFilters">', $html);


    $t1 = explode('<ul class="channels">', $videos1[1]);
    $t2 = explode('</ul>', $t1[1]);
    $videos2 = $t2[0];

//print_r($videos2);
	
$videos = explode('<li><a', $videos2);

unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    
	
	$t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.uloz.to".$t2[0];
    
	
    
    $t1 = explode('">', $video);
    $t2 = explode('</a></li>', $t1[1]);
    $titulek = $t2[0];
	
IF 	(!$akce) {
			$ItemsOut .= "
			<item>
				<title><![CDATA[".$titulek."]]></title>
				<link>".$HTTP_SCRIPT_ROOT."xLiveCZ/ulozto/uloztolive_parser.php?query=1,".$link."</link>
			</item>\n";
    	}
	ELSE
	{
			$ItemsOut .= '
			<item>
				<title><![CDATA[Vyhledat v '.$titulek.']]></title>
				<pubDate>Napište klíčová slova názvu videa</pubDate>
				<link>rss_command://search</link>
				<search url="'.$HTTP_SCRIPT_ROOT.'"xLiveCZ/ulozto/uloztolive_parser.php?query=1,'.$link.',%s" />
			</item>\n';
    	}

}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>