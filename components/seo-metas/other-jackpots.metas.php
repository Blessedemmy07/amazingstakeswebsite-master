<?php
include_once __DIR__ . "/../../components/functions/getJackpotFilterName.php";

$jackpot_name = returnJackpotNameSavedInDB($_SERVER['REQUEST_URI']);

?>
<title><?php echo htmlspecialchars($jackpot_name); ?> Predictions</title>
<meta name="description" content="Free <?php echo htmlspecialchars($jackpot_name); ?> predictions are now available. Visit Amazingstakes today and get reliable fixture analysis to help you make the best decisions.">
<meta name="keywords" content="<?php echo htmlspecialchars($jackpot_name); ?>, Jackpot predictions, Jackpot prediction, midweek jackpot prediction, jackpot predictions today">

<!-- Open Graph Meta Tags --> 
<meta property="og:title" content="Amazingstakes: <?php echo htmlspecialchars($jackpot_name); ?> Predictions">
<meta property="og:description" content="Get expert advice and winning tips for your Amazingstakes <?php echo htmlspecialchars($jackpot_name); ?> prediction. Win more money with our expert analysis and predictions.">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:title" content="Amazingstakes: <?php echo htmlspecialchars($jackpot_name); ?> Predictions">
<meta name="twitter:description" content="Get expert advice and winning tips for your Amazingstakes <?php echo htmlspecialchars($jackpot_name); ?> prediction. Win more money with our expert analysis and predictions.">
