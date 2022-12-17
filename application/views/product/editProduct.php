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
  <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
  <!-- /core JS files -->

   <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/editors/ckeditor5/build/ckeditor.js"></script>

  <!-- Theme JS files -->
  <!-- <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.date.js"></script> -->
  <script src="<?php echo base_url ()?>js/plugins/notifications/jgrowl.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/ui/moment/moment.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/daterangepicker.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/anytime.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.date.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.time.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/legacy.js"></script>


   <script src="<?php echo base_url() ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

  <script src="<?php echo base_url() ?>js/app.js"></script>
  <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>
  <script src="<?php echo base_url() ?>js/custom.js"></script>


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
              <li><a href="#">Offer</a></li>
              <li class="active">Add Offer</li>
            </ul>

          </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-flat">

                <div class="panel-body">
                  <h5 class="panel-title">Product Form </h5>
                  <hr>
                  <form action="#" method="post" id="update" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $this->uri->segment(3) ?>" class="id">
                <input type="hidden" name="sku" value="<?php echo set_value('sku',isset($product['sku']) ? $product['sku'] : '')?>">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Model no</label>
                                <input type="text" placeholder="Model No" class="form-control model_no" name="model_no" value="<?php echo set_value('model_no',isset($product['model_no']) ? $product['model_no'] : '')?>">
                            </div>
                            <div class="col-sm-3">
                                <label>Vehicale Name</label>
                                <input type="text" placeholder="Vehicale Name" class="form-control vehicale_name" name="vehicale_name" value="<?php echo set_value('vehicale_name',isset($product['vehicale_name']) ? $product['vehicale_name'] : '')?>">
                            </div>
                            <div class="col-sm-3">
                                <label>Brand</label>
                                <select class="form-control select brand_id" name="brand_id">
                                    <option value="">Please Select Brand</option>
                                    <?php foreach($brand as $b){?>
                                    <option value="<?php echo $b['id'] ?>" <?php echo set_select('brand_id', '1', $product['brand_id'] == $b['id'] ? TRUE : FALSE ); ?>><?php echo $b['brand'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Category</label>
                                <select class="form-control select category_id" name="category_id">
                                    <option value="">Please Select Package</option>
                                    <?php foreach($category as $row){?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo set_select('category_id', '1', $product['category_id'] == $row['id'] ? TRUE : FALSE ); ?>><?php echo $row['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                                <label>Image (200 x 200)</label><br>
                                <?php if(!empty($product['image'])){ ?>
                                <img class="image" width="50px" height="50px" src="<?php echo $image = !empty($product['image'])  ? base_url().$product['image']  : 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg'; ?>">
                                

                                
                                <button class="btn btn-sm btn-primary change_image" type="button">Change Image</button>
                                <?php } ?>
                                <input type="<?php echo  $e = isset($product['image']) && !empty($product['image']) ? 'hidden' : 'file' ?>" name="image" class="new_image">
                                
                                <input type="hidden"  class="form-control old_image" name="old_image" value="<?php echo $image = empty($product['image']) ? set_value('old_image') : $product['image']?>">
                            </div>
                            <div class="col-sm-3">
                                <label>Youtube Thumbnail ( 1097 x 900)</label>
                                 <?php if(!empty($youtube_thumbnail)){ ?>

                                 
                                <img class="youtube_thumbnail" width="50px" height="50px" src="<?php echo $youtube_thumbnail_data = !empty($youtube_thumbnail)  ? base_url().$youtube_thumbnail  : 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg'; ?>">
                                <button class="btn btn-sm btn-primary change_thumbnail" type="button">Change Image</button>
                                <?php } ?>
                                <input type="<?php echo  $e = isset($youtube_thumbnail) && !empty($youtube_thumbnail) ? 'hidden' : 'file' ?>" name="new_thumbnail" class="new_thumbnail">
                                
                                <input type="hidden"  class="form-control old_thumbnail" name="old_thumbnail" value="<?php echo $youtube_thumbnail = empty($youtube_thumbnail) ? set_value('youtube_thumbnail') : $youtube_thumbnail?>">
                            </div>
                            <div class="col-sm-3">
                                <label>Youtube</label>
                                <input type="text" placeholder="Youtube" class="form-control youtube" name="youtube" value="<?php echo set_value('youtube',isset($youtube) ? $youtube : '')?>">
                            </div>
                            <div class="col-sm-3">
                                <label>MRP</label>
                                <input type="text" placeholder="MRP" class="form-control mrp" name="mrp" value="<?php echo set_value('mrp',isset($product['mrp']) ? $product['mrp'] : '')?>">
                            </div>
                            
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            
                            
                            <div class="col-sm-3">
                                <label>MRP Color</label>
                                <select class="form-control select color_code" name="color_code">
                                    <option value="">Please Select Status</option>
                                    <option value="#000000" <?php echo set_select('color_code', '#000000', $product['color_code'] == '#000000' ? TRUE : FALSE ); ?>>Black</option>
                                    <option value="#FFFFFF" <?php echo set_select('color_code', '#FFFFFF', $product['color_code'] == '#FFFFFF' ? TRUE : FALSE ); ?>>White</option>
                                    
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>MRP Color</label>
                                <select class="form-control select background_color" name="background_color">
                                    <option value="">Please Select Status</option>
                                    <option value="#4b81bd" <?php echo set_select('background_color', '#4b81bd', $product['background_color'] == '#4b81bd' ? TRUE : FALSE ); ?>>Blue</option>
                                    <option value="#707f82" <?php echo set_select('background_color', '#707f82', $product['background_color'] == '#707f82' ? TRUE : FALSE ); ?>>Grey</option>
                                    <option value="#9cbc57" <?php echo set_select('background_color', '#9cbc57', $product['background_color'] == '#9cbc57' ? TRUE : FALSE ); ?>>Green</option>
                                    <option value="#f6ed69" <?php echo set_select('background_color', '#f6ed69', $product['background_color'] == '#f6ed69' ? TRUE : FALSE ); ?>>Yellow</option>
                                    
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Status</label>
                                <select class="form-control select status" name="status">
                                    <option value="">Please Select Status</option>
                                    <option value="1" <?php echo set_select('status', '1', $product['status'] == '1' ? TRUE : FALSE ); ?>>Active</option>
                                    <option value="0" <?php echo set_select('status', '0', $product['status'] == '0' ? TRUE : FALSE ); ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" id="description" rows="10"><?php echo set_value('description',isset($product['description']) ? $product['description'] : '')?></textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Vehical Application</label>
                                <textarea name="vehical_application" class="form-control" id="vehical_application" rows="10"><?php echo set_value('vehical_application',isset($product['vehical_application']) ? $product['vehical_application'] : '')?></textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Other Information</label>
                                <textarea name="other_information" class="form-control" id="other_information" rows="10"><?php echo set_value('other_information',isset($product['other_information']) ? $product['other_information'] : '')?></textarea>
                            </div>
                            <div class="col-sm-3">
                                <label>Disclaimer</label>
                                <textarea name="disclaimer" class="form-control" id="disclaimer" rows="10"><?php echo set_value('disclaimer',isset($product['disclaimer']) ? $product['disclaimer'] : '')?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Features</label>
                                <textarea name="features" class="form-control features"><?php echo $features = empty($product['features']) ? set_value('features') : $product['features']?></textarea>
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
          <!-- /select2 selects -->

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

<div class="loader">
<center>
 <img class="loading-image" src="<?php echo base_url()?>images/loader.gif" alt="loading..">
</center>
</div>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>">
<script type="text/javascript">
        $('#update').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Product/updateProduct',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        window.location.href = base_url+'Product/productList';
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {

                            var element = $('.' + key);
                            if(key == 'category_id' || key == 'status' || key == 'color_code' || key == 'background_color'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                        });
                    }

                }

            });

        });

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
        xhr.open( 'POST', base_url + 'Product/imageUpload', true );
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
            .create( document.querySelector( '.features' ), {
                
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

        $('.change_thumbnail').on('click',function(){
        $('.youtube_thumbnail').css('display','none');
        $('.new_thumbnail').attr('type','file');
        $('.change_thumbnail').css('display','none');
      });

    });

    $('.brand_id').on('change', function(e) {
            e.preventDefault();
            var base_url = $('#base_url').val();
            var brand_id = $('.brand_id').val();

            $.ajax({
                type: 'post',
                data: {
                    brand_id: brand_id
                },
                url: base_url + 'Category/getCategoryList',
                success: function(data) {
                    var result = $.parseJSON(data);

                
                    $('.category_id').empty();
                    $.each(result.message.category, function(key, value) { 

                        // clear and add new option
                        $(".category_id").select2({data: [
                         {id: value.id, text: value.category_name}]});
                    });

                    $('.category_id').select2();
                }

            });

        });
</script>


</script>
