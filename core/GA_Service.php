<?php namespace core;

use Google_Client;
use Google_Service_Analytics;
use Google_Service_Exception;
use Google_IO_Curl;
use Google_Http_Request;

class GA_Service
{
    const MAX_RESULTS = 100;

    protected $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->init();
    }

    private function init()
    {
        $credential = Utils::getCredential();

        if (!empty($credential)) {

            $this->client->setClientId($credential['client_id']);
            $this->client->setClientSecret($credential['client_secret']);
            $this->client->setDeveloperKey($credential['api_key']);
            $this->client->setRedirectUri('http://local.ga.com:8080/login.php');
            $this->client->setScopes(array('https://www.googleapis.com/auth/analytics'));

        } else {
            throw new \Exception("You don't have credential");
        }

    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['token'])) {
            $this->client->setAccessToken($_SESSION['token']);
            return true;
        }

        return $this->client->getAccessToken();
    }

    public function login($code)
    {
        $this->client->authenticate($code);
        $token = $this->client->getAccessToken();
        $_SESSION['token'] = $token;

        return $token;
    }

    public function getLoginUrl()
    {
        $authUrl = $this->client->createAuthUrl();
        return $authUrl;
    }

    /********************* Part 2 *******************/

    public function accounts()
    {
        if (!$this->isLoggedIn()) {
            //login
        }

        $service = new Google_Service_Analytics($this->client);
        $man_accounts = $service->management_accounts->listManagementAccounts();
        $accounts = [];

        foreach ($man_accounts['items'] as $account) {
            $accounts[] = ['id' => $account['id'], 'name' => $account['name']];
        }

        return $accounts;
    }

    public function properties($account_id)
    {
        if (!$this->isLoggedIn()) {
            //login
        }

        try {
            $service = new Google_Service_Analytics($this->client);
            $man_properties = $service->management_webproperties->listManagementWebproperties($account_id);
            $properties = [];

            foreach ($man_properties['items'] as $property) {
                $properties[] = ['id' => $property['id'], 'name' => $property['name']];
            }

            return json_encode($properties);
        } catch (Google_Service_Exception $e) {

            return json_encode([
                'status' => 0,
                'code' => 3,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function views($account_id, $property_id)
    {
        if (!$this->isLoggedIn()) {
            //login
        }

        try {
            $service = new Google_Service_Analytics($this->client);
            $man_views = $service->management_profiles->listManagementProfiles($account_id, $property_id);
            $views = [];

            foreach ($man_views['items'] as $view) {
                $views[] = ['id' => $view['id'], 'name' => $view['name']];
            }

            return json_encode($views);
        } catch (Google_Service_Exception $e) {

            return json_encode([
                'status' => 0,
                'code' => 3,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function metadata()
    {
        $gcurl = new Google_IO_Curl($this->client);

        $response = $gcurl->makeRequest(
            new Google_Http_Request("https://www.googleapis.com/analytics/v3/metadata/ga/columns")
        );

        //verify returned data
        $data = json_decode($response->getResponseBody());

        $items = $data->items;
        $data_items = [];
        $dimensions_data = [];
        $metrics_data = [];

        foreach ($items as $item) {
            if ($item->attributes->status == 'DEPRECATED')
                continue;

            if ($item->attributes->type == 'DIMENSION')
                $dimensions_data[$item->attributes->group][] = $item;

            if ($item->attributes->type == 'METRIC')
                $metrics_data[$item->attributes->group][] = $item;
        }

        $data_items['dimensions'] = $dimensions_data;
        $data_items['metrics'] = $metrics_data;

        return $data_items;
    }

    public function report($view, $dimensions, $metrics)
    {
        // to make the request quicker
        $max_results = self::MAX_RESULTS;

        // query the last month analytics
        $now = new \DateTime();
        $end_date = $now->format('Y-m-d');
        $start_date = $now->modify('-1 month')->format('Y-m-d');

        // if( !is_array( $dimensions ) )
        // 	$dimensions = array( $dimensions );
        $dimensions = implode(",", $dimensions);
        $metrics = implode(",", $metrics);

        try {
            $analytics = new Google_Service_Analytics($this->client);
            $options = [];

            $options['dimensions'] = $dimensions;
            $options['max-results'] = $max_results;

            $data = $analytics->data_ga->get($view, $start_date, $end_date, $metrics,
                $options
            );

            $res = [
                'items' => isset($data['rows']) ? $data['rows'] : [],
                'columnHeaders' => $data['columnHeaders'],
                'totalResults' => $data['totalResults']
            ];

        } catch (Google_Service_Exception $ex) {
            return json_encode([
                'status' => 0,
                'code' => 2,
                'message' => 'Google analytics internal server error: (Technical details) ' . $ex->getErrors()[0]['message']
            ]);
        }

        return $res;
    }

    public function segments()
    {
        if (!$this->isLoggedIn()) {
            //login
        }

        $service = new Google_Service_Analytics($this->client);
        $segments = $service->management_segments->listManagementSegments();

        return $segments;
    }
}



