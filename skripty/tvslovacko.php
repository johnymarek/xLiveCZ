<?php 
error_reporting(0);
$disk = $_GET["disk"];
$DIR_SCRIPT_ROOT  = str_replace("http://127.0.0.1/media","/tmp/usbmounts/",$disk);
$DIR_SCRIPT_ROOT = $DIR_SCRIPT_ROOT."xLiveCZ/"; 
function str_between($string, $start, $end){
	$string = " ".$string; $ini = strpos($string,$start);
	if ($ini == 0) return ""; $ini += strlen($start); $len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
$url="http://master-ng.nacevi.cz/cdn.server/ServerLink.ashx?c=tvslovacko;live1&ip=77.95.192.164&tm=jw_adaptive";
$html=file_get_contents($url);
$server=str_between($html,"<jwplayer:streamer>","</jwplayer:streamer>");
$playpath=str_between($html,'url="','"');
$play = $server."/".$playpath;
$playfinal = $disk."xLiveCZ/nova.sh?type=&amp;url=".$play;
echo '<?xml version="1.0" encoding="UTF8" ?>
	<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<mediaDisplay name=threePartsView sideColorLeft="0:0:0" sideLeftWidthPC="18" sideRightWidthPC="10" sideColorRight="0:0:0" headerXPC="14" headerYPC="3" headerWidthPC="95"
	itemImageXPC="21" itemImageYPC="18" itemXPC="34" itemYPC="18" itemWidthPC="46"	menuXPC="5"	menuWidthPC="15" capXPC="82" capYPC="17" capHeightPC="10" headerCapXPC="90"
	headerCapYPC="10" headerCapWidthPC="0" showDefaultInfo="yes" backgroundColor="0:0:0" itemBackgroundColor="0:0:0" infoYPC="85" popupXPC="7" popupWidthPC="15"
	popupBorderColor="0:0:0" idleImageXPC="45" idleImageYPC="45" idleImageWidthPC="8,6" idleImageHeightPC="6" liding=yes showHeader=no forceFocusOnItem=yes>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy0.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy1.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy2.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy3.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy4.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy5.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy6.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy7.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy8.png</idleImage>
		<idleImage>'.$DIR_SCRIPT_ROOT.'image/busy9.png</idleImage>
	<image redraw="no" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="18">'.$DIR_SCRIPT_ROOT.'backgrounds/top.png</image>
		<text align="center" offsetXPC="0" offsetYPC="-2" widthPC="100" heightPC="20" fontSize="30" backgroundColor=-1:-1:-1 foregroundColor=250:250:250>
TV</text>
</mediaDisplay>
	<channel>
<item>
<title>Prehrat</title>
<link>'.$playfinal.'</link>
<enclosure type="video/mp4" url="'.$playfinal.'"/>
</item>
	</channel>
	</rss>
    ';

?>