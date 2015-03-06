<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.muvi.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$link= $_GET["link"];


echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Muvi.cz</title>";

	$t1 = explode('<title>', $html);
    $t2 = explode('</title>', $t1[1]);
    $titulek = $t2[0];
	
	

	$t1 = explode('<link rel="image_src" href="', $html);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode("so.addVariable('hd.file','", $html);
    $t2 = explode("'", $t1[1]);
    $highid = $t2[0];
	
	$t1 = explode("so.addVariable('file','", $html);
    $t2 = explode("'", $t1[1]);
    $lowid = $t2[0];
	
    
	
	IF 	( $highid !=""){
			$ItemsOut .= "
			<item>
				<title>HQ: ".$titulek."</title>
				<link>".$highid."</link>
				<enclosure type=\"video/mp4\" url=\"".$highid."\"/>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
	}
	IF 	( $lowid !=""){
			$ItemsOut .= "
			<item>
				<title>LQ: ".$titulek."</title>
				<link>".$lowid."</link>
				<enclosure type=\"video/mp4\" url=\"".$lowid."\"/>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
	}
	
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>