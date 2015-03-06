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
   $URL = $odkaz;

}

    $find = "radiocz";
	$pos = strpos($odkaz, $find);
	IF ($pos === false) {
	$nazev = "Radia ostatni";}
	ELSE $nazev = "CZ/SK radia";
	
	
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
$ItemsOut .= "<channel>\n<title>".$nazev."</title>";

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
$url = $sThisFile."?link=".$odkaz.",,".$disk;
?>
<title>Vse</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ab,".$disk;
?>
<title>A - B</title>
<link><?php echo $url;?></link>
</submenu>

<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",c,".$disk;
?>
<title>C</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",d,".$disk;
?>
<title>D</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ef,".$disk;
?>
<title>E - F</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",gh,".$disk;
?>
<title>G - H</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ij,".$disk;
?>
<title>I - J</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",kl,".$disk;
?>
<title>K - L</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",mn,".$disk;
?>
<title>M - N</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",op,".$disk;
?>
<title>O - P</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",qr,".$disk;
?>
<title>Q - R</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",st,".$disk;
?>
<title>S - T</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",uv,".$disk;
?>
<title>U - V</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",wy,".$disk;
?>
<title>W - Y</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",z,".$disk;
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

    $t1 = explode('<link>', $video);
    $t2 = explode('</link>', $t1[1]);
	//$info = str_replace("http://127.0.0.1/media/sda1/scripts/xLiveCZ/msdl.sh?type=test&amp;url=","",$t2[0]);
    $link = str_replace("http://127.0.0.1/media/sda1/scripts/",$disk,$t2[0]);

	
    $t1 = explode('<media:thumbnail url="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
    $first = mb_substr($titulek, 0, 1, 'utf-8');
	
	IF ($sekce == "") { 
	
		$ItemsOut .= '
			<item>
				<title>'.$titulek.'</title>
				<onClick>
				showIdle();
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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
				playItemURL("'.$link.'",5);
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