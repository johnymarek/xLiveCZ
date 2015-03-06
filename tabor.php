<?php echo "<?xml version='1.0' ?>"; ?>
<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $search = ('http://www.tabor.tv/video?order=date&offset='.$queryArr[0]);

}

if($page) {
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents($search);
    }
} else {
    $page = 0;
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents($search);
    }
}
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name=threePartsView
	suffixXPC="2" sideColorLeft="0:0:0"
	sideLeftWidthPC="0"
	sideColorRight="0:0:0"
	headerImageWidthPC="0"
	headerCapWidthPC="0"
  itemWidthPC="70"
	itemImageXPC="5"
	itemImageYPC="18"
	itemXPC="17"
	itemYPC="18"
	backgroundColor="0:0:0"
	itemBackgroundColor="0:0:0"
	showHeader=no
  selectMenuOnRight=no
	showDefaultInfo=no
 itemPerPage=5	infoYPC=90
>
<text offsetXPC=5 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>Regionální videa - <?php echo $nazev; ?></text>			
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_01.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_02.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_03.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_04.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_05.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_06.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_07.png </idleImage>
	<idleImage idleImageWidthPC=10 idleImageHeightPC=10> image/POPUP_LOADING_08.png </idleImage>
<backgroundDisplay>       
<image offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">image/gmini-bg.jpg</image>    
</backgroundDisplay>
<image offsetXPC="84" offsetYPC="89" widthPC="7" heightPC="7">image/arrow_left.png</image>
<image offsetXPC="90" offsetYPC="89" widthPC="7" heightPC="7">image/arrow_right.png</image>
  <image offsetXPC=85 offsetYPC=3 widthPC=10 heightPC=10>
    image/logo.png
	</image>
</mediaDisplay>
<channel>
	<title>Regionální videa</title>
	<menu>main menu</menu>



<?php
if($page > 0) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-16).",".$nazev.",".$queryArr[2];
//if($search) { 
//  $url = $url.$search; 
//}
?>
<title>Předchozí stránka</title>
<link><?php echo $url;?></link><media:thumbnail url="image/left.jpg" />
</item>


<?php } ?>

<?php

$videos = explode('<li class="file', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('<a href="video/', $video);
    $t2 = explode('/', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('title="', $video);
    $t2 = explode('">', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

    echo '<item>';
    echo '<title>'.$titulek.'</title>';
    echo '<link>http://www.tabor.tv/media/video/'.$link.'.flv</link>';
    echo '<enclosure type="video/x-flv" url="http://www.tabor.tv/media/video/'.$link.'.flv"/>';	
    echo '<media:thumbnail url="'.$nahled.'" />';	
    echo '</item>';
	echo "\n";

}


?>

<item>
<?php


$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+16).",".$nazev.",".$queryArr[2];
//$url = $sThisFile."?query=".($page+1).",";
//if($search) { 
//  $url = $url.$search; 
//}
?>
<title>Další stránka</title>
<link><?php echo $url;?></link>
<media:thumbnail url="image/right.jpg" />
</item>

</channel>
</rss>