<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.itnews.sk");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $URL = "http://www.itnews.sk/video/".$nazev."?offset=".$queryArr[0];
}   

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
?>
<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>IT NEWS SK - <?php echo $nazev; ?></text>			
</mediaDisplay>
<?php
//zde pripadne vlozit formatovani stranky
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile."?query=".($page+12).",".$nazev;
?>
<title>Další strana</title>
<link><?php echo $link;?></link>
</submenu>

<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile."?query=".($page-12).",".$nazev;

?>
<title>Předchozí strana</title>
<link><?php echo $link;?></link>
</submenu>

<?php }


if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>IT news SK</title>";


	$videos = explode('<div class="pos-relative">', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {


    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	//$odkaz = "http://www.barrandov.tv/special/videoplayerdata/".$pole[0];
if (($html = openpage($link) ) != FALSE) {

	$t1 = explode("<source src='", $html);
    $t2 = explode("'", $t1[1]);
    $odkaz = $t2[0];
		
    $t1 = explode('poster="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('<h1>', $html);
    $t2 = explode('</h1>', $t1[1]);
    $titulek = $t2[0]; 




			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$odkaz."</link>
        <enclosure type=\"video/mp4\" url=\"".$odkaz."\"/>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
  	}
	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>