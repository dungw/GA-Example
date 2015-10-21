<?php namespace core;

class GA_Service
{
    protected $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->init();
    }

    private function init()
    {
        $this->client->setClientId(Config::get('analytics.client_id'));
        $this->client->setClientSecret(Config::get('analytics.client_secret'));
        $this->client->setDeveloperKey(Config::get('analytics.api_key'));
        $this->client->setRedirectUri('http://localhost:8000/login');
        $this->client->setScopes(array('https://www.googleapis.com/auth/analytics'));
    }
}
