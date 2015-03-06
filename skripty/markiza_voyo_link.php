<?php

  require_once ("./include/browseremulator.class.php");

// emulator

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://voyo.markiza.sk/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
 echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

$ItemsOut .= "<channel>\n<title>Markiza archiv</title>"; 

$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $file = $queryArr[0];
   $nazev = $queryArr[1];
   $disk = $queryArr[2];
}

if (($html = openpage($file) ) != FALSE) {

    $t1 = explode('var product_id = "', $html);
    $t2 = explode('"', $t1[1]);
    $prod = $t2[0];
	
	$t1 = explode('var unit_id = "', $html);
    $t2 = explode('"', $t1[1]);
    $unit = $t2[0];
	
	$t1 = explode('<h2 class="title">', $html);
    $t2 = explode("</h2>", $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('- ', $titulek);
    $t2 = explode(" ", $t1[1]);
    $date = $t2[0];
	$d = explode('.', $date);

	$dlouhy = array('adela-show','rodinna-kliatba','druhy-dych','mesto-tienov','televizne-noviny','prve-televizne-noviny','rychle-televizne-noviny-13-00','rychle-televizne-noviny-14-00','rychle-televizne-noviny-16-00',
'rychle-televizne-noviny-15-00','rychle-televizne-noviny-17-00','rychle-televizne-noviny-18-00','prve-pocasie','sportove-noviny','zo-zakulisia-markizy','na-telo','modre-z-neba','bez-servitky','mafianske-popravy',
'ordinacia-v-ruzovej-zahrade','bez-servitky','tudorovci-sex-moc-a-intrigy','sudkyna-hattchetova','dr-oz','v-dobrom-aj-v-zlom','zita-na-krku');

$kratky = array('adela','rodkliatba','druhydych','mestotienov','tn','ptn','rtn1300','rtn1400','rtn1500','rtn1600','rtn1700','rtn1800','ppocasie','sport','zakulisie','natelo','mzn','bezservitky','popravy',
'ordinacia','servitka','tudors','sudkyna','droz','vdobrom','zita');

IF (in_array ($nazev,$dlouhy)){
$key = array_search($nazev, $dlouhy);
$jmeno=$kratky[$key];
	}
	ELSE {
	$jmeno=$nazev;
	}
	$playpath =  "mp4:".$d[2]."/".$d[1]."/".$d[0]."/".$d[2]."-".$d[1]."-".$d[0]."_".strtoupper($jmeno)."-1.mp4";
	
		
	$t1 = explode('mainVideo = new mediaData(', $html);
    $t2 = explode(', ', $t1[1]);
    $media = $t2[2];
	
	
	


$host =  "rtmpe://vod.markiza.sk/voyosk";

$conn = "-C%20O:1%20-C%20NN:0:".$media.".000000%20-C%20NS:1:%20-C%20NN:2:".$prod.".000000%20-C%20NS:3:null%20-C%20O:0";

		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$disk."xLiveCZ/nova.sh?type=markiza&amp;url=".$host."&amp;y=".$playpath."&amp;p=".$file."&amp;k=".$conn."</link>
				<enclosure type=\"video/mp4\" url=\"".$disk."xLiveCZ/nova.sh?type=markiza&amp;url=".$host."&amp;y=".$playpath."&amp;p=".$file."&amp;k=".$conn."\"/>
			</item>\n";
    	
	

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>