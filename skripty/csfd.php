<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://www.csfd.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
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
  	<text  redraw="yes" align="center" offsetXPC="0" offsetYPC="90" widthPC="100" heightPC="8" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(annotation); annotation;</script>
		</text>
		<text  redraw="yes" align="left" offsetXPC="58" offsetYPC="53" widthPC="18" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(durata); durata;</script>
		</text>
  	<text  redraw="yes" align="left" offsetXPC="77" offsetYPC="53" widthPC="21" heightPC="5" fontSize="17" backgroundColor="10:105:150" foregroundColor="100:200:255">
		  <script>print(pub); pub;</script>
		</text>
		<image  redraw="yes" offsetXPC=61 offsetYPC=25 widthPC=25 heightPC=50>
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
$page=$_GET["page"];   
IF ($page=="") $page="1";

IF ($page=="1")
$URL = ("http://www.csfd.cz/videa/");
ELSE
$URL = ("http://www.csfd.cz/videa/strana-".$page."/");

if (($html = openpage($URL) ) != FALSE) {

echo "<channel>\n<title>CSFD trailery</title>";

if($page > 1) { ?>
<item>
<?php
$sThisFile = 'http://127.0.0.1:80'.$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-25).",";
if($search) { 
  $url = $url.$search; 
}
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
$videos1 = explode('<ul class="ui-image-list">', $html);
//print_r($videos1);
//unset($videos1[0]);
$videos = explode('<li>', $videos1[1]);
unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode('value="', $video);
    $t2 = explode('"', $t1[1]);
    $videoid = $t2[0];

    $t1 = explode('<img src="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
    $t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[3]);
    $titulek = $t2[0];
	
	$t1 = explode('<p>', $video);
    $t2 = explode('</p>', $t1[1]);
    $zanr = $t2[0];
	
	
	$t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[4]);
	$r = "<";
	$pos = strpos($t2[0], $r);
	if ($pos === false) {
				$rezie = $t2[0];
					}
	$t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[5]);
	$r = "<";
	$pos = strpos($t2[0], $r);
	if ($pos === false) {
				$herec1 = $t2[0];
					}
	
	$t1 = explode('">', $video);
    $t2 = explode('</a>', $t1[6]);
	$r = "<";
	$pos = strpos($t2[0], $r);
	if ($pos === false) {
				$herec2 = $t2[0];
					}
/*	$link="http://www.csfd.cz/videa/?video=".$videoid;
  if (($html = openpage($link) ) != FALSE) {
  
  $t1 = explode('var clip = player.addClip("', $html);
    $t2 = explode('"', $t1[1]);
    $lnk = str_replace('\/','/',$t2[0]);	*/
  
	
	echo '
    <item>
    <title>'.$titulek.'</title>
	<annotation>'.$zanr.'</annotation>
	<durata>Režie: '.$rezie.'</durata>
    <pub>Hrají: '.$herec1.','.$herec2.'</pub>
	<onClick>playItemURL("'.$lnk.'",10);</onClick>
    <image>'.$nahled.'</image>
    <media:thumbnail url="'.$nahled.'" />
    <mediaDisplay name="threePartsView"/>
    </item>
    ';
 

}
?>
<item>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile.'?page='.($page+1);
?>
<title>Další strana</title>
<link><?php echo $url;?></link>
<annotation>Další strana</annotation>
<mediaDisplay name="threePartsView"/>
</item>
<?php
	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>