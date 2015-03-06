<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.slevydnes.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
  
  $search = ('http://www.slevydnes.cz/');

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
if (($html = openpage($search) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Slevy</title>";

	
	$videos = explode("lokal", $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<a title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
	
	$t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.slevydnes.cz".$t2[0];
	IF ($title != "") {
		$ItemsOut .= "
			<item>
				<title>".$title."</title>
				<link>http://zam.opf.slu.cz/baco/test/slevy_link.php?link=".$link."</link>
			</item>\n";}
    	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>

