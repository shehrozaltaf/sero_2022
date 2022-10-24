<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?php echo base_url() ?>">
                    <h2 class="brand-text mb-0"><?php echo PROJECT_NAME ?></h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                       data-ticon="icon-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <!--<li class="nav-item dashboard_nav ">
                <a href="<?php /*echo base_url() */?>">
                    <i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="<?php /*echo base_url() */?>">
                    <i class="feather icon-mail"></i>
                    <span class="menu-title" data-i18n="Email">Email</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php /*echo base_url() */?>">
                    <i class="feather icon-settings"></i><span
                            class="menu-title" data-i18n="Settings">Settings</span></a>
                <ul class="menu-content">
                    <li>
                        <a href="<?php /*echo base_url() */?>index.php/Users">
                            <i  class="feather icon-user"></i>
                            <span class="menu-item" data-i18n="Users">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php /*echo base_url() */?>index.php/Users/addUser">
                            <i  class="feather icon-user-plus"></i>
                            <span class="menu-item" data-i18n="Add Users">Add Users</span>
                        </a>
                    </li>

                </ul>
            </li>-->
            <li class=" nav-item">
                <a href="javascript:void(0)" onclick="logout()">
                    <i class="feather icon-power"></i>
                    <span class="menu-title" data-i18n="Logout">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->