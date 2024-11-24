<?php
function renderLeagueHeader($fixture_details,$deviceType) {
    ob_start();

    $leagueId = $fixture_details['game_details']['league_id'];

    $originalRoundName =  $fixture_details['game_details']['round'];
    ?>
    <!-- Render league header here -->
    <div style="background-color: #eef7ff; padding: 2px; font-weight: bold" class="responsive-row fixturesTextSize pb-1 pt-1">
        <div className="table-cell pb-1 pt-1">
            <?php echo $originalRoundName ?>
        </div>
    </div>    
    <!-- Fixture details header only for desktop -->
    <?php if ($deviceType !== "mobile") { ?>
        <div class="responsive-row" style="font-size: 12px; border: none; background-color: whitesmoke;">
            <div class="responsive-cell"></div>
            <div class="responsive-cell team-link"></div>
            <div class="responsive-cell team-link-y">
                <span class="mx-4">1</span>
                <span class="mx-4">X</span>
                <span class="mx-4">2</span>
            </div>
            <div class="responsive-cell team-link-average">Avg</div>
            <div class="responsive-cell">Prediction</div>
            <div class="responsive-cell team-link-standings"></div>
            <div class="responsive-cell team-link-l"></div>
            <div class="responsive-cell team-link-scores"></div>
        </div>
    <?php }

    return ob_get_clean();
}

