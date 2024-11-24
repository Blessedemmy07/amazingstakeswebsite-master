<?php
    require __DIR__ . '/../../vendor/autoload.php';

    use App\Classes\Users;  

    $users = new Users();

    $response = $users ->UserLogin($_POST["email"],$_POST["password"]);

    echo $response;

?>