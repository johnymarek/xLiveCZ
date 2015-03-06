<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.uloz.to/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$key = $_GET["key"];
$code = $_GET["code"];

$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
echo "<?xml version='1.0' encoding='utf-8' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

$decrypt = 'http://kumen.capnix.com/decrypt.php?key='.$key.'&code='.$code;
if (($link = openpage($decrypt) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Uloz.to</title>";

$t1 = explode('link', $link);
    $t2 = explode('end', $t1[1]);
    $page = $t2[0];
$test = $page;



		$ItemsOut .= "
	<item>
				<title>Pokracovat</title>
				<link>".$HTTP_SCRIPT_ROOT."xLiveCZ/ulozto/ulozto_link.php?url=http://uloz.to".$page."</link>
			</item>\n";		   
	
		
	
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>
