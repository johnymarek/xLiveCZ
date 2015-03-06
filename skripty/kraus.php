<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.iprima.cz/showjanakrause/videoarchiv");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

/*if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $search = ('http://prima.stream.cz/?&amp;a=videolist_ajax&amp;section='.$queryArr[1].'&amp;uri=prima&amp;orderby=id&amp;no_detail=1&amp;page='.$queryArr[0]);

}*/
$search="http://www.iprima.cz/showjanakrause/videoarchiv";

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>";
if (($html = openpage($search) ) != FALSE) {


    $t1 = explode("Pro ostatní díly Show Jana Krause vyberte videoarchiv pro:", $html);
    $t2 = explode("</tbody>", $t1[1]);
    $cut = $t2[0];
	
	$videos = explode('<a href=', $cut);
    unset($videos[0]);

$videos = array_values($videos);
//print_r($videos);
foreach($videos as $video) {


    $t1 = explode('">', $video);
    $t2 = explode("<", $t1[1]);
    IF ($t2[0]=="") {
			$t1 = explode('<strong>', $video);
			$t2 = explode("</strong>", $t1[1]);
			$titulek = $t2[0];
	}
	ELSE $titulek = $t2[0];

    $t1 = explode('"', $video);
    $t2 = explode('"', $t1[1]);
    $link = $t2[0];
	
	$t1 = explode('Kraus', $video);
    $t2 = explode("'", $t1[3]);
    $nahled = $t2[0];


		
		$ItemsOut .= "
			<item>
				<title>Kraus ".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/kraus_link.php?link=".$link."</link>
			</item>\n";
    	}
		



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>