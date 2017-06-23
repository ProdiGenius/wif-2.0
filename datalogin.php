<?php

$dbhost = "us-cdbr-iron-east-03.cleardb.net";
$dbuser = "be16402557cf9f";
$dbpass = "069ad73b";
$dbname = "heroku_e4756db2750b0d8";

ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');

$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die("unable to connect to database.");
mysqli_select_db($conn, $dbname) or die ("Unable to select");
?>