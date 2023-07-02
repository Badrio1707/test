<?php include_once '../App/Views/Partials/header.php';?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card o-hidden border-0 my-5 bg-darker">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-600 mb-4">Welcome</h1>
                                </div>
                                <form class="user" id="login-form" method="POST" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user custom-input"
                                            id="username" placeholder="Username">
                                            <span class="ml-2 invalid-feedback" id="username-feedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user custom-input"
                                            id="password" placeholder="Password">
                                            <span class="ml-2 invalid-feedback" id="password-feedback"></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger btn-user btn-block">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </button>                                   
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small text-danger" href="https://t.me/rreliable" target="_blank">Contact me on Telegram</a>
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