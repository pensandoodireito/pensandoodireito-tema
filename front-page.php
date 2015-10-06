<?php get_header(); ?>


    <div id="destaque-home" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#destaque-home" data-slide-to="0" class="active"></li>
            <li data-target="#destaque-home" data-slide-to="1"></li>
            <li data-target="#destaque-home" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/G7THEcKWCwo" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill has-background"
                     style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/bck-destaque-full.jpg');">
                    <a href="#"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/destaque-pesquisas.png"
                                      class="img-adptive" alt="destaque"></a>
                </div>
                <div class="carousel-caption">
                    <p>Confira as pesquisas em andamento do projeto pensando o direito</p>
                </div>
            </div>
            <div class="item">
                <!-- Set the third background image using inline CSS below. -->
                <div class="fill has-background"
                     style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/images/foto-destaque.jpg')"></div>
                <div class="carousel-caption">
                    <p>Pesquisa “Não Tinha Teto, Não Tinha Nada", propõe medidas que resguardam o Direito Fundamental à
                        moradia</p>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#destaque-home" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#destaque-home" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </div>


<?php get_template_part('front', 'noticias'); ?>
<?php get_template_part('destaque', 'debates'); ?>
<?php get_template_part('mini-tutorial'); ?>
<?php
$fp_pub_query = new WP_Query(array(
    'post_type' => 'publicacao',
    'posts_per_page' => 1,
    'order' => 'DESC',
    'orderby' => 'meta_value_num',
    'meta_query' => array(
        array(
            'key' => 'pub_number',
            'type' => 'NUMERIC'
        )
    )
));

if ($fp_pub_query->have_posts()) {
    $fp_pub_query->the_post(); ?>
    <div class="container">
        <div class="row mt-lg" id="publicacoes">
            <div class="col-md-8" id="publicacao-destaque">
                <h2 class="font-roboto red">Publicações da Série Pensando o Direito</h2>

                <div class="row mt-md">
                    <div class="col-xs-12 col-sm-4 text-center">
                        <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
                            <div class="destaque text-center">
                                <p><?php the_title(); ?></p>
                            </div>
                        </a>
                    </div>
                    <div class="description col-xs-12 col-sm-8">
                        <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
                            <h4 class="font-roboto red">
                                Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></h4>
                        </a>

                        <p>
                            <mark>Data da
                                publicação: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?></mark>
                        </p>
                        <p><?php the_excerpt(); ?> <a href="<?php echo get_post_permalink(); ?>">Leia mais</a></p>

                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="btn-group mt-sm" role="group">
                                    <?php
                                    $dld_file = get_post_meta(get_the_ID(), 'pub_dld_file', true);
                                    if (!empty($dld_file)) { ?>
                                        <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>"
                                           class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                                    <?php } else { ?>
                                        <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default"><span
                                                class="fa fa-download"></span> BAIXAR</a>
                                    <?php } ?>
                                    <a href="<?php echo get_post_permalink(); ?>" class="btn btn-danger">VISUALIZAR</a>
                                </div>
                                <p class="mt-md"><a href="<?php echo site_url("/publicacoes"); ?>"><strong>Todas as
                                            publicações</strong></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AGENDA -->
            <div class="col-md-4">
                <?php get_template_part('agenda'); ?>
            </div>
        </div>
        <!-- /col-md-4 -->
    </div>
<?php }
get_footer(); ?>