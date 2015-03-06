<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<?php
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = urlencode($queryArr[1]);
   $URL = ('http://www.stream.cz/?&a=search&search_text='.$nazev.'&resultsorting=relevance&page='.$page);
}
?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+15).",".$nazev;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
</submenu>


<?php
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-15).",".$nazev;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
</submenu>
<?php }; ?>
<mediaDisplay name=threePartsView sideColorLeft="0:0:0" sideLeftWidthPC="18" sideRightWidthPC="10" sideColorRight="0:0:0" headerXPC="14" headerYPC="3" headerWidthPC="95"
	itemImageXPC="21" itemImageYPC="18" itemXPC="34" itemYPC="18" itemWidthPC="46"	menuXPC="5"	menuWidthPC="15" capXPC="82" capYPC="17" capHeightPC="10" headerCapXPC="90"
	headerCapYPC="10" headerCapWidthPC="0" showDefaultInfo="yes" backgroundColor="0:0:0" itemBackgroundColor="0:0:0" infoYPC="85" popupXPC="7" popupWidthPC="15"
	popupBorderColor="0:0:0" idleImageXPC=45 idleImageYPC=42 idleImageWidthPC=10 idleImageHeightPC=16 liding=yes showHeader=no forceFocusOnItem=yes>
	<idleImage> image/POPUP_LOADING_01.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_02.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_03.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_04.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_05.jpg </idleImage>
	<idleImage> image/POPUP_LOADING_06.jpg </idleImage>
<text offsetXPC=20 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250> - Hledaný výraz: <?php echo $nazev;?></text>			
</mediaDisplay>

<channel>
	<title>Stream.cz</title>


<?php

$html = file_get_contents( $URL );

$videos = explode('page', $html);

foreach($videos as $video) {

$t1 = explode('=', $video);
$t2 = explode('"', $t1[1]);
$d++;
IF (is_numeric($t2[0])) $Max[$d] = $t2[0];
}
IF ($Max!="") $MaxNumPage = max($Max);
if($MaxNumPage >= 8) { 
 echo "<item>";echo "\n";
			 echo "<title>Zadej číslo strany (Maximum je $MaxNumPage)</title>";echo "\n";
			 echo "<link>rss_command://search</link>";echo "\n";
			 echo "<search url=\"http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?query=%s,".$nazev."\" />";echo "\n";
			 echo "<media:thumbnail url=\"http://zam.opf.slu.cz/baco/image/otaznik.jpg\" />";echo "\n";
			 echo "</item>"; echo "\n";
}
$videos = explode('<div class="videoListObal">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

  	$t1 = explode("background: #000 url('", $video);
    $t2 = explode("'", $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];


    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('&times;  |  ', $video);
    $t2 = explode('</p>', $t1[1]);
    $datum = $t2[0];
	
	
	
   $odkaz = 'http://www.stream.cz'.$link.'';
  
    echo '<item>';echo "\n";
    echo '<title>'.$titulek.'</title>';echo "\n";
    echo '<link>http://'.$_SERVER["HTTP_HOST"].dirname($_SERVER["SCRIPT_NAME"]).'/streamsp_link.php?link='.$odkaz.'</link>';echo "\n";
	echo '<pubDate>'.$datum.'</pubDate>';echo "\n";
	echo '<media:thumbnail url="'.$nahled.'" />';echo "\n";
    echo '</item>';echo "\n";
	echo "\n";
}
                                           

?>

</channel>
</rss>

</channel>
</rss>