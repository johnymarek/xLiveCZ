<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.markiza.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
//$link= $_GET["link"];
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

    
	$URL = ($search."?offset=".$page);
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Markiza archiv</title>";

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+9).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Dalsi strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php
if($page > 0) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-9).",";
if($search) { 
  $url = $url.$search; 
}

?>
<title>Predchozi strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php }
	
	

	//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<LI class="item"', $html);

unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode(' href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/markiza_talent_link.php?file=http://video.markiza.sk".$t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('<P>', $video);
    $t2 = explode('<br/>', $t1[1]);
    $datum = $t2[0];

    
			$ItemsOut .= "
			<item>
				<title>Talentmania - ".$datum."</title>
				<link>".$link."</link>
				<pubDate>".$datum."</pubDate>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>