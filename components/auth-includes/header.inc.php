<?php   
  if(!isset($_SESSION)) 
  { 
    session_start();
  } 
?>
<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>AmazingStakes</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" href="/images/amazingstakeslogo.ico" type="image/x-icon">
    <!-- Icons. Uncomment required icon fonts --> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/login-styles.css" rel="stylesheet" />
    <link href="/css/dashboard.css" rel="stylesheet" />
  </head>

  <body>
  <div id="preloader" class="preloader" style="display: none;">
      <div class="spinner"></div>
  </div>
