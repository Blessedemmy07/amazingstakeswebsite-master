<?php
function fetchSearchResultsForTeamComparison($search_query) {
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    $search_url = "https://api.pitchpredictions.com/api/search-by-team-name-team-comparison";

    // Prepare the request payload
    $data = json_encode(["search_query" => $search_query]);

    // Initialize cURL session
    $ch = curl_init($search_url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute the request and fetch the response
    $response = curl_exec($ch);

    // Check for errors in the request
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the JSON response
    $results = json_decode($response, true);

    // Access the data part of the response
    $search_res_data = $results['data'] ?? null;

    return $search_res_data;
}
