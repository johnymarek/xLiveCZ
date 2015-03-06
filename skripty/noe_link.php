<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://tvnoe.tbsystem.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
$URL = $_GET["link"];

if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<channel>\n<title>TV Noe archiv</title>";
		
	$t1 = explode('<param name="src" value="', $html);
    $t2 = explode('"', $t1[1]);
    $lnk2 = str_replace ( "low", "high" , $t2[0]);

	if (($html2 = openpage($lnk2) ) != FALSE) {
	
	$t1 = explode('<ref href = "', $html2);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('<Title>', $html2);
    $t2 = explode('</Title>', $t1[1]);
    $titulek = iconv("Windows-1250","UTF-8",$t2[0]);
	
	
			$ItemsOut .= "
			<item>
				<title>Přehrát: ".$titulek."</title>
				<link>".$link."</link>
				<enclosure type=\"video/x-ms-wmv\" url=\"".$link."\"/>
			</item>\n";
  	
	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>