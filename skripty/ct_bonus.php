<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.ceskatelevize.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["link"];
if($query) {
   $queryArr = explode(',', $query);
   $lnk = $queryArr[0];
   $disk = $queryArr[1];
}
$URL = "http://www.ceskatelevize.cz/ivysilani/".$lnk;


echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

if (($html = openpage($URL) ) != FALSE) {
$ItemsOut .= "<channel>\n<title>ČT iVysílání</title>";

	$videos = explode('<li class="itemBlock clearfix">', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode(' href="', $video);
    $t2 = explode('"', $t1[1]);
    $link = "http://www.ceskatelevize.cz".$t2[0];


    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];



    $t1 = explode('alt="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
if (strpos($titulek,'<') != false) {
    $titulek="Bezejmenný titul";
    }
    $titulek2 = Str_replace("&mdash;","-",$titulek);

			$ItemsOut .= "
			<item>
				<title>".$titulek2."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/ct_link.php?link=".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";

	}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>