<?php
//$web="http://http://127.0.0.1/media/sda1/scripts/xLiveCZ/kinotip/serialy/";

Function RootFullPath () {
	return $_SERVER['HTTP_HOST'].dirname($_SERVER["SCRIPT_NAME"]);
}

Function RootPath () {
	$folder = explode("/", dirname($_SERVER["SCRIPT_NAME"]));
	unset($folder[0]);
	$folder = array_values($folder);
	return $folder[0];
}

$ROOT = RootPath ();

$ROOT_FULL_PATH = RootFullPath();

$web="http://".$ROOT_FULL_PATH."/";
?>