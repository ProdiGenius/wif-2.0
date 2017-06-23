<?php

include ("datalogin.php");

if ($_POST)
{
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(
            array(
                'type' => 'error',
                'text' => 'Request must come from ajax.'
            ));

        die($output);
    }

    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);

    $name = urlencode($name);

    $json = file_get_contents("http://www.omdbapi.com/?t=$name&apikey=690932a6");

    $details = json_decode($json);

    if ($details->Response == 'True')
    {
        $output = json_encode(array('type' => 'message', 'text' => '<b>' . $details->Title . ' ' . $details->Year . ' </b> <br>' . $details->Plot . '<br><br><i>Not what you are looking for? Make sure the name of the film is correctly typed.</i>'));
        die ($output);
    } else {
        $output = json_encode(
            array(
                'type' => 'error',
                'text' => '<i>Sorry. This movie could not be found. Please make sure you typed the name correctly.</i>'
            ));

        die($output);
    }

}



?>