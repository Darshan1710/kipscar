/* ------------------------------------------------------------------------------
*
*  # Inbox page
*
*  Demo JS code for mail_list.html pages
*
* ---------------------------------------------------------------------------- */

document.addEventListener('DOMContentLoaded', function() {


    // Custom code
    // ------------------------------

    // Highlight row when checkbox is checked
    $('.table-inbox').find('tr > td:first-child').find('input[type=checkbox]').on('change', function() {
        if($(this).is(':checked')) {
            $(this).parents('tr').addClass('warning');
        }
        else {
            $(this).parents('tr').removeClass('warning');
        }
    });

    // Grab first letter and insert to the icon
    $(".table-inbox tr").each(function (i) {

        // Title
        var $title = $(this).find('.letter-icon-title'),
            letter = $title.eq(0).text().charAt(0).toUpperCase();

        // Icon
        var $icon = $(this).find('.letter-icon');
            $icon.eq(0).text(letter);
    });


    // Plugins
    // ------------------------------

    // Default initialization
    $(".styled").uniform();

    // Initialize Row link plugin
    $('tbody.rowlink').rowlink();

});
