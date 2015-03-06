<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.huste.tv/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}

class cURL
    {
      var $headers;
      var $user_agent;
      var $compression;
      var $cookie_file;
      var $proxy;

      function cURL($cookies = true, $cookie = '/tmp/Cookies.txt', $compression = 'gzip', $proxy = '')
        {
          $this->headers[]   = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
          $this->headers[]   = 'Connection: Keep-Alive';
          $this->headers[]   = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		  //$this->headers[]  = 'Referer: http://static.putlocker.com/video_player.swf';
          $this->user_agent  = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		  
          $this->referer = 'http://static.putlocker.com/video_player.swf';
		  $this->compression = $compression;
          $this->proxy       = $proxy;
          $this->cookies     = $cookies;
		  
          if ($this->cookies == true)
              $this->cookie($cookie);
        }

      function cookie($cookie_file)
        {
          if (file_exists($cookie_file))
            {
              $this->cookie_file = $cookie_file;
            }
          else
            {
              $file = fopen($cookie_file, 'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
              $this->cookie_file = $cookie_file;
              fclose($file);
            }
        }

      function get($url)
        {
          $process = curl_init($url);
          curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
          curl_setopt($process, CURLOPT_HEADER, 0);
          curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
		  curl_setopt($process, CURLOPT_REFERER, $this->referer);
		  if ($this->cookies == true)
              curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
          if ($this->cookies == true)
              curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
          curl_setopt($process, CURLOPT_ENCODING, $this->compression);
          curl_setopt($process, CURLOPT_TIMEOUT, 30);
          if ($this->proxy)
              curl_setopt($process, CURLOPT_PROXY, $this->proxy);
          curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
          $return = curl_exec($process);
          curl_close($process);
          return $return;
        }

      function post($url)
        {
          $process = curl_init($url);
          curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
          curl_setopt($process, CURLOPT_HEADER, 1);
          curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
          if ($this->cookies == true)
              curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
          if ($this->cookies == true)
              curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
          curl_setopt($process, CURLOPT_ENCODING, $this->compression);
          curl_setopt($process, CURLOPT_TIMEOUT, 30);
          if ($this->proxy)
              curl_setopt($process, CURLOPT_PROXY, $this->proxy);
          curl_setopt($process, CURLOPT_POSTFIELDS, $data);
          curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($process, CURLOPT_POST, 1);
          $return = curl_exec($process);
          curl_close($process);
          return $return;
        }

      function error($error)
        {
          echo "cURL Error : $error";
          die;
        }
    }
	
	
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $nazev = $queryArr[1];
   $disk = $queryArr[2];
   $search = ($nazev."/strana-".$page.".html");

}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?query='.($page+1).','.$nazev.",".$disk;
?>
<title>Další strana</title>
<link><?php echo $link;?></link>
</submenu>
<?php				
if($page > 1) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$link = $sThisFile.'?query='.($page-1).','.$nazev.",".$disk;

?>
<title>Předchozí strana</title>
<link><?php echo $link;?></link>
</submenu>

<?php } 
//if (($html = openpage($search) ) != FALSE) {

$cc = new cURL();
$html  = $cc->post($search);

$ItemsOut .= "<channel>\n<title>Huste TV</title>";
    	
	$videos = explode('<div class="left">', $html);
    
	unset($videos[0]);
	//print_r($html);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $odkaz = $t2[0];
	
	$t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<span class="time">', $video);
    $t2 = explode('</span>', $t1[1]);
    $cas = $t2[0];

	
   			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/huste_parser_link.php?file=".$odkaz.",".$disk."</link>
				<pubDate>Délka videa: ".$cas."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
    	
}
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
?>