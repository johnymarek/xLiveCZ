<?php
require_once ("./include/browseremulator.class.php");

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
   $sekce = $queryArr[1];
   $odkaz = $queryArr[0];
   $URL = $odkaz;

}


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

if (($html = openpage($URL) ) != FALSE) {
$ItemsOut .= "<channel>\n<title>CZ/SK rádia</title>";

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz;
?>
<title>Vše</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ab";
?>
<title>A - B</title>
<link><?php echo $url;?></link>
</submenu>

<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",c";
?>
<title>C</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",d";
?>
<title>D</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ef";
?>
<title>E - F</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",gh";
?>
<title>G - H</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",ij";
?>
<title>I - J</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",kl";
?>
<title>K - L</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",mn";
?>
<title>M - N</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",op";
?>
<title>O - P</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",qr";
?>
<title>Q - R</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",st";
?>
<title>S - T</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",uv";
?>
<title>U - V</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",wy";
?>
<title>W - Y</title>
<link><?php echo $url;?></link>
</submenu>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?link=".$odkaz.",z";
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
    $link = $t2[0];

    $t1 = explode('<media:thumbnail url="', $video);
    $t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
	
	$t1 = explode('<enclosure type="', $video);
    $t2 = explode('"', $t1[1]);
    $typ = $t2[0];

    $first = mb_substr($titulek, 0, 1, 'utf-8');
	
	IF ($sekce == "") { 
	
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }

	
	IF ($sekce == "ab") { 
	IF (in_array ($first,$ab)){
				$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
   	}


IF ($sekce == "c") { 
	IF (in_array ($first,$c)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
   	}
}
IF ($sekce == "d") { 
	IF (in_array ($first,$d)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
   	}
}
IF ($sekce == "ef") { 
	IF (in_array ($first,$ef)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
   }
IF ($sekce == "gh") { 
	IF (in_array ($first,$gh)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
   	}
}
IF ($sekce == "ij") { 
	IF (in_array ($first,$ij)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "kl") { 
	IF (in_array ($first,$kl)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "mn") { 
	IF (in_array ($first,$mn)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "op") { 
	IF (in_array ($first,$op)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "qr") { 
	IF (in_array ($first,$qr)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "st") { 
	IF (in_array ($first,$st)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "uv") { 
	IF (in_array ($first,$uv)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	}
IF ($sekce == "wy") { 
	IF (in_array ($first,$wy)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
   	}
	}
IF ($sekce == "z") { 
	IF (in_array ($first,$z)){
		$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url=\"".$nahled."\" />
				<enclosure type=\"".$typ."\" url=\"".$link."\"/>
			</item>\n";
    }
	
}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "eaget/php SELHAL !";
}
?>