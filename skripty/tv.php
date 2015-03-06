<?php
require_once ("./include/browseremulator.class.php");
require_once ("./include/shoutcast.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://zam.opf.slu.cz/baco/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
$link = $_GET["link"];
if($link) {
   $queryArr = explode(',', $link);
   $disk = $queryArr[2];
   $sekce = $queryArr[1];
   $odkaz = $queryArr[0];
   $nazev = $queryArr[3];
}
	$URL = $odkaz;
   	$t1 = explode('media/', $disk);
    $t2 = explode('scripts/', $t1[1]);
    $tmp = "/tmp/usbmounts/".$t2[0]."scripts/";

$ab = array ("A","B");
$c = array ("C","Č");
$d = array ("D","Ď");
$ef = array ("E","F");
$gh = array ("G","H");
$ij = array ("I","J");
$kl = array ("K","L");
$mn = array ("M","N");
$op = array ("O","P");
$qr = array ("Q","R","Ř");
$st= array ("S","Š","T","Ť");
$uv= array ("U","Ú","V");
$wy = array ("W","X","Y");
$z = array ("Z","Ž");

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo '<onEnter>
SetScreenSaverStatus("yes");
  startitem = "middle";
  setRefreshTime(1);
</onEnter>

<onRefresh>
  setRefreshTime(-1);
  itemCount = getPageInfo("itemCount");
</onRefresh>

<mediaDisplay name="threePartsView"
	sideLeftWidthPC="30"
	sideRightWidthPC="0"
	headerImageWidthPC="0"
	selectMenuOnRight="no"
	autoSelectMenu="no"
	autoSelectItem="no"
	itemImageHeightPC="0"
	sideColorLeft="0:0:0"
	menuXPC="5"
	menuWidthPC="12"
	itemmenuWidthPC="12"
	menuPerPage="12"
	menuBackgroundColor="0:0:0"
	menuBorderColor="20:20:20" 
	forceFocusOnItem="yes"
	itemImageWidthPC="0"
	itemXPC="31"
	itemYPC="25"
	itemWidthPC="35"
	itemHeightPC="8"
	capWidthPC="58"
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
	 <image  redraw="yes" offsetXPC=75 offsetYPC=25 widthPC=18 heightPC=21>
		<script>print(img); img;</script>
		</image>
	<idleImage>'.$tmp.'xLiveCZ/image/busy0.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy1.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy2.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy3.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy4.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy5.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy6.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy7.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy8.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy9.png</idleImage>

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
					  info = getItemInfo(idx, "info");
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
if (userInput == "PD" || userInput == "PG" || userInput == "pagedown" || userInput == "pageup") 
{
  idx = Integer(getFocusItemIndex());
 if (userInput == "PD" || userInput == "pagedown") 
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
		<idleImage>'.$tmp.'xLiveCZ/image/busy0.png</idleImage>
        <idleImage>'.$tmp.'xLiveCZ/image/busy1.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy2.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy3.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy4.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy5.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy6.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy7.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy8.png</idleImage>
		<idleImage>'.$tmp.'xLiveCZ/image/busy9.png</idleImage>
		</mediaDisplay>

	</item_template>
';
if (($html = openpage($URL) ) != FALSE) {
$ItemsOut .= "<channel>\n<title>".$nazev." TV</title>";

echo "<submenu>\n";
$sThisFile = $disk."xLiveCZ/category/czech.php";
$url = $sThisFile;
?>
<title>HOME MENU</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",,".$disk.",".$nazev;
?>
<title>Vse</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ab,".$disk.",".$nazev;
?>
<title>A - B</title>
<link><?php echo $url;?></link>
</submenu>

<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",c,".$disk.",".$nazev;
?>
<title>C</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",d,".$disk.",".$nazev;
?>
<title>D</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ef,".$disk.",".$nazev;
?>
<title>E - F</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",gh,".$disk.",".$nazev;
?>
<title>G - H</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ij,".$disk.",".$nazev;
?>
<title>I - J</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",kl,".$disk.",".$nazev;
?>
<title>K - L</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",mn,".$disk.",".$nazev;
?>
<title>M - N</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",op,".$disk.",".$nazev;
?>
<title>O - P</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",qr,".$disk.",".$nazev;
?>
<title>Q - R</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",st,".$disk.",".$nazev;
?>
<title>S - T</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",uv,".$disk.",".$nazev;
?>
<title>U - V</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",wy,".$disk.",".$nazev;
?>
<title>W - Y</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",z,".$disk.",".$nazev;
?>
<title>Z</title>
<link><?php echo $url;?></link>
</submenu>
<?php

	$videos = explode('<item>', $html);

	unset($videos[0]);
	$videos = array_values($videos);

	foreach($videos as $video) {

    $t1 = explode('<title>', $video);
    $t2 = explode('</title>', $t1[1]);
	$titulek = $t2[0];
	/*IF ($nazev=="Russia") $titulek = iconv("UTF-8", "ISO-8859-5", $t2[0]);
	ELSE $titulek = $t2[0];*/
    $t1 = explode('<link>', $video);
    $t2 = explode('</link>', $t1[1]);
	$linkorig = $t2[0];
	
	$find = "http";
	$pos = strpos($linkorig, $find);
	IF ($pos !== false) {
	IF ($titulek == "TV Biznes") $link = $disk."/xLiveCZ/msdl.sh?type=live&amp;url=".$linkorig;
	IF ($nazev == "Mix") $link = $disk."/xLiveCZ/msdl.sh?type=mixtv&amp;url=".$linkorig;
	ELSE $link = $linkorig;
	}
	
	$find = "mms";
	$pos = strpos($linkorig, $find);
	IF ($pos !== false) $link = $disk."/xLiveCZ/msdl.sh?type=test&amp;url=".$linkorig;
	
	$find = "rtsp";
	$pos = strpos($linkorig, $find);
	IF ($pos !== false) $link = $disk."/xLiveCZ/msdl.sh?type=test&amp;url=".$linkorig;
	
	$find = "rtmp";
	$pos = strpos($linkorig, $find);
	IF ($pos !== false) {
	
	$t1 = explode('<type>', $video);
    $t2 = explode('</type>', $t1[1]);
	$type  = $t2[0];
	
	IF ($type=="") $link = $disk."/xLiveCZ/nova.sh?type=&amp;url=".$linkorig;
	IF ($type=="markiza"){
	
	$t1 = explode('<p>', $video);
    $t2 = explode('</p>', $t1[1]);
	$p  = $t2[0];
	$link = $disk."/xLiveCZ/nova.sh?type=markiza&amp;url=".$linkorig."&amp;p=".$p;
	}
	IF ($type=="flvocko"){
	
	$t1 = explode('<p>', $video);
    $t2 = explode('</p>', $t1[1]);
	$p  = $t2[0];
	
	$t1 = explode('<w>', $video);
    $t2 = explode('</w>', $t1[1]);
	$w  = $t2[0];
	
	$link = $disk."/xLiveCZ/nova.sh?type=flvocko&amp;url=".$linkorig."&amp;p=".$p;
	}
	IF ($type=="obecne"){
	
	$t1 = explode('<p>', $video);
    $t2 = explode('</p>', $t1[1]);
	$p  = $t2[0];
	
	$t1 = explode('<w>', $video);
    $t2 = explode('</w>', $t1[1]);
	$w  = $t2[0];
	
	$t1 = explode('<y>', $video);
    $t2 = explode('</y>', $t1[1]);
	$y  = $t2[0];
	
	$t1 = explode('<a>', $video);
    $t2 = explode('</a>', $t1[1]);
	$a  = $t2[0];
	
	$link = $disk."/xLiveCZ/nova.sh?type=obecne&amp;url=".$linkorig."&amp;p=".$p."&amp;a=".$a."&amp;y=".$y;
	}
	
	
	}
	
	
	
    $t1 = explode('<image>', $video);
    $t2 = explode('</image>', $t1[1]);
    $nahled = $t2[0];
	
    $first = mb_substr($titulek, 0, 1, 'utf-8');
	
	IF ($sekce == "") { 
	
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }

	
	IF ($sekce == "ab") { 
	IF (in_array ($first,$ab)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
   	}


IF ($sekce == "c") { 
	IF (in_array ($first,$c)){
		
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
   	}
}
IF ($sekce == "d") { 
	IF (in_array ($first,$d)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
   	}
}
IF ($sekce == "ef") { 
	IF (in_array ($first,$ef)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
   }
IF ($sekce == "gh") { 
	IF (in_array ($first,$gh)){
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
   	}
}
IF ($sekce == "ij") { 
	IF (in_array ($first,$ij)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "kl") { 
	IF (in_array ($first,$kl)){
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "mn") { 
	IF (in_array ($first,$mn)){
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "op") { 
	IF (in_array ($first,$op)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "qr") { 
	IF (in_array ($first,$qr)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "st") { 
	IF (in_array ($first,$st)){
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "uv") { 
	IF (in_array ($first,$uv)){
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	}
IF ($sekce == "wy") { 
	IF (in_array ($first,$wy)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
   	}
	}
IF ($sekce == "z") { 
	IF (in_array ($first,$z)){
	$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",10);
				cancelIdle();
				</onClick>
				<image>'.$nahled.'</image>
			</item>\n';
    }
	
}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>