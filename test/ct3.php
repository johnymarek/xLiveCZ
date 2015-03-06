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
$ac = array ("A","B","C","Č");
$dh = array ("D","Ď","E","F","G","H");
$im = array ("I","J","K","L","M");
$nr = array ("N","O","P","Q","R","Ř");
$su= array ("S","Š","T","Ť","U","Ú");
$vz = array ("V","W","X","Y","Z","Ž");


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
$url = $sThisFile."?link=1,".$odkaz.",,".$disk;
?>
<title>Vše</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",ac,".$disk;
?>
<title>A - Č</title>
<link><?php echo $url;?></link>
</submenu>

<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",dh,".$disk;
?>
<title>D - H</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",im,".$disk;
?>
<title>I - M</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",nr,".$disk;
?>
<title>N - R</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",su,".$disk;
?>
<title>S - U</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=1,".$odkaz.",vz,".$disk;
?>
<title>V - Z</title>
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

	
	IF ($sekce == "ac") { 
	IF (in_array ($first,$ac)){
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

IF ($sekce == "dh") { 
	IF (in_array ($first,$dh)){
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
IF ($sekce == "im") { 
	IF (in_array ($first,$im)){
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
IF ($sekce == "nr") { 
	IF (in_array ($first,$nr)){
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
IF ($sekce == "su") { 
	IF (in_array ($first,$su)){
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
IF ($sekce == "vz") { 
	IF (in_array ($first,$vz)){
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