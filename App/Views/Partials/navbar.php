<nav class="navbar navbar-expand navbar-light bg-darker topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-lg-inline d-none small"><?php echo ucwords(htmlspecialchars($_SESSION['username']));?></span>
                <i class="fas fa-user-shield"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#passwordModal">
                    <i class="fa fa-unlock-alt fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
                    Change Password
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#redirectModal">
                    <i class="fa fa-compass fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
                    Change Redirect
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
