/* ------------------------------------------------------------------------------
*
*  # Dropzone multiple file uploader
*
*  Demo JS code for uploader_dropzone.html page
*
* ---------------------------------------------------------------------------- */


// Multiple files
Dropzone.options.dropzoneMultiple = {
    paramName: "file", // The name that will be used to transfer the file
    dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
    maxFilesize: 1 // MB
};

// Single files
Dropzone.options.dropzoneSingle = {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 1, // MB
    maxFiles: 1,
    dictDefaultMessage: 'Drop file to upload <span>or CLICK</span>',
    autoProcessQueue: false,
    init: function() {
        this.on('addedfile', function(file){
            if (this.fileTracker) {
            this.removeFile(this.fileTracker);
        }
            this.fileTracker = file;
        });
    }
};

// Accepted files
Dropzone.options.dropzoneAcceptedFiles = {
    paramName: "file", // The name that will be used to transfer the file
    dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
    maxFilesize: 1, // MB
    acceptedFiles: 'image/*'
};

// Removable thumbnails
Dropzone.options.dropzoneRemove = {
    paramName: "file", // The name that will be used to transfer the file
    dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
    maxFilesize: 1, // MB
    addRemoveLinks: true
};

// File limitations
Dropzone.options.dropzoneFileLimits = {
    paramName: "file", // The name that will be used to transfer the file
    dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
    maxFilesize: 1, // MB
    maxFiles: 40,
    maxThumbnailFilesize: 1,
    addRemoveLinks: true
};
    