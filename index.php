<?php
include 'common.php';

use core\GA_Service;
use core\controller\IndexController;

//google client
$client = new Google_Client();

//ga service
$ga = new GA_Service($client);

$controller = new IndexController($ga);
$controller->index();

$accounts = $controller->accounts();
print '<pre>'; print_r($accounts);

$properties = json_decode($controller->properties($accounts[0]['id']), true);
print '<pre>'; print_r($properties);

$views = json_decode($controller->views($accounts[0]['id'], $properties[0]['id']));
print '<pre>'; print_r($views);

$metadata = $controller->metadata();
print '<pre>'; print_r($metadata);