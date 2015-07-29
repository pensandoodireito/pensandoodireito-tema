<?php get_header(); ?>
    <div id="pagina-debates">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="red font-roboto">Debates públicos</h1>
                </div>
            </div>
        </div>
        <header class="debates-intro">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="red font-roboto">Participe, sua opinião é muito importante!</h3>
                        <p class="mt-md">A realização de debates envolve cidadãos interessados nas discussões de projetos ou anteprojetos de lei, objetivando complementar, ou até mesmo substituir, formas tradicionais de elaboração, como por exemplo a formação de comissões de juristas.</p>
                    </div>
                    <div class="col-sm-5 image-header">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/debates/img-debates-001.png" class="img-full" alt="Proteção de Dados Pessoais">
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="red font-roboto">Debates em destaque</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="debate-item">
                            <header class="anticorrupcao">
                                <div class="text-center">
                                    <a href="<?php echo site_url("/anticorrupcao"); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/debates/logos/logo-anticorrupcao-w.png" class="img-adptive mt-lg" alt="Medidas Anticorrupção"></a>
                                </div>
                            </header>
                            <div class="description">
                                <p>
                                    Depois do sucesso da plataforma digital que ajudou a construir o Marco Civil da Internet e debateu os Dados Abertos, agora é a vez do governo pedir ajuda à sociedade para encontrar novas medidas de combate à corrupção e impunidade.
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <a href="<?php echo site_url("/anticorrupcao"); ?>" class="btn btn-danger font-roboto">Confira como foi este debate!</a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right mt-xs">
                                            <span class="fontsize-sm text-orange"><i class="fa fa-exclamation-triangle"></i> Debate encerrado dia 8 de julho de 2015</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="red font-roboto">Debates recentes</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="debate-item">
                            <header class="marco-civil">
                                <div class="text-center">
                                    <a href="<?php echo site_url("/marcocivil"); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/debates/logos/marcocivil-w.png" class="img-adptive" alt="Marco Civil da Internet"></a>
                                </div>
                            </header>
                            <div class="description">
                                <p>
                                    Essa regulamentação será feita de maneira colaborativa, utilizando uma plataforma   participativa, seguindo o padrão de debate público utilizado quando o Marco Civil ainda era um Anteprojeto de Lei.
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <a href="<?php echo site_url("/marcocivil"); ?>" class="btn btn-danger font-roboto" target="_blank">Confira como foi este debate!</a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right mt-xs">
                                            <span class="fontsize-sm text-orange"><i class="fa fa-exclamation-triangle"></i> Debate encerrado dia 30 de abril de 2015</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="debate-item">
                            <header class="protecao">
                                <div class="text-center">
                                    <a href="<?php echo site_url("/dadospessoais"); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/debates/logos/protecao-w.png" class="img-adptive" alt="Proteção de dados pessoais"></a>
                                </div>
                            </header>
                            <div class="description">
                                <p>
                                    O debate busca promover a participação da sociedade brasileira na elaboração do anteprojeto de lei para proteção de dados pessoais, por meio da formulação de comentários e sugestões sobre o texto proposto.
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <a href="<?php echo site_url("/dadospessoais"); ?>" class="btn btn-danger font-roboto" target="_blank">Confira como foi este debate!</a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right mt-xs">
                                            <span class="fontsize-sm text-orange"><i class="fa fa-exclamation-triangle"></i> Debate encerrado dia 5 de julho de 2015</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="red font-roboto">Outros debates</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <?php
                        query_posts(array( 'post_type' => 'debate' ));

                        while(have_posts()): the_post();

                            $link = get_post_meta(get_the_ID(), 'debate_link', true);
                            $inicio = get_post_meta(get_the_ID(), 'debate_periodo_de', true);
                            $fim = get_post_meta(get_the_ID(), 'debate_periodo_para', true);
                            $resultados = get_post_meta(get_the_ID(), 'debate_resultados', true);
                        ?>

                        <section class="mt-md divider-bottom pb-md">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="<?php echo $link; ?>" target="_blank"><?php the_post_thumbnail(array(230,175), array('class' => 'img-adptive')); ?></a>
                                </div>
                                <div class="col-sm-6">
                                    <h4><strong class="red"><a href="<?php echo $link; ?>" target="_blank"><?php the_title(); ?></a></strong></h4>
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <div class="well well-sm">
                                        <p>Iniciado em: <?php echo $inicio; ?></p>
                                        <p>Finalizado: <?php echo $fim; ?></p>
                                        <?php if ($resultados): ?>
                                        <p class="divider-top"><i class="fa fa-users"></i><?php echo $resultados; ?></p>
                                        <?php endif; ?>
<!--                                        <p><i class="fa fa-comments"></i> comentários</p>-->
                                    </div>
                                </div>
                            </div>
                        </section>

                        <?php endwhile; ?>

                    </div>
                </div>
            </div>
        </section>
    </div>
<?php get_template_part('mini-tutorial'); ?>
<?php get_footer(); ?>