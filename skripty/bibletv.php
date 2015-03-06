<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.bibletv.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $archiv = $queryArr[1];
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

    
$URL = "http://www.bibletv.cz/".$archiv."?page=".$page;
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>BibleTV archiv</title>";

$vid = explode('?page', $html);

foreach($vid as $video) {

$t1 = explode('=', $video);
$t2 = explode('"', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}

IF ($Max!="") $MaxNumPage = max($Max);

if($MaxNumPage > 1) { 
$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$archiv."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$archiv;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$archiv;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php }
	
	

	//nastaveni bloku pro vyhledani pole polozek
$t1 = explode("<div class='section-left'>", $html);
    $t2 = explode("<div class='section-right'>", $t1[1]);
    $pom = $t2[0];
	
$videos = explode('<div class="mainlist">', $pom);
  
unset($videos[0]);

$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.bibletv.cz".$t2[0];

    
    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.bibletv.cz".$t2[0];
	
	$t1 = explode('<span>', $video);
    $t2 = explode('</span>', $t1[1]);
    $datum = $t2[0];
	
	$t1 = explode('<p>', $video);
    $t2 = explode('<br />', $t1[1]);
    $popis = $t2[0];
	
	   
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/bibletv_link.php?query=".$link."</link>
				<media:thumbnail url='".$nahled."' />
				<pubDate>".$datum."</pubDate>
				<description>".$popis."</description>
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>