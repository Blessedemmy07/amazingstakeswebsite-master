<!DOCTYPE html>
<html lang="en">
   <head>
      
      <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VZTNJSDL77"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VZTNJSDL77');
</script>
      
      <div id='zone_1250688050' ></div>
      <script>
         (function(w,d,o,g,r,a,m){
            var cid='zone_1250688050';
            w[r]=w[r]||function(){(w[r+'l']=w[r+'l']||[]).push(arguments)};
            function e(b,w,r){if((w[r+'h']=b.pop())&&!w.ABN){
                  var a=d.createElement(o),p=d.getElementsByTagName(o)[0];a.async=1;
                  a.src='https://cdn.'+w[r+'h']+'/libs/e.js';a.onerror=function(){e(g,w,r)};
                  p.parentNode.insertBefore(a,p)}}e(g,w,r);
            w[r](cid,{id:1250688050,domain:w[r+'h']});
         })(window,document,'script',['trafficdok.com'],'ABNS');
      </script>

      <script src="/js/calendar.js"></script>

      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <link rel="icon" href="/images/amazingstakeslogo.ico" type="image/x-icon">
      <link rel="apple-touch-icon" sizes="180x180" href="/images/amazingstakeslogo.png">
      <link rel="icon" type="image/png" sizes="32x32" href="/images/amazingstakeslogo.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/images/amazingstakeslogo.png">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <meta name="author" content="Amazingstakes">
      <meta name="theme-color" content="#da532c"/>
      <meta name="robots" content="index, follow">
      <meta name="revisit-after" content="7 days">
      <meta name="copyright" content="© 2024 Amazingstakes All rights reserved." />

   <?php 
      $currentRoute = trim($_SERVER['REQUEST_URI'], '/'); // Get the current route path

      // Set the canonical URL and alternate links based on the current route
      $canonicalUrl = "https://www.amazingstakes.com/" . $currentRoute;
      echo '<link rel="canonical" href="' . $canonicalUrl . '">';
      echo '<link rel="alternate" hreflang="en" href="' . $canonicalUrl . '">';
      echo '<link rel="alternate" hreflang="x-default" href="' . $canonicalUrl . '">';
   ?>

   <script src="/js/calendar.js"></script>

   <!-- Meta Tags and Descriptions--->
   <?php
      //Other jackpot routes
      $jackpotRoutes = getJackpotRoutes();

      // Determine the current route
      $currentRoute = trim($_SERVER['REQUEST_URI'], '/');

      // Include the relevant meta file based on the current route
      if ($currentRoute === '') {
         include __DIR__ .'/../seo-metas/homepage.metas.php';
      } elseif ($currentRoute === 'about-us') {
         include __DIR__ .'/../seo-metas/about-us.metas.php';
      } elseif ($currentRoute === 'jackpot-predictions') {
         include __DIR__ .'/../seo-metas/jackpot-predictions.metas.php';
      } elseif ($currentRoute === 'must-win-teams-today') {
         include __DIR__ .'/../seo-metas/must-win-teams-today.metas.php';
      } elseif ($currentRoute === 'victor-predict') {
         include __DIR__ .'/../seo-metas/victor-predict.metas.php';
      } elseif ($currentRoute === 'sportpesa-mega-jackpot-prediction') {
         include __DIR__ .'/../seo-metas/sportpesa-mega-jackpot-prediction.metas.php';
      } elseif ($currentRoute === 'sportpesa-midweek-jackpot-predictions') {
         include __DIR__ .'/../seo-metas/sportpesa-midweek-jackpot-predictions.metas.php';
      } elseif (in_array($currentRoute, $jackpotRoutes)) { 
         //Other Jackpot pages
         include_once __DIR__ . "/../../components/functions/jackpotRoutes.php";
         include_once __DIR__ . "/../../components/functions/getJackpotFilterName.php";

         include __DIR__ . '/../seo-metas/other-jackpots.metas.php';
      } elseif ($currentRoute === 'todays-prediction') {
         include __DIR__ .'/../seo-metas/todays-prediction.metas.php';
      } elseif ($currentRoute === 'tomorrow-predictions') {
         include __DIR__ .'/../seo-metas/tomorrow-predictions.metas.php';
      } elseif ($currentRoute === 'upcoming-popular-matches') {
         include __DIR__ .'/../seo-metas/upcoming-popular-matches.metas.php';
      } elseif ($currentRoute === 'weekend-football-prediction') {
         include __DIR__ .'/../seo-metas/weekend-predictions.metas.php';
      } elseif ($currentRoute === 'yesterday-predictions') {
         include __DIR__ .'/../seo-metas/yesterday-predictions.metas.php';
      } elseif ($currentRoute === 'live-predictions') {
         include __DIR__ .'/../seo-metas/live-predictions.metas.php';
      }elseif ($currentRoute === 'sure-tips') {
         include __DIR__ .'/../seo-metas/sure-tips.metas.php';
      }elseif ($currentRoute === 'faq') {
         include __DIR__ .'/../seo-metas/faq.metas.php';
      }elseif ($currentRoute === 'correct-score') {
         include __DIR__ .'/../seo-metas/correct-score.metas.php';
      }elseif ($currentRoute === 'take-the-risk') {
         include __DIR__ .'/../seo-metas/take-the-risk.metas.php';
      }elseif ($currentRoute === 'links') {
         include __DIR__ .'/../seo-metas/links.metas.php';
      }elseif ($currentRoute === 'refund') {
         include __DIR__ .'/../seo-metas/refund.metas.php';
      }elseif ($currentRoute === 'bet-of-the-day-tips') {
         include __DIR__ .'/../seo-metas/bet-of-the-day-tips.metas.php';
      }elseif ($currentRoute === 'direct-win-prediction') {
         include __DIR__ .'/../seo-metas/direct-win-prediction.metas.php';
      }elseif ($currentRoute === 'tips-spotika') {
         include __DIR__ .'/../seo-metas/tips-spotika.metas.php';
      }elseif ($currentRoute === 'tips-sokafans') {
         include __DIR__ .'/../seo-metas/tips-sokafans.metas.php';
      }elseif ($currentRoute === '1960tips') {
         include __DIR__ .'/../seo-metas/1960tips.metas.php';
      }elseif ($currentRoute === 'tips180') {
         include __DIR__ .'/../seo-metas/tips180.metas.php';
      }elseif ($currentRoute === 'betensured-prediction') {
         include __DIR__ .'/../seo-metas/betensured-prediction.metas.php';
      }elseif ($currentRoute === 'contact-us') {
         include __DIR__ .'/../seo-metas/contact-us.metas.php';
      }elseif ($currentRoute === 'solo-prediction') {
         include __DIR__ .'/../seo-metas/solo-prediction.metas.php';
      }elseif ($currentRoute === 'prediction-vitibet-adibet') {
         include __DIR__ .'/../seo-metas/prediction-vitibet-adibet.metas.php';
      }elseif ($currentRoute === 'register.auth') {
         include __DIR__ .'/../seo-metas/register.auth.metas.php';
      }elseif ($currentRoute === 'liobet') {
         include __DIR__ .'/../seo-metas/liobet.metas.php';
      }elseif ($currentRoute === 'refund') {
         include __DIR__ .'/../seo-metas/refund.metas.php';
      }elseif ($currentRoute === 'privacy') {
         include __DIR__ .'/../seo-metas/privacy.metas.php';
      }elseif ($currentRoute === 'terms') {
         include __DIR__ .'/../seo-metas/terms.metas.php';
      }elseif ($currentRoute === 'over-2.5-predictions-today') {
         include __DIR__ .'/../seo-metas/over-2.5-predictions-today.metas.php';
      }elseif ($currentRoute === 'soccervista-prediction') {
         include __DIR__ .'/../seo-metas/soccervista-prediction.metas.php';
      } elseif (preg_match('/^football-predictions-by-date\/(\d{4}-\d{2}-\d{2})$/', $currentRoute, $matches)) {
         include __DIR__ .'/../seo-metas/football-predictions-by-date.metas.php';
      } elseif (preg_match('/^football-predictions-for-([^\/]+)\/fixtures$/', $currentRoute, $matches)) {
         include __DIR__ .'/../seo-metas/country/fixtures.metas.php';
      } elseif (preg_match('/^football-predictions-for-([^\/]+)\/([^\/]+)-(\d+)\/fixtures$/', $currentRoute, $matches)) {
         include __DIR__ .'/../seo-metas/leagues/fixtures.metas.php';
      } elseif (preg_match('/^football-predictions-([^\/]+)-vs-([^\/]+)-(\d+)$/', $currentRoute, $matches)) {
         include __DIR__ .'/../seo-metas/matches/matches.metas.php';
      } elseif (preg_match('/^teams\/([^\/]+)-(\d+)$/', $currentRoute, $matches)) {
         include __DIR__ .'/../seo-metas/teams/teams.metas.php';
      } else {
         include __DIR__ .'/../seo-metas/homepage.metas.php';
      }
   ?> 

   <!-- Open Graph Meta Tags -->
   <meta property="og:locale" content="en_US">
   <meta property="og:type" content="website">
   <meta property="og:url" content="<?= $canonicalUrl ?>">
   <meta property="og:image" content="/images/amazingstakeslogo.png">
   <meta property="og:image:alt" content="Amazing Stakes">
   <meta property="og:site_name" content="Amazing Stakes">

   <!-- Twitter Card Meta Tags -->
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:url" content="<?= $canonicalUrl ?>">
   <meta name="twitter:image" content="/images/amazingstakeslogo.png">
   <meta name="twitter:image:alt" content="Amazing Stakes">
   <meta name="twitter:site" content="@AmazingStakes">

   <!-- CSS Links -->
   <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/error-404s/error-404-1/assets/css/error-404-1.css">
   <link rel="stylesheet" href="/css/global.css">
   <link rel="stylesheet" href="/css/other-styles.css">
   <link rel="stylesheet" href="/css/calendar.css">
</head>
