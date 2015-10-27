<?php
include 'common.php';

define('TBL_WIDTH', '');

use core\GA_Service;
use core\controller\IndexController;

//google client
$client = new Google_Client();

//ga service
$ga = new GA_Service($client);

$controller = new IndexController($ga);
$controller->index();

$accounts = $controller->accounts();
//print '<pre>'; print_r($accounts);

$properties = json_decode($controller->properties($accounts[0]['id']), true);
//print '<pre>'; print_r($properties);

$views = json_decode($controller->views($accounts[0]['id'], $properties[0]['id']));
//print '<pre>'; print_r($views);

$metadata = $controller->metadata();
//include 'metadata.php';

$segments = $controller->segments();
//include 'segment.php';

//get the report
$dimensions = ['ga:previousPagePath', 'ga:pagePath'];
$metrics = ['ga:visits'];
$report = $controller->report($dimensions, $metrics, $views[0]->id);
//print '<pre>'; print_r($report);
include 'report.php';


?>
<style type="text/css">
    .tbl {
        border-collapse: collapse;
        border: 1px solid navy;
    }
    .tbl td {
        border: 1px solid navy;
        padding: 3px 5px;
    }
    tr.h {
        background-color: lightgray;
    }
    h3 {
        color: #001199;
    }
</style>
