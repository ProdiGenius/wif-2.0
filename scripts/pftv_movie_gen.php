<?php
require_once 'xpath.php';
//include_once('datalogin.php');

function returnXPathObject($item) {
    $xmlPageDom = new DomDocument();    // Instantiating a new DomDocument object
    @$xmlPageDom->loadHTML($item);  // Loading the HTML from downloaded page
    $xmlPageXPath = new DOMXPath($xmlPageDom);  // Instantiating new XPath DOM object
    return $xmlPageXPath;   // Returning XPath object
}
// Function to make GET request using cURL
function curlGet($url) {
    $ch = curl_init();  // Initialising cURL session
    // Setting cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch);  // Executing cURL session
    curl_close($ch);    // Closing cURL session
    return $results;    // Return the results
}

    //function for making asynchronous curl reqs
    function curlMulti($urls){
        $mh = curl_multi_init();

        //for each url in array...
        foreach ($urls as $id => $d) {
            $ch[$id] = curl_init();

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

        //for each curl session, add results to $results array, remove curl multi session
        foreach ($ch as $id => $content){
            $results[$id] = curl_multi_getcontent($content);
            curl_multi_remove_handle($mh, $content);
        }

        curl_multi_close($mh);

        return $results;
    }


$fh = fopen("pftvmovieurls.txt", "r");
set_time_limit(0);

while(!feof($fh)){
	$current = trim(fgets($fh));
	$iArray[] = explode("*", $current);
}
fclose($fh);

function scrapeMoviePage($episodePage){
	$xpath = new returnXPathObject($episodePage);
	//global $conn;
	$listLen = $xpath->query("//div[@id='mybox']/table/tbody/tr");
	$movieNameUntrimmed = $xpath->query("//div[@class='post-single-content box mark-links']/b[1]/text()")->item(0)->nodeValue;
	$movieNameUntrimmed = preg_replace('/\W\w+\s*(\W*)$/', '', $movieNameUntrimmed);
	$movieName = rtrim($movieNameUntrimmed);
	$movieName = urlencode($movieName);

	if($listLen->length > 2){
		$followUrls = $xpath->query("//div[@id='mybox']/table/tbody/tr[position() > 2]/td[1]/a/@href");
		
		// $sqlinsert_title = "INSERT INTO `#!movietitle_list`
		// (title, created)
		// VALUES('$movieName', NOW())";

		// $sqlcreate_movie = "CREATE TABLE IF NOT EXISTS `$movieName`
		// (id INT NOT NULL AUTO_INCREMENT,
		// PRIMARY KEY (id),
		// embedCode VARCHAR(300),
		// host VARCHAR(30),
		// created DATETIME)";

		// mysqli_query($conn, $sqlinsert_title) or die (mysqli_error($conn));
		// mysqli_query($conn, $sqlcreate_movie) or die (mysqli_error($conn));

		echo "\n";
		print($movieName);
		echo "\n";

		//$array = array();
/*
		foreach ($followUrls as $followUrl) {
			$followUrl = $followUrl->nodeValue;
			$follow[] = ("http://project-free-tv.li". $followUrl);
		}

		$embedPages = curlMulti($follow);

		foreach ($embedPages as $embedPage) {
			scrapeVideoPage($embedPage);
		}
		*/
		foreach ($followUrls as $followUrl){
			$followUrl = $followUrl->nodeValue;
			$followUrl = ("http://project-free-tv.li". $followUrl);
			scrapeVideoPage($followUrl, $movieName);
/*			print("[".$embedVideo."]");
			echo "\n";*/
		}
	}
}
/*function scrapeVideoPage($embedPage){
	$xpathTwo = returnXPathObject($embedPage);
	$framePresent = $xpathTwo->query("//div[@class='post-single-content box mark-links']//iframe/@src");


	if($framePresent->length > 0){
		$embedUrl = $xpathTwo->query("//div[@class='post-single-content box mark-links']//iframe/@src")->item(0)->nodeValue;
		$embedString = $embedUrl;

		$parse = parse_url($embedString);
		$host = $parse["host"];
		$host = preg_replace(array('/embed./','/www./'), '', $host);

		print("[".$embedString."*".$host."]");
		echo "\n";

		//$array[urldecode($movieName)][] = $embedUrl;
	}
	$framePresent = NULL;
	$embedUrl = NULL;
	$embedString = NULL;
	$xpathTwo = NULL;
	$embedUrl = NULL;
	$framePresent = NULL;
	$host = NULL;
	$parse = NULL;

}*/


function scrapeVideoPage($followUrl, $movieName){
	$xpathTwo = new XPATH($followUrl);
	//global $conn;
	$framePresent = $xpathTwo->query("//div[@class='post-single-content box mark-links']//iframe/@src");

	if($framePresent->length > 0){
		$embedUrl = $xpathTwo->query("//div[@class='post-single-content box mark-links']//iframe/@src")->item(0)->nodeValue;
		$embedString = $embedUrl;

		$parse = parse_url($embedString);
		$host = $parse["host"];
		$host = preg_replace(array('/embed./','/www./'), '', $host);

		$sqlinsert_video = "INSERT INTO `$movieName`
		(embedCode, host, created)
		VALUES ('$embedString', '$host', NOW())";

		mysqli_query($conn, $sqlinsert_video) or die (mysqli_error($conn));

		print("[".$embedString."*".$host."]");
		echo "\n";
	}

	return;
}

$starttime = microtime(true);
/*for($i=1900;$i<1910;$i++){
	scrapeMoviePage($iArray[$i][0]);
	print ($i);
	echo "\n";
}
*/
for($i=1900;$i<1910;$i++){
	$array[] = $iArray[$i][0];
}

$episodePages = curlMulti($array);
$x = 1900;

foreach ($episodePages as $episodePage) {
	scrapeMoviePage($episodePage);
	print ($x);
	echo "\n";
	$x++;
}

$endtime = microtime(true);
$timediff = $endtime - $starttime;
echo " ";
echo $timediff;
?>