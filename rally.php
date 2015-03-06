<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.mediasport.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $section = $queryArr[1];}
   $URL = ('http://www.mediasport.cz/'.$section.'/reportazni-videa.html?page='.$page);

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$section;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$section;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }; ?> 
<?php
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>".$section."</title>";

  
	$videos = explode('<div class="video">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('<span class="delka">', $video);
    $t2 = explode('</span>', $t1[1]);
    $cas = $t2[0];
		
    $t1 = explode('<li src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.mediasport.cz".$t2[0];

	$t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $odkaz = "http://www.mediasport.cz".$t2[0];
	
	$t1 = explode('html">', $video);
    $t2 = explode('</a>', $t1[2]);
    $titulek = $t2[0];
	
	if (($html2 = openpage($odkaz)) != FALSE) {
	$t1 = explode("/include/playvideo.php?id_video=", $html2);
    $t2 = explode("'", $t1[1]);
    $link = "http://www.mediasport.cz/include/playvideo.php?id_video=".$t2[0];
	//$link = str_ireplace(array("&amp;"), array("&"), $lnk);


    

    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<enclosure type=\"video/mp4\" url=\"".$link."\" />
				<pubDate>".$cas."</pubDate>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>