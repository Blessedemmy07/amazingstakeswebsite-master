$(document).ready(function(){
    $("#loginBtn").click(function(e){
        e.preventDefault();

        // Define variables
        var user_email = $("#email_address").val();
        var user_password = $("#password").val();
        
        if(validateLoginInputs()){
            UserLogin(user_email, user_password);
        } 
    });

    $("#logoutBtn").click(function(e){
        e.preventDefault();

        // Show the preloader
        $("#preloader").show();

        $.ajax({
            url: "/methods/userlogout",
            success: function(){
                window.location.href = "/";
            },
            complete: function() {
                // Hide the preloader when AJAX call is complete
                $("#preloader").hide();
            }
        });
    });

    $("#btnRegisterUser").click(function(e){
        e.preventDefault();

        if(validateRegisterInputs() == true){
            Createnewuser($("#fullName").val(), $("#email").val(), $("#phone_number").val(), $("#country").val(), $("#password").val(), $("#confirm_password").val());
        } 
    });
});

//Validate Login form
function validateLoginInputs() {
    if ($('#email_address').val() == '') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Email is required!";

        return false;

    } else if ($('#password').val() == '') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Password is required!";

        return false;
    } 
     else {
        return true;
    }
}

//Validate Registration form
function validateRegisterInputs() {
    if ($('#fullName').val() == '') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Name is required!";

        return false;

    } else if ($('#email_address').val() == '') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Email is required!";

        return false;

    } else if ($('#phone_number').val() == '') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Phone Number is required!";

        return false;

    } else if ($('#country').val() === '' || $('#country').val() === 'Please select') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Country is required!";

        return false;

    } else if ($('#password').val() == '') {

        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Password is required!";

        return false;
    } 
     else {
        return true;
    }
}

function UserLogin(email,password){
    // Show the preloader
    $("#preloader").show();

    $.ajax({
        url:"/methods/userlogin",
        method:"POST",
        dataType: "json", 
        data:{
            email:email,
            password:password
        },
        success: function(response) { 
            if (response.status == "success") {
                //Redirect the user to Dashboard
                window.location.href="/dashboard";

            } else {
                $("#alertUserMsg").show();          
                $("#alertUserMsg").removeClass().addClass("alert alert-danger");
                document.getElementById("alertUserMsg").innerHTML = response.message;
            }    
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $("#alertUserMsg").show();          
            $("#alertUserMsg").removeClass().addClass("alert alert-danger");
            document.getElementById("alertUserMsg").innerHTML = thrownError;
        },
        complete: function() {
            // Hide the preloader when AJAX call is complete
            $("#preloader").hide();
        }
    })
}

function Createnewuser(fullName, email, phone_number, country, password, confirm_password) {
    // Show the preloader
    $("#preloader").show();

    // Check if password and confirm_password match
    if (password !== confirm_password) {
        $("#alertUserMsg").show();          
        $("#alertUserMsg").removeClass().addClass("alert alert-danger");
        document.getElementById("alertUserMsg").innerHTML = "Passwords do not match.";

        $("#preloader").hide();        

        return; 
    }

    $.ajax({
        url: '/methods/userregistration', 
        method: 'post',
        data: {
            fullName: fullName,
            email: email,
            phone_number: phone_number,
            country: country,
            password: password
        },
        dataType: "JSON",
        success: function(response) { 
            if (response.status == "success") {
                $("#fullName").val("");
                $("#email").val("");
                $("#password").val("");
                $("#confirm_password").val("");

                //Redirect the user back to Login page
                window.location.href="/login";

            } else {
                $("#alertUserMsg").show();          
                $("#alertUserMsg").removeClass().addClass("alert alert-danger");
                document.getElementById("alertUserMsg").innerHTML = response.message;
            }    
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $("#alertUserMsg").show();          
            $("#alertUserMsg").removeClass().addClass("alert alert-danger");
            document.getElementById("alertUserMsg").innerHTML = thrownError;
        },
        complete: function() {
            // Hide the preloader when AJAX call is complete
            $("#preloader").hide();
        }
    });
}
