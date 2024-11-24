<?php
function renderLeagueHeader($fixture_details,$deviceType) {
    ob_start();

    $leagueId = $fixture_details['game_details']['league_id'];

    $originalleagueName =  $fixture_details['game_details']['league_name'];
    ?>
    <!-- Render league header here -->
    <div style="background-color: #eef7ff; padding: 2px;" class="responsive-row fixturesTextSize pb-1 pt-1">
        <?php if ($deviceType === "desktop") { ?>
            <div class="responsive-cell"></div>
        <?php } ?>

        <div class="responsive-cell team-link-x" style="text-align: left;">
            <?php if (!empty($fixture_details['game_details']['country_flag']) || !empty($fixture_details['game_details']['league_logo'])): ?>
                <img
                    src="<?php echo !empty($fixture_details['game_details']['country_flag']) ? $fixture_details['game_details']['country_flag'] : $fixture_details['game_details']['league_logo']; ?>"
                    class="img-fluid league-logo"
                    alt="<?php echo $fixture_details['game_details']['country_name']; ?>-football-predictions"
                    loading="lazy"
                />
            <?php else: ?>
                <span class="country-name-fallback">
                    <?php echo htmlspecialchars($fixture_details['game_details']['country_name']); ?>
                </span>
            <?php endif; ?>

            &nbsp;
            <?php if (!empty($fixture_details['game_details']['country_name'])) { ?>
                <span style="font-weight: bold;">
                    <?php
                    echo ucfirst(strtolower($fixture_details['game_details']['country_name'])).":";
                    echo ' &nbsp;';
                    if (strtolower(str_replace(' ', '-', $originalleagueName)) != 'jackpots') { ?>
                        <a href="<?php echo '/football-predictions-for-' . urlencode(strtolower($fixture_details['game_details']['country_name'])) . '/' . urlencode(strtolower(str_replace(' ', '-', $originalleagueName))) . '-' . $leagueId . '/fixtures'; ?>" class="ml-2 linkTxt">
                            <?php echo $originalleagueName; ?>
                        </a>
                    <?php } else {
                        echo $originalleagueName;
                    } ?>
                </span>
            <?php } ?>
            &nbsp;
        </div>
        <div class="responsive-cell team-link" style="margin-left: auto;">
            <?php if ($fixture_details['game_details']['league_type'] === "League") { ?>
                <div style="display: flex; justify-content: flex-end;">
                    <a href="/football-predictions-for-<?php echo strtolower($fixture_details['game_details']['country_name']); ?>/<?php echo urlencode(strtolower(str_replace(' ', '-', $originalleagueName))); ?>-<?php echo $leagueId; ?>/standings" class="ml-2 linkTxt">
                        <span>Standings</span>
                    </a>
                </div>
            <?php } ?>
        </div>

        <?php if ($deviceType === "desktop") { ?>
            <div class="responsive-cell"></div>
        <?php } ?>
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

