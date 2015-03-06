<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.tvlux.sk");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $link = $queryArr[1];
   $page = $queryArr[0];
   $disk = $queryArr[2];
   $URL = "http://www.tvlux.sk/archiv/listing/&type=relacia&id=".$link."&iPage=".$page;
}




echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

if (($html = openpage($URL) ) != FALSE) {
$ItemsOut .= "<channel>\n<title>TV LUX archiv</title>";
$t1 = explode('<td width="33%" align="center">', $html);
$t2 = explode('</td>', $t1[1]);
$NumPage = $t2[0];
$MaxNumPage = str_ireplace(array("&nbsp;"), array(""), $NumPage);
	
	$ItemsOut .= "<item>
				<title>Zadej číslo strany (Jste na stránce č. $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$link.",".$disk."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$link.",".$disk;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$link.",".$disk;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }


	$videos = explode('<div class="archiv_item">', $html);
    unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[5]);
    $titulek = $t2[0];
	
	$t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<small><strong>', $video);
    $t2 = explode('</strong>', $t1[1]);
    $datum = $t2[0];
	
	/*$t1 = explode('<div class="clr"></div><div>', $video);
    $t2 = explode('</div>', $t1[1]);
   	$pop = $t2[0]; 
	$popis = str_ireplace(array("&aacute;","&ccaron;","&dcaron;","&eacute;","&ecaron;","&iacute;","&ncaron;","&oacute;","&rcaron;","&scaron;","&tcaron;","&uacute;","&uring;","&yacute;","&zcaron;","&auml;","&ocirc;","&nbsp;"),
	array("á","č","ď","é","ě","í","ň","ó","ř","š","ť","ú","ů","ý","ž","ä","ô"," "), $pop);*/
	
	if (($html = openpage($link) ) != FALSE) {

	$t1 = explode('<param value="http://', $html);
    $t2 = explode('" name="Filename" >', $t1[1]);
    $odkaz = $disk."xLiveCZ/msdl.sh?type=test&amp;url=mms://".$t2[0]."?MSWMExt=.asf";
	
	
	
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<pubDate>".$datum."</pubDate>
				<link>".$odkaz."</link>
				<enclosure type=\"video/x-ms-asf\" url=\"".$odkaz."\"/>
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