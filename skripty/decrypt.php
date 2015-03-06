<?php

$key = $_GET["key"];
$code = $_GET["code"];
$bin = pack('H*', $code);
$lnk = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $bin, MCRYPT_MODE_ECB);
$link = str_replace(array('?'),array(''),$lnk);
echo "link".$link."end";
die();
?>