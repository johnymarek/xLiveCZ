<?php
/*header('Content-type: text/html; charset=utf-8');*/
include('web.php');

// example of how to use basic selector to retrieve HTML contents
include('simple_html_dom.php');
 
// get DOM from URL or file
$html = file_get_html('http://divx.kinotip.cz/');

echo "<?xml version='1.0' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n<title>DIVX</title>\n";
echo "<item>\n";
echo "<title>novinky</title>\n";
echo "<link>".$web ."parser-new.php?polozka=http://divx.kinotip.cz/</link>\n";
echo "<description>aktualne novinky</description>\n";
echo "</item>\n";

// find all link

foreach($html->find('div[class="obar"]') as $e); 
  $obsah=$e->innertext;

$html = str_get_html($obsah);

foreach($html->find('a') as $e) 

if (preg_match("/divx-filmy/", $e, $matches)) 
{//echo $e->href . '<br>';
echo "<item>\n";
echo "<title>".$e->innertext ."</title>
<link>".$web ."parser-new.php?polozka=".$e->href ."</link>
<description>".$e->title."</description>
</item>\n";
}
echo "  <textinput>";
echo "  <title>Hľadaj film na webe </title>";
echo "  <description>";
echo "  Stlač na diaľkovom ovládači 'ENTER' a zadajte nazov filmu ...";
echo "  </description>";
echo "  <link>".$web ."parser-new.php</link>";
echo "  <name>arg</name>";
echo "  </textinput>";

echo "</channel>\n";
echo "</rss>";

?>