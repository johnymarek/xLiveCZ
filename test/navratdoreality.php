<?php
  class cURL
    {
      var $headers;
      var $user_agent;
      var $compression;
      var $cookie_file;
      var $proxy;

      function cURL($cookies = TRUE, $cookie = '/tmp/Cookies.txt', $compression = 'gzip', $proxy = '')
        {
          $this->headers[]   = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
          $this->headers[]   = 'Connection: Keep-Alive';
          $this->headers[]   = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
          $this->user_agent  = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7';
          $this->compression = $compression;
          $this->proxy       = $proxy;
          $this->cookies     = $cookies;
		  
          if ($this->cookies == TRUE)
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
		  curl_setopt($process, CURLOPT_POST, 1); // set POST method
          curl_setopt($process, CURLOPT_POSTFIELDS, "ACTION=check_adult&check=18plus&submit=Je mi více než 18 let."); // add POST fields 
		  if ($this->cookies == TRUE)
              curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
          if ($this->cookies == TRUE)
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
		  curl_setopt($process, CURLOPT_POST, 1); // set POST method
          curl_setopt($process, CURLOPT_POSTFIELDS, "ACTION=check_adult&check=18plus&submit=Je mi více než 18 let."); // add POST fields 
          if ($this->cookies == TRUE)
              curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
          if ($this->cookies == TRUE)
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



echo "<?xml version='1.0' encoding='UTF8' ?>";
?>
<rss version="2.0">
<onEnter>
  startitem = "middle";
  setRefreshTime(1);
</onEnter>

<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
</onRefresh>

<mediaDisplay name="threePartsView"
	sideLeftWidthPC="0"
	sideRightWidthPC="0"
	headerImageWidthPC="0"
	selectMenuOnRight="no"
	autoSelectMenu="no"
	autoSelectItem="no"
	itemImageHeightPC="0"
	itemImageWidthPC="0"
	itemXPC="3"
	itemYPC="25"
	itemWidthPC="52"
	itemHeightPC="8"
	capXPC="3"
	capYPC="25"
	capWidthPC="52"
	capHeightPC="64"
	itemBackgroundColor="0:0:0"
	itemPerPage="8"
    itemGap="0"
	bottomYPC="90"
	backgroundColor="0:0:0"
	showHeader="no"
	showDefaultInfo="no"
	imageFocus=""
	sliding="no" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10"
>

 	<text align="center" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="20" fontSize="30" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>getPageInfo("pageTitle");</script>
		</text>
  	<text redraw="yes" offsetXPC="85" offsetYPC="12" widthPC="10" heightPC="6" fontSize="20" backgroundColor="10:105:150" foregroundColor="60:160:205">
		  <script>sprintf("%s / ", focus-(-1))+itemCount;</script>
		</text>
  	<text  redraw="yes" align="left" offsetXPC="58" offsetYPC="85" widthPC="40" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(annotation); annotation;</script>
		</text>
		<text  redraw="yes" align="left" offsetXPC="58" offsetYPC="80" widthPC="40" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(durata); durata;</script>
		</text>
  	<text  redraw="yes" align="left" offsetXPC="58" offsetYPC="75" widthPC="40" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(pub); pub;</script>
		 </text> 
		<image  redraw="yes" offsetXPC=57 offsetYPC=22 widthPC=50 heightPC=50>
		<script>print(img); img;</script>
		</image>
	<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy0.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy1.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy2.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy3.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy4.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy5.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy6.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy7.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy8.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy9.png</idleImage>

		<itemDisplay>
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx) 
					{
					  location = getItemInfo(idx, "location");
					  img = getItemInfo(idx,"image");
					  annotation = getItemInfo(idx, "annotation");
					  durata = getItemInfo(idx, "durata");
					  pub = getItemInfo(idx, "pub");
					}
					getItemInfo(idx, "title");
				</script>
				<fontSize>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "16"; else "14";
  				</script>
				</fontSize>
			  <backgroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "10:80:120"; else "-1:-1:-1";
  				</script>
			  </backgroundColor>
			  <foregroundColor>
  				<script>
  					idx = getQueryItemIndex();
  					focus = getFocusItemIndex();
  			    if(focus==idx) "255:255:255"; else "140:140:140";
  				</script>
			  </foregroundColor>
			</text>

		</itemDisplay>
		
<onUserInput>
<script>
ret = "false";
userInput = currentUserInput();

if (userInput == "pagedown" || userInput == "pageup")
{
  idx = Integer(getFocusItemIndex());
  if (userInput == "pagedown")
  {
    idx -= -8;
    if(idx &gt;= itemCount)
      idx = itemCount-1;
  }
  else
  {
    idx -= 8;
    if(idx &lt; 0)
      idx = 0;
  }

  print("new idx: "+idx);
  setFocusItemIndex(idx);
	setItemFocus(0);
  redrawDisplay();
  "true";
}
ret;
</script>
</onUserInput>

	</mediaDisplay>
	<item_template>
		<mediaDisplay  name="threePartsView" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
        	<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy1.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy2.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy3.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy4.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy5.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy6.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy7.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy8.png</idleImage>
		<idleImage>/tmp/usbmounts/sda1/scripts/xLiveCZ/image/busy9.png</idleImage>
		</mediaDisplay>

	</item_template>

<?php
$query=$_GET["query"];   
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $category = $queryArr[1];
}
$URL = ("http://navratdoreality.cz/?p=list&page=".$page."&cat=".$category);

$h = new cURL();
$html = $h->get($URL);
echo "<channel>\n<title>Návrat do reality</title>";

if($page > 1) { ?>
<item>
<?php
$sThisFile = 'http://127.0.0.1:80'.$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",".$category;
?>
<title>Předchozí strana</title>
<link><?php echo $url;?></link>
<annotation>Předchozí strana</annotation>
<durata></durata>
<pub></pub>
<mediaDisplay name="threePartsView"/>
</item>
<?php } ?>
<?php
	//nastaveni bloku pro vyhledani pole polozek
$videos = explode('<div class="nadpis">', $html);
unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode('<a href="', $video);
    $t2 = explode('"', $t1[1]);
    $videoid = "http://navratdoreality.cz/".$t2[0];
	$linktoparse = str_replace('&amp;','&',$videoid);

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = "http://navratdoreality.cz".$t2[0];
	
    $t1 = explode('title="', $video);
    $t2 = explode('"', $t1[1]);
    $titulek = $t2[0];
	
	$t1 = explode('<br />hodnocení <span>', $video);
    $t2 = explode('</span>', $t1[1]);
    $hodnoceni = $t2[0];
	
	
	$t1 = explode('<br />shlédnuto <span>', $video);
    $t2 = explode('</span>', $t1[1]);
	$pocet = $t2[0];
				
	$t1 = explode('<div class="popis"><div>', $video);
    $t2 = explode('</div>', $t1[1]);
	$popis_bad = $t2[0];
	$popis = str_replace(array('<b>','</b>','<br />'),array('','',''),$popis_bad);
	$a = new cURL();
    $html2 = $a->get($linktoparse);
				
	$t1 = explode('"file","', $html2);
    $t2 = explode('"', $t1[1]);
    $link = "http://navratdoreality.cz/".$t2[0];

    $find = (".flv");$find2 = (".mp4");
	$pos = strpos($link, $find);$pos2 = strpos($link, $find2);
		if (($pos === false)AND($pos2 === false)){ $tit="";}
	ELSE {
	 
  echo '
    <item>
    <title>'.$titulek.'</title>
    <onClick>
    <script>
    showIdle();
    cancelIdle();
    playItemURL("'.$link.'", 10);
    </script>
    </onClick>
    <image>'.$nahled.'</image>
    <media:thumbnail url="'.$nahled.'" />
	<annotation>Hodnocení: '.$hodnoceni.'</annotation>
	<durata>Shlédnuto: '.$pocet.'</durata>
    <pub>'.$popis.'</pub>
    <mediaDisplay name="threePartsView"/>
    </item>
    ';

}}
?>
<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile.'?query='.($page+1).",".$category;
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
<annotation>Další strana</annotation>
<mediaDisplay name="threePartsView"/>
</item>
<?php
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
?>