<?php echo "<?xml version='1.0' ?>"; ?>
<?php
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $search = ('http://www.autotube.cz/'.$queryArr[1].'-stranka-'.$queryArr[0].'.html');

}



?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>Autotube.cz - <?php echo $nazev; ?></text>			
</mediaDisplay>
<channel>
	<title>Autotube.cz</title>
	<menu>main menu</menu>

<?php
if($page > 0) { ?>

<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$nazev;
?>
<title>Předchozí stránka</title>
<link><?php echo $url;?></link><media:thumbnail url="image/left.jpg" />
</item>


<?php } ?>

<?php
if ($queryArr[0]=="1") 
   $html = file_get_contents('http://www.autotube.cz/'.$queryArr[1].'.html');
ELSE $html = file_get_contents($search);

$videos = explode('<div class="item">', $html);

unset($videos[0]);
$videos = array_values($videos);
foreach($videos as $video) {

    $t1 = explode('<a href="/'.$nazev.'/', $video);
    $t2 = explode('.html', $t1[1]);
    $title = $t2[0];

    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $image = $t2[0];


    $t1 = explode('src="http://img.autotube.cz/thumbnails/', $video);
    $t2 = explode('.jpg', $t1[1]);
    $link = $t2[0];
	$odkaz1 = explode("/", $link);
	$odkaz2 = explode("_", $link);
   
    IF ($title != "") {
    echo '<item>';
    echo '<title>'.$title.'</title>';
    echo '<link>http://stream1.autotube.cz/'.$odkaz1[0].'/'.$odkaz2[1].'.flv</link>';
    echo '<enclosure type="video/flv" url="http://stream1.autotube.cz/'.$odkaz1[0].'/'.$odkaz2[1].'.flv"/>';	
    echo '<media:thumbnail url="'.$image.'" />';	
    echo '</item>';
	echo "\n";}

}


?>
<item>
<?php


$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$nazev;
?>
<title>Další stránka</title>
<link><?php echo $url;?></link>
<media:thumbnail url="image/right.jpg" />
</item>

</channel>
</rss>