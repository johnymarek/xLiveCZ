<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.ceskatelevize.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["link"];
if($query) {
   $queryArr = explode(',', $query);
   $sekce = $queryArr[2];
   $odkaz = $queryArr[1];
   $page = $queryArr[0];
   $disk = $queryArr[3];
   $URL = "http://www.ceskatelevize.cz/ivysilani/".$odkaz."/";

}
$ab = array ("A","B");
$c = array ("C","Č");
$d = array ("D","Ď");
$ef = array ("E","F");
$gh = array ("G","H");
$ij = array ("I","J");
$kl = array ("K","L");
$mn = array ("M","N");
$op = array ("O","P");
$qr = array ("Q","R","Ř");
$st= array ("S","Š","T","Ť");
$uv= array ("U","Ú","V");
$wy = array ("W","X","Y");
$z = array ("Z","Ž");


//$link= $_GET["link"];
//$URL = "http://www.ceskatelevize.cz/ivysilani/".$link."/";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<mediaDisplay>
<text offsetXPC=25 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250> - Kategorie:$odkaz</text>
</mediaDisplay>\n";
if (($html = openpage($URL) ) != FALSE) {
//echo $html;
$ItemsOut .= "<channel>\n<title>ČT iVysílání - podle žánru</title>";

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",".$disk;
?>
<title>Vše</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",ab,".$disk;
?>
<title>A - B</title>
<link><?php echo $url;?></link>
</submenu>

<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",c,".$disk;
?>
<title>C</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",d,".$disk;
?>
<title>D</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",ef,".$disk;
?>
<title>E - F</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",gh,".$disk;
?>
<title>G - H</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",ij,".$disk;
?>
<title>I - J</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",kl,".$disk;
?>
<title>K - L</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",mn,".$disk;
?>
<title>M - N</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",op,".$disk;
?>
<title>O - P</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",qr,".$disk;
?>
<title>Q - R</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",st,".$disk;
?>
<title>S - T</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",uv,".$disk;
?>
<title>U - V</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",wy,".$disk;
?>
<title>W - Y</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",z,".$disk;
?>
<title>Z</title>
<link><?php echo $url;?></link>
</submenu>
<?php

	//$html = explode('<div class="clearfix">', $URL);
	$t1 = explode('<div class="clearfix programmesList">', $html);
    $t2 = explode('<div class="sidePanel', $t1[1]);
    $html = $t2[0];

	$videos = explode('<li>', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<a', $video);
    $t2 = explode('</li', $t1[1]);
    $parse = $t2[0];

    $t1 = explode('href="/ivysilani/', $parse);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];

    $t1 = explode('>', $parse);
    $t2 = explode('<', $t1[1]);
    $titulek = $t2[0];

    $t1 = explode('<span', $parse);
    $t2 = explode('</span>', $t1[1]);
    $bonus = $t2[0];
	
	$first = mb_substr($titulek, 0, 1, 'utf-8');
	
	IF ($sekce == "") { 
	
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}

	
	IF ($sekce == "ab") { 
	IF (in_array ($first,$ab)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
}

IF ($sekce == "c") { 
	IF (in_array ($first,$c)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
}
IF ($sekce == "d") { 
	IF (in_array ($first,$d)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
}
IF ($sekce == "ef") { 
	IF (in_array ($first,$ef)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
}
IF ($sekce == "gh") { 
	IF (in_array ($first,$gh)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
}
IF ($sekce == "ij") { 
	IF (in_array ($first,$ij)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "kl") { 
	IF (in_array ($first,$kl)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "mn") { 
	IF (in_array ($first,$mn)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "op") { 
	IF (in_array ($first,$op)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "qr") { 
	IF (in_array ($first,$qr)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "st") { 
	IF (in_array ($first,$st)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "uv") { 
	IF (in_array ($first,$uv)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "wy") { 
	IF (in_array ($first,$wy)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	}
IF ($sekce == "z") { 
	IF (in_array ($first,$z)){
	if ($bonus == null) {
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct.php?link=1,".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
    else {
    $ItemsOut .= "
			<item>
				<title>".$titulek." (pouze bonusy)</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_bonus.php?link=".$link.",".$disk."</link>
				<media:thumbnail url=\"/tmp/usbmounts/sda1/scripts/xLive/image/ct.jpg\" />
			</item>\n";
    }
	}
	
}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "skripty SELHAL !";
}
?>