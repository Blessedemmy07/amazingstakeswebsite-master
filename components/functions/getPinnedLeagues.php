<?php

function displayPinnedLeagues() {
    $headers = [
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    // Fetch pinned leagues data from API
    function getPinnedLeagues($headers) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.pitchpredictions.com/api/fetch_popular_leagues");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("Error fetching pinned leagues: " . $error);
            return [];
        }

        $data = json_decode($response, true);
        return $data['data'] ?? [];
    }

    // Retrieve pinned leagues data
    $pinnedLeagues = getPinnedLeagues($headers);

    // Prepare HTML output
    $output = '';
    foreach ($pinnedLeagues as $index => $league) {
        $leagueUrl = "/football-predictions-for-" . 
            urlencode(strtolower(str_replace(' ', '-', $league['country_name']))) . "/" . 
            urlencode(strtolower(str_replace(' ', '-', $league['league_name']))) . 
            "-" . $league['league_id'] . "/fixtures";

        $isActive = "popular" . $league['league_id'] === "popular" . ($leagueId ?? '') ? 'activeElement' : '';

        // Append each league's HTML to output string
        $output .= "
            <div class='d-flex align-items-center countryNameLink' key='{$index}'>
                &nbsp;
                <div style='height: 10%; width: 10%; object-fit: contain'>
                    <img
                        src='{$league["downloaded_country_flag"]}'
                        height='100%'
                        width='100%'
                        class='img-fluid'
                        alt='" . strtolower(str_replace(' ', '-', $league['country_name'])) . "-football-predictions'
                        style='background-color: whitesmoke'
                        loading='lazy'/>
                </div>
                <a
                    href='{$leagueUrl}'
                    class='list-group-item list-group-item-action sideNavCustom1 border-none countryNameLink d-flex align-items-center {$isActive}'
                    onclick='openSidemenu()'
                    title='{$league["league_name"]}'>
                    {$league["league_name"]}
                </a>
            </div>";
    }

    // Return the HTML output
    return $output;
}