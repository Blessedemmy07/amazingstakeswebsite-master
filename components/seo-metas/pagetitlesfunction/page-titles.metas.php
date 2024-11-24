<?php
function getPageTitle() {
    // Determine the current route
    $currentRoute = trim($_SERVER['REQUEST_URI'], '/');
    
    //Other jackpot routes
    $jackpotRoutes = getJackpotRoutes();

    // Determine the page title based on the current route
    if ($currentRoute === '') {//Homepage
        return "Mathematical Football Predictions /Amazingstakes/ and Soccer statistics";
    } elseif ($currentRoute === 'about-us') {
        return "About Amazingstakes : Your Winning Edge";
    } elseif ($currentRoute === 'contact-us') {
        return "Contact Us";
    } elseif ($currentRoute === 'register.auth') {
        return "register.auth";
    } elseif ($currentRoute === 'faq') {
        return "Amazingstakes Faq";
    } elseif ($currentRoute === 'links') {
        return "Amazingstakes Partners";
    } elseif ($currentRoute === 'refund') {
        return "No Refund Policy";
    } elseif ($currentRoute === 'privacy') {
        return "Privacy and Data Protection";
    } elseif ($currentRoute === 'jackpot-predictions') {
        return "Jackpot Predictions";
    } elseif ($currentRoute === 'must-win-teams-today') {
        return "Must Win Teams Today";
    } elseif ($currentRoute === 'correct-score') {
        return "Correct Score Prediction Today";
    } elseif ($currentRoute === 'take-the-risk') {
        return "Take the Risk Prediction: Big Odds, Big Wins";
    } elseif ($currentRoute === 'sportpesa-mega-jackpot-prediction') {
        return "SportPesa Mega Jackpot Predictions";
    } elseif ($currentRoute === 'jackpot') {
        return "Midweek Jackpot Predictions";
    } elseif ($currentRoute === 'todays-prediction') {
        return "100 Sure Football Predictions";
    } elseif ($currentRoute === 'tomorrow-predictions') {
        return "Tomorrow’s Predictions";
    } elseif ($currentRoute === 'upcoming-popular-matches') {
        return "Upcoming Popular Matches";
    } elseif ($currentRoute === 'weekend-football-prediction') {
        return "Weekend Football Tips";
    } elseif ($currentRoute === 'yesterday-predictions') {
        return "Yesterday’s Predictions";
    } elseif ($currentRoute === 'live-predictions') {
        return "Live Predictions";
    } elseif ($currentRoute === 'bet-of-the-day-tips') {
        return "Bet of the Day : Mybets Today";
    } elseif ($currentRoute === 'sure-tips') {
        return "Sure Win Prediction Today - Surest Prediction Site";
    } elseif ($currentRoute === 'direct-win-prediction') {
        return "Direct Win Prediction";
    } elseif ($currentRoute === 'tips-sokafans') {
        return "Sokafans Predictions";
    } elseif ($currentRoute === 'tips-spotika') {
        return "Spotika Free Prediction Today";
    } elseif ($currentRoute === 'prediction-vitibet-adibet') {
        return "Adibet and Vitibet Predictions Today";
    } elseif ($currentRoute === 'tips180') {
        return "Tips180 Prediction";
    } elseif ($currentRoute === 'betensured-prediction') {
        return "Betensured Prediction Today";
    } elseif ($currentRoute === '1960tips') {
        return "1960 Tips Prediction";
    } elseif ($currentRoute === 'terms') {
        return "Terms & Conditions";
    } elseif ($currentRoute === 'over-2.5-predictions-today') {
        return "100 Expert Over 2.5 Prediction";
    } elseif ($currentRoute === 'victor-predict') {
        return "Victor Prediction Today";
    } elseif ($currentRoute === 'soccervista-prediction') {
        return "Soccervista Prediction Today";
    } elseif ($currentRoute === 'solo-prediction') {
        return "Solo Prediction For Today";
    } elseif ($currentRoute === 'liobet') {
        return "Liobet Tips";
    } elseif (in_array($currentRoute, $jackpotRoutes)) { //Other jackpot predictions
        include_once __DIR__ . "/../../../components/functions/jackpotRoutes.php";
        include_once __DIR__ . "/../../../components/functions/getJackpotFilterName.php";

        $jackpot_name = returnJackpotNameSavedInDB($_SERVER['REQUEST_URI']);

        return $jackpot_name ." Predictions"; 
    } elseif (preg_match('/^football-predictions-by-date\/(\d{4}-\d{2}-\d{2})$/', $currentRoute, $matches)) {
        $selectedDate = $matches[1];
        $formattedDate = DateTime::createFromFormat('Y-m-d', $selectedDate)->format('l, d/m/Y');

        return "Football Predictions for - $formattedDate";
    } elseif (preg_match('/^football-predictions-for-([^\/]+)\/fixtures$/', $currentRoute, $matches)) {
        // Assuming country_name is the first captured group from the regex
        $country_name = isset($matches[1]) ? $matches[1] : ''; 
    
        return "Football Predictions for " . ucfirst($country_name);

    } elseif (preg_match('/^football-predictions-for-([^\/]+)\/([^\/]+)-(\d+)\/fixtures$/', $currentRoute, $matches)) {
        // Assuming country_name, league_name are captured groups from the regex
        $country_name = isset($matches[1]) ? $matches[1] : ''; 
        $league_name = isset($matches[2]) ? $matches[2] : ''; 
    
        return "Football Predictions for " . ucfirst($country_name) . " - " . ucfirst(str_replace('-', ' ', $league_name))."";
    } elseif (preg_match('/^football-predictions-for-([^\/]+)\/([^\/]+)-(\d+)\/standings$/', $currentRoute, $matches)) {
        // Assuming country_name, league_name are captured groups from the regex
        $country_name = isset($matches[1]) ? $matches[1] : ''; 
        $league_name = isset($matches[2]) ? $matches[2] : ''; 
    
        return "Standings for " . ucfirst($country_name) . " - " . ucfirst(str_replace('-', ' ', $league_name))."";
    } elseif (preg_match('/^football-predictions-([^\/]+)-vs-([^\/]+)-(\d+)$/', $currentRoute, $matches)) {
        $homeTeamName = isset($matches[1]) ? ucfirst(str_replace('-', ' ', $matches[1])) : ''; // Convert to proper name format
        $awayTeamName = isset($matches[2]) ? ucfirst(str_replace('-', ' ', $matches[2])) : ''; // Convert to proper name format
        $fixtureId = isset($matches[3]) ? $matches[3] : ''; // Fixture ID
    
        // Return or echo the formatted string
        echo "$homeTeamName vs $awayTeamName Predictions, Standings and Tips";
    } elseif (preg_match('/^teams\/([^\/]+)-(\d+)$/', $currentRoute, $matches)) {
        // Assuming team_name and team_id are captured groups from the regex
        $team_name = isset($matches[1]) ? $matches[1] : ''; 
        $team_id = isset($matches[2]) ? $matches[2] : ''; 
    
        // Replace hyphens with spaces and make it uppercase
        $formatted_team_name = strtoupper(str_replace('-', ' ', $team_name));
        return "LATEST " . $formatted_team_name . " RESULTS";        
    } else {
        return "Page Not Found";
    } 
}
