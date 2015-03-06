<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.iprima.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $channel = $queryArr[1];
   $id = $queryArr[2];
   $disk = $queryArr[3];
}

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

$ItemsOut .= "<channel>\n<title>Prima archiv</title>";
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",".$channel.",".$id.",".$disk;
echo "<title>Další strana</title>";
echo "<link>$url</link>
</submenu>";
if($page >= 1) {
echo "<submenu>";
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$channel.",".$id.",".$disk;
echo "<title>Předchozí strana</title>";
echo "<link>$url</link>
</submenu>";
}

switch ($channel) {
	case '1':
			$channel_name = "iprima";
			break;
	case '2':
			$channel_name = "cool";
			break;
	case '3':
			$channel_name = "love";
			break;
}

// ###############################################################
// ##                                                           ##
// ##   http://iamm.xf.cz                                       ##
// ##   Copyright (C) 2011  Jiří Vyhnálek (Derby00)             ##
// ##   JSON Parser - získání playlistu iPrima                  ##
// ##                                                           ##
// ###############################################################


// funkce pro překlad do UTF8
function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

// funkce pro zaslání požadavku serveru
function PostToHost($host, $path, $referer, $data_to_send) {
  $fp = fsockopen($host, 80);
  fputs($fp, "POST $path HTTP/1.1\r\n");
  fputs($fp, "Host: $host\r\n");
  fputs($fp, "Referer: $referer\r\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-length: ". strlen($data_to_send) ."\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  fputs($fp, $data_to_send);
  while(!feof($fp)) {
      $res .= fgets($fp, 128);
  }
  fclose($fp);
  return $res;
}
  
// zaslání požadavku serveru a získání odpovědi playlist

$postdata = "method=json&action=relevant"; // výpis první stránky
//$postdata = "method=json&action=relevant&page=1"; // výpis dalších stránek

$playlist = PostToHost(
              "play.iprima.cz",
              "/videoarchiv_ajax/all/$id?method=json&action=relevant&per_page=12&channel=$channel&page=$page",
              "http://play.iprima.cz/videoarchiv_ajax/all/$id?method=json&action=relevant&per_page=12&channel=".$channel."&page=".$page,
              $postdata
);
//?method=json&action=relevant&per_page=12&channel=1&page=0

// překlad do UTF8
$playlist = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $playlist);
//echo $playlist;



//http://www.iprima.cz/videoarchiv/168305/$id/all    

	$videos = explode('{"nid', $playlist);

	unset($videos[0]);
	
	$videos = array_values($videos);

	foreach($videos as $video) {


    $t1 = explode('":"', $video);
    $t2 = explode('"', $t1[1]);
    $id_dil = $t2[0];
	
	$t1 = explode('"image":"', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://www.iprima.cz/".str_replace ( "\/", "/" , $t2[0]);
	
	
    
    $t1 = explode('"title":"', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0]; 
	
	$t1 = explode('"date":"', $video);
    $t2 = explode('"', $t1[1]);
    $datum = $t2[0]; 
	
	
	//http://play.iprima.cz/iprima
	$link = "http://play.iprima.cz/".$channel_name."/".$id_dil."/".$id;
	
	
	
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/newprima_link.php?query=".$link.",".$disk."</link>
				<pubDate>".$datum."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";}
			


	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
?>