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
        jQuery('#label_destaque_texto').fadeIn('300');
    } else {
        jQuery('#label_destaque_texto').fadeOut('300');
    }
}

//Imagem button on Debate Archive
jQuery(document).ready(function($){

    var debate_uploader;

    $('#upload_debate_image_button').click(function(e) {

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (debate_uploader) {
            debate_uploader.open();
            return;
        }

        //Extend the wp.media object
        debate_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Escolha a imagem',
            button: {
                text: 'Escolha a imagem'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        debate_uploader.on('select', function() {
            attachment = debate_uploader.state().get('selection').first().toJSON();
            $('#imagem').val(attachment.url);
            var img_frame = $('#img_preview_frame');
            if ( $('#img_preview').length == 0 ) {
                img_frame.append('<img style="width: 100%;" class="img_preview" id="img_preview" src="' + attachment.url + '"/>');
            } else {
                $('#img_preview').attr('src', attachment.url);
            }
        });

        //Open the uploader dialog
        debate_uploader.open();

    });
});
jQuery(function() {
    jQuery( 'input[name="nome_certificado"]' ).autocomplete({
        source: function( request, response ) {
            jQuery.ajax({
                url: ajaxurl,
                dataType: "json",
                type: 'post',
                data: {
                    q: request.term,
                    action: "certificados"
                },
                success: function( data ) {
                    response($.map( data, function( item ) {
                        return {
                            label: item.nome + ' - ' + item.nome_evento,
                            value: item.id,
                            evento: item.nome_evento,
                            participante: item.nome
                        }
                    }));
                }
            });
        },
        minLength: 3,
        select: function( event, ui ) {

            jQuery('#resumo-certificado').hide();
            jQuery('#botao-emitir-certificado').hide();

            jQuery('#resumo-certificado').html('<span>' + ui.item.participante + '</span>' + ui.item.evento);
            jQuery('input[name="id_certificado"]').val(ui.item.value);

            jQuery('#botao-emitir-certificado').fadeIn('fast');
            jQuery('#resumo-certificado').fadeIn('fast');

            return false;

        },
        open: function() {
            jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
});
