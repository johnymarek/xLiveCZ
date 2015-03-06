<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://farmarhladazenu.joj.sk");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["page"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $URL = $queryArr[1];
   $disk = $queryArr[2];
}

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

    
//$URL = ('http://farmarhladazenu.joj.sk/videa/farmarhladazenu-epizody.html');
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>JOJ Archiv</title>";

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$disk;
?>
<title>Dalsi strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$disk;
?>
<title>Predchozi strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php }

	$t1 = explode('<div class="b b-horizontal-l c">', $html);
    $t2 = explode('<div id="rightContent"', $t1[1]);
    $pom = $t2[0];	

$videos = explode('<li class="i c">', $pom);

unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {
 
    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $file = $t2[0];
	$link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/farmar_link.php?file=".$file.",".$disk;

    
    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled =$t2[0];
	
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>