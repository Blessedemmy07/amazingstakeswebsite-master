<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";

// Get the current URL
$currentUrl = $_SERVER['REQUEST_URI'];

// Check if "cameroon-pay" is in the URL
$isGhanaPay = strpos($currentUrl, 'ghana-pay') !== false;
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
                    <h3>MOBILE MONEY / CARD</h3>
                </div>
                <img src="../../images/amazing-flutter.jpg" alt="Flutterwave" width="50%">
                <br>
                <a href="international" 
                    class="btn-sm button-br <?php echo $isGhanaPay ? 'disabled' : ''; ?>" 
                    <?php echo $isGhanaPay ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>
                    Make Payment
                </a>            
                </div>

            <!-- Right Column: Active Plans -->
            <div class="col-md-4"> 
                <div class="inn-tittle">
                    <h2>PAY VIA M-PESA</h2>
                </div>
                <img src="../../images/amazing-mtn.png" alt="Flutterwave" width="50%">
                <br><br/>
                <a  href="m-money" class="btn-sm button-br">Make Payment</a>
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