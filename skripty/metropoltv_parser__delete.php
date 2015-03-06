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

$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $disk = $queryArr[2];

$reklama = array("porady","videa");
	$pos = strpos($nazev, $reklama[0]);
	$pos2 = strpos($nazev, $reklama[1]);
	
	
IF ($pos2 === false){
$URL = $nazev."archiv/strana/".$page."/";
}
IF ($pos === false){
$URL = $nazev."strana/".$page."/";
}}

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

//if ($stranky != 0 && $page <= $stranky) {

if (($html = openpage($URL) ) != FALSE) {
$ItemsOut .= "<channel>\n<title>Metropol TV</title>";
IF ($pos2 === false){
    $t1 = explode('<a class="active" href="', $html);
    $t2 = explode('archiv/strana', $t1[1]);
    $naz = $t2[0];}
	
IF ($pos === false){
    $t1 = explode('<a class="active" href="', $html);
    $t2 = explode('strana', $t1[1]);
    $naz = $t2[0];}
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?query='.($page+1).','.$naz;
?>
<title>Další strana</title>
<link><?php echo $link;?></link>
</submenu>
<?php				
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?query='.($page-1).','.$naz;

?>
<title>Předchozí strana</title>
<link><?php echo $link;?></link>
</submenu>

<?php } 



$videos = explode('strana', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

$t1 = explode('/', $video);
$t2 = explode('"', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}
IF ($Max!="") $MaxNumPage = max($Max);
if($MaxNumPage > 1) { 

$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$naz.",".$disk."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}


IF ($pos2 === false){		
	$videos = explode('<div class="show">', $html);

if ( $videos[1] != null) {

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<h3>', $video);
    $t2 = explode(' -', $t1[1]);
    $datum = $t2[0];
   
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $lnk = $t2[0];   
   
    $t1=explode('">',$video);
    $t2=explode('</a></h3>',$t1[2]);
    $title = $t2[0];
	
	$t1=explode('src="',$video);
    $t2=explode('"',$t1[1]);
    $image = $t2[0];

			$ItemsOut .= "
			<item>
				<title>".$title."</title>
				<pubDate>".$datum."</pubDate>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/metropoltv_link.php?file=".$lnk.",".$disk."</link>
				<media:thumbnail url=\"".$image."\" />
			</item>\n";

	}}}

IF ($pos === false){	


	$videos = explode('<div class="video">', $html);


	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<span class="time">', $video);
    $t2 = explode('</span>', $t1[1]);
    $time = $t2[0];
   
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $lnk = $t2[0];   
   
    $t1=explode('alt="',$video);
    $t2=explode('"',$t1[1]);
    $title = $t2[0];
	
	$t1=explode('src="',$video);
    $t2=explode('"',$t1[1]);
    $image = $t2[0];

			$ItemsOut .= "
			<item>
				<title>".$title."</title>
				<pubDate>Délka videa: ".$time."</pubDate>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/metropoltv_link.php?file=".$lnk."</link>
				<media:thumbnail url=\"".$image."\" />
			</item>\n";

	
}}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>