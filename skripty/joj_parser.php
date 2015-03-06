<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.joj.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
   $nazev = $queryArr[1];
   $disk = $queryArr[2];
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

    
$URL = ($nazev."/strana-".$page.".html");
if (($html = openpage($URL) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>JOJ Archiv</title>";

$vid = explode('strana', $html);

foreach($vid as $video) {

$t1 = explode('-', $video);
$t2 = explode('.', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}

IF ($Max!="") $MaxNumPage = max($Max);

if($MaxNumPage > 1) { 
$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$nazev.",".$disk."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$nazev.",".$disk;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$nazev.",".$disk;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php }
	
	

	//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<td><strong>', $html);

unset($videos[0]);

$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
	$find = "huste";
	$pos = strpos($t2[0], $find);
		
	if ($pos === false) {
    $link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/joj_parser_link.php?file=".$t2[0].",".$disk;} 
	ELSE $link = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/huste_parser_link.php?file=".$t2[0].",".$disk;

    
    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>