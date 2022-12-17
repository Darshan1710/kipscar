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
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>

    <!-- /theme JS files -->
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
                            <li><a href="#.html">Section</a></li>
                            <li class="active">Section List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <a class="btn btn-sm btn-success" href="#" data-target="#add_modal" data-toggle="modal"><i class="icon-plus2"></i> Add Section</a>
                        </div>


                        <table class="table" id="product-list">
                            <thead>
                                <tr>
                                   
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                     $i = 0;
                                     if(isset($section) && !empty($section)){
                                     foreach($section as $row){
                                     ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><?php echo $row['title']; ?></td>

                                            

                                            <td class="text-center">
                                                <ul class="icons-list">
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                            <i class="icon-menu9"></i>
                                                        </a>

                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="#" id="<?php echo $row['id'] ?>" data-toggle="modal" data-target="#edit_modal" class="editSection"><i class="icon-file-pdf"></i> Edit</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                     <?php } } ?>
                            </tbody>
                        </table>
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
<div id="add_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Section form</h5>
            </div>

            <form action="#" method="post" id="section_form">
                <div class="modal-body">
  
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Section</label>
                                <input type="text" placeholder="Section" class="form-control" id="section" name="section">
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary" id="add_coupen">Submit</button>  
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Section form</h5>
            </div>

            <form action="#" id="updateSection">
                <div class="modal-body">
                    <input type="hidden" name="id" class="id">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Section</label>
                                <input type="text" placeholder="Section" class="form-control section" name="section">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.change_image').on('click',function(){
        $('.image').css('display','none');
        $('.new_image').attr('type','file');
        $('.change_image').css('display','none');
      });
        
        //add Accressories
        var table = $('#product-list').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
             "dom" : 'Blfrtip',
                         "buttons": [
                               {
                                   "extend": 'excelHtml5',
                                   "title" : 'Order',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'csv',
                                   "title" : 'Order',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'pdfHtml5',
                                   "title" : 'Order',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                 "extend"  : 'print',
                                 "title"   : 'Order',
                                 "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                "extend" : 'colvis'
                               }
                         ]
        });

        $('#section_form').submit(function(e){
                        e.preventDefault();
                        var base_url = $('#base_url').val();
                        var formData = new FormData($(this)[0]);
                         $.ajax({
                                type:'post',
                                data:formData,
                                url: base_url+'Section/addSection',
                                processData: false,
                                contentType: false,
                                success:function(data){
                                    var obj = $.parseJSON(data);
                                   
                                    if(obj.errCode == -1){
                                        alert('Added Successfully');
                                        window.location.reload();
                                    }else if(obj.errCode == 2){
                                        alert('Error Occur');
                                    }else{
                                        
                                        $('.error').remove();
                                        $.each(obj.message,function(key,value){
                                            
                                            var element = $('#'+key);
                                            element.closest('.form-control').after(value);
                                        });
                                    }
                                }

                            });
                    });

                    $(document).on('click', '.editSection', function() {
                        var base_url = $('#base_url').val();
                        var id = $(this).attr('id');
                        $.ajax({
                            type: 'post',
                            data: {
                                id: id
                            },
                            url: base_url + 'Section/editSection',
                            success: function(data) {
                                var obj = $.parseJSON(data);
                                if (obj.errCode == -1) {
                                    $('.id').val(obj.data.id);
                                    $('.section').val(obj.data.title);
                                } else if(obj.errCode == 2){
                                    alert(obj.data);
                                }else if(obj.errCode == 3){
                                    alert('Inputs are not valid');
                                }

                            }

                        });
                        });

                        $('#updateSection').submit(function(e) {
                        e.preventDefault();
                        var form_data = new FormData($(this)[0]);
                        var base_url = $('#base_url').val();
                        $.ajax({
                            type: 'post',
                            data: form_data,
                            processData: false,
                            contentType: false,
                            url: base_url + 'Section/updateSection',
                            success: function(data) {
                                var obj = $.parseJSON(data);
                                if (obj.errCode == -1) {
                                    alert(obj.message);
                                    location.reload();
                                }else if(obj.errCode == 2){
                                    alert(obj.message);
                                } else if(obj.errCode == 3){
                                    $('.error').remove();
                                    $.each(obj.message,function(key,value){
                                        
                                        var element = $('.'+key);
                                        element.closest('.form-control').after(value);
                                    });
                                }

                            }

                        });

                        });

    });
</script>