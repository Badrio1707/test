        <?php if (isset($_SESSION['username'])) { ?>
        <div class="modal" tabindex="-1" role="dialog" id="passwordModal">
            <form class="user" method="POST" autocomplete="off" id="password-form">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-darker">
                        <div class="modal-header custom-border-bottom">
                            <h5 class="modal-title">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" id="password-close" onclick="password_close()" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user custom-input"
                                    id="password" placeholder="Current password">
                                    <span class="ml-2 invalid-feedback" id="password-feedback"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user custom-input"
                                    id="new-password" placeholder="New password">
                                    <span class="ml-2 invalid-feedback" id="new-password-feedback"></span>
                            </div>
                            <div class="form-group mb-0">
                                <input type="password" class="form-control form-control-user custom-input"
                                    id="confirm-new-password" placeholder="Confirm password">
                                    <span class="ml-2 invalid-feedback" id="confirm-new-password-feedback"></span>
                            </div>
                        </div>
                        <div class="modal-footer custom-border-top">
                            <button type="submit" class="btn btn-danger btn-user"><i class="fas fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="redirectModal">
            <form class="user" method="POST" autocomplete="off" id="redirect-form">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-darker">
                        <div class="modal-header custom-border-bottom">
                            <h5 class="modal-title text-gray-600">Change Redirect</h5>
                            <button type="button" class="close" data-dismiss="modal" id="redirect-close" onclick="redirect_close()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control form-control-user custom-input"
                                    id="redirect" placeholder="New redirect">
                                    <span class="ml-2 invalid-feedback" id="redirect-feedback"></span>
                            </div>
                        </div>
                        <div class="modal-footer custom-border-top">
                            <button type="submit" class="btn btn-danger btn-sm btn-user"><i class="fas fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
        <script src="/vendor/jquery/jquery.min.js"></script>
        <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="/js/sb-admin-2.min.js"></script>
        <?php if ($title == 'Login') { ?><script src="/js/login.js"></script><?php } ?>
        <?php if ($title == 'Requests') { ?><script src="/js/requests.js"></script><?php } ?>
        <?php if ($title == 'Logs') { ?><script src="/js/logs.js"></script><?php } ?>
        <?php if ($title == 'Overview') { ?><script src="/js/overview.js"></script><?php } ?>
        <?php if (isset($_SESSION['username'])) { ?><script src="/js/main.js"></script><?php } ?>
    </body>
</html>