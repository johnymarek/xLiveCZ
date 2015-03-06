	class CWebPageDownloader{
		
		public static function _getPageContent($url){
			// create a new cURL resource
			$ch = curl_init();
			
			CLogger::getInstance()->logMessage("WebPageDownloader: ".$url);
			
			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			// grab URL
			$toReturn = curl_exec($ch);
			
			// close cURL resource, and free up system resources
			curl_close($ch);
			
			return $toReturn;
		}	
	}




volání:

CWebPageDownloader::_getPageContent("xxxxxx");