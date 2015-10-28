<?php
include 'common.php';

define('TBL_WIDTH', '');

use core\GA_Service;
use core\Utils;
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

$segments = $controller->segments();
//include 'segment.php';

/****************** REPORT ****************/

//dimensions
$dimensions = [
    'ga:hostname',
    'ga:pagePath',
    'ga:previousPagePath',
    'ga:pagePathLevel1',
    'ga:pagePathLevel2',
    'ga:pagePathLevel3',
    'ga:pagePathLevel4',
    'ga:source',
    'ga:medium',
    'ga:sourceMedium'
];

//metrics
$metrics = ['ga:sessions'];

//options
$options = [];

//order by
$orders = ['ga:sessions'];
$orderRules = ['-'];
$options['sort'] = Utils::encodeOrderby(Utils::groupOrderby($orders, $orderRules));

//define filters
$dimensionShow = ['show'];
$dimensionFilters = ['ga:pagePath'];
$dimensionRules = ['exact'];
$dimensionValues = ['/san-pham/184/ly-coc.html'];

//filters
$filters = [];
$group_filters = [];
$group_filters['dimensions'] = Utils::groupFilters(
    $dimensionShow,
    $dimensionFilters,
    $dimensionRules,
    $dimensionValues
);

//filter by dimensions
$filters[] = Utils::encodeDimensionFilters($group_filters['dimensions']);

//filter by metrics

$options['filters'] = implode(';', $filters);

//GET THE REPORT
$report = $controller->report($dimensions, $metrics, $views[0]->id, $options);

//print '<pre>'; print_r($report); die;
include 'report.php';

$metadata = $controller->metadata();
include 'metadata.php';

















?>
<style type="text/css">
    .tbl {
        margin: 20px 0px;
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
