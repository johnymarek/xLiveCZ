<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<mediaDisplay>
<text offsetXPC=5 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>
Prima Autosalon HDTV</text>
</mediaDisplay>
<channel>
	<title>Prima Autosalon HDTV</title>
	<menu>main menu</menu>

<?php

$html = file_get_contents("http://www.autosalontv.cz");


$videos = explode('<tr class="radek-dil">', $html);


unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];


    $t1 = explode('year=', $video);
    $t2 = explode('&', $t1[1]);
    $rok = $t2[0];

    $t1 = explode('week=', $video);
    $t2 = explode('"', $t1[1]);
    $tyden = $t2[0];


    $t1 = explode('>AUTOSALON', $video);
    $t2 = explode('<', $t1[1]);
    $titulek = $t2[0];


    echo '<item>';
    echo '<title>AUTOSALON'.$titulek.'</title>';
    echo '<link>mms://bcastd.livebox.cz/up/as/'.$rok.'/'.$tyden.''.$rok.'.wmv</link>';
    echo '<enclosure type="video/wmv" url="mms://bcastd.livebox.cz/up/as/'.$rok.'/'.$tyden.''.$rok.'.wmv"/>';	
    echo '<media:thumbnail url="http://www.autosalontv.cz'.$nahled.'" />';	
    echo '</item>';
	echo "\n";


}


?>

</channel>
</rss>