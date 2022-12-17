<div class="sidebar sidebar-main">
                <div class="sidebar-content">

                    <!-- User menu -->
                    <div class="sidebar-user">
                        <div class="category-content">
                            <div class="media">
                                <a href="#" class="media-left"><img src="<?php echo base_url() ?>images/placeholders/placeholder.jpg" class="img-circle img-sm" alt=""></a>
                                <div class="media-body">
                                    <span class="media-heading text-semibold"><?php echo ucwords($this->session->userdata('username')) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /user menu -->


                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">

                                <!-- Main -->
                                <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
                                <li class="active"><a href="<?php echo base_url() ?>Admin/dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>Catalog</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url()?>Product/productList" class="nav-link">Products</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Category/categoryList" class="nav-link">Category</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Brand/brandList" class="nav-link">Brand</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Condition/conditionList" class="nav-link">Condition</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Product/getSuggestionList" class="nav-link">Suggested Product</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>Order</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url()?>Order/orderList" class="nav-link">Order List</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>Salesorder/orderList" class="nav-link">Sales Person Order List</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item nav-item-submenu nav-item-open">
                                    <a href="#" class="nav-link "><i class="icon-price-tag3"></i> <span>User</span></a>
                                    <ul class="nav nav-group-sub" data-submenu-title="Form components">
                                        <li class="nav-item"><a href="<?php echo base_url()?>Customer/customerList" class="nav-link">Customer</a></li>
                                        <li class="nav-item"><a href="<?php echo base_url()?>User/userList" class="nav-link">User</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><i class="icon-wrench3"></i> <span>Store</span></a>
                                    <ul>

                                         <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Banner/bannerList" class="nav-link "><i class="icon-price-tag3"></i> <span>Banner</span></a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Notification/notificationList" class="nav-link "><i class="icon-price-tag3"></i> <span>Notification</span></a>
                                        </li>
                                        <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>News/newsList" class="nav-link "><i class="icon-price-tag3"></i> <span>News</span></a>
                                        </li>
                                        <!-- <li class="nav-item nav-item-submenu nav-item-open">
                                            <a href="<?php echo base_url()?>Blog/blogList" class="nav-link "><i class="icon-price-tag3"></i> <span>Blog</span></a>
                                        </li> -->
                                    </ul>
                                </li>

                                <!-- /main -->
                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>