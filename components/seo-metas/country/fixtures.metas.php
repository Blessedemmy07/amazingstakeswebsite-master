<?php
// Determine the current route
$currentRoute = trim($_SERVER['REQUEST_URI'], '/');

$title = "";
$description = "";
$keywords = ""; 
// Check if the current route matches the date pattern
if (preg_match('/^football-predictions-for-([^\/]+)\/fixtures$/', $currentRoute, $matches)) {
    // Get the country name from the URL
    $country_name = isset($matches[1]) ? $matches[1] : ''; 

    // Update meta tags for this specific page
    $title = "Football Predictions for $country_name | Amazingstakes";
    $description = "Explore our football predictions for $country_name. Join Amazingstakes for accurate winning tips!";
    $keywords = "Football Predictions, $country_name, Amazingstakes";

    // Update Open Graph and Twitter descriptions
    $ogDescription = "Check out our football predictions for $country_name. The right site is Amazingstakes.";
    $twitterDescription = "Discover accurate football predictions for $country_name at Amazingstakes.";
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
