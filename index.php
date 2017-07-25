<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-site-verification" content="kgcvAGNBkMvTP6lWUf4qqNpZjU-j-p49Wyl8YkWpR6M" />
<meta name="msvalidate.01" content="39ACD259F09FBA8C53D1DD8C9137CF36" />
<meta name="title" content="Watch Movies and TV Shows Online for Free - Watch it Free! - Putlocker, Sockshare, novamov, firedrive"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title> Watch Movies and TV Shows Online for Free </title>
<?php
    include 'datalogin.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/style2.css"/>
<link rel='stylesheet' type='text/css' href='css/style3.css'/>
<link rel='stylesheet' type='text/css' href='css/movie_styles.css'/>
<link rel="stylesheet" type="text/css" href="css/search.css" media="screen"/>
<script src="js/jquery-1.11.1.min.js"></script> 

<script type="text/javascript">
_atrk_opts = { atrk_acct:"Nx8Wj1a0CM00Ux", domain:"watchitfree.me",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=Nx8Wj1a0CM00Ux" style="display:none" height="1" width="1" alt="" /></noscript>

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


<div id="alpha-container" style="background-color: #FFFFFF;">
    <div id="index-container">
    </div>

    <div id="container">
    <div id="meta-container">
        <div id="Top_shows">
            <div id="title_block">
                <span class="titleboxtitle">POPULAR MOVIES</span>
            </div>
            <div class="thumbnail-display">
                <li>
                <div id="thumbnail">
                    <a href="movie.php?id=The+Avengers" title="The Avengers"><img class="hoverable" id="js-img-lazy" alt="The Avengers" src="resources/images/the_avengers.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail">
                    <a href="movie.php?id=127+Hours" title="127 Hours"><img class="hoverable" id="js-img-lazy" alt="127 Hours" src="resources/images/127_hours.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail">
                    <a href="movie.php?id=War+Horse" title="War Horse"><img class="hoverable" id="js-img-lazy" alt="War Horse" src="resources/images/war_horse.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail" style="">
                    <a href="movie.php?id=Frozen" title="Frozen"><img class="hoverable" id="js-img-lazy" alt="Frozen" src="resources/images/frozen.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail" style="">
                    <a href="movie.php?id=Precious+Cargo" title="Fear The Walking Dead"><img class="hoverable" id="js-img-lazy" alt="Precious Cargo" src="resources/images/precious_cargo.jpg"></a>
                </div>
                </li>
            </div>
            <div id="display-list">
<?php 


            $table_list = "select title from `#!movietitle_list` order by id limit 30";

            $rs = mysqli_query($conn, $table_list);

            if (!$rs) {
                die("Could not get data.");
            }
            $counter = 0;
            $list_index = 0;

            while ($row = mysqli_fetch_array($rs)){
                $list[$list_index]=$row[0];
                $list_index++;
            }

            echo "<ul>";
            while($counter >= 0 && $counter < 10){
                $title = ucwords(urldecode($list[$counter]));
                echo ('<li><a class="mainLink" href="movie.php?id='.$list[$counter].'">'.$title.'</a>');
                $counter++;
            }
            echo "</ul>";
            echo "<ul>";
            while($counter >= 10 && $counter < 20){
                $title = ucwords(urldecode($list[$counter]));
                echo ('<li><a class="mainLink" href="movie.php?id='.$list[$counter].'">'.$title.'</a>');
                $counter++;
            }
            echo "</ul>";
            echo "<ul>";
            while($counter >= 20 && $counter <30){
                $title = ucwords(urldecode($list[$counter]));
                echo ('<li><a class="mainLink" href="movie.php?id='.$list[$counter].'">'.$title.'</a>');
                $counter++;
            }
            echo "</ul>";

?>
            </div>
        </div>
        <div id="Top_movies">
            <div id="title_block">
                <span class="titleboxtitle">RECENTLY ADDED</span>
            </div>
            <div class="thumbnail-display">
                <li>
                <div id="thumbnail">
                    <a href="movie.php?id=The+Avengers" title="The Avengers"><img class="hoverable" id="js-img-lazy" alt="The Avengers" src="resources/images/the_avengers.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail">
                    <a href="movie.php?id=127+Hours" title="127 Hours"><img class="hoverable" id="js-img-lazy" alt="127 Hours" src="resources/images/127_hours.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail">
                    <a href="movie.php?id=War+Horse" title="War Horse"><img class="hoverable" id="js-img-lazy" alt="War Horse" src="resources/images/war_horse.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail" style="">
                    <a href="movie.php?id=Frozen" title="Frozen"><img class="hoverable" id="js-img-lazy" alt="Frozen" src="resources/images/frozen.jpg"></a>
                </div>
                </li>
                <li>
                <div id="thumbnail" style="">
                    <a href="movie.php?id=Precious+Cargo" title="Fear The Walking Dead"><img class="hoverable" id="js-img-lazy" alt="Precious Cargo" src="resources/images/precious_cargo.jpg"></a>
                </div>
                </li>
            </div>
            <div id="display-list">
<?php 


            $table_list = "select title from `#!movietitle_list` order by id limit 30";

            $rs = mysqli_query($conn, $table_list);

            if (!$rs) {
                die("Could not get data.");
            }
            $counter = 0;
            $list_index = 0;

            while ($row = mysqli_fetch_array($rs)){
                $list[$list_index]=$row[0];
                $list_index++;
            }

            echo "<ul>";
            while($counter >= 0 && $counter < 10){
                $title = ucwords(urldecode($list[$counter]));
                echo ('<li><a class="mainLink" href="movie.php?id='.$list[$counter].'">'.$title.'</a>');
                $counter++;
            }
            echo "</ul>";
            echo "<ul>";
            while($counter >= 10 && $counter < 20){
                $title = ucwords(urldecode($list[$counter]));
                echo ('<li><a class="mainLink" href="movie.php?id='.$list[$counter].'">'.$title.'</a>');
                $counter++;
            }
            echo "</ul>";
            echo "<ul>";
            while($counter >= 20 && $counter <30){
                $title = ucwords(urldecode($list[$counter]));
                echo ('<li><a class="mainLink" href="movie.php?id='.$list[$counter].'">'.$title.'</a>');
                $counter++;
            }
            echo "</ul>";

            mysqli_close($conn);
?>
            </div>
        </div>
        
    </div>
    <div id="recentuploads">
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
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <p>
        WatchItFree provides links to other sites on the internet and doesn't host any files itself.
    </p>
</div>
</div>

<script type='text/javascript'> // Javascript for movie image pop-up
    jQuery(function () {
        $('.hoverable').hover(function () {
            $(this).animate();
            $(this).toggleClass('transition');
        });
    });
</script>
<script language="javascript" type="text/javascript" src="js/link_target.js"></script>
<script src="js/search.js"></script>
</body>
</html>
