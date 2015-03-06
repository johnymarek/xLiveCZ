 <?php
require_once ("./include/shoutcast.php");
$link = $_GET["url"];
$display_array = array("Stream Title", "Stream Genre", "Stream URL", "Current Song");

$radio = new Radio($link);

$data_array = $radio->getServerInfo($display_array);

return ($data_array);
?> 