<?php
require __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . "/../components/functions/jackpotRoutes.php";

use App\Facades\Router; 

// Initialize Routing class
$router = new Router();

// Define routes
$router->get('/', function() {
    include __DIR__ . '/../pages/homepage.php'; // Include homepage file
});

$router->get('/about-us', function() {
    include __DIR__ . '/../pages/about-us.php'; // Include about-us file
});

$router->get('/upcoming-popular-matches', function() {
    include __DIR__ . '/../pages/upcoming-popular-matches.php'; // Include upcoming-popular-matches page file
});

$router->get('/todays-prediction', function() {
    include __DIR__ . '/../pages/todays-prediction.php'; // Include todays-prediction page file
});

$router->get('/live-predictions', function() {
    include __DIR__ . '/../pages/live-predictions.php'; // Include live-predictions page file
});

$router->get('/tomorrow-predictions', function() {
    include __DIR__ . '/../pages/tomorrow-predictions.php'; // Include tomorrow-predictions page file
});

$router->get('/yesterday-predictions', function() {
    include __DIR__ . '/../pages/yesterday-predictions.php'; // Include yesterday-predictions page file
}); 

$router->get('/refund', function() {
    include __DIR__ . '/../pages/refund.php'; // Include refund page file
});

$router->get('/privacy', function() {
    include __DIR__ . '/../pages/privacy.php'; // Include privacy page file
});

$router->get('/correct-score', function() {
    include __DIR__ . '/../pages/correct-score.php'; // Include correct-score page file
});

$router->get('/take-the-risk', function() {
    include __DIR__ . '/../pages/take-the-risk.php'; // Include take-the-risk page file
});

$router->get('/weekend-football-prediction', function() {
    include __DIR__ . '/../pages/weekend-predictions.php'; // Include weekend-football-prediction page file
}); 

$router->get('/must-win-teams-today', function() {
    include __DIR__ . '/../pages/must-win-teams-today.php'; // Include must-win-teams-today page file
}); 
$router->get('/sure-tips', function() {
    include __DIR__ . '/../pages/sure-tips.php'; // Include sure-tips page file
});

$router->get('/solo-prediction', function() {
    include __DIR__ . '/../pages/solo-prediction.php'; // Include solo-prediction page file
});

$router->get('/betensured-prediction', function() {
    include __DIR__ . '/../pages/betensured-prediction.php'; // Include solo-prediction page file
});

$router->get('/over-2.5-predictions-today', function() {
    include __DIR__ . '/../pages/over-2.5-predictions-today.php'; // Include solo-prediction page file
});

$router->get('/football-predictions-by-date/{date}', function($date) {
    $_GET['date'] = $date; // Populate $_GET['date']
    include __DIR__ . '/../pages/football-predictions-by-date.php';
});

$router->get('/jackpot-predictions', function() {
    include __DIR__ . '/../pages/jackpot-predictions.php'; // Include jackpot-predictions page file
});

$router->get('/bet-of-the-day-tips', function() {
    include __DIR__ . '/../pages/bet-of-the-day-tips.php'; // Include bet-of-the-day-tips page file
});

$router->get('/direct-win-prediction', function() {
    include __DIR__ . '/../pages/direct-win-prediction.php'; // Include direct-win-prediction page file
});

$router->get('/tips180', function() {
    include __DIR__ . '/../pages/tips180.php'; // Include tips180 page file
});

$router->get('/victor-predict', function() {
    include __DIR__ . '/../pages/victor-predict.php'; // Include victor-predict page file
});
 
$router->get('/tips-sokafans', function() {
    include __DIR__ . '/../pages/tips-sokafans.php'; // Include tips-sokafans page file
});

$router->get('/tips-spotika', function() {
    include __DIR__ . '/../pages/tips-spotika.php'; // Include tips-spotika page file
});

$router->get('/1960tips', function() {
    include __DIR__ . '/../pages/1960tips.php'; // Include 1960tips page file
});

$router->get('/contact-us', function() {
    include __DIR__ . '/../pages/contact-us.php'; // Include contact-us page file
});
$router->get('/faq', function() {
    include __DIR__ . '/../pages/faq.php'; // Include faq page file
});

$router->get('/links', function() {
    include __DIR__ . '/../pages/links.php'; // Include links page file
});

$router->get('/terms', function() {
    include __DIR__ . '/../pages/terms.php'; // Include terms page file
});
$router->get('/liobet', function() {
    include __DIR__ . '/../pages/liobet.php'; // Include liobet page file
});

$router->get('/soccervista-prediction', function() {
    include __DIR__ . '/../pages/soccervista-prediction.php'; // Include soccervista-prediction page file
});

$router->get('/prediction-vitibet-adibet', function() {
    include __DIR__ . '/../pages/prediction-vitibet-adibet.php'; // Include prediction-vitibet-adibet page file
});

$router->get('/sportpesa-mega-jackpot-prediction', function() {
    include __DIR__ . '/../pages/jackpots/sportpesa-mega-jackpot-prediction.php'; // Include sportpesa-mega-jackpot-prediction page file
});

$router->get('/jackpot', function() { //sportpesa-midweek-jackpot-predictions
    include __DIR__ . '/../pages/jackpots/sportpesa-midweek-jackpot-predictions.php'; // Include sportpesa-midweek-jackpot-predictions page file
}); 

$router->get('/betika-midweek-jackpot-predictions', function() {
    include __DIR__ . '/../pages/jackpots/betika-midweek-jackpot-predictions.php'; // Include betika-midweek-jackpot-predictions page file
});

$router->get('/mozzart-super-daily-jackpot-predictions', function() {
    include __DIR__ . '/../pages/jackpots/mozzart-super-daily-jackpot-predictions.php'; // Include mozzart-super-daily-jackpot-predictions page file
});

$router->get('/football-predictions-for-{country_name}/fixtures', function($country_name) {
    $_GET['country_name'] = $country_name; 

    include __DIR__ . '/../pages/country/fixtures.php';  
});

$router->get('/other_leagues_json', function() {
    include __DIR__ . '/jsonfiles/other-leagues.json';  
});

$router->get('/other_competitions_json', function() {
    include __DIR__ . '/jsonfiles/other-competitions.json';  
});

$router->get('/football-predictions-for-{country_name}/{league_name}-{league_id}/fixtures', function($country_name, $league_name, $league_id) {
    $_GET['country_name'] = $country_name;
    $_GET['league_name'] = $league_name;
    $_GET['league_id'] = $league_id;

    include __DIR__ . '/../pages/leagues/fixtures.php';
});

$router->get('/football-predictions-for-{country_name}/{league_name}-{league_id}/standings', function($country_name, $league_name, $league_id) {
    $_GET['country_name'] = $country_name;
    $_GET['league_name'] = $league_name;
    $_GET['league_id'] = $league_id;

    include __DIR__ . '/../pages/leagues/standings.php';
});

$router->get('/football-predictions-{home_team_name}-vs-{away_team_name}-{match_id}', function($home_team_name, $away_team_name, $match_id) {
    $_GET['home_team_name'] = $home_team_name;
    $_GET['away_team_name'] = $away_team_name;
    $_GET['match_id'] = $match_id;

    include __DIR__ . '/../pages/matchdetails/matches.php';
});

$router->get('/teams/{team_name}-{team_id}', function($team_name, $team_id) {
    $_GET['team_name'] = $team_name;
    $_GET['team_id'] = $team_id;

    include __DIR__ . '/../pages/teamdetails/teams.php';
});

$router->get('/login', function() {
    // Start the session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the session variable for the logged-in user is set
    if (isset($_SESSION["logged_in_user"])) {
        // If the user is logged in, redirect to the dashboard
        header("Location: /dashboard");
        exit(); // Make sure to exit after redirection
    } else {
        // If the user is not logged in, include the login page
        include __DIR__ . '/../pages/auth/login.auth.php';
    }
});

$router->get('/register', function() {
    include __DIR__ . '/../pages/auth/register.auth.php'; // Include register.auth page file
});

//Post methods for authentication
$router->post('/methods/userlogin', function() {
    include __DIR__ . '/../src/Methods/Userlogin.methods.php';
});

$router->post('/methods/userregistration', function() {
    include __DIR__ . '/../src/Methods/UserRegister.methods.php';
});

$router->get('/methods/userlogout', function() {
    include __DIR__ . '/../src/Methods/Userlogout.methods.php';
});

$router->get('/dashboard', function() {
    include __DIR__ . '/../pages/auth/dashboard.auth.php'; // Include dashboard.auth.auth page file
});

$router->get('/edit', function() {
    include __DIR__ . '/../pages/auth/edit-profile.auth.php'; // Include edit-profile.auth.php page file
});

$router->post('/update_user_profile', function() {
    include __DIR__ . '/../src/Methods/UpdateProfile.methods.php'; // Include UpdateProfile.methods.php page file
});

$router->get('/make-payment', function() {
    include __DIR__ . '/../pages/auth/make-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/choose-inter', function() {
    include __DIR__ . '/../pages/auth/payment-method.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/paypal', function() {
    include __DIR__ . '/../pages/auth/paypal-payments.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/paypal-pro', function() {
    include __DIR__ . '/../pages/auth/paypal-pro.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/international', function() {
    include __DIR__ . '/../pages/auth/international.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/inter-pay', function() {
    include __DIR__ . '/../pages/auth/inter-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/local', function() {
    include __DIR__ . '/../pages/auth/local-nigeria-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/local-pay', function() {
    include __DIR__ . '/../pages/auth/local-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/m-bank', function() {
    include __DIR__ . '/../pages/auth/m-bank.auth.php'; // Include make-payment.auth.auth page file
}); 

$router->get('/cameroon-payment', function() {
    include __DIR__ . '/../pages/auth/cameroon-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/cameroon-pay', function() {
    include __DIR__ . '/../pages/auth/payment-method.auth.php'; // Include make-payment.auth.auth page file
}); 

$router->get('/choose-uk', function() {
    include __DIR__ . '/../pages/auth/choose-uk.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/uk-payment', function() {
    include __DIR__ . '/../pages/auth/uk-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/uk-pay', function() {
    include __DIR__ . '/../pages/auth/uk-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/uk-paypal', function() {
    include __DIR__ . '/../pages/auth/uk-paypal.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/ghana-payment', function() {
    include __DIR__ . '/../pages/auth/ghana-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/ghana-pay', function() {
    include __DIR__ . '/../pages/auth/ghana-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/m-money', function() {
    include __DIR__ . '/../pages/auth/m-money.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/kenya-payment', function() {
    include __DIR__ . '/../pages/auth/kenya-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/kenya-pay', function() {
    include __DIR__ . '/../pages/auth/kenya-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/m-pesa', function() {
    include __DIR__ . '/../pages/auth/m-pesa.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/rwanda-payment', function() {
    include __DIR__ . '/../pages/auth/rwanda-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/rwanda-pay', function() {
    include __DIR__ . '/../pages/auth/rwanda-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/tanz-payment', function() {
    include __DIR__ . '/../pages/auth/tanz-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/tanz-pay', function() {
    include __DIR__ . '/../pages/auth/tanz-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/uganda-payment', function() {
    include __DIR__ . '/../pages/auth/uganda-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/uganda-pay', function() {
    include __DIR__ . '/../pages/auth/uganda-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/zambia-payment', function() {
    include __DIR__ . '/../pages/auth/zambia-payment.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/zambia-pay', function() {
    include __DIR__ . '/../pages/auth/zambia-pay.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/sure-2', function() {
    include __DIR__ . '/../pages/auth/vippages/sure-2.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/5-Odds', function() {
    include __DIR__ . '/../pages/auth/vippages/5-odds.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/sure-3', function() {
    include __DIR__ . '/../pages/auth/vippages/sure-3.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/10-Odds', function() {
    include __DIR__ . '/../pages/auth/vippages/10-odds.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/50-odds', function() {
    include __DIR__ . '/../pages/auth/vippages/50-odds.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/rollover', function() {
    include __DIR__ . '/../pages/auth/vippages/rollover.auth.php'; // Include make-payment.auth.auth page file
});

$router->get('/investment', function() {
    include __DIR__ . '/../pages/auth/vippages/investment.auth.php'; // Include make-payment.auth.auth page file
});

// Include `other-jackpot-predictions.php` for the listed jackpot routes
$jackpotRoutes =  getJackpotRoutes();

// Iterate over each route and define it to use `other-jackpot-predictions.php`
foreach ($jackpotRoutes as $route) {
    $router->get("/$route", function() {
        include __DIR__ . '/../pages/jackpots/other-jackpot-predictions.php';
    });
}

// Handle the incoming request
$router->handleRequest();
