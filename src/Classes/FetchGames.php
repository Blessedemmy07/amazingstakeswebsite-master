<?php

namespace App\Classes;

use App\Facades\Http;  
use App\Configs\ErrorLogger;  
use App\Configs\Configurations; 

class FetchGames
{
    private $errLogger;  // Declare the ErrorLogger property

    public function __construct() {
        // Instantiate the ErrorLogger
        $this->errLogger = new ErrorLogger();

        // Instantiate Configurations Class
        $configsEnv = new Configurations();

        // Set the timezone for the website
        $configsEnv->SetTimezone();
    }

    public function FetchTodaysMatches($fixture_date, $start_index,$end_index)
    {
        try {           
            // Define the API URL and the query parameters
            $url = 'https://backend.sokapedia.com/api/fetch_todays_games';
            $queryParams = [
                'fixture_date' => $fixture_date,
                'start_index' => $start_index,
                'end_index' => $end_index
            ];

            // Use the Http class to fetch data from the API
            $todaysMatches = Http::get($url, $queryParams);

            return $todaysMatches;

        } catch (\Exception $e) {
            // Log the exception message in public/logs
            $this->errLogger->WriteError("Error fetching todays matches: " . $e->getMessage());

            // Optionally, return an error response or rethrow the exception
            return $e->getMessage();
        }
    }
}
