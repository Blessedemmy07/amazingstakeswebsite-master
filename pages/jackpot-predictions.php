<?php
include_once __DIR__ . "/../components/shared/preloader.shared.php";
include_once __DIR__ . "/../components/layouts/top-layout.layout.php";  
include_once __DIR__ . "/../components/functions/GetJackpotName.php";
include_once __DIR__ . "/../components/functions/getJackpotNameFromSlug.php";
include_once __DIR__ . "/../components/functions/jackpotRoutes.php";

// Function to fetch active jackpots
function getActiveJackpots() {
    $headers = [
        "Authorization: UJlhuDILIR1Lc2IEwZDIKOln9d"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.pitchpredictions.com/api/fetch_active_jackpots_only');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) { 
        return [];
    }

    $data = json_decode($response, true);
    return $data['status'] && isset($data['data']) ? $data['data'] : [];
}

// Convert string to sentence case (PHP equivalent of toSentenceCase)
function toSentenceCase($string) {
    return ucwords(strtolower($string));
}

// Format date function
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('l, F j, Y');
}

// Slugs array
$slugs = getJackpotRoutes();

// Fetch active jackpots
$activeJackpots = getActiveJackpots();

// Extract slugs from active jackpots to compare with the full list
$activeSlugs = array_map(function ($jackpot) {
    return returnSlugFromJackpotName(toSentenceCase($jackpot['jackpot_name']));
}, $activeJackpots);

// Filter slugs for "All Jackpots Section" to exclude those already shown in "Active Jackpots"
$filteredSlugs = array_filter($slugs, function ($slug) use ($activeSlugs) {
    return !in_array($slug, $activeSlugs);
});

// Prepare all jackpot data for the client-side
$allJackpots = array_merge(
    array_map(function ($jackpot) {
        return [
            'name' => toSentenceCase($jackpot['jackpot_name']),
            'slug' => returnSlugFromJackpotName(toSentenceCase($jackpot['jackpot_name'])),
            'numberOfGames' => $jackpot['numberOfGames'],
            'startDate' => $jackpot['startDate'],
            'endDate' => $jackpot['endDate'],
            'active' => true
        ];
    }, $activeJackpots),
    array_map(function ($slug) {
        return [
            'name' => getJackpotNameFromSlug($slug),
            'slug' => $slug,
            'active' => false
        ];
    }, $filteredSlugs)
);
?>

<!-- HTML Part -->
<div class="container"> <!--sites-card-->
    <div class="search-bar mb-2">
        <input
            type="text"
            id="searchTerm"
            placeholder="Search By Jackpot Name"
            class="form-control"
            style="color: black; font-weight: bold;"
        />
    </div>

    <div class="row" id="activeJackpotList" style="text-align: left; font-weight: bold; margin: 0px 5px 5px 5px;">
        <h3>Active Jackpots</h3>
        <!-- Active Jackpot Items will be populated here by JavaScript -->
    </div>

    <div class="row" id="allJackpotList" style="text-align: left; font-weight: bold; margin: 0px 5px 5px 5px;">
        <h3>Other Jackpots</h3>
        <!-- Other Jackpot Items will be populated here by JavaScript -->
    </div>
</div>

<script>
    // Get jackpots data from PHP
    const jackpots = <?php echo json_encode($allJackpots); ?>;

    const searchInput = document.getElementById('searchTerm');
    const activeJackpotList = document.getElementById('activeJackpotList');
    const allJackpotList = document.getElementById('allJackpotList');

    // Function to format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }

    // Function to render jackpots
    function renderJackpots(filteredJackpots) {
        let activeContent = '';
        let allContent = '';
        let numbering = 1; // Shared numbering variable for both sections

        filteredJackpots.forEach(jackpot => {
            if (jackpot.active) {
                activeContent += `
                    <div class="m-1">
                        <a href="/${jackpot.slug}">
                            ${numbering++}. ${jackpot.name}
                            &nbsp;&nbsp; (<span class="fixturesTextSize" style="color: #212529;">No of Games: ${jackpot.numberOfGames}</span>)
                        </a>
                        <div class="m-1">
                            <p class="fixturesTextSize ml-5" style="color: gray;">
                                (Start Date: ${formatDate(jackpot.startDate)} - End Date: ${formatDate(jackpot.endDate)})
                            </p>
                        </div>
                    </div>
                `;
            } else {
                allContent += `
                    <div class="m-2">
                        <a href="/${jackpot.slug}">
                            ${numbering++}. ${jackpot.name}
                        </a>
                    </div>
                `;
            }
        });

        activeJackpotList.innerHTML = '<h3>Active Jackpots</h3>' + activeContent;
        allJackpotList.innerHTML = '<h3>Other Jackpots</h3>' + allContent;
    }

    // Function to filter jackpots based on search term
    function filterJackpots(searchTerm) {
        return jackpots.filter(jackpot => 
            jackpot.name.toLowerCase().includes(searchTerm.toLowerCase())
        );
    }

    // Event listener for search input
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.trim();
        const filteredJackpots = filterJackpots(searchTerm);
        renderJackpots(filteredJackpots);
    });

    // Render all jackpots initially
    renderJackpots(jackpots);
</script>


<?php
//Seo Content
include_once __DIR__ . "/../components/seo-content/jackpot-predictions.content.php";

include_once __DIR__ . "/../components/layouts/bottom-layout.layout.php";
?>
