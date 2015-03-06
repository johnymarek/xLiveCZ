<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>
TV OVA - Fabex Ostrava</text>
</mediaDisplay>

<channel>

<title>TV OVA - Fabex Ostrava</title>
	<menu>main menu</menu>


<?php
$html = file_get_contents("http://www.tvova.cz/");



$videos = explode('<div class="search_video">', $html);

unset($videos[0]);

$videos = array_values($videos);

foreach($videos as $video) {
   
    $t1 = explode('<a href="http://www.tvova.cz/vsechny-videa/play-', $video);
    $t2 = explode('-s1.html', $t1[1]);
    $link = $t2[0];

	$t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"></a>', $t1[1]);
    $nahled = $t2[0];
	
    echo '<item>';
    echo '<title>'.$titulek.'</title>';
	echo '<link>http://www.tvova.cz/video/'.$link.'.flv</link>';
    echo '<enclosure type="video/flv" url="http://www.tvova.cz/video/'.$link.'.flv"/>';	
	echo '<media:thumbnail url="'.$nahled.'" />';
    echo '</item>';
	echo "\n";
}


?>

</channel>
</rss>