<?php
    require __DIR__ . '/../../vendor/autoload.php';

    use App\Classes\Users;  

    $users = new Users();

    $create_user = $users->CreateUser($_POST["fullName"],$_POST["email"],$_POST["phone_number"],$_POST["country"], $_POST["password"]);

    echo $create_user;

?>