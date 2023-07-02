<?php include_once '../App/Views/Partials/header.php';?>

<div id="wrapper">
    <?php include_once '../App/Views/Partials/sidebar.php';?>
    <div id="content-wrapper" class="d-flex flex-column bg-darkest">
        <div id="content">
            <?php include_once '../App/Views/Partials/navbar.php';?>
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-600">Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger custom-border bg-darker h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                           Username</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($_SESSION['username']);?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary custom-border bg-darker h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Requests</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($request);?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-edit fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success custom-border bg-darker h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Logs</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($log);?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-bell fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning custom-border bg-darker h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo htmlspecialchars($count);?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jumbotron bg-darker border-left-danger">
                    <h1 class="display-4">Welcome, <span class="text-danger font-italic"><?php echo htmlspecialchars($_SESSION['username']);?></span></h1>
                    <p class="lead">If you need any help you can click one of the buttons below to get in touch with an administrator.</p>
                    <hr class="my-4">
                    <p>Contact us on Telegram.</p>
                    <p class="lead">
                        <a class="btn btn-outline-danger btn-md btn-rounded" href="https://t.me/rreliable" role="button"><i class="fab fa-telegram-plane"></i> Reliable</a>
                        <a class="btn btn-outline-primary btn-md btn-rounded" href="https://t.me/Lahsj" role="button"><i class="fab fa-telegram-plane"></i> Lahsj</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
     
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include_once '../App/Views/Partials/footer.php';?>