<?php
  session_start(); 

  // Define timeout in seconds (20 minutes)
  $timeout_duration = 1200; 

  // Check if session has data
  if (!isset($_SESSION['logged_in_user']) || empty($_SESSION['logged_in_user'])) {
      // If Session is not set, redirect back to Login Page
      header("Location: /login");
      exit; // Stop further script execution after redirect
  }

  // Check if the session has a last activity timestamp
  if (isset($_SESSION['last_activity'])) {
    // Calculate time since last activity
    $elapsed_time = time() - $_SESSION['last_activity'];
    
    // If elapsed time is greater than the timeout duration, destroy the session
    if ($elapsed_time > $timeout_duration) {
        session_unset();
        session_destroy();

        header("Location: /login"); // Redirect to login page 
        exit();
    }
  }
?>
