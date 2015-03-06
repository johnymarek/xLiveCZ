<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel>
	<title>Youdive.eu</title>
	<menu>main menu</menu>

<?php
$link = $_GET["file"];
    $html = file_get_contents($link);
    $t1 = explode('vkey=', $html);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
    echo '<item>';
    echo '<title>Video LQ</title>';
    echo '<link>http://www.youdive.eu/media/videos/flv/'.$link.'.flv</link>';
    echo '<enclosure type="video/flv" url="http://www.youdive.eu/media/videos/flv/'.$link.'.flv"/>';	
    echo '</item>';

    echo '<item>';
    echo '<title>Video HD</title>';
    echo '<link>http://www.youdive.eu/media/videos/hd/'.$link.'.mp4</link>';
    echo '<enclosure type="video/mp4" url="http://www.youdive.eu/media/videos/hd/'.$link.'.mp4"/>';	
    echo '</item>';


?>
</channel>
</rss>