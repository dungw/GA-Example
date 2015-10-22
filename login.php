<?php
include 'common.php';

use core\GA_Service;

$code = isset($_GET['code']) ? $_GET['code'] : (isset($_POST['code']) ? $_POST['code'] : '');

if ($code) {

    //google client
    $client = new Google_Client();

    //ga service
    $ga = new GA_Service($client);

    //access token
    $accessToken = $ga->login($code);

    print "Access Token: <br>";
    print '<pre>'; print_r(json_decode($accessToken, true)); print '</pre>';
    print '<br><br>Redirect to <a href="/">home page</a>';

} else {

    return "Invalide request parameters";
}