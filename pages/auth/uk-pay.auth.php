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
            <h2>Payment Confirmation</h2>
        </div> 
        <div class="row">
            <div class="col-md-6 col-12">
                <img src="../../images/amazing-flutter.jpg" alt="Flutterwave" width="50%">
                <form>
                    <a class="flwpug_getpaid" 
                    data-PBFPubKey="FLWPUBK-b5632577f4906cd0c76d1d74dc026c31-X" 
                    data-txref="Amazing-556stakesu" 
                    data-amount="<?php echo $amount ?>" 
                    data-customer_email="<?php echo $email; ?>" 
                    data-currency="GBP" 
                    data-pay_button_text="&nbsp;Make Payment&nbsp;" 
                    data-country="NG" 
                    data-redirect_url="https://www.amazingstakes.com/dashboard"></a>

                    <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                </form>
            </div>
        </div>
        <br/>
    </div>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>