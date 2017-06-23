<html>
<head>
    <title>Add a New Movie</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/style2.css"/>
    <link rel='stylesheet' type='text/css' href='css/style3.css'/>
    <link rel='stylesheet' type='text/css' href='css/movie_styles.css'/>
    <link rel="stylesheet" type="text/css" href="css/input.css">
    <link rel="stylesheet" type="text/css" href="css/search.css" media="screen" />
    <script src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {


        $(".search_btn").click(function() {

            var movie_name = $('input[name="name"]').val();

            var proceed_search = true;

            if (movie_name == "")
            {
                $('input[name=name]').css('border-color', 'red');
                proceed_search = false;
            }

            if (proceed_search)
            {
                post_search_data = {'name': movie_name};

                $.ajax ({
                    type: 'POST',
                    url: 'new_link_search.php',
                    data: post_search_data,
                    async: false,
                    success: function(res) {
                        if (res.type == 'error')
                        {
                            html_output = '<div class="error">' + res.text + '</div>';
                        } else {
                            html_output = '<div class="success">' + res.text + '</div>';
                        }

                        $("#search_result").hide().html(html_output).slideDown();

                    },
                    error: function (xhr, status, errorThrown) {
                        console.log(xhr);
                    },
                    dataType:"json"
                });

            }

        });


        $(".submit_btn").click(function () {

            var name = $('input[name="name"]').val();
            var link = $('input[name="link"]').val();

            var challengeField = $("#recaptcha_challenge_field").val();
            var responseField = $("input#recaptcha_response_field").val();

            var proceed = true;
            if (name == "") {
                $('input[name=name]').css('border-color', 'red');
                proceed = false;
            }
            if (link == "") {
                $('input[name=link]').css('border-color', 'red');
                proceed = false;
            }
            if (!quality)
            {
                alert("select is empty");
            }

            if (proceed) {
                post_data = {'name': name, 'link': link,'challengeField': challengeField, 'responseField': responseField};

                $.ajax ({
                    type: 'POST',
                    url: 'submit.php',
                    data: post_data,
                    async: false,
                    success: function(response) {
                        if (response.type == 'error') {
                            output = '<div class="error">' + response.text + '</div>';
                        } else {
                            output = '<div class="success">' + response.text + '</div>';

                            $('#link_form input').val('');
                        }

                        $("#result").hide().html(output).slideDown();

                    },
                    error: function (xhr, status, errorThrown) {
                        console.log(xhr);
                    },
                    dataType:"json"

                });


            }
        });

        $("#movie_select input").keyup(function() {
            $("#link_form input").css('border-color', '');
            $("#search_result").slideUp();
        });


        $("#link_form input").keyup(function () {
            $("#link_form input").css('border-color', '');
            $("#result").slideUp();
        });
      });

</script>

</head>

<body>

<script type="text/javascript">
    var RecaptchaOptions = {
        theme : 'clean'
    };
</script>

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
<div style="height: 50px;"></div>
<fieldset id="link_form">

    <div id = "movie_select">
        <div class="search_form">
            <label for= "name">
                <span>Movie Name</span>
                <input type="text" name="name" id="name" placeholder="Movie name" autocomplete="off">
            </label>
            <label>
                <span>&nbsp;</span>
                <button class="search_btn" id="search">Search</button>
            </label>
        </div>

        <div id="search_result">

        </div>
    </div>

    <legend>Submit a new Link</legend>
    <div id="result"></div>

    <label for = "link">
        <span>Movie Link</span>
        <input type="text" name="link" id="link" placeholder="Movie link" autocomplete="off">
    </label>

    <?php
        require_once('recaptchalib.php');
        $publickey = "6LfR2vcSAAAAAKqEd2gA3Kc9m2vS-bINp9px0vp8";
        //$publickey = "6LeO7PcSAAAAAMOPlpYG8vUl0RFE612VYiTr-G5L";

        echo recaptcha_get_html($publickey);
    ?>

    <label>
        <span>&nbsp;</span>
        <button class="submit_btn" id="submit">Submit</button>
    </label>

</fieldset>

<div id="push"></div>

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

<script src="js/search.js"></script>
<script language="javascript" type="text/javascript" src="js/link_target.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-53458532-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>