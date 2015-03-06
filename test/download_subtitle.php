<?php
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
$ROOT  = current(explode('scripts/', dirname(__FILE__).'/')).'';
$DIR_SCRIPT_ROOT  = current(explode('xLiveCZ/', dirname(__FILE__).'/')).'xLiveCZ/';
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';


$url = $_GET["url"];

//stažení titulků
$cmd = $DIR_SCRIPT_ROOT."download_subtitle.sh?type=ct&amp;url=".$url."&amp;disk=".$ROOT." >/dev/null 2>&1 &";
system($cmd);

//převod

    $inFile = $ROOT."ceskatelevize.sub";
	$outFile = str_replace(".sub", ".new.sub", $inFile);
	$regExp = "/^[ ]*[0-9]+; /";
	
	$ret = "";
	$arrLines = file($inFile);
	foreach($arrLines as $line){
		if(strlen(trim($line))==0) continue;
		if(preg_match($regExp, $line)){
			$line = preg_replace($regExp, "", $line);
			$line = trim($line);
			list($t1, $t2) = explode(" ", $line);
			$ret .= "{".$t1."}{".$t2."}\n";
		} else {
			$ret .= trim($line)."\n";
		}
	}
	
	$f = fopen($outFile, "w");
	fwrite($f, $ret);
	fclose($f);
?>