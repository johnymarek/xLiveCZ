<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.fashionstarstv.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $kategorie = $queryArr[1];
$URL = "http://www.fashionstarstv.cz/ajax/ajax.php?cmd=articles&artc_id=".$kategorie."&od=".$page."&kolik=5&ajax=1";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

if (($html = openpage($URL) ) != FALSE) {

$videos = explode('articles_list', $html);

foreach($videos as $video) {

$t1 = explode('">', $video);
$t2 = explode('</a>', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}

IF ($Max!="") $MaxNumPage = max($Max);
$ItemsOut .= "<channel>\n<title>FashionstarsTV</title>";
if($MaxNumPage >= 1) { 
$nasobek=5*$MaxNumPage;
$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<pubDate>strankovani je v nasobcich 5, pro $MaxNumPage. stránku zadej $nasobek </pubDate>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$kategorie."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+5).",".$kategorie;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page > 5) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-5).",".$kategorie;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }


	$videos = explode('<div class="article">', $html);
    
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.fashionstarstv.cz".$t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.fashionstarstv.cz".$t2[0];
	
	if (($html = openpage($link) ) != FALSE) {

	$t1 = explode('file: "', $html);
    $t2 = explode('"', $t1[1]);
    $odkaz = "http://www.fashionstarstv.cz".$t2[0];
	
	$t1 = explode('Publikováno dne</strong>:', $html);
    $t2 = explode('<br />', $t1[1]);
    $datum = $t2[0];
	$pole = explode(".", $datum);
	
	
	$find   = "mp4";
    $pos = strpos($odkaz, $find);

	if ($titulek != ""){
	 if ($pos === false) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<pubDate>".$datum."</pubDate>
				<description>".$popis."</description>
				<link>".$odkaz."</link>
				<enclosure type=\"video/x-flv\" url=\"".$odkaz."\"/>
				<media:thumbnail url=\"".$nahled."\" />
		     </item>\n";}
     ELSE { $ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<pubDate>".$datum."</pubDate>
				<description>".$popis."</description>
				<link>".$odkaz."</link>
				<enclosure type=\"video/mp4\" url=\"".$odkaz."\"/>
				<media:thumbnail url=\"".$nahled."\" />
		     </item>\n";}
    }
	}
    }
	}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>