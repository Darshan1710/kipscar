<div class="sidebar sidebar-main">
                <div class="sidebar-content">

                    <!-- User menu -->
                    <div class="sidebar-user">
                        <div class="category-content">
                            <div class="media">
                                <a href="#" class="media-left"><img src="<?php echo base_url() ?>images/placeholders/placeholder.jpg" class="img-circle img-sm" alt=""></a>
                                <div class="media-body">
                                    <span class="media-heading text-semibold"><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name')?></span>
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
                                <li class="active"><a href="index.html"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                
                                <li>
                                    <a href="<?php echo base_url()?>Admin/enquiryList"><i class="icon-stack2"></i>Enquiry</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Admin/orderList"><i class="icon-stack2"></i>Order</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Admin/productList"><i class="icon-stack2"></i>Products</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Admin/categoryList"><i class="icon-stack2"></i> <span>Category</span></a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Customer/customerList"><i class="icon-stack2"></i>Customer</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Customer/supplierList"><i class="icon-stack2"></i>Supplier</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Purchase/purchaseList"><i class="icon-stack2"></i>Purchase</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>Purchase/stockList"><i class="icon-stack2"></i>Stock</a>
                                </li>
                                <!-- /main -->
                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>