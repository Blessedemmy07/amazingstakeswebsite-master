<?php
// Determine the current route
$currentRoute = trim($_SERVER['REQUEST_URI'], '/');

// Initialize default meta tags
$title = "";
$description = "";
$keywords = ""; 

// Check if the current route matches the pattern for home and away teams
if (preg_match('/^football-predictions-([^\/]+)-vs-([^\/]+)-(\d+)$/', $currentRoute, $matches)) {
    // Extract home and away team names from the URL
    $homeTeamName = isset($matches[1]) ? ucwords(str_replace('-', ' ', $matches[1])) : '';
    $awayTeamName = isset($matches[2]) ? ucwords(str_replace('-', ' ', $matches[2])) : '';

    // Update meta tags for this specific page
    $title = "Football Predictions: $homeTeamName vs $awayTeamName | Amazingstakes";
    $description = "Explore our football predictions for the match between $homeTeamName and $awayTeamName. Join Amazingstakes for accurate winning tips!";
    $keywords = "Football Predictions, $homeTeamName vs $awayTeamName, Amazingstakes";

    // Update Open Graph and Twitter descriptions
    $ogDescription = "Check out our football predictions for the match between $homeTeamName and $awayTeamName. Amazingstakes has the best tips!";
    $twitterDescription = "Discover accurate football predictions for $homeTeamName vs $awayTeamName at Amazingstakes.";
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
