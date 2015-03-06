<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://extreme.com/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $URL = "http://extreme.com/".$nazev."?page=".$page;
}   
 if ( $page == 1 ) { 
   $URL = 'http://extreme.com/'.$nazev;
}

function Pruzkum ($kod, $start, $zacatek,$end) {
    $t1 = explode($start, $kod);
    $t2 = explode($end, $t1[$zacatek]);
    $pruzkum = $t2[0];
	return $pruzkum;
}
function MaxNumPage ($html) {
  $html =  Pruzkum ($html, '<div class="related_pagination">', 1, '</div>');
  $videos = explode('<a', $html);
	$i = count ($videos) -2;
  $MaxNumPage =  Pruzkum ($videos[$i], '">', 1, '<');
  if ($html == null) {$MaxNumPage = 1;}
	return $MaxNumPage;
}

if (($html = openpage($URL) ) != FALSE) {

$MaxNumPage = MaxNumPage ($html);

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
if ($page != $MaxNumPage) {
?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$nazev;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php 
}
//neni-li prvni stranka pak pridat polozku menu na predchozi stranku
if($page > 1) { ?>

<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$nazev;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php } 




echo "<channel>
<title>Extreme.com - $nazev</title>\n";
if ($MaxNumPage > 1) {

$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=%s,".$nazev;

$ItemsOut .= "<item>
<title>Skok na stranu: 1 - $MaxNumPage</title>
<link>rss_command://search</link>
<media:thumbnail url=\"image/searchpage.png\" />
<search url=\"$url\" />
</item>";
 }

//print_r($html);
$html =  Pruzkum ($html, '<div class="videos_list">', 1, '<div class="related_pagination">');
//print_r($html);




$videos = explode('<div class="video_cell">', $html);

unset($videos[0]);


$videos = array_values($videos);
foreach($videos as $video) {

    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
	$link = "http://extreme.com".$t2[0];

    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
	$titulek = $t2[0];

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
	$nahled = $t2[0];

if (($html = openpage($link) ) != FALSE) {
$hash =  Pruzkum ($html, 'FCPlayer.swf?id=', 1, '&amp;');

if ($titulek != null ) {

			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/freecaster_link.php?query=".$link.",".$hash."</link>
				<image>".$nahled."</image>
			</item>\n";
 }



}}

if($MaxNumPage != $page) { 
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$nazev;
$ItemsOut .= "<item>
<title>Další strana</title>
<link>$url</link>
<media:thumbnail url=\"image/nextpage.png\" />
</item>\n";
}
	echo $ItemsOut;

} else {
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n<title>Server není dostupný</title>
<item>
<title>Archiv není dostupný, opakujte požadavek!</title>
</item>
\n";
}
?>
</channel>
</rss>
