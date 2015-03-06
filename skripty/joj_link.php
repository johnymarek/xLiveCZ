<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.joj.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["file"];
if($query) {
   $queryArr = explode(',', $query);
   $link = $queryArr[0];
   $disk = $queryArr[1];
}
//$link = "http://televizia.joj.sk/tv-archiv/crepiny-s-hviezdickou/14-12-2009.html";
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";


if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>JOJ Archiv</title>";

	$t1 = explode('<base href="', $html);
    $t2 = explode('"', $t1[1]);
    $basepath = $t2[0];

    $t1 = explode('videoId=', $html);
    $t2 = explode('&amp', $t1[1]);
    $link1 = $basepath."services/Video.php?clip=".$t2[0];
	
	
	if (($html = openpage($link1) ) != FALSE) {

	$videos = explode('<file ', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {
	
	$t1 = explode('title="', $html);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$prep = "n11.joj.sk";
	
	$t1 = explode('path="', $video);
    $t2 = explode('"', $t1[1]);
    $odkaz = $t2[0];
	
	$S = "http://c.static.csmatalent.sk/fileadmin/templates/swf/csmt_player.swf?no_cache=171307";
	$C = "1935";
	$N = $prep;
	$T = ("rtmp://".$prep);
	$Y = $odkaz;
		
	$find   = ".mp4";
    $pos = strpos($odkaz, $find);

    IF ($pos === false) {
			$ItemsOut .= "
			<item>
				<title>".$titulek." - Nízka kvalita</title>
				<link>http://".$prep."/".$odkaz."</link>
				<enclosure type=\"video/flv\" url=\"http://".$prep."/".$odkaz."\"/>
			</item>\n";}
	ELSE {
			$ItemsOut .= "
			<item>
				<title>".$titulek." - Vysoká kvalita</title>
			    <link>".$disk."xLiveCZ/nova.sh?type=mp4jh&amp;n=".$N."&amp;t=".$T."&amp;p=".$link."&amp;s=".$S."&amp;y=".$Y."&amp;c=".$C."</link>
				<enclosure type=\"video/mp4\" url=\"".$disk."xLiveCZ/nova.sh?type=mp4jh&amp;n=".$N."&amp;t=".$T."&amp;p=".$link."&amp;s=".$S."&amp;y=".$Y."&amp;c=".$C."\"/>
			</item>\n";
    	
	}}
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>