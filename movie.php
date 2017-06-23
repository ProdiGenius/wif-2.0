<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include 'datalogin.php';    
    $name = $_GET["id"];
    
    $name = urlencode($name);
    
    if (false !== ($json = file_get_contents("http://www.omdbapi.com/?t=$name&apikey=690932a6"))) {
            $details = json_decode($json);

            if ($details->Response == 'True') {

                $imdb = $details->imdbID;
                $Title = $details->Title;
                echo '<meta name="title" content="Watch '. $Title .' putlocker, full for free | Stream '.$Title.' Free HD | Watchitfree" />';
                echo '<title>Watch '. $Title .' putlocker, full for free | Stream '.$Title.' Free HD | Watchitfree</title>';
                echo '<meta name="description" content="Watch '. $Title .' online for free on Putlocker, sockshare, cmovieshd - All hosted on Watchitfree.me" />';
                echo '<meta name="keywords" content="'. $Title .', '.$details->Genre.', putlocker, sockshare, stream movies online, watch free movies, free movies online, vodlocker" />';
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
    <a href="/" style="text-decoration:none;">
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

<?php

	$name = $_GET["id"];

    $titlename = urlencode($name);
    $titlename = str_replace('%20', '+', $titlename);

	$name = urlencode($name);
	

        if (false !== ($json = file_get_contents("http://www.omdbapi.com/?t=$name&apikey=690932a6"))) {
            $details = json_decode($json);

            if ($details->Response == 'True') {

                $imdb = $details->imdbID;
                $Title = $details->Title;
                $posterUrl = $details->Poster;

                echo('

                <div id="meta-container">
                <div id="eTitle">
                <h1><span><a href="movie.php?id='.$name.'">'.$Title.'</a></span></h1>
                </div>
                <div id="thumbnail-box">

                <a>
			    <img src="'.$posterUrl.'"></a>

			    </div>

                <div id="movie_description">

                    <h4>' . $Title . '<span style="opacity: 0.8">' . " " . $details->Year . '</span></h4>

                    <p>GENRE: '.$details->Genre.'</p>

                    <br>

                    <p>' . $details->Plot . '</p>
                    <p>Directed by: '.$details->Director.'</p>
                    <p>Actors: '.$details->Actors.'</p>
                    <br>

                    <p class="rated"> RATED: '.$details->Rated.'</p>
                    <p>RUNTIME: '.$details->Runtime.'</p>
                    <p>'.$details->imdbRating.'/10</p>
                    <p>'.$details->Awards.'</p>

                </div>
                </div>');
            }
        }

        else {
            echo "Movie does not exist.";
        }
       // mysqli_close($conn);
?>

<div id="row">
    <div class="links_container">
    <p style="font-size: 1.5em; font-weight: bold;">Links</p>
    
    <table cellspacing="0">
    <tbody>
        <?php
            $name = $_GET["id"];

            $titlename = urlencode($name);
            $titlename = str_replace('%20', '+', $titlename);

            $name = urlencode($name);

            $sql="SHOW TABLES LIKE '".$titlename."'";

            $sql_table_list_check = "SELECT * FROM `#!movietitle_list` WHERE title = '".$titlename."'";
            $table_check = mysqli_query($conn, $sql_table_list_check);
            
            if (!$table_check) {
            header("Location: errormessages/404.php");
            }

            $row_count = mysqli_num_rows($table_check);

            if ($row_count < 1)
            {
            header("Location: errormessages/404.php");
            }

            $retval = mysqli_query($conn, $sql);

            if (!$retval) {
            die ("Could not get data.");
            }

            $row_count = mysqli_num_rows($retval);

            if ($row_count < 1)
            {
                header("Location: errormessages/404.php");
            }

            else{
                $sql ="SELECT id, host, created FROM `$titlename`";
                $retval = mysqli_query($conn, $sql);

                if (!$retval) {
                    die ("Could not get data.");
                }

                while ($row = mysqli_fetch_assoc($retval)) {
                    echo ('
                    <tr>
                        <td><span><img src="resources/images/unknown.png" style="vertical-align:middle;" height="16px"><a href="video.php?name='.$name.'&id='.$row["id"].'">'.$row["host"].'</span></td>
                        <td><a href="video.php?name='.$name.'&id='.$row["id"].'">Watch This Video!</a></td>
                        <td>'.$row["created"].'</td>
                    </tr>
                    ');
                }
            
            }

        mysqli_close($conn);

        ?>
    </tbody>
    </table>
    </div>  
</div>
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
                <li><a href="#">Contacts</a></li>
            </ul>
        </div>
    </div>
    <p>
        WatchItFree provides links to other sites on the internet and doesn't host any files itself.
    </p>
</div>
</div>
<script language="javascript" type="text/javascript" src="js/link_target.js"></script>
<script src="js/search.js"></script>
</body>
</html>