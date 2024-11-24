<?php
require __DIR__ . '/../../vendor/autoload.php';

use App\Classes\CustomDatePicker;  // Ensure the namespace is correct

// Instantiate the FetchGames class
$custom_date_picker = new CustomDatePicker();

// Simulate state using PHP variables
$noOfMyMatches = 0;
$favMatchesUpdateCounter = 0; 

// Check the current route to simulate React's useRouter
$currentRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Fetch the count of matches (on page load or based on some condition)
$noOfMyMatches = 0; 

?>
<div class="row d-block d-lg-none" style="margin:auto; padding-top:5px; border:1px solid white; border-radius:3px; background-color:white;">
    <div class="col-lg-12 col-sm-12 o-hidden">
        <form method="POST" action="">
            <!-- Navigation Links -->
            <div onclick="this.form.submit()" class="nav scrollable nav-fill small position-relative flex-nowrap fixturesTextSize">
                <a href="/todays-prediction" class="nav-link scroll-card <?= $currentRoute === '/todays-prediction' ? 'activeElement' : '' ?>">
                    Today
                </a>
                <a href="/live-predictions" class="nav-link scroll-card <?= $currentRoute === '/live-predictions' ? 'activeElement' : '' ?>">
                    Live
                </a>
                <a href="#" class="nav-link scroll-card <?= $currentRoute === '/my-favourite-predictions' ? 'activeElement' : '' ?>">
                    My <i class="bi bi-star"></i> &nbsp;
                    <span class="number-circle rounded-square fixturesTextSize" style="background-color:white; color:black; font-weight:bold; font-size:12px;">
                        <?= $noOfMyMatches ?>
                    </span>
                </a>
                <a href="/must-win-teams-today" class="nav-link scroll-card <?= $currentRoute === '/must-win-teams-today' ? 'activeElement' : '' ?>">
                    Top Picks
                </a>
                <a href="/tomorrow-predictions" class="nav-link scroll-card <?= $currentRoute === '/tomorrow-predictions' ? 'activeElement' : '' ?>">
                    Tomorrow
                </a>
                <a href="/yesterday-predictions" class="nav-link scroll-card <?= $currentRoute === '/yesterday-predictions' ? 'activeElement' : '' ?>">
                    Yesterday
                </a>
                <a href="/weekend-football-prediction" class="nav-link scroll-card <?= $currentRoute === '/weekend-football-prediction' ? 'activeElement' : '' ?>">
                    Weekend
                </a>
                <a href="#" class="nav-link scroll-card <?= $currentRoute === '#' ? 'activeElement' : '' ?>">
                    Compare Teams
                </a>
                <a href="/jackpot-predictions" class="nav-link scroll-card <?= $currentRoute === '/jackpots' ? 'activeElement' : '' ?>">
                    Jackpots
                </a>
            </div>
            <input type="hidden" name="refreshMatches" value="1">
        </form>
    </div>

    <div class="col-sm-12 datePicker" id="datePickerT">
        <?php
            // Render the custom date picker from class
            echo $custom_date_picker->render();        
        ?>
    </div> 
</div>

