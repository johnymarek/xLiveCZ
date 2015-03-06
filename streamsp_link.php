<?php echo "<?xml version='1.0' ?>"; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">

<?php
$link = $_GET["link"];
$html = file_get_contents($link);

$t1 = explode('<meta name="title" content="', $html);
    $t2 = explode('-', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<link rel="image_src" href="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

	echo "<mediaDisplay>
    <text offsetXPC=55 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>:$titulek</text>			
    </mediaDisplay>\n";

    echo "<channel>
	<title>Stream.cz</title>\n";

   $t1 = explode('<meta name="description" content="', $html);
   $t2 = explode('"', $t1[1]);
   $popis1 = $t2[0];
   $popis = Str_replace("&amp;","-",$popis1);
   
   $t1 = explode('<div id="videoDescription">', $html);
   $t2 = explode('-', $t1[1]);
   $datum = $t2[0];
   
   
   $t1 = explode('&cdnHQ=', $html);
   $t2 = explode('&', $t1[1]);
   $hq = $t2[0];
   
   $t1 = explode('&cdnLQ=', $html);
   $t2 = explode('&', $t1[1]);
   $lq = $t2[0];
   
   $t1 = explode('&cdnHD=', $html);
   $t2 = explode('&', $t1[1]);
   $hd = $t2[0];
   
   
   

    IF ($hd!="") {
	$lhd = "http://cdn-dispatcher.stream.cz/getSource?id=".$hd."&proto=rtmp";
	$html2 = file_get_contents($lhd);
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
	
	echo '<item>';echo "\n";
    echo '<title>Přehrát v HD kvalitě</title>';echo "\n";
    echo '<link>http://'.$server.'/'.$cesta.'</link>';echo "\n";
	echo '<pubDate>'.$datum.'</pubDate>';echo "\n";
	echo '<description>Popis: '.$popis.'</description>';echo "\n";
    echo '<media:thumbnail url="'.$nahled.'" />';echo "\n";
    echo '<enclosure type="video/mp4" url="http://'.$server.'/'.$cesta.'"/>';echo "\n";	
    echo '</item>';echo "\n";
	echo "\n";
}
    IF ($hq!="") {
	$lhq = "http://cdn-dispatcher.stream.cz/getSource?id=".$hq."&proto=rtmp";
	$html2 = file_get_contents($lhq);
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
    echo '<item>';echo "\n";
    echo '<title>Přehrát v HQ kvalitě</title>';echo "\n";
    echo '<link>http://'.$server.'/'.$cesta.'</link>';echo "\n";
	echo '<pubDate>'.$datum.'</pubDate>';echo "\n";
	echo '<description>Popis: '.$popis.'</description>';echo "\n";
    echo '<media:thumbnail url="'.$nahled.'" />';echo "\n";
    echo '<enclosure type="video/mp4" url="http://'.$server.'/'.$cesta.'"/>';echo "\n";	
    echo '</item>';echo "\n";
	echo "\n";
}
    IF ($lq!="") {
	$llq = "http://cdn-dispatcher.stream.cz/getSource?id=".$lq."&proto=rtmp";
	$html2 = file_get_contents($llq);
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
   echo '<item>';echo "\n";
    echo '<title>Přehrát v LQ kvalitě</title>';echo "\n";
    echo '<link>http://'.$server.'/'.$cesta.'</link>';echo "\n";
	echo '<pubDate>'.$datum.'</pubDate>';echo "\n";
	echo '<description>Popis: '.$popis.'</description>';echo "\n";
    echo '<media:thumbnail url="'.$nahled.'" />';echo "\n";
    echo '<enclosure type="video/mp4" url="http://'.$server.'/'.$cesta.'"/>';echo "\n";	
    echo '</item>';echo "\n";
	echo "\n";
}
                                           

?>

</channel>
</rss>