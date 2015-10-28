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

    public function report($dimensions, $metrics, $viewID, $options=[])
    {
        if (!$this->ga->isLoggedIn())
            return json_encode([
                'status' => 0,
                'code' => 1,
                'message' => 'Login required'
            ]);

        if (!$dimensions || !$metrics || !$viewID)
            return json_encode([
                'status' => 0,
                'code' => 1,
                'message' => 'Invalid request parametter'
            ]);

        $view = 'ga:' . $viewID;

        $report = $this->ga->report($view, $dimensions, $metrics, $options);

        return $report;
    }

    public function segments()
    {
        $segments = $this->ga->segments();

        return $segments;
    }
}

