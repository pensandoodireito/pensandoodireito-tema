function carregar_publicacoes() {
    var loader = '<div class="col-sm-6 col-xs-12" id="loader-gif">Carregando mais publicações... <img src="' + publicacoes.ajaxgif + '"/></div>';
    jQuery("#lista-publicacoes").append(loader);
    jQuery.ajax({
        url: publicacoes.ajaxurl,
        type: 'POST',
        data: "action=publicacoes_paginacao_infinita&paged=" + publicacoes.paginaAtual + "&destaqueID=" + destaqueID,
        success: function (html) {
            jQuery('#loader-gif').remove();
            jQuery("#lista-publicacoes").append(html);

            publicacoes.paginaAtual++;

            if (publicacoes.paginaAtual > publicacoesPaginasMaximas) {
                jQuery("#mais-publicacoes").hide();
            }
        }
    });

    return false;
}