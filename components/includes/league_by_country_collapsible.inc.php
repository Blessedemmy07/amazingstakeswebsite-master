<?php
include __DIR__. "/../functions/getSideNavLeagues.php";

$otherLeagues = getOtherLeagues();
$allCountriesAndLeagues = getAllCompetitionsLeagues();

$countryName = strtolower($_GET['countryName'] ?? '');
$leagueId = $_GET['leagueId'] ?? '';
$collapseStates = [];

// Toggle collapse function
function toggleCollapse(&$collapseStates, $countryName) {
    $collapseStates[$countryName] = !($collapseStates[$countryName] ?? false);
}

// Combine unique countries data and other competitions
$uniqueCountries = [];
foreach ($otherLeagues as $league) {
    $countryName = $league['country_name'];
    $countryLogo = $league['downloaded_country_flag'];
    $leagueName = $league['league_name'];
    $leagueId = $league['league_id'];

    if (isset($uniqueCountries[$countryName])) {
        $uniqueCountries[$countryName]['data'][] = ['leagueName' => $leagueName, 'leagueId' => $leagueId, 'countryLogo' => $countryLogo];
        if (!in_array($leagueName, $uniqueCountries[$countryName]['leagues'])) {
            $uniqueCountries[$countryName]['leagues'][] = $leagueName;
        }
    } else {
        $uniqueCountries[$countryName] = [
            'data' => [['leagueName' => $leagueName, 'leagueId' => $leagueId, 'countryLogo' => $countryLogo]],
            'leagues' => [$leagueName]
        ];
    }
}

$otherCompetitionsCountries = [];
foreach ($allCountriesAndLeagues as $league) {
    $countryName = $league['country_name'];
    $countryLogo = $league['downloaded_country_flag'];
    $leagueName = $league['league_name'];
    $leagueId = $league['league_id'];

    if (isset($otherCompetitionsCountries[$countryName])) {
        $otherCompetitionsCountries[$countryName]['data'][] = ['leagueName' => $leagueName, 'leagueId' => $leagueId, 'countryLogo' => $countryLogo];
        if (!in_array($leagueName, $otherCompetitionsCountries[$countryName]['leagues'])) {
            $otherCompetitionsCountries[$countryName]['leagues'][] = $leagueName;
        }
    } else {
        $otherCompetitionsCountries[$countryName] = [
            'data' => [['leagueName' => $leagueName, 'leagueId' => $leagueId, 'countryLogo' => $countryLogo]],
            'leagues' => [$leagueName]
        ];
    }
}

$combinedData = array_merge($uniqueCountries, $otherCompetitionsCountries);

// Loop through all countries and leagues without limiting to `$numCountries`
foreach ($combinedData as $countryName => $countryData) {
    $leagues = $countryData['data'];
    $countryMenuId = strtolower(str_replace(' ', '-', $countryName)) . "Collapse";
    $isActiveCountry = strtolower($countryName) === $countryName;
    $isActiveLeague = in_array($leagueId, array_column($leagues, 'leagueId'));

    // Display Other Competitions title
    if ($countryName === "Africa") {
        echo "<div class='border-bottom' id='otherCompetitionsMenu'><br/>";
        echo "<div class='d-flex align-items-center'>";
        echo "<span class='list-group-item list-group-item-action p-1' style='color: white; font-weight: bold; background-color: #202c3c;'>Other Competitions</span>";
        echo "</div></div>";
    }

    echo "<div class='list-group list-group-flush collapsibleNav' id='{$countryName}Menu'>";
    echo "<div class='d-flex align-items-center'>";
    echo "<a href='/football-predictions-for-" . strtolower(str_replace(' ', '-', $countryName)) . "/fixtures' class='list-group-item list-group-item-action sideNavCustom1 countryNameLink p-1' title='{$countryName}'>{$countryName}</a>";
    echo "<span data-bs-toggle='collapse' data-bs-target='#{$countryMenuId}' role='button' aria-expanded='false' style='margin-left: auto; cursor: pointer; color: white' onclick='toggleCollapse(\"{$countryMenuId}\")'>";
    echo "<i class='bi bi-node-plus-fill'></i>";
    echo "</span></div></div>";

    // Collapsible section for each country's leagues
    echo "<div id='{$countryMenuId}' class='collapse'>";
    echo "<div class='card-body'>";
    foreach ($leagues as $league) {
        $leagueLink = "/football-predictions-for-" . strtolower(str_replace(' ', '-', $countryName)) . "/" . urlencode(strtolower(str_replace(' ', '-', $league['leagueName']))) . "-{$league['leagueId']}/fixtures";
        echo "<div style='display: flex; align-items: center;' class='d-flex align-items-left leagueNameWrapper'>";
        echo "<a href='{$leagueLink}' class='list-group-item ml-2 list-group-item-action sideNavCustom1 countryNameLink' title='{$league['leagueName']}'>{$league['leagueName']}</a>";
        echo "</div>";
    }    
    echo "</div></div>";
}

?>
<!-- Add JavaScript function to handle toggle -->
<script>
function toggleCollapse(collapseId) {
    const element = document.getElementById(collapseId);
    if (element.style.display === "none" || element.style.display === "") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}
</script>
