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