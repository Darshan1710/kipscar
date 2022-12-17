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
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>

    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

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

  <script src="<?php echo base_url ()?>js/plugins/ui/moment/moment.min.js"></script>

    <script src="<?php echo base_url() ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
    <link href="<?php echo base_url()  ?>css/daterangepicker.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>js/moment.min.js"></script>
    <script src="<?php echo base_url() ?>js/daterangepicker.js"></script>
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
                            <li><a href="#.html">Customer</a></li>
                            <li class="active">Customer List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <a class="btn btn-sm btn-success" href="<?php echo base_url() ?>Customer/customerForm"><i class="icon-home4"></i> Add Customer</a>
                            <a class="btn btn-sm btn-success" href="#" data-target="#sms_modal" data-toggle="modal"><i class="icon-home4"></i> Send SMS</a><!-- 
                            <a class="btn btn-sm btn-success" href="#" data-target="#email_modal" data-toggle="modal"><i class="icon-home4"></i> Send Email</a> -->
                        </div>
                        

                        <table class="table" id="customer_list">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                    <th>Sr. No.</th>    
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                           
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


<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Customer form</h5>
            </div>

            <form action="#" method="post" id="update">
                <input type="hidden" name="unique_id" id="unique_id" class="unique_id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Mobile</label>
                                <input type="number" minlength="10"  maxlength="10" class="form-control mobile" name="mobile" value="" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            </div>
                            <div class="col-sm-4">
                                <label>Name</label>
                                <input type="text" placeholder="Name" class="form-control name" name="name">
                            </div>
                            <div class="col-sm-4">
                                <label>Email</label>
                                <input type="text" placeholder="Email" class="form-control email" name="email">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Password</label>
                                <input type="password"  class="form-control password" name="password" >
                            </div>
                            <div class="col-sm-4">
                                <label>Confirm Password</label>
                                <input type="password" placeholder="Confirm Password" class="form-control confirm_password" name="confirm_password" >
                            </div>
                            <div class="col-sm-4">
                                <label>Status</label>
                                <select class="form-control status" name="status">
                                    <option value="2">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="sms_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">SMS form</h5>
            </div>
            <form action="#" method="post" id="messageForm">
            <div class="modal-body">
               <fieldset class="mb-3">
                  <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                  <div class="form-group row">
                     <label class="col-form-label col-lg-2">Message</label>
                     <div class="col-lg-10">
                        <textarea class="form-control" name="message" id="message"><?php echo set_value('message')?></textarea>
                     </div>
                  </div>
               </fieldset>
            </div>
            <div class="modal-footer">
               <button class="btn bg-primary">Send Message</button>    
            </div>
         </form>
            
        </div>
    </div>
</div>

<div id="email_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Email form</h5>
            </div>
            <form action="#" method="post" id="emailForm">
            <div class="modal-body">
               <fieldset class="mb-3">
                  <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                  <div class="form-group row">
                     <label class="col-form-label col-lg-2">Subject</label>
                     <div class="col-lg-10">
                        <input type="text" class="form-control" name="subject" id="subject">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-form-label col-lg-2">Message</label>
                     <div class="col-lg-10">
                        <textarea class="form-control" name="message" id="message"></textarea>
                     </div>
                  </div>
               </fieldset>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn bg-primary" id="send_message">Send Message</button>    
            </div>
         </form>
            
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

         $('#customer_list thead th').each(function() {
            var i = 0;
            var title = $(this).text();
            if (title == 'Sr. No.' || title == 'Action' ) {

            }else if(title == 'Status'){
                $(this).html(title+'<select class="col-search-input">'+
                                '<option value="">All</option>'+
                                '<option value="1">Active</option>'+
                                '<option value="2">Inactive</option>'+

                                '</select>');
            }else if(title == 'Created At'){
                $(this).html(title + '<input type="text" class="col-search-input" id="created_at_picker">');
            } else {
                $(this).html(title + '<input type="text" class="col-search-input" />');
            }
        });

        var table = $('#customer_list').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "scrollY": '50vh',
            "scrollX": true,
            "select": {
                 'style': 'multi'
            },
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('Customer/getCustomerListDetails/'); ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 20, 50, 100, 200, 500,1000],
             "dom" : 'Blfrtip',
                         "buttons": [
                               {
                                   "extend": 'excelHtml5',
                                   "title" : 'Customer',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'csv',
                                   "title" : 'Customer',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'pdfHtml5',
                                   "title" : 'Customer',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                 "extend"  : 'print',
                                 "title"   : 'Customer',
                                 "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                "extend" : 'colvis'
                               }
                         ],
             "columnDefs": [{
                "targets": 0,
                'searchable': false,
                'orderable': false,
                'checkboxes': {
                   'selectRow': true
                }
            },
            {
                "name": "sr_no",
                "targets": 1
            },
            {
                "name": "name",
                "targets": 2
            },
            {
                "name": "mobile",
                "targets": 3
            },
            {
                "name": "email",
                "targets": 4
            },
            {
                "name": "c.status",
                "targets": 5,
                "orderable": false
            },
            {
                "name": "c.created_at",
                "targets": 6,
                "orderable": false
            }

        ]
        });

        table.columns().search('');

        //draw table
        table.columns().every(function() {
            var table = this;

            $('input', this.header()).on('keyup change', function() {

                    if (table.search() !== this.value) {
                        table.search('')
                        table.columns().search('')
                        table.search(this.value).draw();  
                    }
                
                
            });

            $('select', this.header()).on('change', function() {
                   if (table.search() !== this.value) {
                       table.search('')
                       table.columns().search('')
                       table.search(this.value).draw();
                   }
               });
        });

        $('.auto_generate').on('click',function(){
               var length           = 10;
               var result           = '';
               var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
               var charactersLength = characters.length;
               for ( var i = 0; i < length; i++ ) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
               }
               $('.password').val(result);
               $('.confirm_password').val(result);
        })
        

        $(document).on('click', '.editCustomer', function() {
            var base_url = $('#base_url').val();
            var unique_id = $(this).attr('id');
            $.ajax({
                type: 'post',
                data: {
                    unique_id: unique_id
                },
                url: base_url + 'Customer/editCustomer',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        $('.unique_id').val(unique_id);
                        $('.name').val(obj.data.name);
                        $('.email').val(obj.data.email);
                        $('.mobile').val(obj.data.mobile);
                         $('.password').val(obj.data.password);
                        $('.confirm_password').val(obj.data.password);
                    } else if (obj.errCode == 2) {
                        alert(obj.data);
                    } else if (obj.errCode == 3) {
                        alert('Inputs are not valid');
                    }

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
                url: base_url + 'Customer/updateCustomer',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        location.reload();
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {

                            var element = $('.' + key);
                            if(key == 'status'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                        });
                    }

                }

            });

        });

         //get selected numbers
            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                var base_url = $('#base_url').val();
                var selectedIds = table.columns().checkboxes.selected()[0];
                var ids = selectedIds.toString();
                var msg = $('#message').val();

                if(parseInt(ids.length) <= 0){
                    alert('Please Select Atleast one record');
                }else{
                    $.ajax({
                        type: 'post',
                        data: {
                            ids: ids,
                            msg: msg
                        },
                        url: base_url + 'Admin/sendMessage',
                        success: function(data) {
                            alert('success');
                            $('#sms_model').modal('hide');
                            $("input[type=checkbox]").prop("checked", false);
                            table.state.clear();
                           // window.location.reload();
                        }

                    });
                }

            });


            // //get selected numbers
            // $('#emailForm').on('submit', function(e) {
            //     e.preventDefault();
            //     var base_url = $('#base_url').val();
            //     var selectedIds = table.columns().checkboxes.selected()[0];
            //     var ids = selectedIds.toString();
            //     var msg = $('#message').val();

            //     if(parseInt(ids.length) <= 0){
            //         alert('Please Select Atleast one record');
            //     }else{
            //         $.ajax({
            //             type: 'post',
            //             data: {
            //                 subject: subject,
            //                 msg: body
            //             },
            //             url: base_url + 'Admin/sendBulkEmail',
            //             success: function(data) {
            //                 alert('success');
            //                 $('#sms_model').modal('hide');
            //                 $("input[type=checkbox]").prop("checked", false);
            //                 table.state.clear();
            //                // window.location.reload();
            //             }

            //         });
            //     }

            // });

        $('#created_at_picker').daterangepicker({
          autoUpdateInput: false,
          locale: {
              cancelLabel: 'Clear'
          },
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')]
            }
      });

      $('#created_at_picker').on('apply.daterangepicker', function(ev, picker) {
          $('#created_at_picker').daterangepicker({
              startDate : picker.startDate.format('MM/DD/YYYY'),
              endDate : picker.endDate.format('MM/DD/YYYY'),
              locale: {
                  cancelLabel: 'Clear'
                },
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')]
                }
          });
      });

      $('#created_at_picker').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });


    });
</script>