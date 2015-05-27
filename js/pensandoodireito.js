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
            title: 'Escolha a imagem',
            button: {
                text: 'Escolha a imagem'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#midia_destaque').val(attachment.url);
            $('#img_preview').attr('src', attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });
});

function destaque_controla_midia(valor) {
    jQuery('#midia_destaque').val('');
    if (valor == 'img_texto' || valor == 'img_full') {
        jQuery('.midia_video').fadeOut('300',function(){
            jQuery('.midia_imagem').fadeIn('300');
        });
    } else {
        jQuery('.midia_imagem').fadeOut('300',function(){
            jQuery('.midia_video').fadeIn('300');
        });
    }
    if (valor == 'img_texto' || valor == 'video_texto') {
        jQuery('.destaque_texto').fadeIn('300');
    } else {
        jQuery('.destaque_texto').fadeOut('300');
    }
}
