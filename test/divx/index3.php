<?php
require_once ("./include/browseremulator.class.php");
$URL= $_GET["polozka"];
function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.kinotip.cz");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
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
		  
          //$this->referer = 'http://static.putlocker.com/video_player.swf';
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

      function post($url, $data)
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

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";


if (($html = openpage($URL) ) != FALSE) {
    
	$ItemsOut = "<channel>\n<title>Divx filmy video</title>";
	
	$t1 = explode('<a href="/vidbux.php?', $html);
    $t2 = explode('"', $t1[1]);
    $idvidbux = "http://divx.kinotip.cz/vidbux.php?".$t2[0];
	
	
	if (($html2 = openpage($idvidbux) ) != FALSE) {

	$t1 = explode('<IFRAME SRC="', $html2);
   	$t2 = explode('"', $t1[1]);
    $id = $t2[0];
	
	//print_r($id);
	/*if (($html3 = curl_init($id) ) != FALSE) {*/
	
	if (($htmlpom = openpage($id) ) != FALSE) {
	
	
	$t1 = explode("top.location.href='", $htmlpom);
    $t2 = explode("'", $t1[1]);
    $pom = $t2[0];
	
	if (($html = openpage($pom) ) != FALSE) {
	
	$t1 = explode('<input name="id" type="hidden" value="', $html);
    $t2 = explode('"', $t1[1]);
    $id = $t2[0];
	$t1 = explode('<input name="fname" type="hidden" value="', $html);
    $t2 = explode('"', $t1[1]);
    $fname = $t2[0];

$fields = array(
    'op' => 'download1',
	'usr_login' => '',
    'id' => $id,
	'id' => $fname,
	'referer' => '',
    'method_free' => 'Continue+to+Video',
				);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $data .= $key.'='.$value.'&'; }
rtrim($data,'&');

$cc = new cURL();
$html3  = $cc->post($pom, $data);
	print_r($html3);
	
	
	$t1 = explode("playlist: '", $html3);
    $t2 = explode("'", $t1[1]);
    $odkaz1 = "http://www.putlocker.com".$t2[0];
	
	$t1 = explode('duration="', $html3);
    $t2 = explode('"', $t1[1]);
    $cas = $t2[0];
	

	
	
	$t1 = explode('<img src="', $html3);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<title>', $html3);
    $t2 = explode('</title>', $t1[1]);
    $titulek = $t2[0];
	
	$cc = new cURL();
    $html4  = $cc->get($odkaz1);
	$t1 = explode('<media:content url="', $html4);
    $t2 = explode('"', $t1[2]);
    $odkaz = $t2[0];
	
			
	
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$odkaz."</link>
				<enclosure type=\"video/x-flv\" url=".$odkaz."\" />
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
  	
	}}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>