<!DOCTYPE html>
<html lang="en">
   <!-- Mirrored from demo.interface.club/limitless/demo/bs4/Template/layout_1/LTR/default/full/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 17 May 2019 06:40:16 GMT -->
   <!-- Added by HTTrack -->
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <!-- /Added by HTTrack -->
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title><?php echo TITLE; ?></title>
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/layout.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
      <!-- /global stylesheets -->
      <!-- Core JS files -->
      <script src="<?php echo base_url() ?>js/main/jquery.min.js"></script>
      <script src="<?php echo base_url() ?>js/main/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
      <!-- /core JS files -->
      <!-- Theme JS files -->
      <link href="<?php echo base_url()?>css/daterangepicker.css" rel="stylesheet">
      <script src="<?php echo base_url()?>js/moment.min.js"></script>
      <script src="<?php echo base_url()?>js/daterangepicker.js"></script>
      <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
      <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.full.min.js"></script>
      <script src="<?php echo base_url() ?>js/plugins/extensions/jquery_ui/interactions.min.js"></script>

      <script src="<?php echo base_url() ?>js/app.js"></script>
      <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>
      <link href="<?php echo base_url()?>css/dataTables.checkboxes.css" rel="stylesheet">
      <script src="<?php echo base_url()?>js/dataTables.checkboxes.min.js"></script>

      <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

      <!-- /theme JS files -->
   </head>
   <body>
      <!-- Main navbar -->
      <?php $this->load->view('common/navbar'); ?>
      <!-- /main navbar -->
      <!-- Page content -->
      <div class="page-content">
         <!-- Main sidebar -->
         <?php $this->load->view('common/sidebar'); ?>
         <!-- /main sidebar -->
         <!-- Main content -->
         <div class="content-wrapper">
            <!-- Page header -->
            <div class="page-header page-header-light">
               <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                  <div class="d-flex">
                     <div class="breadcrumb">
                        <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <span class="breadcrumb-item active">Dashboard</span>
                     </div>
                     <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                  </div>
               </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
               <!-- Main charts -->
               <div class="row">
                  <!-- Page content -->
                  <!-- Page content -->
                  <div class="page-content">
                     <!-- Main content -->
                     <div class="content-wrapper">
                        <!-- Content area -->
                        <div class="content">
                           <!-- Hover rows -->
                           <div class="card">
                              <div class="card-header">
                                 <div class="row">
                                    
                                      <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#add_modal" style="margin-right: 1%;"><i class="icon-user" aria-hidden="true"></i> Add Submenu</a>

                                    
                                 </div>
                                 
                              </div>
                              <table class="table datatable-basic table-hover text-center" id="submenuList">
                                 <thead>
                                    <tr>
                                       <th>Sr. No.</th>
                                       <th>Menu</th>
                                       <th>Sub Menu</th>
                                        <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                      <?php if(isset($submenu)){
                                            $i = 1;
                                            foreach($submenu as $row){
                                      ?>
                                          <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['menu'];?></td>
                                            <td><?php echo $row['submenu'];?></td>
                                            <td><div class="list-icons">
                                             <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                   <a href="#" data-toggle="modal" data-target="#edit_modal" class="dropdown-item editSubmenu" id="<?php echo $row['id']?>"><i class="icon-file-pencil"></i>Edit</a>
                                                </div>
                                             </div>
                                          </div></td>
                                          </tr>
                                      <?php 
                                      $i++;
                                      } } ?>
                                 </tbody>
                              </table>
                           </div>
                           <!-- /hover rows -->
                        </div>
                        <!-- /content area -->
                     </div>
                     <!-- /main content -->
                  </div>
              </div>
          </div>
        </div>
      </div>



<div id="add_modal" class="modal fade" tabindex="-1">
    <div class="modal-sm modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Add Submenu</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" id="add">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                              <div class="col-sm-12">

                                <div class="form-group">
                                    <label>Menu</label>
                                   
                                    <select class="form-control" name="menu" id="menu">
                                      <option>Please Select Menu</option>
                                      <?php if(isset($menu)){
                                            foreach($menu as $m){
                                        ?>
                                          <option value="<?php echo $m['id'] ?>"><?php echo $m['menu']; ?></option>
                                      <?php } } ?>
                                    </select>
                                </div>
                              </div>

                              <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Submenu</label>
                                    <input class="form-control" type="text" name="submenu" id="submenu" placeholder="Enter submenu">
                                </div>
                              </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary">Submit</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Update Menu</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" id="update">
              <input type="hidden" name="id" class="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                              <div class="col-sm-12">
                                <label>Menu</label>
                                <select class="form-control menu" name="menu" >
                                    <option>Please Select Menu</option>
                                    <?php if(isset($menu)){
                                          foreach($menu as $m){
                                      ?>
                                        <option value="<?php echo $m['id'] ?>"><?php echo $m['menu']; ?></option>
                                    <?php } } ?>
                                  </select>
                              </div>

                              <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Submenu</label>
                                    <input class="form-control submenu" type="text" name="submenu"  placeholder="Enter submenu">
                                </div>
                              </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary">Submit</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>



      <!-- Footer -->
      <?php $this->load->view('common/footer'); ?>
      <!-- /footer -->

      </body>

      </html>

<input type="hidden" name="base_url" value="<?php echo base_url()?>" id="base_url">
<!-- /Edit modal -->
<script type="text/javascript">
   $(document).ready(function() {



var table = $('#submenuList').DataTable({
});


//add user
$('#add').submit(function(e) {
    e.preventDefault();
    var form_data = new FormData($(this)[0]);
    var base_url = $('#base_url').val();
    $.ajax({
        type: 'post',
        data: form_data,
        processData: false,
        contentType: false,
        url: base_url + 'User/addSubmenu',
        success: function(data) {
            var obj = $.parseJSON(data);
            if (obj.errCode == -1) {
                alert(obj.message);
                location.reload();

            } else if (obj.errCode == 2) {
                alert(obj.message);
            } else if (obj.errCode == 3) {
                $('.error').remove();
                $.each(obj.messages, function(key, value) {
                    var element = $('#' + key);
                    element.closest('.form-control').after(value);
                });
            }

        }

    });

});


$(document).on('click', '.editSubmenu', function() {
    var base_url = $('#base_url').val();
    var id = $(this).attr('id');
    $.ajax({
        type: 'post',
        data: {
            id: id
        },
        url: base_url + 'User/editSubmenu',
        success: function(data) {
            var obj = $.parseJSON(data);

            $('.id').val(obj.data.id);
             $('.menu').val(obj.data.menu_id);
            $('.submenu').val(obj.data.submenu);
        }

    });
});

$('#update').submit(function(e) {
e.preventDefault();
var form_data = new FormData($(this)[0]);
var base_url = $('#base_url').val();
$.ajax({
    type: 'post',
    data: form_data,
    processData: false,
    contentType: false,
    url: base_url + 'User/updateSubmenu',
    success: function(data) {
        var obj = $.parseJSON(data);
        if (obj.errCode == -1) {

            alert(obj.message);
            location.reload();

        } else if (obj.errCode == 2) {
            alert(obj.message);
        } else if (obj.errCode == 3) {
            $('.error').remove();
            $.each(obj.messages, function(key, value) {

                var element = $('.' + key);
                element.closest('.form-control').after(value);
            });
        }

    }

});

});



});
</script>