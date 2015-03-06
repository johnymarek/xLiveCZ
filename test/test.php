<?php
$url = 'http://koukni.cz/MP4/31180602.mp4';

print_r(get_headers($url));

print_r(get_headers($url, 1));
?>
