<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.stream.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$nazev = $_GET["id"];
$search = ('http://music.stream.cz/ajax/playlist/load?playlist_id='.$nazev);



echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n<title>Stream MUSIC playlists</title>";
echo "<mediaDisplay>
<text offsetXPC=55 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>Playlist cislo $nazev ze Stream MUSIC</text>			
</mediaDisplay>\n";


if (($html = openpage($search) ) != FALSE) {

	//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<li id="js_pl_clip_id_', $html);

unset($videos[0]);
$videos = array_values($videos);

foreach($videos as $video) {

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];

    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];


    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = 'http://music.stream.cz'.$t2[0];
	
	if (($html = openpage($link) ) != FALSE) {

	   
    $t1 = explode('hdID=', $html);
    $t2 = explode('&', $t1[1]);
    $hd = $t2[0];
	
	$t1 = explode('cdnHQ=', $html);
    $t2 = explode('&', $t1[1]);
    $hq = $t2[0];
	
	$t1 = explode('cdnLQ=', $html);
    $t2 = explode('&', $t1[1]);
    $lq = $t2[0];
	
	IF ($hd=="") $hd = $hq;
	ELSE IF ($hq=="") $hd = $lq;
   

		
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://cdn-dispatcher.stream.cz/?id=".$hd."</link>
				<enclosure type=\"video/mp4\" url=\"http://cdn-dispatcher.stream.cz/?id=".$hd."\" />
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}
		
}


	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>

