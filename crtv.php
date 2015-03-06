<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>
CR TV - z mest a obci</text>
</mediaDisplay>
<channel>
	<title>CR TV - z mest a obci</title>
	<menu>main menu</menu>
<?php
//$html = file_get_contents("http://www.crtv.cz/");
$section = $_GET["section"];
$query = $section;
$html = file_get_contents( $query );


$videos = explode('<tr class="listAll">', $html);

unset($videos[0]);

$videos = array_values($videos);

foreach($videos as $video) {
   
    $t1 = explode('<img src="'.$query.'/images/', $video);
    $t2 = explode('.jpg', $t1[1]);
    $link = $t2[0];
	$odkaz = explode("a", $link);
	
	
	
	$t1 = explode('class="listCity">', $video);
    $t2 = explode('</a>', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<strong>', $video);
    $t2 = explode('</strong>', $t1[1]);
    $titulek2 = $t2[0];
	
	$t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	IF (($query=="http://www.valasske-kralovstvi.tv") or ($query=="http://www.1hokejovaliga.tv")) { 
    echo '<item>';
    echo '<title>'.$titulek.'-'.$titulek2.'</title>';
    echo '<link>'.$query.'/videos/'.$odkaz[0].'-flvhigh.flv</link>';
    echo '<enclosure type="video/flv" url="'.$query.'/videos/'.$odkaz[0].'-flvhigh.flv"/>';
    echo '<media:thumbnail url="'.$nahled.'" />';		
    echo '</item>';
	echo "\n";
}
	
	ELSE{
	echo '<item>';
    echo '<title>'.$titulek.'-'.$titulek2.'</title>';
    echo '<link>'.$query.'/videos/'.$odkaz[0].'-wmvhigh.wmv</link>';
    echo '<enclosure type="video/x-ms-wmv" url="'.$query.'/videos/'.$odkaz[0].'-wmvhigh.wmv"/>';
    echo '<media:thumbnail url="'.$nahled.'" />';		
    echo '</item>';
	echo "\n";}
}


?>

</channel>
</rss>