<?php
function FetchFixtureByIdMyFav($myselectedids) {
    $url = "https://api.pitchpredictions.com/api/fetch_fixtures_by_id";
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Prepare the payload with the selected fixture IDs
    $data = json_encode(['fixture_id' => $myselectedids]);

    // Initialize cURL
    $ch = curl_init($url);

    // Set the cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors in the request
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
        return;
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);

    // Check if the response is successful
    if ($responseData['status'] === true) {
        $selected_f_data = $responseData['data'];

        // Store the selected fixture data in the session
        $_SESSION['myselectedfavoritematchesdata'] = json_encode($selected_f_data);
    } else {
        // Handle any errors returned by the API
        echo 'Error: Failed to fetch fixture data';
    }
}
