            <!-- Main Sidebar -->
            <div id="sidebar">
                <!-- Wrapper for scrolling functionality -->
                <div class="sidebar-scroll">
                    <!-- Sidebar Content -->
                    <div class="sidebar-content">
                        <!-- Brand -->
                        <a href="<?php echo base_url('admin/home') ?>" class="sidebar-brand">
                            <i class="gi gi-flash"></i><strong><?php echo $this->lang->line('type_tracking') ?></strong>
                        </a>
                        <!-- END Brand -->

                        <!-- User Info -->
                        <div class="sidebar-section sidebar-user clearfix">
                            <div class="sidebar-user-avatar">
                                <a href="<?php echo base_url('client/user') ?>">
                                    <?php $avatar = session_logged_in()['avatar'] ?>
                                    <img src='<?php echo (!is_null($avatar)) ? $avatar : base_url(LINK_TO_GET_USERS_IMAGE. DEFAULT_IMAGE) ?>' alt="avatar">
                                </a>
                            </div>
                            <div class="sidebar-user-name"><?php echo session_logged_in()['full_name'] ?></div>
                            <div class="sidebar-user-links">
                                <a href="<?php echo base_url('client/user') ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang->line('profile') ?>"><i class="gi gi-user"></i></a>
                                <a href="<?php echo base_url('admin/orders') ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang->line('inbox') ?>"><i class="gi gi-envelope"></i></a>
                                <a href="<?php echo base_url('logout') ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang->line('log_out') ?>"><i class="gi gi-exit"></i></a>
                            </div>
                        </div>
                        <!-- END User Info -->

                        <!-- Sidebar Navigation -->
                        <ul class="sidebar-nav">
                            <li>
                                <a href="<?php echo base_url('admin/home') ?>"><i class="gi gi-stopwatch sidebar-nav-icon"></i><?php echo $this->lang->line('dashboard') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('client/store') ?>"><i class="fa fa-home sidebar-nav-icon"></i><?php echo $this->lang->line('store') ?></a>
                            </li>
                            <li class="sidebar-header">
                                <span class="sidebar-header-title"><?php echo $this->lang->line('manage_orders') ?></span>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/orders') ?>" class="sidebar-nav-icon"></i><i class="fa fa-envelope sidebar-nav-icon"></i><?php echo $this->lang->line('orders') ?></a>
                            </li>
                            <li class="sidebar-header">
                                <span class="sidebar-header-title"><?php echo $this->lang->line('manage_types') ?></span>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/categories') ?>" class="sidebar-nav-icon"></i><i class="fa fa-book sidebar-nav-icon"></i><?php echo $this->lang->line('categories') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/types') ?>" class="sidebar-nav-icon"></i><i class="fa fa-glass sidebar-nav-icon"></i><?php echo $this->lang->line('types') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/subtypes') ?>" class="sidebar-nav-icon"></i><i class="fa fa-glass sidebar-nav-icon"></i><?php echo $this->lang->line('subtypes') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/batches') ?>" class="sidebar-nav-icon"></i><i class="fa fa-archive sidebar-nav-icon"></i><?php echo $this->lang->line('batches') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/products') ?>" class="sidebar-nav-icon"></i><i class="fa fa-money sidebar-nav-icon"></i><?php echo $this->lang->line('products') ?></a>
                            </li>
                            <li class="sidebar-header">
                                <span class="sidebar-header-title"><?php echo $this->lang->line('manage_store') ?></span>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/customize') ?>"><i class="fa fa-television sidebar-nav-icon"></i><?php echo $this->lang->line('customize') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/pages') ?>" class="sidebar-nav-icon"></i><i class="fa fa-file-o sidebar-nav-icon"></i><?php echo $this->lang->line('pages') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/posts') ?>" class="sidebar-nav-icon"></i><i class="fa fa-file-o sidebar-nav-icon"></i><?php echo $this->lang->line('posts') ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/sale') ?>" class="sidebar-nav-icon"></i><i class="fa fa-product-hunt sidebar-nav-icon"></i><?php echo $this->lang->line('products_to_sale') ?></a>
                            </li>
                            <li class="sidebar-header">
                                <span class="sidebar-header-title"><?php echo $this->lang->line('manage_users') ?></span>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/users') ?>" class="sidebar-nav-icon"></i><i class="fa fa-users sidebar-nav-icon"></i><?php echo $this->lang->line('users') ?></a>
                            </li>
                            <li class="sidebar-header">
                                <span class="sidebar-header-title"><?php echo $this->lang->line('trash') ?></span>
                            </li>
                            <li>
                                <a href="<?php echo base_url('admin/trash') ?>" class="sidebar-nav-icon"></i><i class="fa fa-trash sidebar-nav-icon"></i><?php echo $this->lang->line('trash') ?></a>
                            </li>
                        </ul>
                        <!-- END Sidebar Navigation -->
                    </div>
                    <!-- END Sidebar Content -->
                </div>
                <!-- END Wrapper for scrolling functionality -->
            </div>
            <!-- END Main Sidebar -->