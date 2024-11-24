<?php
// Determine the current route
$currentRoute = trim($_SERVER['REQUEST_URI'], '/');

$title = "";
$description = "";
$keywords = ""; 
// Check if the current route matches the date pattern
if (preg_match('/^football-predictions-by-date\/(\d{4}-\d{2}-\d{2})$/', $currentRoute, $matches)) {
    // Get the date from the URL
    $selectedDate = $matches[1];
    $formattedDate = DateTime::createFromFormat('Y-m-d', $selectedDate)->format('l, d/m/Y');

    // Update meta tags for this specific page
    $title = "Football Predictions By Date - $formattedDate";
    $description = "Explore our football predictions for $formattedDate. Join Amazingstakes for accurate winning tips!";
    $keywords .= ", Football Predictions By Date, $formattedDate";

    // Update Open Graph and Twitter descriptions
    $ogDescription = "Check out our football predictions for $formattedDate. The right site is Amazingstakes.";
    $twitterDescription = "Discover accurate football predictions for $formattedDate at Amazingstakes.";
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
