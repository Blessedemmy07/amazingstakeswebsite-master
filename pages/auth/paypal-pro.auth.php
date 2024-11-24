<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
include_once __DIR__ . "/../../components/shared/geoiploc.shared.php";
include __DIR__ . "/../../components/functions/vip-section-functions.php";
require_once __DIR__."/../../vendor/autoload.php";

use App\Classes\VipPlans;

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$country_ip = "";
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
    $country_ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
}else{
    $country_ip = $_SERVER['REMOTE_ADDR'];
}

$all_vip_plans = new VipPlans();

$plan = (isset($_GET["plan"]))?test_input($_GET["plan"]):"";

$name = $_SESSION["name"];
$email = $_SESSION["logged_in_user"];
$_SESSION["logged_in_user"] = $email;
$user_id = $_SESSION["logged_in_user_id"];

$payment_pro = $all_vip_plans->PaymentProPlans($plan);

if(count($payment_pro)){
    $row = $payment_pro[0]; 

    // Prefill values from the array
    $amount = $row["amount"];
    $paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; // Paypal API URL
    $paypal_id = 'info@supatips.com'; // Business email ID
    $time = time();
    $item_number = "ama{$time}stakes";
    $item_name = "Payment for " . $row["subject_include"] . " Plan";
    $logo = 'https://www.amazingstakes.com/images/logo.png';
    $date_time = date("Y-m-d H:i:s");

    // Store session data
    $_SESSION["trans_ref"] = $item_number;
    $_SESSION["amount"] = $amount;

    $sign = $row["sign"];

    $all_vip_plans->TransactionLog($user_id, $email, $item_number, $plan, $item_name, $amount, $date_time, $country_ip, $actual_link);

    $all_vip_plans->sendPaymentNotificationEmail("payment@amazingstakes.com", $name, $item_number, $amount, "$", $date_time, "Payment Attempt Notification");

    $trans_logs = $all_vip_plans->FetchTranscationLogs($user_id, $date_time);
    
    if (!empty($trans_logs) && is_array($trans_logs)) {
        $log = $trans_logs[0];

        $invoice_id = $log["id"];
        $success = 0;
        $fail = 1;
        $success_hash = sha1($item_number.$invoice_id.$success);
        $fail_hash = sha1($item_number.$invoice_id.$fail);
    
        $_SESSION['item_number'] = $item_number;
        $_SESSION['success_hash'] = $success_hash;
        $_SESSION['bet_plan'] = $plan;
        $_SESSION['bet_email'] = $email;
    }
}
?>

<div class="content-wrapper">
    <br/>
    <div class="container flex-grow-1 container-p-y">
        <div class="row" style="margin:15px">
            <body onLoad="javascript: document.pp_frm.submit();">
                <form name="pp_frm" action="<?php echo $paypal_url; ?>" method="post">
                    <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
                    <input type="hidden" name="item_number" value="<?php echo $item_number; ?>">
                    <input type="hidden" name="credits" value="1">
                    <input type="hidden" name="userid" value="<?php echo $email; ?>">
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="cpp_header_image" value="<?php echo $logo; ?>">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="handling" value="0"><input type="hidden" name="cancel_return" value="https://www.amazingstakes.com/m-paypal.php?a=<?php echo $item_number; ?>&b=<?php echo $fail_hash; ?>">
                    <input type="hidden" name="return" value="https://www.amazingstakes.com?a=<?php echo $item_number; ?>&b=<?php echo $success_hash; ?>&c=success">
                </form>
            </body>
            <h3 class="text-center" style="color:#1a2740">Redirecting to Paypal Payment</h3>
        </div>
    </div>
    <br/>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>