<?php
/******
* You may use and/or modify this script as long as you:
* 1. Keep my name & webpage mentioned
* 2. Don't use it for commercial purposes
*
* If you want to use this script without complying to the rules above, please contact me first at: marty@excudo.net
* 
* Author: Martijn Korse
* Website: http://devshed.excudo.net
*
* Date:  08-05-2006
***/

/**
 * version 2.6
 *
 * Warning: you are using an old version!!!
 * 
 * There is a new version of this class which can be downloaded here:
 * http://devshed.excudo.net/scripts/php/source/internet+radio
 *
 * Only use this version if your webserver does not support PHP5
 *
 */
class Radio
{
	var $fields = array();
	var $fieldsDefaults = array(
					"Server Status",
					"Stream Status",
					"Listener Peak",
					"Average Listen Time",
					"Stream Title",
					"Content Type",
					"Stream Genre",
					"Stream URL",
					"Current Song");
	var $usingDefaults;
	var $very_first_str;
	var $domain, $port, $path;
	var $errno, $errstr;
	var $trackLists = array();
	var $isShoutcast, $isIcecast;
	var $nonShoutcastData = array(
					"Server Status"		=> "n/a",
					"Server Type"		=> "n/a",
					"Stream Status"		=> "n/a",
					"Listener Peak"		=> "n/a",
					"Average Listen Time"	=> "n/a",
					"Stream Title"		=> "n/a",
					"Content Type"		=> "n/a",
					"Stream Genre"		=> "n/a",
					"Stream Description"	=> "n/a",
					"Stream URL"		=> "n/a",
					"Stream AIM"		=> "n/a",
					"Stream IRC"		=> "n/a",
					"Current Song"		=> "n/a",
					"Current Listeners"	=> "n/a",
					"Bitrate"		=> "n/a"
					);
	var $altServer = False;

	function Radio($url)
	{
		$parsed_url = parse_url($url);
		$this->domain	= isset($parsed_url['host']) ? $parsed_url['host'] : "";
		$this->port	= !isset($parsed_url['port']) || empty($parsed_url['port']) ? "80" : $parsed_url['port'];
		$this->path	= empty($parsed_url['path']) ? "/" : $parsed_url['path'];

		if (empty($this->domain))
		{
			$this->domain = $this->path;
			$this->path = "";
		}

		$this->setOffset("Current Stream Information");
		$this->setFields();		// setting default fields

		$this->setTableStart("<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">");
		$this->setTableEnd("</table>");
	}

	function setFields($array=False)
	{
		if (!$array)
		{
			$this->fields = $this->fieldsDefaults;
			$this->usingDefaults = true;
		}
		else
		{
			$this->fields = $array;
		}
	}
	function setOffset($string)
	{
		$this->very_first_str = $string;
	}
	function setTableStart($string)
	{
		$this->tableStart = $string;
	}
	function setTableEnd($string)
	{
		$this->tableEnd = $string;
	}

	function getHTML($page=False)
	{
		if (!$page)
			$page = $this->path;
		$contents = "";
		$domain = (substr($this->domain, 0, 7) == "http://") ? substr($this->domain, 7) : $this->domain;


		if (@$fp = fsockopen($domain, $this->port, $this->errno, $this->errstr, 2))
		{
			fputs($fp, "GET ".$page." HTTP/1.1\r\n".
				"User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows 98)\r\n".
				"Accept: */*\r\n".
				"Host: ".$domain."\r\n\r\n");

			$c = 0;
			while (!feof($fp) && $c <= 20)
			{
				$contents .= fgets($fp, 4096);
				$c++;
			}

			fclose ($fp);

			$this->isShoutcast = False;
			$this->isIcecast = False;
			preg_match("/(Content-Type:)(.*)/i", $contents, $matches);
			if (count($matches) > 0)
			{
				$contentType = trim($matches[2]);
				if ($contentType == "text/html")
				{
					$this->isShoutcast = True;
					return $contents;
				}
				else
				{
					$htmlContent = substr($contents, 0, strpos($contents, "\r\n\r\n"));

					$dataStr = str_replace("\r", "\n", str_replace("\r\n", "\n", $contents));
					$lines = explode("\n", $dataStr);
					foreach ($lines AS $line)
					{
						if ($dp = strpos($line, ":"))
						{
							$key = substr($line, 0, $dp);
							$value = trim(substr($line, ($dp+1)));
							if (preg_match("/genre/i", $key))
								$this->nonShoutcastData['Stream Genre'] = $value;
							elseif (preg_match("/name/i", $key))
								$this->nonShoutcastData['Stream Title'] = $value;
							elseif (preg_match("/server/i", $key))
								$this->nonShoutcastData['Stream Type'] = $value;
							elseif (preg_match("/description/i", $key))
								$this->nonShoutcastData['Stream Description'] = $value;
							elseif (preg_match("/content-type/i", $key))
								$this->nonShoutcastData['Content Type'] = $value;
							elseif (preg_match("/icy-br/i", $key))
							{
								$this->nonShoutcastData['Stream Status'] = "Stream is up at ".$value."kbps";
								$this->nonShoutcastData['Bitrate'] = $value;
								$this->isIcecast = True;
							}
							elseif (preg_match("/icy-notice2/i", $key))
							{
								$this->nonShoutcastData['Server Status'] = "This is <span style=\"color: red;\">not</span> a Shoutcast server!";
								if (preg_match("/ultravox/i", $value))
									$this->nonShoutcastData['Server Status'] .= " But an <a href=\"http://ultravox.aol.com/\" target=\"_blank\">Ultravox</a> Server";
								$this->altServer = $value;
							}
							elseif (preg_match("/url/i", $key))
								$this->nonShoutcastData['Stream URL'] = $value;
						}
					}
					if ($this->isIcecast)
					{
						$this->nonShoutcastData['Server Type'] = "Icecast";
						$this->getIcecastStatusHtml();
					}
					return nl2br($htmlContent);
				}
			}
			else
				return $contents;
		}
		else
		{
			return False;
		}
	}

	function getIcecastStatusHtml($page = "/status.xsl")
	{
		$contents = "";
		$domain = (substr($this->domain, 0, 7) == "http://") ? substr($this->domain, 7) : $this->domain;

		if (@$fp = fsockopen($domain, $this->port, $this->errno, $this->errstr, 2))
		{
			fputs($fp, "GET ".$page." HTTP/1.1\r\n".
				"User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows 98)\r\n".
				"Accept: */*\r\n".
				"Host: ".$domain."\r\n\r\n");

			$c = 0;
			while (!feof($fp))
			{
				$contents .= fgets($fp, 4096);
				$c++;
			}

			fclose ($fp);

			$tables = explode("<table", $contents);
			foreach ($tables AS $table)
			{
				if (preg_match("/(<td(.*)>".$this->nonShoutcastData['Stream Title']."<\/td>)/", $table))
				{
					$rows = explode("<tr>", $table);
					foreach ($rows AS $row)
					{
						if (preg_match_all("/<td.*>(.*)<\/td>/siU", $row, $matches))
						{
							$type = trim(str_replace(":", "", $matches[1][0]));
							$value = $matches[1][1];
							if ($type == "Current Song")
								$this->nonShoutcastData['Current Song'] = $value;
							elseif ($type == "Current Listeners")
								$this->nonShoutcastData['Current Listeners'] = $value;
							elseif ($type == "Peak Listeners")
								$this->nonShoutcastData['Listener Peak'] = $value;
						}
					}
				}
			}
		}
	}

	function getServerInfo($display_array=null, $very_first_str=null)
	{
		if (!isset($display_array))
		{
			if ($this->isShoutcast)
			{
				$display_array = $this->fields;
			}
			else
			{
				$display_array = array_keys($this->nonShoutcastData);
			}
		}
		if (!isset($very_first_str))
			$very_first_str = $this->very_first_str;

		if ($html = $this->getHTML())
		{
			 // parsing the contents
			$data = array();

			foreach ($display_array AS $key => $item)
			{
				if ($this->isShoutcast)
				{
					$very_first_pos	= stripos($html, $very_first_str);
					$first_pos	= stripos($html, $item, $very_first_pos);
					$line_start	= strpos($html, "<td>", $first_pos);
					$line_end	= strpos($html, "</td>", $line_start) + 4;
					$difference	= $line_end - $line_start;
					$line		= substr($html, $line_start, $difference);
					$data[$key]	= strip_tags($line);
				}
				else
				{
					$data[$item]	= $this->nonShoutcastData[$item];
				}
			}
			return $data;
		}
		else
		{
			return $this->errstr." (".$this->errno.")";
		}
	}

	function createHistoryArray($page)
	{
		if (!in_array($page, $this->trackLists))
		{
			$this->trackLists[] = $page;
			if ($html = $this->getHTML($page))
			{
				$fromPos	= stripos($html, $this->tableStart);
				if (!$fromPos)
				{
					$fromPos	= stripos($html, str_replace("\"", "", $this->tableStart));
				}
				$toPos		= stripos($html, $this->tableEnd, $fromPos);
				$tableData	= substr($html, $fromPos, ($toPos-$fromPos));
				$lines		= explode("</tr><tr>", $tableData);
				$tracks = array();
				$c = 0;
				foreach ($lines AS $line)
				{
					$info = explode ("</td><td>", $line);
					$time = trim(strip_tags($info[0]));
					if (substr($time, 0, 9) != "Copyright" && !preg_match("/Tag Loomis, Tom Pepper and Justin Frankel/i", $info[1]))
					{
						$this->tracks[$c]['time'] = $time;
						$this->tracks[$c++]['track'] = trim(strip_tags($info[1]));
					}
				}
				if (count($this->tracks) > 0)
				{
					unset($this->tracks[0]);
					if (isset($this->tracks[1]))
						$this->tracks[1]['track'] = str_replace("Current Song", "", $this->tracks[1]['track']);
				}
			}
			else
			{
				$this->tracks[0] = array("time"=>$this->errno, "track"=>$this->errstr);
			}
		}
	}
	function getHistoryArray($page="/played.html")
	{
		if (!in_array($page, $this->trackLists))
			$this->createHistoryArray($page);
		return $this->tracks;
	}
	function getHistoryTable($page="/played.html", $timeColText=False, $trackColText=False, $class=False)
	{
		if (!in_array($page, $this->trackLists))
			$this->createHistoryArray($page);
		$output = "<table".($class ? " class=\"".$class."\"" : "").">";
		if ($timeColText && $trackColText)
			$output .= "<tr><td>".$timeColText."</td><td>".$trackColText."</td></tr>";
		foreach ($this->tracks AS $trackArr)
			$output .= "<tr><td>".$trackArr['time']."</td><td>".$trackArr['track']."</td></tr>";
		$output .= "</table>\n";
		return $output;
	}
}

 // this is needed for those with a php version < 5
 // the function is copied from the user comments @ php.net (http://nl3.php.net/stripos)
if (!function_exists("stripos"))
{
	function stripos($haystack, $needle, $offset=0)
	{
		return strpos(strtoupper($haystack), strtoupper($needle), $offset);
	}
}
?>