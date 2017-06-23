<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
    include 'datalogin.php';
            
    $name = $_GET["name"];
    $id = $_GET["id"];
    
    $name = urlencode($name);
    
    if (false !== ($json = file_get_contents("http://www.omdbapi.com/?t=$name&apikey=690932a6"))) {
            $details = json_decode($json);

            if ($details->Response == 'True') {

                $imdb = $details->imdbID;
                $Title = $details->Title;
                echo '<meta name="title" content="Play '. $Title .' full putlocker, sockshare, vodlocker - Version '. $id .' - Watchitfree" />';
                echo '<title>Play '. $Title .' full putlocker, sockshare, vodlocker - Version '. $id .' - Watchitfree </title>';
            }
            else{
                echo '<title></title>';
            }
    }
    else{
    
    }
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/style2.css"/>
<link rel='stylesheet' type='text/css' href='css/style3.css'/>
<link rel='stylesheet' type='text/css' href='css/movie_styles.css'/>
<link rel="stylesheet" type="text/css" href="css/search.css" media="screen"/>
<script src="js/jquery-1.11.1.min.js"></script> 

</head>
<body>

<div id="headercontainer">
<div id="fixed">
<div id="header">
    <div id="header-1">
    <a href="http://www.watchitfree.me" style="text-decoration:none;">
        <img src="resources/images/wif.png" class='site-logo' />
    </a>
    </div>
</div>

<div id="menu">
    <div id="menu-top">
        <ul id="topnav">
            <li><a href="http://www.watchitfree.me">Home</a></li>
            <li><a href="new_link.php">Upload Movies</a></li>
            <li><a href="#">Tv-Shows (coming soon)</a></li>
            <li><a href="sort.php?sort=alpha">Movies</a></li>
        </ul>
        <div class="search-icon">
            <p> SEARCH: </p>
            <div id="search">
                <input id="search" type="text" autocomplete="off">
                <ul id="results"></ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div id='alpha-container'>

    <div id = "container">
        <!--<div id="disclaimer"><h3>Welcome to the WatchItFree Alpha stage!</h3>
        </div>-->

<?php

    $name = $_GET["name"];
    $embedID = $_GET["id"];

	$titlename = urlencode($name);
    $titlename = str_replace('%20', '+', $titlename);

    $name = urlencode($name);


    $sql = "SELECT embedCode, host FROM `$titlename` WHERE id = '".$embedID."'";

    $retval = mysqli_query($conn, $sql);

    if (!$retval) {
    die ("Could not get data.");
    }
    $capname = urldecode($name);
    $capname = ucfirst($capname);

    echo ('
        <div id="meta-container">
            <div id="eTitle">
                <h1><span><a href="movie.php?id='.$name.'">'.$capname.'</a></span></h1>
            </div>
        ');
    while ($row = mysqli_fetch_assoc($retval)) {
    echo ('
        <div id="iframecontainer">
        <iframe style="max-width: 100%;" src="'.$row["embedCode"].'"  frameborder=0 marginheight=0 marginwidth=0 scrolling=NO allowfullscreen="true" width="100%" height="450px"></iframe>
        </div>
        ');
    }
    echo ('</div>');

    mysqli_close($conn);

?>
</div>
<div id="footer">
    <div class="wrapper">
        <div class="bottomMenu container firstone">
            <h4>Site Links</h4>
            <ul>
                <li><a href="#">Keywords</a></li>
                <li><a href="#">Movie Genres</a></li>
                <li><a href="#">Movie Years</a></li>
                <li><a href="#">TV Show Genres</a></li>
                <li><a href="#">TV Show Years</a></li>
                <li><a href="#">Trends</a></li>
                <li><a href="#">Latest Watched</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Rules</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <p>
        WatchItFree provides links to other sites on the internet and doesn't host any files itself.
    </p>
</div>
</div>
</div>
<script language="javascript" type="text/javascript" src="js/link_target.js"></script>
<script src="js/search.js"></script>
</body>
</html>