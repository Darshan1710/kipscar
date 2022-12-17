<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo TITLE; ?></title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/icons/icomoon/styles.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/minified/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/minified/core.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/minified/components.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/minified/colors.min.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/custom.css">

        <!-- Core JS files -->
        
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/loaders/pace.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/loaders/blockui.min.js'); ?>"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/visualization/d3/d3.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/visualization/d3/d3_tooltip.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/forms/styling/uniform.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/ui/moment/moment.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/ckeditor/ckeditor.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/editor_ckeditor.js'); ?>"></script>


        <script type="text/javascript" src="<?php echo base_url('assets/js/core/app.js'); ?>"></script>

        <script>
                
            $(document).ready(function(){
                $('.change_image').on('click',function(){
                        $('.change_image').css('display','none'); 
                        $('.previous_image').css('display','none'); 
                        $('.edit_image').css('display','block');
                });
            });
        </script>


    </head>

    <body>

        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><img src="<?php echo base_url('assets/images/logo_light.png') ?>" alt=""></a>

                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>


                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url('assets/images/placeholder.jpg'); ?>" alt="">
                            <span><?php echo ucwords($this->session->userdata('username')); ?></span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">

                            <li><a href="<?php echo base_url()?>Admin/logout"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->


        <!-- Page container -->
        <div class="page-container">

            <!-- Page content -->
            <div class="page-content">

                <?php $this->load->view('common/sidebar'); ?>


                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Page header -->
                    <div class="page-header">

                        <div class="breadcrumb-line">
                            <ul class="breadcrumb">
                                <li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
                                <li class="active">Edit Blog</li>
                            </ul>
                        </div>
                    </div>
                    <!-- /page header -->


                    <!-- Content area -->
                    <div class="content">

                        <!-- 2 columns form -->
                            <form method="post" id="event_form" enctype="multipart/form-data" action="<?php echo base_url('blog/updateBlog'); ?>">
                                <div class="panel panel-flat">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">Blog</h5>
                                    </div>

                                    <div class="panel-body">
                                        <div class="row">
                                            <input type="hidden" name="blog_id" value="<?php echo $id = isset($blog['id']) && !empty($blog['id']) ? $blog['id'] : set_value('id') ?>">

                                            <div class="form-group col-sm-12">
                                                <label class="col-sm-3 req">Title</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="title" value="<?php echo $title = set_value('title') == false ? $blog['title'] : set_value('title'); ?>">
                                                    <?php echo form_error('title'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-12">
                                                <label class="col-sm-3 req">Image</label>
                                                <div class="col-sm-8">
                                                        <img src="<?php echo $img = isset($blog['image']) && !empty($blog['image']) ? base_url().$blog['image'] : base_url().set_value('previous_image') ?>" width="50px" height="50px" class="previous_image">
                                                        <input class="form-control edit_image" type="file" name="image" style="display: none;">
                                                        <input type="hidden" name="previous_image" value="<?php echo $image = isset($blog['image']) && !empty($blog['image']) ? $blog['image'] : set_value('previous_image');?>">
                                                        <button type="button" class="btn btn-primary change_image">Change Image</button>
                                                        <?php echo form_error('image'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label class="col-sm-3 req">Content</label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" id="editor-full" name="content"><?php echo $content = set_value('content') == false ? $blog['content'] : set_value('content'); ?></textarea>
                                                    <?php echo form_error('content') ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-12">
                                                <label class="col-sm-3 req">Status</label>
                                                <div class="col-sm-12">
                                                    <input type="radio" name="status" value="1" <?php echo $checked = isset($blog['status']) && !empty($blog['status']) ? ($blog['status'] == '1' ? 'checked' : '') : (set_value(
                                                        'status') == '1' ? 'checked' : '') ?>>&nbsp;&nbsp;Active
                                                    <input type="radio"  name="status" value="0" <?php  echo $checked = isset($blog['status']) && !empty($blog['status']) ? ($blog['status'] == '0' ? 'checked' : '') : (set_value(
                                                        'status') == '0' ? 'checked' : '') ?>>&nbsp;&nbsp;Inactive
                                                </div>
                                            </div>
                                            


                                        </div>



                                        <div class="col-sm-offset-3 col-sm-8">
                                            <button type="submit" id="submit_button" class="col-sm-3 btn btn-primary pull-right">Submit form <i class="icon-arrow-right14 position-right"></i></button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- /2 columns form -->

                        <?php $this->load->view('common/footer'); ?>

                    </div>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

    </body>
    
</html>


