<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.ceskatelevize.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

$query = $_GET["link"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $disk = $queryArr[2];
   $URL = "http://www.ceskatelevize.cz/ivysilani/".$nazev."dalsi-casti/".$page."/";
}   
 if ( $page == 1 ) { 
   $URL = "http://www.ceskatelevize.cz/ivysilani/".$nazev."dalsi-casti/";
}
//$URL = "http://www.ceskatelevize.cz/ivysilani/".$_GET["link"];

if (($html = openpage($URL) ) != FALSE) {
    $t1 = explode('/dalsi-casti/', $html);
    $t2 = explode('/', $t1[2]);
    $stranky = $t2[0];
} else {
	echo "TEST SELHAL !";
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

//if ($stranky != 0 && $page <= $stranky) {

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?link='.($page+1).','.$nazev.",".$disk;
?>
<title>Další strana</title>
<link><?php echo $link;?></link>
</submenu>
<?php				
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?link='.($page-1).','.$nazev.",".$disk;

?>
<title>Předchozí strana</title>
<link><?php echo $link;?></link>
</submenu>

<?php } 

if (($html = openpage($URL) ) != FALSE) {
$ItemsOut .= "<channel>\n<title>ČT iVysílání</title>";

$videos = explode('rel="page', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

$t1 = explode('=', $video);
$t2 = explode('&', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}
IF ($Max!="") $MaxNumPage = max($Max);
if($MaxNumPage > 1) { 

$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?link=%s,".$nazev."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
		
	$videos = explode('<li class="itemBlock clearfix', $html);

if ( $videos[1] != null) {

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode(' href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.ceskatelevize.cz".$t2[0];


    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $datum = $t2[0];
	
	$t1 = explode('<meta name="description" content="', $html);
    $t2 = explode('"', $t1[1]);
    $popis = $t2[0];

	$t1 = explode('<p>', $video);
    $t2 = explode('</p>', $t1[1]);
    $titulek = $t2[0];

	//if (strpos($titulek,'<') != false) {
    if ($titulek=="") $titulek="Bezejmenný titul";
    
    $titulek2 = Str_replace("&mdash;","-",$titulek);

			$ItemsOut .= "
			<item>
				<title>".$titulek2." $datum</title>
				<pubDate>".$datum."</pubDate>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_link.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";

	}
}	
else {
    $t1 = explode('<param name="url" value="', $html);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];


	if (($html = openpage($link) ) != FALSE) {
    $t1 = explode('<ENTRY><REF HREF="http://', $html);
    $t2 = explode('"', $t1[1]);
    $link = "mms://".$t2[0];
    $link1 = urldecode($link);
	$link2 = str_ireplace(
  array("&"), 
  array("&amp;"), 
  $link1);
  


			$ItemsOut .= "
			<item>
				<title>Nevim ktery porad</title>
				<link>http://127.0.0.1/nova.sh?url=".$link2."</link>
				<enclosure type=\"video/mp4\" url=\"http://127.0.0.1/nova.sh?url=".$link2."\" />
				<pubDate>".$datum."</pubDate>
				<description>".$popis."</description>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />

			</item>\n";

		}
//  
}


	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>