<?php

include("datalogin.php");

require_once('recaptchalib.php');

//prod
$privatekey = "6LfR2vcSAAAAAAqLhylORlU0GPvPs1meLHQtvkg5";

//staging (heroku)
//$privatekey = "6LeO7PcSAAAAAPcPk4ipRQThEznjOkyv1F_LEvVg";


if ($_POST) {

    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(
            array(
                'type' => 'error',
                'text' => 'Request must come from ajax.'
            ));

        die($output);
    }

    if (!isset($_POST["name"]) || !isset($_POST["link"])) {
        $output = json_encode(array('type' => 'error', 'text' => 'Input fields are empty!'));
        die ($output);
    }

    if (!isset($_POST["responseField"]))
    {
        $output = json_encode(array('type' => 'error', 'text' => 'The captcha is empty.'));
        die ($output);
    }

    $resp = recaptcha_check_answer ($privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["challengeField"],
        $_POST["responseField"]);

    if (!$resp->is_valid) {
        $output = json_encode(array('type' => 'error', 'text' => 'The captcha was not entered correctly. Try again.'));
        die ($output);
    } else {

        $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
        $link = filter_var($_POST["link"], FILTER_SANITIZE_URL);


        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $link)) {
            $output = json_encode(array('type' => 'error', 'text' => 'Not a valid URL.'));
            die ($output);
        }

        function addhttp($url)
        {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }

        $link = addhttp($link);

        $link_host = parse_url($link);
        $link_host = $link_host['host'];

        $valid_hosts = array("ovfile.com", "videozer.com", "royalvids.eu", "divxstage.eu",
                "divxstage.net", "veevr.com", "gorillavid.com", "gorillavid.in", "megavideo", "movshare.net",
                "zshare", "tudou", "youtube", "youku", "vidbux.com", "putlocker.com", "sockshare.com",
                "videobb.com", "videoweed.es", "videoweed.com", "smotri.com", "fairyshare.com", "milledrive.com",
                "divxden.com", "vidxden.com", "miloyski.com", "sina.com", "putfile.com", "novamov.com",
                "wisevid.com", "loombo.com", "vidbux.com", "zalaa.com", "vidhog.com", "xvidstage.com",
                "nowvideo.eu", "nowvideo.sx", "divxbase.com", "nosvideo.com", "vidbull.com", "mooshare.biz", "180upload.com",
                "videobam.com", "allmyvideos.net", "modovideo.com", "vidspot.net", "vodlocker.com", "movreel.com",
                "video.tt", "faststream.in", "vidto.me", "firedrive.com", "promptfile.com", "thefile.me", "divxstage.to");


        $is_host_valid = false;

        foreach ($valid_hosts as $host) {
            if ((strpos($link_host, $host) !== false)) {
                $is_host_valid = true;
                break;
            }
        }

        if ($is_host_valid == false) {
            $output = json_encode(array('type' => 'error', 'text' => $link_host . ' is not a valid host.'));
            die ($output);
        }

        $name = urlencode($name);

        $json = file_get_contents("http://www.omdbapi.com/?t=$name&apikey=690932a6");
        $details = json_decode($json);

        if ($details->Response == 'True') {
            $sql = "SHOW TABLES FROM `heroku_e4756db2750b0d8` LIKE '$name'";

            /*$output = json_encode(array('type' => 'message', 'text' => 'About to insert.'));
            die ($output . mysqli_error($link));*/

            $retval = mysqli_query($conn, $sql);


            if (mysqli_num_rows($retval)) {

                $sql = "INSERT INTO `$name` (embedCode, host, created) VALUES ('$link', '$link_host', NOW())";

                $retval = mysqli_query($conn, $sql);


                if (!$retval) {
                    $output = json_encode(array('type' => 'error', 'text' => 'Could not enter data.'));
                    die ($output . mysqli_error($conn));
                }

                //mysqli_close($conn);

                $output = json_encode(array('type' => 'message', 'text' => 'Link entered successfully!'));
                die ($output);

                mysqli_close($conn);

            } else {

                $response_name = $details->Title;
                $response_name = urlencode($response_name);

                $sqlinsert_title = "INSERT INTO `#!movietitle_list`
                (title, created)
                VALUES('$response_name', NOW())";

                $sql_create = "CREATE TABLE IF NOT EXISTS `$response_name`
					(id INT NOT NULL AUTO_INCREMENT,
					PRIMARY KEY (id),
					embedCode VARCHAR(300),
					host VARCHAR(30),
					created DATETIME)
					";

                $sql_insert = "INSERT INTO `$response_name`
							(embedCode, host, created)
							VALUES ('$link', '$link_host', NOW())";

                mysqli_query($conn, $sqlinsert_title) or die (mysqli_error($conn));
                mysqli_query($conn, $sql_create) or die (mysqli_error($conn));
                mysqli_query($conn, $sql_insert) or die (mysqli_error($conn));

                mysqli_close($conn);

                $output = json_encode(array('type' => 'message', 'text' => 'Link entered successfully!'));
                die ($output);
            }
        } else {
            $output = json_encode(array('type' => 'error', 'text' => 'This movie does not exist. Please make sure you typed the name correctly.'));
            die ($output);
        }

    }
} else {
}

?>