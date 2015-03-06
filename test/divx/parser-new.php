<?php
include('web.php');

$file=$_GET["polozka"];

if (isset($_GET['arg']))
{
$arg=stripslashes($_GET['arg']);
$file="http://divx.kinotip.cz/?s=".$arg;
}
else
$arg="";


// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
 
// get DOM from URL or file
$html = file_get_html($file);

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n<title>DIVX</title>\n";


// find all link
foreach($html->find('div[class="post"]') as $e)
{
  $obsah=$e->innertext ;

$html = str_get_html($obsah);
foreach($html->find('h2') as $e)
{
$obsah=$e->innertext ;
$html2 = str_get_html($obsah);


foreach($html2->find('a') as $e)
{ $cesta=$e->href ;
  $nazov=$e->innertext ;

 
}
}

foreach($html->find('div[class="entry"]') as $e) 
{
$obsah=$e->innertext ;
$obsah=explode("<br />", $obsah);

$html2 = str_get_html($obsah[0]);
foreach($html2->find('img') as $e) 
{$obrazok=$e->src ;
/*$novyobrazok="http://api.imgur.com/2/upload?url=".$e->src;
$output = file_get_contents($novyobrazok);
echo $html3 = str_get_html($output);
foreach($html3->find('input[type="text"]') as $checkbox)
 {echo $checkbox;
}*/
}
$popis=explode("</p>", $obsah[1]);

$popis[0]=str_replace("\n", "", $popis[0]);
}
if (!isset($nazov))
{
$nazov="Neklikat";
}

echo "<item>
            <title>".$nazov."</title>
               <link>".$web."index3.php?polozka=".$cesta."</link>
			   <description>".$popis[0]."</description>
			   <media:thumbnail url='".$obrazok."' />
			   </item>\n";
}


// strankovanie
$html = file_get_html($file);
foreach($html->find('div[id=\'wp_page_numbers\']') as $e); 
 $obsah=$e->innertext ;

$html = str_get_html($obsah);
foreach($html->find('a') as $e) ;

{

// echo $e->href. " \n ";



			echo "<item>
            <title>Stranka ".$e->innertext ."</title>
               <link>".$web ."parser-new.php?polozka=".$e->href ."</link>
			   <description>".$e->href."</description>
			   </item>\n";

}

//uzavretie
echo "  </channel>";
echo "</rss>";

?>