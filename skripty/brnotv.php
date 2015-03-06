<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.b-tv.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
  
  
  
  $search = ('http://www.b-tv.cz/videoarchiv');

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
if (($html = openpage($search) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Brno TV</title>";

	
	$videos = explode('<li><a', $html);
    
	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('href="', $video);
    $t2 = explode('"', $t1[1]);
    $sekce = ('http://www.b-tv.cz/videoarchiv'.$t2[0]);
	
	$t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $title = $t2[0];
	
		IF ($title != ("Všechny") AND $title != ("Autorská čtení") AND $title != ("ŠIK")) {
   		$ItemsOut .= "
			<item>
				<title>".$title."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/brnotv_parser.php?file=".$sekce."</link>
			</item>\n";
    	}
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>