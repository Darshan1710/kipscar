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
                                <li class="active">Add Blog</li>
                            </ul>
                        </div>
                    </div>
                    <!-- /page header -->


                    <!-- Content area -->
                    <div class="content">

                        <!-- 2 columns form -->
                        <form method="post" id="event_form" enctype="multipart/form-data" action="<?php echo base_url('blog/addBlog'); ?>">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Blog</h5>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-3 req">Title</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text" name="title" value="<?php echo set_value('title') ?>">
                                                <?php echo form_error('title'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-3 req">Image</label>
                                            <div class="col-sm-8">
                                                    <input class="form-control" type="file" name="image">
                                                    <?php echo form_error('image'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-3 req">Content</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="content" id="editor-full"><?php echo set_value('content'); ?></textarea>
                                                <?php echo form_error('content') ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label class="col-sm-3 req">Status</label>
                                            <div class="col-sm-12">
                                                <input type="radio"  name="status" value="1">&nbsp;&nbsp;Active
                                                <input type="radio"  name="status" value="0">&nbsp;&nbsp;Inactive
                                            </div>
                                        </div>
                                            


                                    </div>



                                    <div class="col-sm-offset-3 col-sm-8">
                                        <button type="submit" id="submit_button" class="col-sm-3 btn btn-primary pull-right">Submit form <i class="icon-arrow-right14 position-right"></i></button>

                                    </div>
                                </div>
                            </div>
                        </form>

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

<script>
    
CKEDITOR.replace('content');
    
    
    $(document).ready(function(){
    $('#edit_image').on('click',function(){
    $('#edit_image').css('display','none'); 
    $('#edit_image_icon').css('display','none'); 
    $('#edit_image_file').trigger('click');
    $('#edit_image_file').css('display','');
});
});
</script>

