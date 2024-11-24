<?php
use GuzzleHttp\Client;

function getOtherLeagues() {
    $client = new Client();
    
    try {
        $response = $client->get('https://api.pitchpredictions.com/api/fetch_other_leagues', [
            'headers' => [
                'Authorization' => 'UJlhuDILIR1Lc2IEwZDIKOln9d'
            ]
        ]);

        $data = json_decode($response->getBody(), true);
                
        return $data['data'] ?? [];
        
    } catch (\Exception $e) {
        // Handle error here, e.g., log it or display a message
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function getAllCompetitionsLeagues() {
    $client = new Client();
    
    try {
        $response = $client->get('https://api.pitchpredictions.com/api/fetch_other_competions', [
            'headers' => [
                'Authorization' => 'UJlhuDILIR1Lc2IEwZDIKOln9d'
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        
        return $data['data'] ?? [];
        
    } catch (\Exception $e) {
        // Handle error here, e.g., log it or display a message
        echo "Error: " . $e->getMessage();
        return [];
    }
}