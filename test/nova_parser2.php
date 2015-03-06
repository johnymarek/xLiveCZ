<?php
require_once ("./include/browseremulator.class.php");

function openpage ($rowurl) {
	$be = new BrowserEmulator();
	$be->addHeaderLine("Referer", "http://voyo.nova.cz/");   // volani odkud jsi na stranku prisel. pouzij nejakou jejich vychozi stranku.
	$file = $be->fopen($rowurl);

	while ($line = fgets($file, 1024)) {
		$_page.=$line;
	}
	fclose($file);

	if ($_page == "") return FALSE;

	return $_page;
}
// ###############################################################
// ##                                                           ##
// ##   Copyright (C) 2011  Pavel Bačo (killerman)              ##
// ##                                                           ##
// ###############################################################
//$link= $_GET["link"];
$query = $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $page = $queryArr[0];
   $search = $queryArr[1];
}
echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
 

//if (($html = openpage($search) ) != FALSE) {

$ItemsOut .= "<channel>\n<title>Nova archiv</title>";

	
/*	$t1 = explode('input type="hidden" name="parent_id" value="', $html);
    $t2 = explode('"', $t1[1]);
    $strankovani = $t2[0];*/
    
$URL = ($search."?page=".$page);
if (($html = openpage($URL) ) != FALSE) {

echo "<submenu>\n";
//vlozeni polozky menu na dalsi strnku
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page+1).",";
if($search) { 
  $url = $url.$search; 
}
?>
<title>Dalsi strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php
if($page > 0) { ?>
<submenu>
<?php
$sThisFile = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$url = $sThisFile."?query=".($page-1).",";
if($search) { 
  $url = $url.$search; 
}

?>
<title>Predchozi strana</title>
<link><?php echo $url;?></link>
</submenu>

<?php }
	
	

	//nastaveni bloku pro vyhledani pole polozek
$videos = explode("<div class='poster'>", $html);

unset($videos[0]);
$videos = array_values($videos);
//parsovani polozek

	foreach($videos as $video) {

    $t1 = explode("<a href='", $video);
    $t2 = explode("'", $t1[1]);
    $link = "http://www.eaget.cz/media/ims/php/nova_parser_link.php?file=http://voyo.nova.cz".$t2[0];

    $t1 = explode("<img src='", $video);
    $t2 = explode("'", $t1[1]);
    $nahled = $t2[0];

    $t1 = explode("title='", $video);
    $t2 = explode("'", $t1[1]);
    $titulek = $t2[0];

	IF ($titulek!=""){
    
			$ItemsOut .= "
			<item>
				<title>".$titulek."</title>
				<link>".$link."</link>
				<media:thumbnail url='".$nahled."' />
			</item>\n";
    	}
		}



	$ItemsOut .= "</channel>\n</rss>";
	echo $ItemsOut;
} else {
	echo "TEST SELHAL !";
}
?>