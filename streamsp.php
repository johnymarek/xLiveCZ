<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.stream.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $URL = ('http://www.stream.cz/kategorie/'.$nazev.'/'.$page);
}

?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+9).",".$nazev;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-9).",".$nazev;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }; ?>
<mediaDisplay>
<text offsetXPC=20 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250> - Kategorie: <?php echo $nazev;?></text>			
</mediaDisplay>

<channel>
	<title>Stream.cz</title>


<?php

if (($html = openpage($URL) ) != FALSE) {

$videos = explode('page', $html);

foreach($videos as $video) {

$t1 = explode('=', $video);
$t2 = explode('"', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}
$MaxNumPage = max($Max);
if($MaxNumPage >= 8) { 
 echo "<item>";echo "\n";
			 echo "<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>";echo "\n";
			 echo "<link>rss_command://search</link>";echo "\n";
			 echo "<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$nazev."\" />";echo "\n";
			 echo "<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />";echo "\n";
			 echo "</item>"; echo "\n";
}
$videos = explode('<div class="videoListObal">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

  	$t1 = explode("background: #000 url('", $video);
    $t2 = explode("'", $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];


    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('&times;  |  ', $video);
    $t2 = explode('</p>', $t1[1]);
    $dat = $t2[0];
	$datum = str_ireplace(array(" "), array(""), $dat);
	
	
	
   $odkaz = 'http://www.stream.cz'.$link.'';

   echo '<item>';echo "\n";
    echo '<title>'.$titulek.'</title>';echo "\n";
    echo '<link>http://zam.opf.slu.cz/baco/streamsp_link.php?link='.$odkaz.'</link>';echo "\n";
	echo '<pubDate>'.$datum.'</pubDate>';echo "\n";
	echo '<media:thumbnail url="'.$nahled.'" />';echo "\n";
    echo '</item>';echo "\n";
	echo "\n";
}}

                                           

?>

</channel>
</rss>