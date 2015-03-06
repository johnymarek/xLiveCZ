<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.metropol.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
$URL=$_GET["file"];


if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>Metropol TV</title>";
		
	$t1 = explode('file: "', $html);
	$t2 = explode('"', $t1[1]);
	$link = $t2[0];
	
	$t1 = explode('streamer: "', $html);
	$t2 = explode('"', $t1[1]);
	$rtmp = $t2[0];
	
	$t1 = explode('<title>', $html);
    $t2 = explode('|', $t1[1]);
    $titulek = $t2[0];
	
	
			$ItemsOut .= "
			<item>
				<title>Přehrát: ".$titulek."</title>
				<link>".$link."</link>
				<enclosure type=\"video/mp4\" url=\"".$link."\"/>
			</item>\n";
  	


	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>