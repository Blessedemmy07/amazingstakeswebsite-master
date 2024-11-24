<?php
require_once  __DIR__.'/functions/SearchFituresByName.php';

if (isset($_POST['searchInput'])) {
    $search_query = trim($_POST['searchInput']);
    
    if (strlen($search_query) >= 3) {
        $searchResults = FetchSearchResults($search_query);

        // Output HTML for each search result
        if (!empty($searchResults)) {
            foreach (array_slice($searchResults, 0, 10) as $result) {
                echo '<div>';
                if ($result['search_group'] == "team") {
                    echo '<a href="/team/' . urlencode(strtolower(str_replace(' ', '-', $result['search_res_name']))) . '-' . $result['search_res_id'] . '/results" class="ml-2 searchboxTxt4">
                            <div class="responsive-row searchboxTxt2 m-2">
                                <div class="col-10">' . htmlspecialchars($result['search_res_name']) . '</div>
                                <div class="col-2">' . htmlspecialchars($result['search_group']) . '</div>
                            </div>
                          </a>';
                } elseif ($result['search_group'] == "country") {
                    echo '<a href="/country/football-predictions-for-' . urlencode(strtolower($result['search_res_name'])) . '/fixtures" class="ml-2 searchboxTxt4">
                            <div class="responsive-row searchboxTxt2 m-2">
                                <div class="col-10">' . htmlspecialchars($result['search_res_name']) . '</div>
                                <div class="col-2">' . htmlspecialchars($result['search_group']) . '</div>
                            </div>
                          </a>';
                } elseif ($result['search_group'] == "league") {
                    echo '<a href="/league/football-predictions-for-' . urlencode(strtolower($result['search_country'])) . '/' . urlencode(strtolower(str_replace(' ', '-', $result['search_res_name']))) . '-' . $result['search_res_id'] . '/fixtures" class="ml-2 searchboxTxt4">
                            <div class="responsive-row searchboxTxt2 m-2">
                                <div class="col-10">' . htmlspecialchars($result['search_res_name']) . ' <span style="color: indianred;">(' . htmlspecialchars($result['search_country']) . ')</span></div>
                                <div class="col-2">' . htmlspecialchars($result['search_group']) . '</div>
                            </div>
                          </a>';
                } elseif ($result['search_group'] == "fixture") {
                    echo '<a href="/match/football-predictions-' . urlencode(strtolower(str_replace(' VS ', 'vs', $result['search_res_name']))) . '-' . $result['search_res_id'] . '" class="ml-2 searchboxTxt4">
                            <div class="responsive-row searchboxTxt2 m-2">
                                <div class="col-10" style="white-space: pre-wrap;">' . htmlspecialchars($result['search_res_name']) . ' <span style="color: white;">(' . htmlspecialchars($result['search_res_date']) . ')</span></div>
                                <div class="col-2">match</div>
                            </div>
                          </a>';
                }
                echo '</div>';
            }
            if (count($searchResults) > 10) {
                echo '<div class="container">
                        <div class="row searchboxTxt2">
                            <a class="btn btn-link btn-sm searchboxTxt" href="?query=' . urlencode($search_query) . '" style="border-radius: 8px; color: white; font-weight: bold;">Show All Results</a>
                        </div>
                      </div>';
            }
        }
    }
}
?>
