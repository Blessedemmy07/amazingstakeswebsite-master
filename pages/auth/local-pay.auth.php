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
            <h2>SELECT A PAYMENT OPTION</h2>
        </div>
        <div class="row">     
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h3>PAY ONLINE (CARD/USSD)</h3>

                <img src="../../images/paystack.png" alt="Flutterwave" width="80%">
                <p>
                <br /><br />
                </p>
                <form>
                    <button type="button" onclick="payWithPaystack()" class="button-br"> Make Payment </button>
                </form>                
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="inn-tittle">
                    <h2>PAY WITH BANK/MOBILE TRANSFER</h2>
                    </div>
                    <img src="images/sterling.png" alt="Sterling" width="50%"> <br>
                    <a  href="m-bank" class="button-br">Make Payment</a>
            </div>
        </div>
        
    </div>
    <br/>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
function payWithPaystack(){
    var handler = PaystackPop.setup({
    key: 'pk_live_09e5eb560fa82de8151d6cbb70e248f57b5e9a42',
    email: '<?php echo $email ?>',
    amount: <?php echo $amount ?>00,
    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
    metadata: {
        custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            }
        ]
    },
    callback: function(response){
        alert('success. transaction ref is ' + response.reference);
    },
    onClose: function(){
        alert('window closed');
    }
    });
    handler.openIframe();
}
</script>