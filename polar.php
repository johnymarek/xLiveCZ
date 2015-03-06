<?php echo "<?xml version='1.0' ?>"; ?>
<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $search = $queryArr[2];

}

if($page) {
    if($search) {
        $html = file_get_contents($search."/".$page);
    } else {
        $html = file_get_contents($search."/".$page);
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
<mediaDisplay>
<text offsetXPC=5 offsetYPC=6 widthPC=100 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>Regionální videa - <?php echo $nazev; ?></text>			
</mediaDisplay>
<channel>
	<title>Regionální videa</title>
	<menu>main menu</menu>



<?php
if($page > 0) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Předchozí stránka</title>
<link><?php echo $url;?></link><media:thumbnail url="image/left.jpg" />
</item>


<?php } ?>

<?php

$videos = explode('<div class = "video" >', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('nadpis_video_nahled2">', $video);
    $t2 = explode('<', $t1[1]);
    $title = $t2[0];

    $t1 = explode('<img src = "', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];
	
	$t1 = explode('<span class = "datum">', $video);
    $t2 = explode('</span>', $t1[1]);
    $datum = $t2[0];
	
	$t1 = explode('<span class = "delka">', $video);
    $t2 = explode('</span>', $t1[1]);
    $cas = $t2[0];


    $t1 = explode('<a href = "', $video);
    $t2 = explode('"', $t1[3]);
    $link = $t2[0];

	echo '<item>';
    echo '<title>'.$title.'</title>';
	echo '<pubDate>'.$datum.'</pubDate>';
	echo '<description>Délka videa: '.$cas.'</description>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="http://www.tvportaly.cz'.$image.'" />';	
    echo '<enclosure type="video/mp4" url="'.$link.'"/>';
    echo '</item>';
	echo "\n";

}


?>

<item>
<?php


$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$nazev.",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Další stránka</title>
<link><?php echo $url;?></link>
<media:thumbnail url="image/right.jpg" />
</item>

</channel>
</rss>