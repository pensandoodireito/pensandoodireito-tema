var publicacaoLock = false;
function carregar_publicacoes() {
    publicacaoLock = true;
    var loader = '<div class="col-sm-6 col-xs-12" id="loader-gif">Carregando mais publicações... <img src="' + publicacoes.ajaxgif + '"/></div>';
    if (jQuery('#loader-gif').length == 0) {
        jQuery(".publicacoes-list").append(loader);
    }


    var params = getQueryParameters();
    params.action = 'publicacoes_paginacao_infinita';
    params.paged = publicacoes.paginaAtual;
    params.destaqueID = destaqueID;

    jQuery.post(
        publicacoes.ajaxurl,
        params,
        function (html) {
            jQuery('#loader-gif').remove();
            jQuery(".publicacoes-list").append(html);
            jQuery(html);
            publicacoes.paginaAtual++;
            publicacaoLock = false;
        }
    );

    return false;
}

function getQueryParameters(str) {
    return (str || document.location.search).replace(/(^\?)/, '').split("&").map(function (n) {
        return n = n.split("="), this[n[0]] = n[1], this;
    }.bind({}))[0];
};

jQuery(function ($) {
    if (location.href.indexOf("publicacoes") != -1) {
        $(window).scroll(function () {
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
                if (!publicacaoLock) {
                    carregar_publicacoes();
                }

            }
        });
    }
});