<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.tvmb.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$page= $_GET["page"];
$URL = "http://www.tvmb.cz/tvmb?page=".$page."&limit=15";


echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {
$videos = explode('page', $html);

foreach($videos as $video) {

$t1 = explode('=', $video);
$t2 = explode('&', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}

$MaxNumPage = max($Max);
$ItemsOut .= "<channel>\n<title>Mladá Boleslav</title>";
if($MaxNumPage >= 15) { 
$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage/15)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=%s,\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?page=".($page+15);
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page >= 15) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?page=".($page-15);
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }


	
	$videos = explode('rel="lightbox[nodes]"', $html);
    
	unset($videos[0]);
	//print_r($videos);
	$videos = array_values($videos);

	foreach($videos as $video) {

    	
    $t1 = explode('<b>', $video);
    $t2 = explode('</b>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('src="..', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.tvmb.cz".$t2[0];
	
	$t1 = explode('</p>', $video);
    $t2 = explode('</td ></tr>', $t1[1]);
    $popis = $t2[0];
	
	$t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://tvmb.cz/'.$t2[0];
	
	if (($html = openpage($link) ) != FALSE) {
	
	$t1 = explode('<param name="filename" value="', $html);
    $t2 = explode('"', $t1[1]);
    $link1 = $t2[0];
	$link2 = str_ireplace(array("&amp;"), array("&"), $link1);
	
	
	if (($html = openpage($link2) ) != FALSE) {
	
	$videos = explode('<entry', $html);
    
	unset($videos[0]);
	//print_r($videos);
	$videos = array_values($videos);

	foreach($videos as $video) {
		
	$t1 = explode('<ref href="', $video);
    $t2 = explode('"', $t1[1]);
    $odkaz = $t2[0];
	
	$find   = "files";
    $pos = strpos($odkaz, $find);
    if ($pos === false) $r++;
	ELSE {
	
	//IF 	($nazev=="Reportáže")
	    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$odkaz."</link>
				<description>Popis:".$popis."</description>
				<enclosure type=\"video/x-ms-asf\" url=\"".$odkaz."\"/>
			</item>\n";
    
	}}}}}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
	} else {
	echo "TEST SELHAL !";
}

?>