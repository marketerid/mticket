<?php
namespace App\Google;

class AnalyticService{
    public function __construct()
    {

    }


    public function devices($slug = '', $dayAgo = 7){
        if(!$slug){
            return 0;
        }
        $dayAgo     = (int)$dayAgo;
        $analytics  = $this->initialize();
        $profile    = $this->getFirstProfileId($analytics);
        try {
            $results    = $analytics->data_ga->get(
                'ga:' . $profile,
                $dayAgo . 'daysAgo',
                'today',
                'ga:sessions',
                [
                    'dimensions'    => 'ga:browser,ga:operatingSystem,ga:mobileDeviceInfo',
                    'sort'          => '-ga:sessions,ga:browser',
                    'filters'       => 'ga:pagePath=~/' . $slug
                ]
            );
        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            $error = $e->getMessage();
            return 0;
        }

        return $results;
    }

    public function citySource($slug = '', $dayAgo = 7){
        if(!$slug){
            return 0;
        }
        $dayAgo     = (int)$dayAgo;
        $analytics  = $this->initialize();
        $profile    = $this->getFirstProfileId($analytics);
        try {
            $results    = $analytics->data_ga->get(
                'ga:' . $profile,
                $dayAgo . 'daysAgo',
                'today',
                'ga:sessions',
                [
                    'dimensions'    => 'ga:city',
                    'sort'          => '-ga:sessions,ga:city',
                    'filters'       => 'ga:pagePath=~/' . $slug
                ]
            );
        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            $error = $e->getMessage();
            return 0;
        }

        $rows   = [];
        foreach ($results->rows as $row){
            $rows[] = [
                'title' => $row[0],
                'total' => $row[1]
            ];
        }

        return $rows;
    }

    public function trafficSources($slug = '', $dayAgo = 7){
        if(!$slug){
            return 0;
        }
        $dayAgo     = (int)$dayAgo;
        $analytics  = $this->initialize();
        $profile    = $this->getFirstProfileId($analytics);
        try {
            $results    = $analytics->data_ga->get(
                'ga:' . $profile,
                $dayAgo . 'daysAgo',
                'today',
                'ga:sessions',
                [
                    'dimensions'    => 'ga:source',
                    'sort'          => '-ga:sessions,ga:source',
                    'filters'       => 'ga:pagePath=~/' . $slug
                ]
            );
        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            $error = $e->getMessage();
            return 0;
        }

        $rows   = [];
        foreach ($results->rows as $row){
            $rows[] = [
                'title' => $row[0],
                'total' => $row[1]
            ];
        }

        return $rows;
    }

    public function sessionDays($slug = '', $dayAgo = 7){
        if(!$slug){
            return 0;
        }
        $dayAgo     = (int)$dayAgo;
        $analytics  = $this->initialize();
        $profile    = $this->getFirstProfileId($analytics);
        $results    = $analytics->data_ga->get(
            'ga:' . $profile,
            $dayAgo . 'daysAgo',
            'today',
            [
                'dimensions'    => 'ga:sessions',
                'filters'       => 'ga:pagePath=~/' . $slug
            ]);

        return $results->totalResults;
    }

    public function getRealTimeActive($slug = ''){
        if(!$slug){
            return 0;
        }

        $analytics  = $this->initialize();
        $profile    = $this->getFirstProfileId($analytics);


        try {
            $results = $analytics->data_realtime->get(
                'ga:' . $profile,
                'rt:activeUsers',
                [
                    'dimensions'    => 'rt:medium',
                    'filters'       => 'ga:pagePath=~/' . $slug
                ]);
            // Success.
        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            $error = $e->getMessage();
            return 0;
        }


        return $results->totalResults;

    }

    private function getFirstProfileId($analytics) {
        // Get the user's first view (profile) ID.

        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                    ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();

                } else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new Exception('No properties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }

    private function initialize(){
        $KEY_FILE_LOCATION = env('GOOGLE_KEY_PATH', null);

        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_Analytics($client);

        return $analytics;

    }
}