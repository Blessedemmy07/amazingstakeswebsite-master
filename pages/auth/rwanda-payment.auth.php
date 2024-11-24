<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
include __DIR__ . "/../../components/functions/vip-section-functions.php";

require_once __DIR__."/../../vendor/autoload.php";

use App\Classes\VipPlans;

$all_vip_plans = new VipPlans();

$special_plans = $all_vip_plans->FetchSpecialPlans("rwand");

$investment_plans = $all_vip_plans->FetchInvestmentPlans("rwand");
?>

<div class="content-wrapper">
    <br/>
    <div class="container flex-grow-1 container-p-y">
        <div class="row"  style="margin:15px">     
            <h2>SELECT A PLAN</h2>
        </div>

        <div class="row" style="margin:15px">     
            <div class="col-md-6">
                <!-- VIP Plan Collapsible -->
                <div class="styledCard">
                    <!-- <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#vipPlan" aria-expanded="true">
                                VIP Plan
                            </button>
                        </h2>
                    </div> -->
                    <div id="specialPlan" class="collapse show">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center" style="font-weight:bold">SPECIAL PLAN</h3>
                            </div>
                            <div class="row">
                                <?php
                                if (count($special_plans) > 0) {
                                    foreach ($special_plans as $row) {
                                        $plan_id = $row["id"];
                                        $subject_include = $row["subject_include"];
                                        $amount = $row["amount"];
                                        $sign = $row["sign"];
                                        echo "<a href=\"rwanda-pay?plan={$plan_id}\"><div class=\"bet-btn-dark-expert\">{$subject_include} {$sign}" . formatNumber($amount) . "</div></a>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>          
            </div>
            <div class="col-md-6">
                <!-- Special Plan Collapsible -->
                <div class="styledCard">
                    <!-- <div class="card-header">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#specialPlan" aria-expanded="false">
                                Special Plan
                            </button>
                        </h2>
                    </div> -->
                    <div id="investmentPlan" class="collapse show">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center" style="font-weight:bold">INVESTMENTS PLAN</h3>
                            </div>
                            <?php
                            if (count($investment_plans) > 0) {
                                foreach ($investment_plans as $row) {
                                    $plan_id = $row["id"];
                                    $subject_include = $row["subject_include"];
                                    $amount = $row["amount"];
                                    $sign = $row["sign"];
                                    echo "<a href=\"rwanda-pay?plan={$plan_id}\"><div class=\"bet-btn-dark-expert\">{$subject_include} {$sign}" . formatNumber($amount) . "</div></a>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
    </div>
    <br/>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>