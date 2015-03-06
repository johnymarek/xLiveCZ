<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>Youdive.eu</text>			
</mediaDisplay>
<channel>
	<title>Youdive.eu</title>
	<menu>main menu</menu>


<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}

if($page) {
    if($search) {
        $html = file_get_contents($search."?page=".$page);
    } else {
        $html = file_get_contents($search."?page=".$page);
    }
} else {
    $page = 1;
    if($search) {
        $html = file_get_contents($search);
    } else {
        $html = file_get_contents($search);
    }
}


if($page > 1) { ?>

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
$videos = explode('<div class="video_box">', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link ="http://zam.opf.slu.cz/baco/youdive_link.php?file=http://www.youdive.eu".$t2[0];
	$link = str_ireplace(
  array("ě","š","č","ř","ž","ý","á","í","é","ů","ú", "ť", "ď", "ň", "Ě","Š","Č","Ř","Ž","Ý","Á","Í","É","Ů","Ú", "Ť", "Ď", "Ň"), 
  array("e","s","c","r","z","y","a","i","e","u","u", "t", "d", "n", "E","S","C","R","Z","Y","A","I","E","U","U", "T", "D", "N"), 
  $link);

	

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];

    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>'.$link.'</link>';
    echo '<media:thumbnail url="http://www.youdive.eu'.$image.'" />';	
    echo '</item>';
}


?>

<item>
<?php


$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
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