/**
 * Created by DiRaOL on 11/03/15.
 */
jQuery(document).ready(function() {
    <!-- invoke the tooltip on any element with the class tooltiped -->
    //jQuery('.tooltiped').tooltip(); // Was meant to be used on the sidebar-publicacao

    <!-- invoke the date picker on any element with the class date-pick -->
    Date.firstDayOfWeek = 7;
    jQuery('.datePick').datepicker({
        dateFormat : 'dd/mm/yy'
    });
});

jQuery(document).ready(function($){


    var custom_uploader;


    $('#upload_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#destaque_media').val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });


});
