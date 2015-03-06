<?php
error_reporting(0);
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
   $URL = $queryArr[0];
   $disk = $queryArr[1];
}

if (($html = openpage($URL) ) != FALSE) {

	$ItemsOut = "<?xml version='1.0' ?>
	<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">

	<channel>
		<title>ČT iVysílání LIVE</title>\n";

	// získání JSON array
	//http://www.ceskatelevize.cz/ivysilani/embed/iFramePlayerCT24.php?hash=c0c8a758a91f456c09aefd2b333b3717c5c28cb2&amp;videoID=CT24&amp;tpl=live&amp;multimediaID=1
	//extract data from the post
	
 $t1 = explode('callSOAP(', $html);
    $t2 = explode(':[{', $t1[1]);
    $soap1 = $t2[0].":[{";
	
	$t1 = explode('},{', $html);
    $t2 = explode(');', $t1[1]);
    $soap2 = $t2[0];
	
	$soap = $soap1.$soap2;
	//osetreni kdyz neni vlozena do soap reklama, napriklad Udalosti
	$find = "hash";
	$pos = strpos($soap, $find);
	
	//print_r($html);
	
	IF ($pos === false) {
	$t1 = explode('callSOAP(', $html);
    $t2 = explode(');', $t1[1]);
    $soap = $t2[0];
	}
	
	//osetreni pro nektere stranky kde je nejdrive iframe
	IF ($soap=="") {
	
	$t1 = explode('<iframe src="', $html);
    $t2 = explode('"', $t1[1]);
    $pomocna = "http://www.ceskatelevize.cz".$t2[0];
	$link = str_replace('&amp;','&',$pomocna);	
	$link2 = str_replace('&autoStart=false','',$link);
	$lnk = str_replace(' ','%20',$link2);
	
	if (($html2 = openpage($lnk) ) != FALSE) {
	
	 $t1 = explode('callSOAP(', $html2);
    $t2 = explode(');', $t1[1]);
    $soap = $t2[0];
	}}
	
// překlad na PHP multi pole
$json = json_decode($soap, true);

// funkce pro převod na ploché pole
function flattenpost($data) {
    if(!is_array($data)) return urlencode($data);
    $ret=array();
    foreach($data as $n => $v) {
        $ret = array_merge($ret,_flattenpost(1,$n,$v));
    }
    return $ret;
}
function _flattenpost($level,$key,$data) {
    if(!is_array($data)) return array($key=>$data);
    $ret=array();
    foreach($data as $n => $v) {
        $nk=$level>=1?$key."[$n]":"[$n]";
        $ret = array_merge($ret,_flattenpost($level+1,$nk,$v));
    }
    return $ret;
}
// vytvoření plochého pole
$json = flattenpost($json);

// převod pole na parametry pro zaslání požadavku
    foreach ($json as $k => $v)
        $postdata_str .= urlencode($k) .'='. urlencode($v) .'&';

// funkce pro zaslání požadavku serveru
function PostToHost($host, $path, $referer, $data_to_send) {
  $fp = fsockopen($host, 80);
  fputs($fp, "POST $path HTTP/1.1\r\n");
  fputs($fp, "Host: $host\r\n");
  fputs($fp, "Referer: $referer\r\n");
  fputs($fp, "Origin: http://www.ceskatelevize.cz\r\n");
  fputs($fp, "Accept: */*\r\n");
  fputs($fp, "X-Requested-With: XMLHttpRequest\r\n");
  fputs($fp, "x-addr: 127.0.0.1\r\n");
  fputs($fp, "User-Agent: User-Agent","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.168 Safari/535.19\r\n");
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
 
// zaslání požadavku serveru a získání odpovědi
$playlist = PostToHost(
              "www.ceskatelevize.cz",
              "/ivysilani/ajax/playlistURL.php",
              "http://www.ceskatelevize.cz/ivysilani",
              $postdata_str
)."</end>";

// získání výsledného URL playlistu - done...
    $t1 = explode('http://', $playlist);
    $t2 = explode('<', $t1[1]);
    $playlistURL = "http://".$t2[0];
    
if (($html = openpage($playlistURL) ) != FALSE) {
    
    $t1 = explode('base="', $html);
    $t2 = explode('"', $t1[1]);
    //$r = "'".$t2[0]."'";
	$r = $t2[0]."/";
    	
   $videos = explode('<video ', $html);
   unset($videos[0]);
   $videos = array_values($videos);
   foreach($videos as $video) {

   
    $t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $Y = $t2[0];
	
    $t1 = explode('label="', $video);
    $t2 = explode('"', $t1[1]);
    $quality = $t2[0];
	
    $rtmp = "'".$r.$Y."'";
	
       	
         $ItemsOut .= "
         <item>
         <title>Přehrát v $quality</title>
         <link>".$disk."xLiveCZ/nova.sh?tip=ct&amp;act=".$rtmp."</link>
		 <media:thumbnail url='http://www.radiotv.cz/files/gallery/loga_ct.png' />
		 <enclosure type=\"video/mp4\" url=\"".$disk."xLiveCZ/nova.sh?tip=ct&amp;act=".$rtmp."\" />
         </item>\n";
      
   }
}
else {
	 $ItemsOut .= "
         <rss><chanel><item>
         <title>Stanice nyní nevysílá!</title>
		 </item></channel>\n </rss>";
}


	$ItemsOut .= "</channel>\n </rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>