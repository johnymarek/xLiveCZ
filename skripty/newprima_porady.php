<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.iprima.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $kanal = $queryArr[0];
   $disk = $queryArr[1];
}
// VSTUP $html (obsah stranky http://play.iprima.cz/iprima, http://play.iprima.cz/love,http://play.iprima.cz/cool)
switch ($kanal) {
	case '1':
			$channel_name = "iprima";
			break;
	case '2':
			$channel_name = "cool";
			break;
	case '3':
			$channel_name = "love";
			break;
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

$ItemsOut .= "<channel>\n<title>Prima ".$channel_name." archiv</title>";
//definice prazdneho pole
$porady = Array();
$link = "http://play.iprima.cz/".$channel_name;
if (($html = openpage($link) ) != FALSE) {


// moje parsovaci funkce
function Pruzkum ($kod, $start, $zacatek,$end) {
    $t1 = explode($start, $kod);
    $t2 = explode($end, $t1[$zacatek]);
    $pruzkum = $t2[0];
   return $pruzkum;
}

// funkce pro překlad do UTF8
function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

// vyparsovani json pole seznamu poradu
$porady_zdroj =  Pruzkum ($html, 'topcat = [', 1, '];');

// preklad nazvu do UTF8
$porady_zdroj = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $porady_zdroj);


// rozdeleni pro parsovani jednotlivych polozek
$videos = explode('{', $porady_zdroj);
unset($videos[0]);
$videos = array_values($videos);

//parsovani polozek
foreach($videos as $video) {

$porad =  Pruzkum ($video, 'name":"', 1, '"');
$porad_id =  Pruzkum ($video, 'tid":"', 1, '"');
//pridani polozky do multipole
$porady[] = Array("porad_id" => $porad_id, "porad" => $porad);

}
// setrizeni polozek pole seznamu poradu podle abecedy
$tmp = Array();
foreach($porady as &$ma) 
    $tmp[] = &$ma["porad"];
array_multisort($tmp, $porady);

foreach($porady as &$ma)

//vypis polozek nabidky

     $ItemsOut .= "<item>
            <title>".$ma["porad"]."</title>
            <link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/newprima.php?query=0,".$kanal.",".$ma["porad_id"].",".$disk."</link>
            <media:thumbnail url=\"".$ma["porad_id"].".jpg\" />      
        </item>\n";
		
$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
	}
?>