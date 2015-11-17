var publicacaoLock = false;
function carregar_publicacoes() {
    publicacaoLock = true;
    var loader = '<div class="col-sm-6 col-xs-12" id="loader-gif">Carregando mais publicações... <img src="' + publicacoes.ajaxgif + '"/></div>';
    if(jQuery('#loader-gif').length == 0){
        jQuery(".publicacoes-list").append(loader);
    }

    jQuery.post(
        publicacoes.ajaxurl,
        {
            'action': 'publicacoes_paginacao_infinita',
            'paged': publicacoes.paginaAtual,
            'destaqueID': destaqueID
        },
        function(html){
            jQuery('#loader-gif').remove();
            jQuery(".publicacoes-list").append(html);
            jQuery(html);
            publicacoes.paginaAtual++;
            publicacaoLock = false;
        }
    );

    return false;
}

jQuery(function ($) {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
            if(!publicacaoLock){
                carregar_publicacoes();
            }

        }
    });
});