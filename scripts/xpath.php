<?php
/*
The following class will be used for scraping IMDB
as well as tv streaming sites in future. So far my 
intentions are to test it on IMDB and store the 
data in a db so we can get rid of the OMDB and not be 
restricted to a limited amount of queries.
*/
class XPATH {
	public $dom, $xpath, $proxy;

	function __construct($urls){
		set_time_limit(0); 

		$html = $this->curlMulti($urls);
		$this->dom = new DOMDocument();
		@$this->dom->loadHTML($html);
		$this->xpath = new DOMXPath($this->dom);
		
	}


	//function for making asynchronous curl reqs
	public function curlMulti($urls){
		$mh = curl_multi_init();

		//for each url in array...
		foreach ($urls as $id => $d) {
			$ch[$id] =curl_init();

			$url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;

            curl_setopt($ch[$id], CURLOPT_URL, $url);
          	curl_setopt($ch[$id], CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
            curl_setopt($ch[$id], CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch[$id], CURLOPT_HEADER, 1);
            curl_multi_add_handle($mh, $ch[$id]);// Add curl sessions to curl multi session
    
		}

		$running = NULL; // Set $running to NULL

		do{
			curl_multi_exec($mh, $running); //Execute curl multi session in parallel
		}while ($running > 0);

		//for each curl session, add results to $results array, remove curl multi
		foreach ($ch as $id => $content){
			$results[$id] = curl_multi_getcontent($content);
			curl_multi_remove_handle($mh, $content);
		}

		curl_multi_close($mh);

/*		if (!$results) {
			echo "<br />cURL error number:" .curl_errno($ch);
			echo "<br />cURL error:" . curl_error($ch) . " on URL - " . $url;
			var_dump(curl_getinfo($ch));
			var_dump(curl_error($ch));
			exit;
		}*/

		return $results;
	}

	public function query($q){
		$result = $this->xpath->query($q);
		return $result;
	}


	public function preview($results){
		echo "<pre>";
		print_r($results);
		echo "<br>Node Values <br>";
		foreach($results as $result){
			echo trim($result->nodeValue) . '<br>';
			$array[] = $result;
		}
		if(is_array($array)){
			echo "<br><br>";
			print_r($array);
		}
		
	}

	private function __curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		// for use of proxies
		// curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		// curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

		$result = curl_exec($ch);
		
		//display errors
		if (!$result) {
			echo "<br />cURL error number:" .curl_errno($ch);
			echo "<br />cURL error:" . curl_error($ch) . " on URL - " . $url;
			var_dump(curl_getinfo($ch));
			var_dump(curl_error($ch));
			exit;
		}
		return $result;
				
	}

	// returns random proxies from a proxy.txt file (for future use)
	private function __getProxy(){
		$fh = fopen("../proxy.txt", 'r+');
		while(!feof($fh)){
			$proxies[] = trim(fgets($fh));
		}
		$proxy = $proxies[array_rand($proxies)]; // choose random proxy
		fclose($fh);
		return $proxy;
	}
	
}
?>