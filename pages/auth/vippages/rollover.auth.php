<?php
include __DIR__ . "/../../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../../components/includes/header.inc.php";
include_once __DIR__ . "/../../../components/includes/navbar.inc.php";
include_once __DIR__ . "/../../../components/shared/preloader.shared.php";
include __DIR__ . "/../../../components/functions/vip-section-functions.php";

use App\Classes\Users;
use App\Classes\VipMatches;

$users = new Users();
$users_data = $users->FetchAllUsers($_SESSION["logged_in_user"])[0] ?? [];

$vip_active = $users_data["vip_active"] ?? null;

$matches = new VipMatches();

$today = date("Y-m-d"); // Today's date
$yesterday = date("Y-m-d", strtotime("-1 day")); // Yesterday's date
$tomorrow = date("Y-m-d", strtotime("+1 day")); // Tomorrow's date

$yesterdayMatches = $matches->FetchInvestmentPlanMatches($yesterday, "21");
$todayMatches = $matches->FetchInvestmentPlanMatches($today, "21");
$tomorrowMatches = $matches->FetchInvestmentPlanMatches($tomorrow, "21");
?>

<div class="content-wrapper">
    <br/>
    <div class="container flex-grow-1 container-p-y">
        <?php if ($vip_active == 0): ?>
            <h2 align="center">PAGE RESTRICTED</h2>
            <br/>
            <p align="center" style="font-size:17px;font-weight:800px;color:brown">
                You have not subscribed to this plan or your subscription has expired
            </p>
            <br/>
            <div align="center">
                <a href="make-payment" class="inn-reg-com inn-reg-book">Subscribe</a>
            </div>
        <?php elseif ($vip_active === 1): ?>
            <h2>Rollover Bet</h2>

            <div class="container mt-4">
                <!-- Tab Headers -->
                <ul class="nav nav-tabs nav-justified" id="matchTabs">
                    <li class="nav-item">
                        <a class="nav-link" id="yesterday-tab" data-toggle="tab" href="#yesterday" role="tab">Yesterday</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab">Today</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tomorrow-tab" data-toggle="tab" href="#tomorrow" role="tab">Tomorrow</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="matchTabsContent">
                    <!-- Yesterday's Matches -->
                    <div class="tab-pane fade" id="yesterday" role="tabpanel">
                        <!-- Table for yesterday's matches -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>League</th>
                                    <th>Matches</th>
                                    <th>Tip</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="yesterdayMatches">
                                <?php
                                    if (count($yesterdayMatches) > 0) {
                                        foreach ($yesterdayMatches as $match) {
                                            echo formatMatchRow($match);
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' style='font-size:15px;font-weight:bold'>Prediction Not Available. Please Check Back Later.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Today's Matches -->
                    <div class="tab-pane fade show active" id="today" role="tabpanel">
                        <!-- Table for today's matches -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>League</th>
                                    <th>Matches</th>
                                    <th>Tip</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="todayMatches">
                                <?php
                                    if (count($todayMatches) > 0) {
                                        foreach ($todayMatches as $match) {
                                            echo formatMatchRow($match);
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' style='font-size:15px;font-weight:bold'>Prediction Not Available. Please Check Back Later.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tomorrow's Matches -->
                    <div class="tab-pane fade" id="tomorrow" role="tabpanel">
                        <!-- Table for tomorrow's matches -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>League</th>
                                    <th>Matches</th>
                                    <th>Tip</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="tomorrowMatches">
                                <?php
                                    if (count($tomorrowMatches) > 0) {
                                        foreach ($tomorrowMatches as $match) {
                                            echo formatMatchRow($match);
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' style='font-size:15px;font-weight:bold'>Prediction Not Available. Please Check Back Later.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <br/>
</div>

<?php 
include __DIR__ . "/../../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../../components/includes/footer.inc.php';
?>
