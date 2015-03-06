<?php echo "<?xml version='1.0' encoding='UTF8' ?>"; ?>
<rss version="2.0">

<channel>
	<title>Metropol TV</title>
	<menu>main menu</menu>


<?php

require_once ("./include/browseremulator.class.php");
function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.metropol.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$disk = $_GET["disk"];
$link = "http://www.metropol.cz/aktualne/";

if (($html = openpage($link) ) != FALSE) {

	$t1 = explode('<div class="sub shows">', $html);
    $t2 = explode('<div class="show-logo">', $t1[1]);
    $pom = $t2[0];
	
$videos = explode('<li>', $pom);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $lnk = $t2[0];
   
    $t1=explode('alt="',$video);
    $t2=explode('"',$t1[1]);
    $title = $t2[0];
	
	$t1=explode('<img src="',$video);
    $t2=explode('"',$t1[1]);
    $image = $t2[0];
	
	$reklama = array("porady","videa");
	$pos = strpos($lnk, $reklama[0]);
	$pos2 = strpos($lnk, $reklama[1]);
	
	if (($pos === false) AND ($pos2 === false)){ }
  else { 
     echo "
    <item>
    <title>".$title."</title>
    <link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/metropoltv_parser.php?query=1,".$lnk.",".$disk."</link>
	<media:thumbnail url=\"".$image."\" />
    </item>
    ";
    
}}}

?>

</channel>
</rss>