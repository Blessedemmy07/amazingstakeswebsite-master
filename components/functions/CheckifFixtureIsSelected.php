<?php
function CheckIfFixtureIsSelected($fixtureId) {
    // Get the fixture data from the session
    // Assuming the data is stored in $_SESSION['myselectedfavoritematchesdata'] as a JSON string
    if (isset($_SESSION['myselectedfavoritematchesdata'])) {
        // Decode the JSON data to an array
        $dataArray = json_decode($_SESSION['myselectedfavoritematchesdata'], true);

        if (!empty($dataArray)) {
            // Loop through the array and check if the fixture ID exists
            foreach ($dataArray as $fixture) {
                if (isset($fixture['fixture_id']) && $fixture['fixture_id'] === (int)$fixtureId) {
                    return true; // Fixture found
                }
            }
        }
    }
    
    return false; // Fixture not found
}
