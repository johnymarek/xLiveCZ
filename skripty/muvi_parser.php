<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.muvi.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query= $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $URL = $nazev."?list=".$page;
}   


echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?query='.($page+1).','.$nazev;
?>
<title>Další strana</title>
<link><?php echo $link;?></link>
</submenu>
<?php				
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?query='.($page-1).','.$nazev;

?>
<title>Předchozí strana</title>
<link><?php echo $link;?></link>
</submenu>

<?php } 
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Muvi.cz</title>";

/*$strankovani = explode('<div class="poradac">', $html);
unset($strankovani[0]);
$videos = explode('<li><a href=', $strankovani[1]);
unset($videos[0]);
IF ($nazev != ("http://www.muvi.cz/aerokratas/")AND $nazev != ("http://www.muvi.cz/australsky-denik/")){
foreach($videos as $video) {
    $t1 = explode('">', $video);
    $t2 = explode('</a></li>', $t1[1]);
    $d++;
	IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}

$MaxNumPage = max($Max);
}
if($MaxNumPage > 1) { 
$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$nazev."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
	$pom = explode('<div class="image_container">', $html);
   
	unset($pom[0]);
	
	$videos = array_values($pom);*/
	
	$videos = explode('<li class="listItem">', $html);
    
	unset($videos[0]);
		
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.muvi.cz".$t2[0];
	
    $t1 = explode('<div class="showTitle">', $video);
    $t2 = explode('</div>', $t1[1]);
    $titulek = $t2[0];
	
	
	/*IF ($nazev == "http://www.muvi.cz/palce/"){*/
	$t1 = explode('div class="showAiringInfo">', $video);
    $t2 = explode('|', $t1[1]);
    $time = $t2[0];
	
	$t1 = explode('img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/muvi_link.php?link=".$link."</link>
				<pubDate>Délka videa: ".$time."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
    	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>