<?php
function FetchSearchResults($search_query) {
    $headers = [
        "Content-type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    $search_url = "https://api.pitchpredictions.com/api/search_request_by_keyword";

    // Set up the data for the POST request
    $postData = json_encode(["search_query" => $search_query]);

    // Initialize cURL session
    $ch = curl_init($search_url);

    // Configure cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Execute the request and decode the response
    $response = curl_exec($ch);
    $results = json_decode($response, true);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    // Close the cURL session
    curl_close($ch);

    // Extract the data
    $search_res_data = $results['data'] ?? null;

    return $search_res_data;
}
