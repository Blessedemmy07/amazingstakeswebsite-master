<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
?>

<div class="content-wrapper">
    <br/>
    <div class="container flex-grow-1 container-p-y">
        <div class="row" style="margin:15px">
            <!-- Left Column: My Information -->
            <div class="col-md-4">
                <div class="inn-tittle">
                    <h2>SELECT A PAYMENT OPTION</h2>
                </div>
                <div class="inn-tittle">
                    <h3>Mobile Money / Card</h3>
                </div>
                <img src="../../images/amazing-flutter.jpg" alt="Flutterwave" width="50%">
                <br>
                <form>
                    <a class="flwpug_getpaid" 
                    data-PBFPubKey="" 
                    data-txref="Amazing-556stakesu" 
                    data-amount="<?php echo $amount ?>" 
                    data-customer_email="<?php echo $email; ?>" 
                    data-currency="KES" 
                    data-pay_button_text="&nbsp;Make Payment&nbsp;" 
                    data-country="NG" 
                    data-redirect_url="https://www.amazingstakes.com/dashboard"></a>

                    <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                </form>            
                </div>

            <!-- Right Column: Active Plans -->
            <div class="col-md-4"> 
                <div class="inn-tittle">
                    <h2>Pay Via M-Pesa</h2>
                </div>
                <img src="../../images/amazing-mpesa.jpg" alt="Mpesa" width="50%">
                <br><br/>
                <a  href="m-pesa" class="btn-sm button-br">Make Payment</a>
            </div>

            <div class="col-md-4"> 
                <div class="inn-tittle">
                    <h2>Pay Via PayPal</h2>
                </div>
                <img src="../../images/amazing-paypal.png" alt="Flutterwave" width="50%">
                <br>
                <a  href="paypal" class="btn-sm button-br">Make Payment</a>
            </div>
        </div>
    </div>
    <br/>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>