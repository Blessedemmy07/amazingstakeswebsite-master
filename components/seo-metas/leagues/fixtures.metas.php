<?php
// Determine the current route
$currentRoute = trim($_SERVER['REQUEST_URI'], '/');

$title = "";
$description = "";
$keywords = ""; 
// Check if the current route matches the date pattern
if (preg_match('/^football-predictions-for-([^\/]+)\/([^\/]+)-(\d+)\/fixtures$/', $currentRoute, $matches)) {
    // Get the country name from the URL
    $country_name = isset($matches[1]) ? $matches[1] : ''; 

    // Update meta tags for this specific page
    $title = "Football Predictions for " . $country_name . " - " . $league_name;
    $description = "Get the latest " . $country_name . " " . $league_name . " trends, including the most talked about players, teams, and matches. Stay up to date on the top league trends.";
    $keywords = "Football Predictions, $country_name, $league_name, Amazingstakes";

    // Update Open Graph and Twitter descriptions
    $ogDescription = "Get the latest " . $country_name . " " . $league_name . " trends, including the most talked about players, teams, and matches. Stay up to date on the top league trends.";
    $twitterDescription = "Get the latest " . $country_name . " " . $league_name . " trends, including the most talked about players, teams, and matches. Stay up to date on the top league trends.";
}
?>

<title><?php echo htmlspecialchars($title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($description); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">

<!-- Open Graph Meta Tags --> 
<meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($ogDescription); ?>">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:title" content="<?php echo htmlspecialchars($title); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($twitterDescription); ?>">
