<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.uloz.to/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
//$query= $_GET["query"];
$URL =$_GET["url"];
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
echo "<?xml version='1.0' encoding='utf-8' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Uloz.to</title>";


	$t1 = explode('<img class="captcha" src="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled1 = $t2[0];
	
	$t1 = explode('captcha/', $nahled1);
    $t2 = explode('.png', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<div class="freeDownloadForm"><form action="', $html);
    $t2 = explode('"', $t1[1]);
    $link = "www.uloz.to".$t2[0];

   	$ItemsOut .= "
			<item>
				<title>Zadej kód z obrázku</title>
				<pubDate>Opište písmena z obrázku (stačí malými písmeny)</pubDate>
				<link>rss_command://search</link>
				<search url=\"".$HTTP_SCRIPT_ROOT."xLiveCZ/ulozto/ulozto_link_final.php?query=%s,".$nahled.",".$link.",10\" />;
				<media:thumbnail url=\"".$nahled1."\" />
			</item>\n 
      <item>
				<title>Načíst jiný obrázek</title>
				<pubDate>Načte jiný obrázek na opsání (pokud je nečitelný)</pubDate>
				<link>".$HTTP_SCRIPT_ROOT."xLiveCZ/ulozto/ulozto_link.php?url=".$URL."</link>
			</item>\n";				   
	
		
	
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>
