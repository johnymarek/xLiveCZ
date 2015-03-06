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
   $link = $queryArr[0];
   $disk = $queryArr[1];
}

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";


$ItemsOut .= "<channel>\n<title>Prima archiv</title>";

if (($html = openpage($link) ) != FALSE) {

//ziskani auth key
$key = "http://embed.livebox.cz/iprima/player-embed.js?__tok".mt_rand ( )."__=".mt_rand ( );

	if (($html2 = openpage($key) ) != FALSE) {
	//print_r($html2);
	$t1 = explode('?auth=', $html2);
    $t2 = explode("'", $t1[1]);
    $auth = str_replace("|","%7C",$t2[0]);

	//rtmp://bcasts1w.livebox.cz:80/iprima_token?auth=_any_|1332631520|406334a49ae1e82e94e3a848600a290e0c35cc0c/mp4:Prima-1203232343-16409_1500.mp4	
	}
	  	
	$t1 = explode("'hq_id':'", $html);
	$t2 = explode("'", $t1[1]);
	$filehq = $t2[0];
    $filehd = str_replace ( "_1000.", "_1500." , $t2[0]);
	
	$t1 = explode("'lq_id':'", $html);
	$t2 = explode("'", $t1[1]);
    $filelq = $t2[0];
	
	$find = "Prima";
	$poshq = strpos($filehq, $find);
	$poslq = strpos($filelq, $find);
	
	//print_r($poshq);
	
	
	$t1 = explode('<link rel="image_src" href="', $html);
	$t2 = explode('"', $t1[1]);
    $nahled = $t2[0];
		
	$t1 = explode("'st_date':'", $html);
	$t2 = explode("'", $t1[1]);
    $datum = $t2[0];

	
	
	
	$t1 = explode("'zoneGEO':", $html);
	$t2 = explode(",", $t1[1]);
    $geo = $t2[0];
	
	IF ($filehq != "") {
	IF (($geo=="0")or(($poshq === false)and($poslq === false))) {
	$prep = "rtmp://bcasts1w.livebox.cz:80/iprima_token?auth=".$auth."/mp4:";}
	ELSE {
	$prep = "rtmp://bcasts1w.livebox.cz:80/iprima_token_1?auth=".$auth."/mp4:";}
	IF (($geo=="0")or(($poshq === true)and($poslq === true))) {
	$prep = "rtmp://bcasts1w.livebox.cz:80/iprima_token?auth=".$auth."/";}
	ELSE {
	$prep = "rtmp://bcasts1w.livebox.cz:80/iprima_token_1?auth=".$auth."/";
	
	}
	
	

	
	
		
			$ItemsOut .= "
			<item>
				<title>Přehrát v HD</title>
				<link>".$disk."xLiveCZ/nova.sh?tip=ct&amp;act='".$prep.$filehd."'</link>
				<enclosure type=\"video/mp4\" url=\"".$disk."xLiveCZ/nova.sh?tip=ct&amp;act='".$prep.$filehd."'\"/>
				<pubDate>".$datum."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
			
			$ItemsOut .= "
			<item>
				<title>Přehrát v HQ</title>
				<link>".$disk."xLiveCZ/nova.sh?tip=ct&amp;act='".$prep.$filehq."'</link>
				<enclosure type=\"video/mp4\" url=\"".$disk."xLiveCZ/nova.sh?tip=ct&amp;act='".$prep.$filehq."'\"/>
				<pubDate>".$datum."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
			
			$ItemsOut .= "
			<item>
				<title>Přehrát v LQ</title>
				<link>".$disk."xLiveCZ/nova.sh?tip=ct&amp;act='".$prep.$filelq."'</link>
				<enclosure type=\"video/mp4\" url=\"".$disk."xLiveCZ/nova.sh?tip=ct&amp;act='".$prep.$filelq."'\"/>
				<pubDate>".$datum."</pubDate>
				<media:thumbnail url=\"".$nahled."\" />
			</item>\n";
			
			
			}
	
	
	
	ELSE {
	
	$t1 = explode('<param name="flashvars" value="', $html);
    $t2 = explode('"', $t1[1]);
    $html2 = $t2[0];
	
	
	
	
	$t1 = explode("hdID=", $html2);
    $t2 = explode('"', $t1[1]);
    $hd = $t2[0];
	
	$t1 = explode("cdnHQ=", $html2);
    $t2 = explode('"', $t1[1]);
    $hq = $t2[0];
	
	$t1 = explode("cdnID=", $html2);
    $t2 = explode('&', $t1[1]);
    $lq= $t2[0];
	
	
	IF ($hd!="") {
	$lhd = "http://cdn-dispatcher.stream.cz/getSource?id=".$hd."&proto=rtmp";
	if (($html2 = openpage($lhd) ) != FALSE) {
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
		$ItemsOut .= "
			<item>
				<title>Přehrát v HD kvalitě ze stream.cz</title>
				<link>http://".$server."/".$cesta."</link>
				<enclosure type=\"video/mp4\" url=\"http://".$server."/".$cesta."\" />
				<pubDate>".$datum."</pubDate>
				<description>Popis:".$popis."</description>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}
	IF ($hq!="") {
	$lhq = "http://cdn-dispatcher.stream.cz/getSource?id=".$hq."&proto=rtmp";
	if (($html2 = openpage($lhq) ) != FALSE) {
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
	
		$ItemsOut .= "
			<item>
				<title>Přehrát v HQ kvalitě ze stream.cz</title>
				<link>http://".$server."/".$cesta."</link>
				<enclosure type=\"video/mp4\" url=\"http://".$server."/".$cesta."\" />
				<pubDate>".$datum."</pubDate>
				<description>Popis:".$popis."</description>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}
	IF ($lq!="") {
	$llq = "http://cdn-dispatcher.stream.cz/getSource?id=".$lq."&proto=rtmp";
	if (($html2 = openpage($llq) ) != FALSE) {
	
	$t1 = explode('domain="', $html2);
	$t2 = explode('"', $t1[1]);
	$server = $t2[0];
	
	$t1 = explode('path="', $html2);
	$t2 = explode('"', $t1[1]);
	$cesta = $t2[0];
	
		$ItemsOut .= "
			<item>
				<title>Přehrát v LQ kvalitě ze stream.cz</title>
				<link>http://".$server."/".$cesta."</link>
				<enclosure type=\"video/flv\" url=\"http://".$server."/".$cesta."\" />
				<pubDate>".$datum."</pubDate>
				<description>Popis:".$popis."</description>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}}
		
	}}

	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
?>