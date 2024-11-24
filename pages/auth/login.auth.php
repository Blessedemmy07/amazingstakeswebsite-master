<?php 
include_once __DIR__ . "/../../components/shared/preloader.shared.php";
include __DIR__. "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
?>
<!-- Content -->
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8 col-sm-10">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h2 class="text-center font-weight-light my-4">Login To Your Account</h2>
                            </div>
                            <div class="card-body">
                                <div class="row container-fluid">
                                    <div  role="alert" id="alertUserMsg" style="text-align:center; display: none">
                                        <p id="alertMessage2"></p>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="email" 
                                            id="email_address"
                                            name="email"
                                            placeholder="Enter your email" />
                                    <label for="inputEmail">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="password" 
                                            id="password"
                                            name="password"
                                            placeholder="Password" />
                                    <label for="inputPassword">Password</label>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-block" id="loginBtn" 
                                                style="background-color:#ffc210;color:black;font-weight:bold">LOGIN</button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a href="/register" style="color: #337ab7; text-decoration: none;">Register</a>
                                    <a class="small" href="#" style="color: #337ab7; text-decoration: none;">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="py-2"></div>
                        </div>
                        <div class="py-4"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<!-- / Content -->
<?php 
include __DIR__. "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>
