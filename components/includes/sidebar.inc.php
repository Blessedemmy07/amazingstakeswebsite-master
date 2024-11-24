<?php
include __DIR__. "/../functions/getPinnedLeagues.php";
?>

<div class="bg-white mb-3" id="sidebar-wrapper">
    <div class="list-group list-group-flush">
        <a href="/todays-prediction"
            class="list-group-item list-group-item-action list-group-item-light p-2 sideNavCustom1 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/todays-prediction' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Football Predictions Today
        </a>
        <a href="/live-predictions"
            class="list-group-item list-group-item-action p-2 sideNavCustom1 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/live-predictions' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Live Football Predictions 
        </a>
        <a href="/upcoming-popular-matches"
            class="list-group-item list-group-item-action sideNavCustom1 p-2 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/upcoming-popular-matches' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Upcoming Football Predictions
        </a>
        <a href="/tomorrow-predictions"
            class="list-group-item list-group-item-action sideNavCustom1 p-2 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/tomorrow-predictions' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Football Predictions Tomorrow
        </a>
        <a href="/weekend-football-prediction"
            class="list-group-item list-group-item-action sideNavCustom1 p-2 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/weekend-football-prediction' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Football Predictions Weekend
        </a>
        <a href="/yesterday-predictions"
            class="list-group-item list-group-item-action sideNavCustom1 p-2 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/yesterday-predictions' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Football Predictions Yesterday
        </a>
        <a href="/must-win-teams-today"
            class="list-group-item list-group-item-action sideNavCustom1 p-2 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/must-win-teams-today' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Top Predictions (Top Picks)
        </a>
        <a href="/jackpot-predictions"
            class="list-group-item list-group-item-action sideNavCustom1 p-2 countryNameLink <?= $_SERVER['REQUEST_URI'] === '/jackpot-predictions' ? 'activeElement' : '' ?>"
            onclick="openSidemenu()">
            Jackpot Predictions
        </a>
        <div className="border-bottom" id="sidenavDynamicheader">Top Leagues</div>
        <div className="responsive-cell team-link">
            <?php echo displayPinnedLeagues(); ?>
        </div>
        <div class="border-bottom" id="sidenavDynamicheader">Countries</div>
        <?php require __DIR__ . "/league_by_country_collapsible.inc.php"; ?>
    </div>
</div>