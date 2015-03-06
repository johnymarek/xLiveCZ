<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://ifktv.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

$URL = $_GET["file"];

if (($html = openpage($URL) ) != FALSE) {

	//nastaveni bloku pro vyhledani pole polozek
    $t1 = explode('settingsFile: "', $html);
    $t2 = explode('"', $t1[1]);
    $link = "http://ifktv.cz/".$t2[0];
	
if (($html2 = openpage($link) ) != FALSE) {	

    $t1 = explode('<videoPath value="', $html2);
    $t2 = explode('"', $t1[1]);
    $final = "http://ifktv.cz/".$t2[0];
 	
}}
print $final;
?>