<?php
echo "<?xml version='1.0' encoding='UTF8' ?>";
$DIR_SCRIPT_ROOT  = current(explode('xLiveCZ/', dirname(__FILE__).'/')).'xLiveCZ/';
$HTTP_SCRIPT_ROOT = current(explode('scripts/', 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/')).'scripts/';
?>
<!--Xtreamer Community 2011 - Killerman and Kumeni-->
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>Vyhledávání Uloz.to</title>
    <menu>main menu</menu>
    <mediaDisplay>
      <text offsetXPC=5 offsetYPC=6 widthPC=50 heightPC=6 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=250:250:250>Uloz.to</text>
    </mediaDisplay>
    <item>
      <title>Vyhledávat na Uloz.to</title>
      <pubDate>Napište klíčová slova názvu videa</pubDate>
      <link>rss_command://search</link>
      <search url="<?php echo $HTTP_SCRIPT_ROOT; ?>xLiveCZ/ulozto/ulozto_find.php?query=0,%s" />
    </item>
    <item>
      <title>Vložit odkaz na Uloz.to</title>
      <pubDate>Vložte část odkazu na uloz.to (Např.:"12345678/video-avi")</pubDate>
      <link>rss_command://search</link>
      <search url="<?php echo $HTTP_SCRIPT_ROOT; ?>xLiveCZ/ulozto/ulozto_link.php?url=http://www.uloz.to/%s" />
    </item>
	<item>
      <title>Uloz.to LIVE</title>
      <link><?php echo $HTTP_SCRIPT_ROOT; ?>xLiveCZ/ulozto/uloztolive.php</link>
    </item>
	<item>
      <title>Vyhledávat na Uloz.to LIVE</title>
      <link><?php echo $HTTP_SCRIPT_ROOT; ?>xLiveCZ/ulozto/uloztolive.php?action=hledat</link>
    </item>
  </channel>
</rss>