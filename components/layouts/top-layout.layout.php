<?php
include_once __DIR__ . "/../includes/header.inc.php";
include_once __DIR__ . "/../includes/navbar.inc.php";
include_once __DIR__ . "/../seo-metas/pagetitlesfunction/page-titles.metas.php";

// Instantiate the FetchSearchResults and CountNoOfMyMatches classes
$fetchSearchResults = []; //new FetchSearchResults();
$countMyMatches = 0; //new CountNoOfMyMatches();

// Initialize variables
$searchResults = [];
$searchQuery = '';
$noOfMyMatches = 0; //$countMyMatches->getCount(); // Assuming this method returns the count of matches
$favMatchesUpdateCounter = 0;

// Function to handle search input
function searchOnChange($inputSearchQuery)
{
    global $fetchSearchResults, $searchResults;
    if (strlen($inputSearchQuery) >= 3) {
        $searchResults = $fetchSearchResults->fetch($inputSearchQuery); // Adjust based on actual function
    }
}

// Function to clear search results
function closeForm()
{
    global $searchResults;
    $searchResults = [];
}
?>

<div style="background-color:#ffffff;">
    <div class="container-mob desktop-container-resize">
        <div class="d-flex" id="wrapper">
            <!--Sidebar -->
            <?php include_once __DIR__ . "/../includes/sidebar.inc.php"; ?>

            <div id="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div style="margin-top:6px; margin-bottom:3px;">
                            <!--Scrollbar -->
                            <?php include_once __DIR__ . "/../includes/scrollnav.inc.php"; ?>
                        </div>
                        <!--Page Titles -->
                        <div class="col-sm-12 text-center text-nowrap sites-card mb-1" style="background-color: #eef7ff; font-weight: bold;">
                            <h1 class="h1headerTitle mb-0"><?php echo getPageTitle() ?></h1>
                        </div>
                        <!-- Part where the page goes in -->
                        <div style="margin-top:0px;">
                            