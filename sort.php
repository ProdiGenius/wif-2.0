<html>


<head>

    <link rel="stylesheet" type="text/css" href="css/sortpage.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/style2.css"/>
    <link rel='stylesheet' type='text/css' href='css/style3.css'/>
    <link rel="stylesheet" type="text/css" href="css/search.css" media="screen"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
<?php
include 'datalogin.php';
?>
    <!-- Start Alexa Certify Javascript -->
<!--<script type="text/javascript">
_atrk_opts = { atrk_acct:"Nx8Wj1a0CM00Ux", domain:"watchitfree.me",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=Nx8Wj1a0CM00Ux" style="display:none" height="1" width="1" alt="" /></noscript>
-->
<!-- End Alexa Certify Javascript -->  

</head>

<body>
<!-- <div id="header">

    <div id="navContainer">

        <div id="Home"><a href="http://www.watchitfree.me" style="text-decoration:none;">HOME</a></div>

        <div id="Home"><a href="new_link.php" style="text-decoration:none;">LINKS</a></div>

        <div id="search">
            <div class="icon">
                <p>SEARCH:</p>
            </div>
            <input id="search" type="text" autocomplete="off">
            <ul id="results"></ul>
        </div>
    </div>

</div> -->
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

    <div id ="container">

    <div id ="pagination_wrapper">

        <?php

        $table_name = "#!movietitle_list";


        if (!isset ($_GET["sort"]))
        {
            die ("404. Sorry.");
        } else {
            $sort_url = $_GET["sort"];
        }

        $max_results = 5;

        if (!isset ($_GET["page"]))
        {
            $page = 0;
        } else {
            $page = $_GET["page"];
        }

        if ($sort_url == 'alpha')
        {
            $sort = "title";
            echo('<div id="pagination-title"><h1>Movies (A-Z)</h1></div>');
        } else if ($sort_url == 'date') {
            $sort = "created desc";
            echo('<div id="pagination-title"><h1>New Movies (Date Added)</h1></div>');

        } else {
            $sort = "create_time desc";
            echo('<div id="pagination-title"><h1>New Movies (Date Added)</h1></div>');
        }

        $sql_total_movies = "select count(*) as total from `$table_name`";

        $return = mysqli_query($conn, $sql_total_movies);

        if (!$return)
        {
            die ("Could not get data.");
        }

        $row = mysqli_fetch_array($return);
        $rec_count = $row[0];


        if ($page == 0) {
            $offset = 0;
        }

        $number_pages = ($rec_count - ($rec_count % $max_results)) / $max_results;

        if ($rec_count % $max_results !== 0)
        {
            $number_pages += 1;
        }

        $offset = $max_results * $page;

        $sql = "select title from `$table_name` order by $sort LIMIT $offset, $max_results";

        $retval = mysqli_query($conn, $sql);

        if (!$retval) {
            die ("Could not get data for retval. '".$page."'");
        }

        echo ('<div id="thumbnail-list">');
        echo ('<ul>');
        while ($row = mysqli_fetch_array($retval))
        {
            echo ("<li><a href='movie.php?id=$row[0]'>");
            $json = file_get_contents("http://www.omdbapi.com/?t=$row[0]&apikey=690932a6");
            $details = json_decode($json);

            if ($details -> Response == 'True')
            {
                $imdb = $details->imdbID;
                $posterUrl = $details->Poster;
            }

            echo ('<img src="'.$posterUrl.'">');
            $row[0] = ucwords($row[0]);
            echo ucwords(urldecode("<h3>$row[0]</h3>"));
            echo ('<p>'.$details->Plot.'</p>');
            echo ('</a></li>');
        }
        echo ('<ul>');
        echo ('</div>');


        echo ('<div class="pagination">');
        echo ('<a href="sort.php?sort='.$sort_url.'&page=0" class="page gradient">First</a>');

        $min_page = null;
        $max_min_page = null;

        if ($page < $number_pages - 3) {
            $min_page = $page + 3;
            $max_min_page = $number_pages - 3;
        } else if ($page > $number_pages - 3) {
            $min_page = $number_pages - ($number_pages - $page);
            $max_min_page = $number_pages;
        }

        if ($min_page == $max_min_page) {
            for ($q = $page; $q <= $number_pages; $q++) {
                $link_address = 'sort.php?sort='.$sort_url.'&page='.$q;
                if ($q == $page)
                {
                    echo "<a href='".$link_address."' class='page active'>$q</a>";
                } else {
                    echo "<a href='".$link_address."' class='page gradient'>$q</a>";
                }
            }
        } else {
            for ($i = $page; $i <= $min_page; $i++) {
                $link_address = 'sort.php?sort='.$sort_url.'&page='.$i;
                if ($i == $page)
                {
                    echo "<a href='".$link_address."' class='page active'>$i</a>";
                } else {
                    echo "<a href='".$link_address."' class='page gradient'>$i</a>";
                }
            }

            echo "... ";

            for ($x = $max_min_page; $x <= $number_pages; $x++) {
                $link_address = 'sort.php?sort='.$sort_url.'&page='.$x;
                if ($x == $page)
                {
                    echo "<a href='".$link_address."' class='page active'>$x</a>";
                } else {
                    echo "<a href='".$link_address."' class='page gradient'>$x</a>";
                }
            }
        }

        $last_link = $number_pages - 1;
        echo ('<a href="sort.php?sort='.$sort_url.'&page='.$last_link.'" class="page gradient">Last</a>');
        echo ('</div>');




        mysqli_close($conn);

        ?>
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


<script language="javascript" type="text/javascript" src="js/link_target.js"></script>
<script src="js/search.js"></script>
<!--
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-53458532-1', 'auto');
    ga('send', 'pageview');

</script>
-->



</body>

</html>
