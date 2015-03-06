<?php

// ###############################################################
// ##                                                           ##
// ##   http://iamm.xf.cz                                       ##
// ##   Copyright (C) 2011  Jiří Vyhnálek (Derby00)             ##
// ##   JSON Parser - získání playlistu iPrima                  ##
// ##                                                           ##
// ###############################################################


// funkce pro překlad do UTF8
function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

// funkce pro zaslání požadavku serveru
function PostToHost($host, $path, $referer, $data_to_send) {
  $fp = fsockopen($host, 80);
  fputs($fp, "POST $path HTTP/1.1\r\n");
  fputs($fp, "Host: $host\r\n");
  fputs($fp, "Referer: $referer\r\n");
  fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  fputs($fp, "Content-length: ". strlen($data_to_send) ."\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  fputs($fp, $data_to_send);
  while(!feof($fp)) {
      $res .= fgets($fp, 128);
  }
  fclose($fp);
  return $res;
}
  
// zaslání požadavku serveru a získání odpovědi playlist

$postdata = "method=json&action=relevant"; // výpis první stránky
//$postdata = "method=json&action=relevant&page=1"; // výpis dalších stránek

$playlist = PostToHost(
              "www.iprima.cz",
              "/videoarchiv_ajax/all/2317/all",
              "http://www.iprima.cz/videoarchiv_ajax/all/2317/all",
              $postdata
);

// překlad do UTF8
$playlist = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $playlist);
echo $playlist;

// získání embed videa
/*$postdata = "method=json&action=video"; // výpis embed videa

$embed = PostToHost(
              "www.iprima.cz",
              "/videoarchiv_ajax/165786",
              "http://www.iprima.cz/videoarchiv_ajax/171814",
              $postdata
);

// překlad do UTF8
$embed = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $embed);
echo $embed;*/


?>