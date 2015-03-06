<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>
Děčín - <?php echo $section; ?></text>
</mediaDisplay>
<?php
$section = $_GET["section"];
$query = 'http://e-decin.cz/multimedia/'.$section;
$html = file_get_contents( $query );

IF ($section=="") ($section="zastupitelstvo");

?>
<channel>
	<title>Děčín</title>
	<menu>main menu</menu>



<?php
$videos = explode('alt="[VID]">', $html);

unset($videos[0]);

$videos = array_values($videos);

foreach($videos as $video) {
   
    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('<a href="', $video);
    $t2 = explode('.wmv', $t1[1]);
    $titulek = $t2[0];
	
	IF ($section=="zastupitelstvo") ($section="");
	echo '<item>';
    echo '<title>'.$titulek.'</title>';
    echo '<link>http://e-decin.cz/multimedia/'.$section.'/'.$link.'</link>';
    echo '<enclosure type="video/x-ms-wmv" url="http://e-decin.cz/multimedia/'.$section.'/'.$link.'"/>';	
    //echo '<media:thumbnail url="'.$nahled.'" />';	
    echo '</item>';
	echo "\n";

}


?>

</channel>
</rss>