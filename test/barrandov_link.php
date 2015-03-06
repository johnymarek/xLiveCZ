<?php
// ###############################################################
// ##                                                           ##
// ##   http://sites.google.com/site/pavelbaco/                 ##
// ##   Copyright (C) 2012  Pavel Bačo   (killerman)            ##
// ##                                                           ##
// ###############################################################
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", $URL);   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$URL= $_GET["file"];
echo "<?xml version='1.0' ?>\n";
$DIR_SCRIPT_ROOT  = current(explode('xLiveCZ/', dirname(__FILE__).'/')).'xLiveCZ/';
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";


if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>Barrandov archiv</title>";
	
	$p = $URL;	
    
     $t1 = explode('.swf?itemid=', $html);
    $t2 = explode("'", $t1[1]);
    $id = "http://www.barrandov.tv/special/videoplayerdata/".$t2[0]; 
	//$id = "http://www.barrandov.tv/special/voddata/".$t2[0]; 
	
	$t1 = explode('<title>', $html);
    $t2 = explode('</title>', $t1[1]);
    $titulek = $t2[0]; 
	
	$t1 = explode('content="', $html);
    $t2 = explode('"', $t1[1]);
    $datum = $t2[0]; 
	
	$t1 = explode('<meta name="description" content="', $html);
    $t2 = explode('"', $t1[1]);
    $popis = $t2[0]; 
	
	$t1 = explode('<link rel="image_src" href="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0]; 
	
	
	/*$t1 = explode("new SWFObject('", $html);
    $t2 = explode("'", $t1[1]);*/
    $W = "http://www.barrandov.tv/flash/unigramPlayer_v1.swf?itemid=65240";
	
	
	if (($html2 = openpage($id) ) != FALSE) {
	//print_r($id);
	$f = "WIN 10,3,181,14";
	
	/*$t1 = explode('<hostname>', $html2);
    $t2 = explode('/', $t1[1]);
    $r = "rtmpe://".$t2[0].":1935/vodpass"; */
	
	$t1 = explode('<streamname>', $html2);
    $t2 = explode('</streamname>', $t1[1]);
    $y = $t2[0];

    $t1 = explode('<hashdquality>', $html2);
    $t2 = explode('</hashdquality>', $t1[1]);
    $hd = $t2[0];
	
	IF ($hd == "true") {
	$high = str_replace("500","HD",$y);
	$string = $HTTP_SCRIPT_ROOT."xLiveCZ/nova.sh?type=barrandov&amp;p=".$p."&amp;y=".$high;
	$ItemsOut .= "
			<item>
				<title>HD: ".$titulek."</title>
				<link>".$string."</link>
				<description>".$popis."</description>
				<enclosure type=\"video/mp4\" url=\"".$string."\"/>
				<media:thumbnail url=\"".$nahled."\" />
				
			</item>\n";
	}
	
	$string = $HTTP_SCRIPT_ROOT."xLiveCZ/nova.sh?type=barrandov&amp;p=".$p."&amp;y=".$y;
	
			$ItemsOut .= "
			<item>
				<title>LQ: ".$titulek."</title>
				<link>".$string."</link>
				<description>".$popis."</description>
				<enclosure type=\"video/mp4\" url=\"".$string."\"/>
				<media:thumbnail url=\"".$nahled."\" />
				
			</item>\n";
  	
	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>