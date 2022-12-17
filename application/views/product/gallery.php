<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE; ?></title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>

    <script src="<?php echo base_url ()?>js/plugins/pickers/anytime.min.js"></script>
    <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.js"></script>
    <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.date.js"></script>
    <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.time.js"></script>
    <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/legacy.js"></script>
    <!-- /core JS files -->

    <link href="<?php echo base_url()  ?>css/daterangepicker.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>js/moment.min.js"></script>
    <script src="<?php echo base_url() ?>js/daterangepicker.js"></script>

    <!-- Theme JS files -->
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>

    <script src="<?php echo base_url() ?>js/plugins/uploaders/dropzone.min.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/uploader_dropzone.js"></script>

    <script src="<?php echo base_url() ?>js/plugins/extensions/contextmenu.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/ui/prism.min.js"></script>

    <script src="<?php echo base_url() ?>js/demo_pages/extra_context_menu.js"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <?php $this->load->view('common/navbar'); ?>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <?php $this->load->view('common/sidebar'); ?>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">


                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo base_url() ?>Admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
                            <li><a href="#.html">Package</a></li>
                            <li class="active">Package List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        

                    <div class="panel-body">
                     
                        <form action="<?php echo base_url('ImageController/upload_photo/'.$this->uri->segment(3))?>" class="dropzone" id="dropzone_multiple">
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
                            <input type="hidden" name="album_id" id="album_id" value="<?php echo $this->uri->segment(3); ?>">
                        </form>
                        <a href="<?php echo base_url() ?>Product/productList" class="btn btn-s-sm btn-danger btn-rounded pull-right">Go Back</a>
                    </div>

                        <div class="panel-body">
                            <legend></legend>
                                <?php 

                                if(isset($images) && !empty($images)){                

                                    $counter = 1;
                                    foreach($images as $row){ ?> 
                                        <div class="col-md-3 context-menu-<?php echo $counter; ?> text-center text-bold" photo-id="<?php echo $row['id']; ?>" id="image_div">
                                            <a href="<?php echo base_url().$row['thumbnail']; ?>"  id="<?php echo $row['id']; ?>">
                                            <img class="img-rounded " src="<?php echo base_url().$row['thumbnail'];?>" alt="image not available" height="120px" width="160px" data-toggle="context" data-target=".context-data-menu_<?php echo $counter; ?>">
                                            <div class="context-data-menu_<?php echo $counter; ?>">
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" class="edit" id="<?php echo $row['id'] ?>"><i class="icon-copy4"></i> Edit</a></li>
                                                        <li><a href="#" class="deleteimage" id="<?php echo $row['id'] ?>"><i class="icon-paste3"></i> Delete</a></li>
                                                        
                                                        
                                                    </ul>
                                                </div>
                                            </a>
                                        </div>
                                <?php 
                                    $counter++; 
                                    }
                                     
                                  }?>
                        </div>

                       
                    </div>
                    <!-- /basic responsive configuration -->


                    <!-- Footer -->
                    <?php $this->load->view('common/footer'); ?>
                    <!-- /footer -->

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
<div id="edit_image_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Image</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="<?php echo base_url().'ImageController/updateImageDetails'?>" method="post" id="update_image">
        <div class="modal-body">
          <div class="row form-group">
                <input type="hidden" name="photo_id" id="photo_id">
                <div class="col-sm-12">
                    <label>Image</label>
                    <img src="" class="edit_image zoom" width="50px" height="50px">
                    <button type="button" class="btn btn-sm btn-primary button1">Change Image</button>
                    <input type="file" name="file" class="form-control image_input_1" style="display: none;">
                    <input type="hidden" name="old_image" id="old_image">
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn bg-primary update_image">Submit</button>
          
        </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  $('.button1').click(function(){
        $('.edit_image').css('display','none');
        $('.button1').css('display','none');
        $('.image_input_1').css('display','block');
    });



$(function(){
    $('#update_image').submit(function(e){
        e.preventDefault();

        var url = $('#base_url').val();
        var formData  = new FormData($('#update_image')[0]);
        var base_url = url+'ImageController/updateImageDetails';
        $.ajax({
            url: base_url,
            type: 'post',
            data: formData,
            contentType: false, 
            processData: false,
            success: function(data) {
                var obj = $.parseJSON(data);
                if(obj.errCode == -1){
                    alert(obj.message);
                    //window.location.reload();
                }else{
                    alert(obj.message);
                }
            }
        }); 
    });

    $('.edit').on('click',function(){
       
        var id  = $(this).attr('id');
        var url = $('#base_url').val();
        var base_url = url+'ImageController/getImageDetails';
        $.ajax({
            url: base_url,
            type: 'post',
            data: {id:id},
            success: function(data) {
                var obj = $.parseJSON(data);
                if(obj.errCode == -1){
                    $('#photo_id').val(obj.data.id);
                    $('.edit_image').attr('src',url+obj.data.product_images);
                    $('#old_image').val(obj.data.image);
                    $('#edit_image_modal').modal('show');
                }else{
                    alert(obj.message);
                }
            }
        }); 
    });

    $('.deleteimage').on('click',function(){
       
        var id  = $(this).attr('id');
        var url = $('#base_url').val();
        var base_url = url+'ImageController/deletePhoto';
        if(confirm('Are you sure you want to delete?')){
            $.ajax({
                url: base_url,
                type: 'post',
                data: {id:id},
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if(obj.errCode == -1){
                        window.location.reload();
                    }else{
                        alert(obj.message);
                    }
                }
            }); 
        }
    });
});
</script>
