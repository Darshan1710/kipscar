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
    <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
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
                    
<!-- 2 columns form -->


    <div class="panel panel-flat">
        

        <div class="panel-body">
         

            <a href="javascript:void(0);" class="btn btn-s-sm btn-danger btn-rounded pull-right reorder_link" id="saveReorder">Reorder Images</a>
            <div id="reorderHelper" class="light_box" style="display:none;">1. Drag photos to reorder.<br>2. Click 'Save Reordering' when finished.</div>
        </div> 

        <div class="panel-body">
            <div>
                  <h2 class="text-center" style="font-weight:bold;text-transform: capitalize;color:#3c8dbc;"><?php echo $name;?></h2><br>
                 
                  <div class="col-md-12">
                    
                    
                    <div class="gallery">
                        <div class="row">
                        <ul class="reorder_ul reorder-photos-list" >
                        <?php 
                        if(!empty($photo_data)){ 
                            foreach($photo_data as $row){ 
                        ?>
                            <li id="image_li_<?php echo $row['id']; ?>" class="ui-sortable-handle col-md-3">
                                <a href="javascript:void(0);" style="float:none;" class="image_link">
                                    <img src="<?php echo base_url($row['product_images']); ?>" width="150px" height="150px"/>
                                </a>
                            </li>
                        <?php } } ?>
                        </ul>
                        </div>
                    </div>
                  </div>
            </div>

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
                                    <input type="file" name="files" class="form-control image_input_1" style="display: none;">
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






                    <!-- /basic responsive configuration -->


                    <!-- Footer -->
         
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
<!-- <script type="text/javascript">
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
                    window.location.reload();
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
                    $('.edit_image').attr('src',obj.data.image);
                    $('#old_image').val(obj.data.image);
                    $('#edit_image_modal').modal('show');
                }else{
                    alert(obj.message);
                }
            }
        }); 
    });
});
</script> -->
<script>
$(document).ready(function(){
    $('.reorder_link').on('click',function(){
        $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
        $('.reorder_link').html('save reordering');
        $('.reorder_link').attr("id","saveReorder");
        $('#reorderHelper').slideDown('slow');
        $('.image_link').attr("href","javascript:void(0);");
        $('.image_link').css("cursor","move");
        $("#saveReorder").click(function( e ){
            if( !$("#saveReorder i").length ){
                $(this).html('').prepend('<img src="<?php echo base_url('assets/images/refresh-animated.gif'); ?>"/>');
                $("ul.reorder-photos-list").sortable('destroy');
                $("#reorderHelper").html("Reordering Photos - This could take a moment. Please don't navigate away from this page.").removeClass('light_box').addClass('notice notice_error');
    
                var h = [];
                $("ul.reorder-photos-list li").each(function() {
                    h.push($(this).attr('id').substr(9));
                });
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('ImageController/orderUpdate'); ?>",
                    data: {ids: " " + h + ""},
                    success: function(){
                        window.location.reload();
                    }
                }); 
                return false;
            }   
            e.preventDefault();     
        });
    });
});
</script>



