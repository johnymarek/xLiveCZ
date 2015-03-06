<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.huste.tv/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
/*echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";*/

if (($html = openpage($link) ) != FALSE) {

/*$ItemsOut .= "<channel>\n<title>Huste TV</title>";*/
    
	$t1 = explode('videoId=', $html);
    $t2 = explode('&', $t1[1]);
    $config = ("http://www.huste.tv/services/Video.php?clip=".$t2[0]);
	
	/*$t1 = explode('Pridané:</span>', $html);
    $t2 = explode('</li>', $t1[1]);
    $datum = $t2[0];*/
	
	if (($html = openpage($config) ) != FALSE) {
	
	/*$t1 = explode('image="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('title="', $html);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
	
	$t1 = explode('<meta name="category" value="', $html);
    $t2 = explode('"', $t1[1]);
    $category = $t2[0];
	
	$t1 = explode('duration="', $html);
    $t2 = explode('"', $t1[1]);
    $cas = $t2[0];
	
	if ($cas > 0) {
        $mins = floor ($cas / 60);
        $secs = $cas % 60;
        }
	$time= printf ("%d:%2.1f",$cas, $mins, $secs);	*/	
	$videos = explode('<file ', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

	$t1 = explode('url="', $video);
    $t2 = explode('"', $t1[1]);
    $rtmp = $t2[0];
	
	$t1 = explode(' label="', $video);
    $t2 = explode('"', $t1[1]);
    $quality = $t2[0];
	
	$t1 = explode('path="', $video);
    $t2 = explode('"', $t1[1]);
    $Y = $t2[0];
	
	$t1 = explode('rtmp://', $rtmp);
    $t2 = explode('/', $t1[1]);
    $prep = $t2[0];
	
	$W = "http://player.joj.sk/huste/HusteMainPlayer.5.1.swf";
	$C = "1935";
	$N = $prep;
	$R = ("rtmp://".$prep);
		
   
	$finallink = $disk."xLiveCZ/nova.sh?type=obecne&url=".$R."&w=".$W."&p=".$link."&y=".$Y."&a=";
				
 }}}

	print $finallink;
	die();
?>