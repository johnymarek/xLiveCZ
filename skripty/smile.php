<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://media.tbn.org/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

$link = "http://mfile.akamai.com/66239/live/reflector%3A41866.asx";
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

/*$t1 = explode('http://', $link);
$t2 = explode('/', $t1[1]);
$pref = $t2[0];*/

if (($html = openpage($link) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Smile of Child USA</title>";

	$t1 = explode('<REF HREF="', $html);
    $t2 = explode('"', $t1[1]);
    $link1 = $t2[0];
	$link = str_ireplace(array("&"),array("&amp;"), $link1);

    $ItemsOut .= "
			<item>
				<title>Smile of Child</title>
			    <link>http://127.0.0.1/media/sda1/scripts/xLiveCZ/msdl.sh?type=test&amp;url=".$link."</link>
				<enclosure type=\"video/x-ms-wmv\" url=\"http://127.0.0.1/media/sda1/scripts/xLiveCZ/msdl.sh?type=test&amp;url=".$link."\"/>
				<media:thumbnail url=\"http://www.novahd.cz/images/stanice/smile-of-a-child.jpg\" />
			</item>\n";
			
  
	

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>