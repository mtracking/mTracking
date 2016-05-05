<div id="main-container">
    <header class="navbar navbar-default">
        <!-- Left Header Navigation -->
        <ul class="nav navbar-nav-custom">
            <!-- Main Sidebar Toggle Button -->
            <li>
                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                    <i class="fa fa-bars fa-fw"></i>
                </a>
            </li>
            <!-- END Main Sidebar Toggle Button -->
        </ul>
        <!-- END Left Header Navigation -->

        <!-- Right Header Navigation -->
        <ul class="nav navbar-nav-custom pull-right">
            <!-- User Dropdown -->
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <?php $avatar = session_logged_in()['avatar'] ?>
                    <img src="<?php echo (!is_null($avatar)) ? $avatar : base_url(LINK_TO_GET_USERS_IMAGE. DEFAULT_IMAGE) ?>" alt="avatar"> <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                    <li class="dropdown-header text-center"><?php echo $this->lang->line('account') ?></li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo base_url('client/user') ?>">
                            <i class="fa fa-user fa-fw pull-right"></i>
                            <?php echo $this->lang->line('profile') ?>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo base_url('logout') ?>"><i class="fa fa-ban fa-fw pull-right"></i> <?php echo $this->lang->line('log_out') ?></a>
                    </li>
                </ul>
            </li>
            <!-- END User Dropdown -->
        </ul>
        <!-- END Right Header Navigation -->
    </header>
    <!-- END Header -->

    <!-- Page content -->
<!--     <div id="page-content" style="min-height: 894px;">

    </div> -->
    <!-- END Page Content -->
