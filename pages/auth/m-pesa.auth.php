<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
include __DIR__ . "/../../components/functions/vip-section-functions.php";

require_once __DIR__."/../../vendor/autoload.php";

use App\Classes\VipPlans;

$all_vip_plans = new VipPlans();

$plan = (isset($_GET["plan"]))?test_input($_GET["plan"]):"";

if(!empty($plan))
{
    $payment_pro = $all_vip_plans->PaymentProPlans($plan);

    if(count($payment_pro)){
        $row = $payment_pro[0]; 

        $_SESSION['plan'] = $plan;
        $name = $_SESSION["name"];
        $plan = $row["plan"];
        $period = $row["period"];
        $amount = $row["amount"];
        $email = $_SESSION["logged_in_user"];
        $_SESSION["logged_in_user"] = $email;
        $user_id = $_SESSION["logged_in_user_id"];
    }
}
?>

<div class="content-wrapper">
    <br/>
    <div class="container flex-grow-1 container-p-y">
        <div class="row">
            <h2 class="text-uppercase font-weight-bold">M-Pesa Payment</h2>
        </div>
        <div class="row">
            <p>All payments should be made ONLY to the numbers stated below
            </>
            <p> NAME : Stephen Karuku</p>
            <h5>254799489335</h5>
            <p><b>Region: </b> West Africa (KENYA)</p>
            <hr>
            <h2>MTN Mobile Money</h2>
            <p>All payments should be made ONLY to the numbers stated below
            </>
            <p> NAME : Adeyemi Emmanuel</p>
            <h5>2348100245895</h5>
            <p><b>Region: </b> West Africa (NIGERIA)</p>
            <p><hr></p>           
            <p>After making your payment, please send the MPesa details: <strong>Name, "Registered" email address, transation ID</strong> and <strong>date of payment</strong> to</p>
                
            <span>Mail:</span><p><strong>payment@amazingstakes.com</strong></p>
               
            <p>It is always easier and quicker to contact us via the email address above.<p>
            <p>Your account would be upgraded as soon as payment is recieved.</p>
            <p><b>PLEASE NOTE THAT THE ABOVE LISTED NUMBER IS THE ONLY RECOGNISED MPESA AGENT AVAILABLE FOR AMAZINGSTAKES PAYMENTS IN EAST AFRICA. PLEASE BEWARE OF FRAUD.</b></p>        
        </div>
    </div>
    <br/>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>