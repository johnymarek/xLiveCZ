<?php
$a_itags=array(37,22,18);
@include('ytqual.inc');

$file=$_GET["file"];
if(preg_match('/youtube\.com\/(v\/|watch\?v=)([\w\-]+)/', $file, $match)) {;
  $id = $match[2];
  $link="http://www.youtube.com/watch?v=".$id;
  //$html=file_get_contents($link);
  $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:7.0.1) Gecko/20100101 Firefox/7.0.1");
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_COOKIE, "/tmp/cokie.txt");
        $html = curl_exec($ch);
        curl_close($ch);
  $html = urldecode($html);
  $h=explode('fmt_stream_map',$html);
  $html=urldecode($h[1]);
  $videos = explode('url=', $html);
  foreach ($videos as $video) {
  $t1=explode(";", $video);
    $link=$t1[0];
    $t1=explode("itag=",$link);
    $t2=explode("&",$t1[1]);
    $tip=$t2[0];
    if (in_array($tip,$a_itags)) break;
  }
}
# zkusit odstranit z $tip query fexp - pokud se vyskytuje
if (strpos($link, "fexp")) {
	$query = parse_url($link);
	parse_str( $query[query] , $output);
	$path = ($query['scheme']."://".$query['host'].$query['path']."?");
	unset($output[fexp]);
	$link=$path.http_build_query($output);
}
print $link;
die();
?>