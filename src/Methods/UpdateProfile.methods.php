<?php
    require __DIR__ . '/../../vendor/autoload.php';

    use App\Classes\Users;  

    $users = new Users();

    $response = $users ->UpdateUserProfile($_POST["name"],$_POST["phone"],$_POST["country"],$_POST["email"]);

    $update_profile_response = json_decode($response, true);

    if($update_profile_response["status"] == "success"){
        echo $_SESSION['success']=$update_profile_response["message"];
    }
    else{
        echo $_SESSION['error']= $update_profile_response["message"];
    }        

    header('Location: edit');
?>