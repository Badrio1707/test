<?php include_once '../App/Views/Partials/header.php';?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
                                </div>
                                <form class="user" id="register-form" method="POST" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                            id="username" placeholder="Enter an username">
                                            <span class="ml-2 invalid-feedback" id="username-feedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" placeholder="Enter a password">
                                            <span class="ml-2 invalid-feedback" id="password-feedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="confirm-password" placeholder="Confirm your password">
                                            <span class="ml-2 invalid-feedback" id="confirm-password-feedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                            id="license" placeholder="Enter a license key" maxlength="16">
                                        <span class="ml-2 invalid-feedback" id="license-feedback"></span>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-user btn-block">
                                        <i class="fas fa-user-plus"></i> Register
                                    </button>                                   
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="#">Don't have a license key? Get one here!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/login">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../App/Views/Partials/footer.php';?>