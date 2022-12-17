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

    <link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets// -->

    <!-- Core JS files -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/editors/ckeditor5/build/ckeditor.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
     <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script> 

    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

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
                            <li><a href="#.html">Product</a></li>
                            <li class="active">Product List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <div class="row">
                            <div class="col-md-7">
                            <a class="btn btn-sm btn-success" href="#" data-target="#add_modal" data-toggle="modal"><i class="icon-plus2"></i> Add Products</a>
                             <a class="btn btn-sm btn-success" href="<?php echo base_url()?>Product/importProductsForm"><i class="icon-file-excel"></i> Import Products</a>        
                            <!--  <a class="btn btn-sm btn-success" id="stock_in"><i class="icon-home4"></i> Stock In</a>
                             <a class="btn btn-sm btn-success" id="out_of_stock"><i class="icon-home4"></i> Out Of Stock</a> -->
                             <a class="btn btn-sm btn-success" id="active"><i class="icon-home4"></i> Active </a>
                             <a class="btn btn-sm btn-success" id="inactive"><i class="icon-home4"></i> In Active </a>
                             <a class="btn btn-sm btn-danger" id="delete"><i class="icon-home4"></i> Delete </a>
                        
                             </div>
                             <div class="col-md-2">
                             <a>
                                <select class="form-control select" name="section" id="section">
                                    <option value="">Please Select Section</option>
                                    <?php 
                                    if(isset($home_sections)){
                                    foreach($home_sections as $row){?>

                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['title'] ?></option>
                                    <?php } } ?>
                                </select>
                            </a>
                            </div>
                            <div class="col-md-2">
                             <a>
                                <select class="form-control select" name="apply" id="apply">
                                    <option value="">Please Select Section</option>
                                        <option value="add">Add</option>
                                        <option value="remove">Remove</option>
                                </select>
                            </a>
                            </div>
                            <div class="col-md-1">
                             <a href="#" id="section-submit" class="btn btn-primary">Submit</a>
                            </div>
                            </div>
                        </div>


                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkbox" class="checkbox" id="select_all"></th>
                                    <th>Sr. No.</th>
                                    <th>Action</th>
                                    <th>Product Image</th>
                                    <th>Model No</th>
                                    <th>Vehicale Name</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>MRP</th>
                                    <th>New Products</th>
                                    <th>Top Selling Products</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    
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
<div id="add_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title text-center">Product form</h5>
            </div>

            <form action="#" method="post" id="add" enctype="multipart/form-data">
              
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Model No</label>
                                <input type="text" placeholder="Model No" class="form-control" name="model_no" id="model_no">
                            </div>
                            <div class="col-sm-3">
                                <label>Vehicale Name</label>
                                <input type="text" placeholder="Vehicale Name" class="form-control" name="vehicale_name" id="vehicale_name">
                            </div>
                            <div class="col-sm-3">
                                <label>Brand</label>
                                <select class="form-control select" name="brand_id" id="brand_id">
                                    <option value="">Please Select Category</option>
                                    <?php foreach($brand as $b){?>
                                    <option value="<?php echo $b['id'] ?>"><?php echo $b['brand'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Category</label>
                                <select class="form-control select" name="category_id" id="category_id">
                                    <option value="">Please Select Category</option>
                                    <?php foreach($category as $row){?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Product Image (1097 x 900)</label>
                                <input type="file" name="file" class="form-control" id="file">
                            </div>
                            <div class="col-sm-3">
                                <label>Youtube Thumbnail (1097 x 900)</label>
                                <input type="file" name="youtube_thumbnail" class="form-control" id="youtube_thumbnail">
                            </div>
                            <div class="col-sm-3">
                                <label>Youtube</label>
                                <input type="text" name="youtube" class="form-control" id="youtube">
                            </div>
                            <div class="col-sm-3">
                                <label>MRP</label>
                                <input type="number" name="mrp" class="form-control" id="mrp">
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>MRP Color</label>
                                <select class="form-control select" name="color_code" id="color_code">
                                    <option value="">Please Select</option>
                                    <option value="#000000" selected>Black</option>
                                    <option value="#FFFFFF">White</option>
                                </select>

                            </div>
                            <div class="col-sm-3">
                                <label>MRP Background Color</label>
                                <select class="form-control select" name="background_color" id="background_color">
                                    <option value="">Please Select</option>
                                    <option value="#4b81bd" selected>Blue</option>
                                    <option value="#707f82">Grey</option>
                                    <option value="#9cbc57">Green</option>
                                    <option value="#f6ed69">Yellow</option>
                                </select>

                            </div>
                            <div class="col-sm-3">
                                <label>Status</label>
                                <select class="form-control select" name="status" id="status">
                                    <option value="">Please Select</option>
                                    <option value="1" selected>Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" id="description" rows="10"></textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Vehical Application</label>
                                <textarea name="vehical_application" class="form-control" id="vehical_application" rows="10"></textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Other Information</label>
                                <textarea name="other_information" class="form-control" id="other_information" rows="10"></textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Disclaimer</label>
                                <textarea name="disclaimer" class="form-control" id="disclaimer" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Features</label>
                                <textarea name="features" class="form-control" id="features"></textarea>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        var base_url = $('#base_url').val();
        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', base_url + 'Admin/imageUpload', true );
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            resolve( {
                default: response.url
            } );
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

// ...

function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}

    ClassicEditor
            .create( document.querySelector( '#features' ), {
                
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'undo',
                        'redo',
                        'CKFinder',
                        'alignment',
                        'fontColor',
                        'fontSize',
                        'fontFamily',
                        'horizontalLine',
                        'strikethrough',
                        'subscript',
                        'superscript',
                        'underline',
                        'imageUpload'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                licenseKey: '',
                extraPlugins: [ MyCustomUploadAdapterPlugin ]
                
            } )
            .then( editor => {
                window.editor = editor;
        
            } )
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: airp6p6983ak-3lssgkec8ut' );
                console.error( error );
            } );

    

});

    $(document).ready(function() {
        $('.change_image').on('click',function(){
        $('.image').css('display','none');
        $('.new_image').attr('type','file');
        $('.change_image').css('display','none');
      });

        $("#select_all").change(function(){  //"select all" change 
            var status = this.checked; // "select all" checked status
            $('.checkbox').each(function(){ //iterate all listed checkbox items
                this.checked = status; //change ".checkbox" checked status
            });
        });
            
        $('#example thead th').each(function() {
            var i = 0;
            var title = $(this).text();
            if (title == 'Sr. No.' || title == 'Action' || title == 'Product Image') {

            }else if(title == 'Status' || title == 'New Products' || title == 'Top Selling Products'){
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

        var table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "scrollY": '50vh',
            "scrollX": true,
            "stateSave": true,
            "stateDuration":-1,
            "paging" : true,
            "select": {
                 'style': 'multi'
            },
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('Product/getProductListDetails/'); ?>",
                "type": "POST",
            },
            "lengthMenu": [10, 20, 50, 100, 200, 500,1000],
             "dom" : 'Blfrtip',
                         "buttons": [
                               {
                                   "extend": 'excelHtml5',
                                   "title" : 'Products',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'csv',
                                   "title" : 'Products',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'pdfHtml5',
                                   "title" : 'Products',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                 "extend"  : 'print',
                                 "title"   : 'Products',
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
                "orderable": false,
                'searchable': false,
                "targets": 1
            },
            {
                "name": "action",
                "orderable": false,
                'searchable': false,
                "targets": 2
            },
            {
                "name": "image",
                "orderable": false,
                'searchable': false,
                "targets": 3
            },
            {
                "name": "model_no",
                "targets": 4
            },
            {
                "name": "vehicale_name",
                "targets": 5
            },
            {
                "name": "brand",
                "targets": 6
            },
            {
                "name": "category_name",
                "targets": 7
            },
            {
                "name": "mrp",
                "targets": 8,
                "orderable": false
            },
            {
                "name": "new_products",
                "targets": 9,
                "orderable": false
            },
            {
                "name": "top_selling_products",
                "targets": 10,
                "orderable": false
            },
            {
                "name": "p.status",
                "targets":11,
                "orderable": false
            },
            {
                "name": "p.created_at",
                "targets": 12,
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

        var state = table.state.loaded();
            if (state) {
                table.columns().eq(0).each(function(colIdx) {
                    var colSearch = state.columns[colIdx].search;
                    
                    if (colSearch.search) {
                        $('input', table.column(colIdx).header()).val(colSearch.search);
                        $('select', table.column(colIdx).header()).val(colSearch.search.slice(1, -1));


                        table.search(colSearch.search).draw(); 
                    }
                });

                
            }


        $('#add').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Product/addProduct',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        if(confirm('Do you want to add product in different brand?')){
                            $('#category_id').find('option').remove().end();
                        }else{
                            location.reload();
                        }
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                            if(key == 'status' || key == 'category_id'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                            
                        });
                    }

                }

            });

        });



      

        $('#section-submit').on('click', function(e) {
            e.preventDefault();
            var base_url = $('#base_url').val();
            var selectedIds = table.columns().checkboxes.selected()[0];
            var ids = selectedIds.toString();
            if(ids.length > 0){
                var section = $('#section').val();
                var apply = $('#apply').val();

                if(apply == 'add'){
                    url_data = base_url + 'Product/addSectionProductsStatus';
                }else{
                    url_data = base_url + 'Product/removeSectionProductsStatus';
                }
                $.ajax({
                    type: 'post',
                    data: {
                        section : section,
                        ids: ids
                    },
                    url:url_data ,
                    success: function(data) {
                        alert('success');

                        $("input[type=checkbox]").prop("checked", false);
                        table.state.clear();
                        window.location.reload();
                    }

                });
            }else{
                alert('Please select atleast one record');
            }

        });


        // $('#out_of_stock').on('click', function(e) {
        //     e.preventDefault();
        //     var base_url = $('#base_url').val();
        //     var ids = [];
        //     $.each($("input[name='checkbox']:checked"), function(){
        //         ids.push($(this).val());
        //     });

        //     $.ajax({
        //         type: 'post',
        //         data: {
        //             ids: ids
        //         },
        //         url: base_url + 'Product/outOfStock',
        //         success: function(data) {
        //             alert('success');
        //             $('#message_model').modal('hide');
        //             $("input[type=checkbox]").prop("checked", false);
        //             table.state.clear();
        //             window.location.reload();
        //         }

        //     });

        // });

       

        // $('#stock_in').on('click', function(e) {
        //     e.preventDefault();
        //     var base_url = $('#base_url').val();
        //     var ids = [];
        //     $.each($("input[name='checkbox']:checked"), function(){
        //         ids.push($(this).val());
        //     });

        //     $.ajax({
        //         type: 'post',
        //         data: {
        //             ids: ids
        //         },
        //         url: base_url + 'Product/stockIn',
        //         success: function(data) {
        //             alert('success');
        //             $('#message_model').modal('hide');
        //             $("input[type=checkbox]").prop("checked", false);
        //             table.state.clear();
        //             window.location.reload();
        //         }

        //     });

        // });

        $('#active').on('click', function(e) {
            e.preventDefault();
            var base_url = $('#base_url').val();
            var selectedIds = table.columns().checkboxes.selected()[0];
            var ids = selectedIds.toString();

            $.ajax({
                type: 'post',
                data: {
                    ids: ids
                },
                url: base_url + 'Product/activateProductsStatus',
                success: function(data) {
                    alert('success');
                    $('#message_model').modal('hide');
                    $("input[type=checkbox]").prop("checked", false);
                    table.state.clear();
                    window.location.reload();
                }

            });

        });

         $('#inactive').on('click', function(e) {
            e.preventDefault();
            var base_url = $('#base_url').val();
            var selectedIds = table.columns().checkboxes.selected()[0];
            var ids = selectedIds.toString();

            $.ajax({
                type: 'post',
                data: {
                    ids: ids
                },
                url: base_url + 'Product/deactivateProductsStatus',
                success: function(data) {
                    alert('success');
                    $('#message_model').modal('hide');
                    $("input[type=checkbox]").prop("checked", false);
                    table.state.clear();
                    window.location.reload();
                }

            });

        });

         $('#delete').on('click', function(e) {
            e.preventDefault();
            var base_url = $('#base_url').val();
            var selectedIds = table.columns().checkboxes.selected()[0];
            var ids = selectedIds.toString();

            $.ajax({
                type: 'post',
                data: {
                    ids: ids
                },
                url: base_url + 'Product/deleteMultipleProduct',
                success: function(data) {
                    alert('success');
                    
                    $("input[type=checkbox]").prop("checked", false);
                    table.state.clear();
                   // window.location.reload();
                }

            });

        });


         $('#brand_id').on('change', function(e) {
            e.preventDefault();
            var base_url = $('#base_url').val();
            var brand_id = $('#brand_id').val();

            $.ajax({
                type: 'post',
                data: {
                    brand_id: brand_id
                },
                url: base_url + 'Category/getCategoryList',
                success: function(data) {
                    var result = $.parseJSON(data);

                

                    $.each(result.message.category, function(key, value) { 

                        // clear and add new option
                        $("#category_id").select2({data: [
                         {id: value.id, text: value.category_name}]});
                    });

                    $('#category_id').select2();
                }

            });

        });

    });
</script>

