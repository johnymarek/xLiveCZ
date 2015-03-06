<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.freecaster.tv/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $link = $queryArr[0];
   $hash = $queryArr[1];   
}
function Pruzkum ($kod, $start, $zacatek,$end) {
    $t1 = explode($start, $kod);
    $t2 = explode($end, $t1[$zacatek]);
    $pruzkum = $t2[0];
	return $pruzkum;
}
// http://extreme.com/player/smil/dj0xMDE1MzM5JmM9MTAwMDAwMg?source=freecaster&source_url=http://extreme.com/bmx/1015339/macneil-bmx-chris-silva-fu3&transaction_id=id=

$URL = "http://extreme.com/player/smil/".$hash."?source=freecaster&source_url=".$link."&transaction_id=id=";

// $html = file_get_contents("http://prima.stream.cz/na-noze/");
if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<?xml version='1.0' ?>
	<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">
	<channel>
		<title>Extreme.com - Play</title>\n";
$base =  Pruzkum ($html, 'httpBase" content="', 1, '"');

$titulek =  Pruzkum ($html, '<switch id="', 1, '"');

$lid =  Pruzkum ($html, '<video src="', 2, '"');
$hid =  Pruzkum ($html, '<video src="', 1, '"');

			$ItemsOut .= "
			<item>
				<title>".$titulek." - HQ</title>
        <link>".$base.$hid."</link>
        <enclosure type=\"video/mp4\" url=\"".$base.$hid."\"/>
       		</item>
			<item>
				<title>".$titulek." - LQ</title>
        <link>".$base.$lid."</link>
        <enclosure type=\"video/mp4\" url=\"".$base.$lid."\"/>
        
			</item>\n";

	$ItemsOut .= "</channel></rss>";
	echo $ItemsOut;

} else {
	echo "
<item>
<title>Archiv není dostupný, opakujte požadavek!</title>
</item>
</channel>
</rss>\n";
}
?>