<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.stream.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $search = ('http://prima.stream.cz/?&amp;a=videolist_ajax&amp;section='.$queryArr[1].'&amp;uri=prima&amp;orderby=id&amp;no_detail=1&amp;page='.$queryArr[0]);

}

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<mediaDisplay>
<text offsetXPC=55 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>:$nazev</text>			
</mediaDisplay>\n";


if (($html = openpage($search) ) != FALSE) {

$videos = explode('page', $html);

foreach($videos as $video) {

$t1 = explode('=', $video);
$t2 = explode('"', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}

IF ($Max!="") $MaxNumPage = max($Max);
$ItemsOut .= "<channel>\n<title>Prima TV</title>";
if($MaxNumPage >= 8) { 
$ItemsOut .= "<item>
				<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>
				<link>rss_command://search</link>
				<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$nazev."\" />
				<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />
			</item>";
}
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+8).",".$nazev;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-8).",".$nazev;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }
	
	

	//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<a style="background:', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode("#000 url('", $video);
    $t2 = explode("'", $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('<a title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];


    $t1 = explode(' href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('videolist_one_time">', $video);
    $t2 = explode('&nbsp;', $t1[1]);
    $cas = $t2[0];

		
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/prima_link.php?link=".$link."</link>
				<pubDate>Délka videa: ".$cas."</pubDate>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>