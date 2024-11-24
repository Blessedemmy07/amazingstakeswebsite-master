<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
require_once __DIR__."/../../vendor/autoload.php";

use App\Classes\Users;

$users = new Users();

$users_data = $users->FetchAllUsers($_SESSION["logged_in_user"])[0];

if(count($users_data)){
    $fullName = $users_data["fullName"];
    $email = $users_data["email"];
    $country = $users_data["country"];
    $phone_number = $users_data["phone_number"];
    $dateCreated = $users_data["dateCreated"];
    $active_plan = $users_data["active_plan"];
    $active_from = $users_data["active_from"];
    $plan_expired = $users_data["plan_expired"];
    $vip_active = $users_data["vip_active"];
    $vip_starts = $users_data["vip_starts"];
    $vip_expires = $users_data["vip_expires"];

    $today = date("Y-m-d", time());
    # Checks to see if the Basic or Premium Plan has expired or not.
    if($today > $plan_expired){
      $users->UpdateActivePlanByDate($email);
    }

    #Checks to see if the Monster Tips Plan has expired or not.
    if($today > $vip_expires){ 
        $users->UpdateVipActive($email);    
    }

    $startr = strtotime($vip_starts);
    $endr = strtotime($vip_expires);

    $days_between = ceil(abs($endr - $startr) / 86400);

    $date1 = strtotime($active_from); // Register date
    $date2 = strtotime($plan_expired); // Expire date
    $date3 = strtotime($vip_starts); // Clever Active Date
    $date4 = strtotime($vip_expires); // Clever End Date
    
    $todayDate = time();
    $timePast = $todayDate - $date1;
    $cleverTimePast = $todayDate - $date3;
    
    $duration = $date2 - $date1;
    if($todayDate < $date1){
        $completed = 0;
    }elseif($todayDate >= $date2){
        $completed = 100;
    }else{

        $completed  = floor(($timePast/$duration)*100);
    }

    $cleverDuration = $date4 - $date3;
    if($todayDate < $date3){
        $cleverCompleted = 0;
    }elseif($todayDate >= $date4){
        $cleverCompleted = 100;
    }else{
        $cleverCompleted = floor(($cleverTimePast/$cleverDuration)*100);
    }


    $startDate = ((strtotime($today) - strtotime($active_from)) / (60 * 60 * 24));
    $endDate = ((strtotime($plan_expired) - strtotime($active_from)) / (60 * 60 * 24));

    $startCleverDate = ((strtotime($today) - strtotime($vip_starts)) / (60 * 60 * 24));
    $endCleverDate = ((strtotime($vip_expires) - strtotime($vip_starts)) / (60 * 60 * 24));
}
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row" style="margin:15px">
            <!-- Left Column: My Information -->
            <div class="col-md-6">
                <div class="styledCard">
                    <div class="card-body p-3">
                        <h5 class="card-title text-center" style="font-size:medium">MY INFORMATION</h5>
                        <p>Name: <strong><?php echo $users_data["fullName"] ?></strong></p>
                        <p>Email: <strong><?php echo $users_data["email"] ?></strong></p>
                        <p>User ID: <strong><?php echo $users_data["id"] ?></strong></p>
                        <p>Phone: <strong><?php echo $users_data["phone_number"] ?></strong></p>
                        <p>Country:<strong><?php echo $users_data["country"] ?></strong></p>
                        <p>Date Created:<strong><?php echo $users_data["dateCreated"] ?></strong></p>
                        <div class="row">
                            <a href="edit" class="btn btn-danger btn-block">Edit Profile</a>
                        </div>
                    </div>                    
                </div>
            </div>

            <!-- Right Column: Active Plans -->
            <div class="col-md-6">
                <div class="styledCard">
                <div class="card-body p-3">
                    <h5 class="card-title text-center" style="font-size:medium">ACTIVE PLANS</h5>
                    
                    <!-- Regular Plan -->
                    <p style="margin: 0px">Regular Plan: 
                        <?php 
                        if ($users_data["active_plan"] == 1) {
                            echo '<strong>VIP Plan</strong>';
                            echo '<div class="row mb-3"><a href="make-payment" class="btn btn-warning"><strong>Buy Plan</strong></a></div>';

                        } elseif ($users_data["active_plan"] == 2) {
                            echo '<strong>Special Plan</strong>';
                            echo '<div class="row mb-3"><a href="make-payment" class="btn btn-warning"><strong>Buy Plan</strong></a></div>';

                        } else {
                            echo '<div class="row mb-3"><a href="make-payment" class="btn btn-warning"><strong>Buy Plan</strong></a></div>';
                        }
                        ?>
                    </p>

                    <!-- Investment Scheme -->
                    <p style="margin: 0px">Investment Scheme: 
                        <?php 
                        if ($users_data["vip_active"] == 1) {
                            echo '<strong>"Yes"</strong>';
                            echo '<div class="row mb-3"><a href="#" class="btn btn-warning"><strong>View Plan</strong></a></div>';
                        } else {
                            echo '<strong>"No"</strong>';
                            echo '<div class="row mb-3"><a href="make-payment" class="btn btn-warning"><strong>Buy Plan</strong></a></div>';
                        }
                        ?>
                    </p>

                    <!-- Experts -->
                    <p style="margin: 0px">Experts: 
                        <?php 
                        if ($users_data["guided_active"] == 1) {
                            echo '<strong>"Yes"</strong>';
                            echo '<div class="row mb-3"><a href="#" class="btn btn-warning"><strong>View Plan</strong></a></div>';
                        } else {
                            echo '<strong>"No"</strong>';
                            echo '<div class="row mb-3"><a href="make-payment" class="btn btn-warning"><strong>Buy Plan</strong></a></div>';
                        }
                        ?>
                    </p>

                    <!-- Make Payment Button -->
                    <div class="row">
                        <a href="make-payment" class="btn btn-danger"><strong>Make Payment</strong></a>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7 inn-title">
                <h2><i class="bi bi-check-all" aria-hidden="true"></i> My Store</h2>
                <p>Study statistics, recent form, head to head information, and team news to give you as much of an advantage. Knowing all of this will help you take an analytical approach and work out which outcome is most likely.
                </p>
                <p>Knowing a club’s current ranking isn’t enough. Make sure you’re staying up to date on other critical developments, such as injuries, lineup alterations, and recent changes in coaching.
                </p>
                <p>You must know what the betting options are and how they work.
                </p>
                <p>Whenever possible, play it safe, and restrict lots of selection.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7 inn-title">
                <h4>Special Plan</h4>
                <div class="vip-btn">
                    <ul>
                        <li><a href="sure-2"><i class="bi bi-cookie fb1"></i> Sure 2</a></li>

                        <li><a href="sure-3"><i class="bi bi-cookie fb1"></i> Sure 3</a></li>

                        <li><a href="5-Odds"><i class="bi bi-cookie fb1"></i> 5 Odds</a></li>

                        <li><a href="10-Odds"><i class="bi bi-cookie fb1"></i> 10 Odds</a></li>

                        <li><a href="50-odds"><i class="bi bi-cookie fb1"></i> Weekend 50 Odds</a></li>
                    </ul>
                </div>
                <h4>Investment Plan</h4>
                <div class="vip-btn">
                    <ul>
                        <li><a href="rollover"><i class="bi bi-cookie fb1"></i>Rollover (1.30-2.00)</a></li>

                        <li><a href="investment"><i class="bi bi-cookie fb1"></i>Investment (2.10-3.50)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>
