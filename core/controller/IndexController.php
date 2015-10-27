<?php namespace core\controller;

/**
 * Created by PhpStorm.
 * User: dung.vuong
 * Date: 10/22/2015
 * Time: 3:59 PM
 */

use core\GA_Service;

class IndexController
{
    private $ga;

    public function __construct(GA_Service $ga)
    {
        $this->ga = $ga;
    }

    public function index()
    {
        if ($this->ga->isLoggedIn()) {

            print 'Show home page';


        } else {
            $url = $this->ga->getLoginUrl();
            header("Location: " . $url);
        }
    }

    public function accounts()
    {
        $accounts = $this->ga->accounts();

        return $accounts;
    }

    public function properties($account_id)
    {
        $properties = $this->ga->properties($account_id);

        return $properties;
    }

    public function views($account_id, $property_id)
    {
        $views = $this->ga->views($account_id, $property_id);

        return $views;
    }

    public function metadata()
    {
        $metadata = $this->ga->metadata();

        return $metadata;
    }

    public function report()
    {
        if (!$this->ga->isLoggedIn())
            return json_encode([
                'status' => 0,
                'code' => 1,
                'message' => 'Login required'
            ]);

        $dimensions = isset($_GET['dimensions']) ? $_GET['dimensions'] : (isset($_POST['dimensions']) ? $_POST['dimensions'] : '');
        $metrics = isset($_GET['metrics']) ? $_GET['metrics'] : (isset($_POST['metrics']) ? $_POST['metrics'] : '');
        $view = isset($_GET['view']) ? $_GET['view'] : (isset($_POST['view']) ? $_POST['view'] : '');

        if (!$dimensions || !$metrics || !$view)
            return json_encode([
                'status' => 0,
                'code' => 1,
                'message' => 'Invalid request parametter'
            ]);

        $view = 'ga:' . $view;

        $report = $this->ga->report($view, $dimensions, $metrics);

        return $report;
    }

}

