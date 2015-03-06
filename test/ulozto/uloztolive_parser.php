<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://uloz.to");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$be->addHeaderLine("X-Requested-With", "XMLHttpRequest");
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
$query= $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
   $hledat = $queryArr[2];
}  
echo "<?xml version='1.0' encoding='utf-8' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

IF ($hledat=="") $url = ($search.$page."?orderBy=%40id__desc");
ELSE
$url = "http://uloz.to/hledej/?pos=".$page."&q=".$hledat."&redir=0&service=live&media=video";

echo $url;

if (($html = openpage($url)) != FALSE) {

$ItemsOut .= "<channel>\n<title>Ulož.to LIVE kategorie</title>";
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$search.",".$hledat;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$search.",".$hledat;

?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php }

	//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<div class="thumb thumbVideo">', $html);

unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    
	
	$t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.uloz.to".$t2[0];
    
	
    
    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];

	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<span class="fileSize">', $video);
    $t2 = explode('<span', $t1[1]);
    $velikost = $t2[0];
	
	$t1 = explode('<span class="fileTime">', $video);
    $t2 = explode('</span>', $t1[1]);
    $delka = $t2[0];
	
		
			$ItemsOut .= "
			<item>
				<title><![CDATA[".$titulek."]]></title>
				<pubDate>Velikost: ".$velikost." Délka: ".$delka."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
				<link>".$HTTP_SCRIPT_ROOT."xLiveCZ/ulozto/uloztolive_link.php?url=".$link."</link>
			</item>\n";
    	
		

}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>