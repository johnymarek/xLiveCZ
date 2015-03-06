<?php
$query= $_GET["query"];
if($query) {
   $queryArr = explode(',', $query);
   $captcha = $queryArr[0];
   $picture = $queryArr[1];
   $url = $queryArr[2];
 }

//extract data from the post
extract($_POST);

//set POST variables

$fields = array(
    'id' => 'frm-downloadDialog-freeDownloadForm',
    'captcha[id]' => $picture,
    'captcha[text]' => $captcha,
    'freeDownload' => 'Stáhnout'
				);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string,'&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);

//execute post
$result = curl_exec($ch);
curl_close($ch);
//close connection


echo "<?xml version='1.0' encoding='utf-8' ?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";

//print_r($result);
$ItemsOut .= "<channel>\n<title>Uloz.to</title>";


	$t1 = explode('<p><a href="', $result);
    $t2 = explode('"', $t1[1]);
    $lnk = $t2[0];
	$link = $lnk;// str_replace("&", "&amp;",$lnk);
	 
	$ItemsOut .= "
			<item>
				<title>Přehrát ></title>
				<link>".$link."</link>
				<pubDate>Potvrďte pro začátek přehrávání</pubDate>
				<enclosure type=\"video/mp4\" url=\"".$link."\"/>
			</item>\n";
	
	
	$ItemsOut .= "</channel>\n</rss>";
	
	echo $ItemsOut;
	//print $result;
?>
