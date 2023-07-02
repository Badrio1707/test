<ul class="navbar-nav bg-darker sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
            <img src="/img/logo.png" width="35">
        </div>
        <div class="sidebar-brand-text mx-3">TR Admin</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?php echo ($title == 'Dashboard') ? 'active' : '';?>">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Pages
    </div>
    <li class="nav-item <?php echo ($title == 'Requests') ? 'active' : '';?>">
        <a class="nav-link" href="/requests">
            <i class="fas fa-edit"></i>
            <span>Requests</span>
        </a>
    </li>
    <li class="nav-item <?php echo ($title == 'Logs' || $title == 'Overview') ? 'active' : '';?>">
        <a class="nav-link" href="/logs">
            <i class="fas fa-bell"></i>
            <span>Logs</span>
        </a>
    </li>
    <li class="nav-item <?php echo ($title == 'Exchange') ? 'active' : '';?>">
        <a class="nav-link" href="/exchange">
            <i class="fas fa-exchange-alt"></i>
            <span>Paysafe to BTC</span>
        </a>
    </li>
    <li class="nav-item <?php echo ($title == 'Settings') ? 'active' : '';?>">
        <a class="nav-link" href="/settings">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Settings</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Contact us
    </div> 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContacts"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fab fa-telegram"></i>
            <span>Contact</span>
        </a>
        <div id="collapseContacts" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Contact on Telegram:</h6>
                <a class="collapse-item" href="https://t.me/rreliable" target="_blank">Reliable</a>
                <a class="collapse-item" href="https://t.me/Lahsj" target="_blank">Lahsj</a>            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>