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
        <?php
            $debate_destaque = new WP_Query(array( 'post_type' => 'debate', 'meta_key' => 'debate_destaque', 'meta_value' => 'destaque' ));

            $posts_exibidos = array();

            if ($debate_destaque->have_posts()) {
                $debate_destaque->the_post();

                $posts_exibidos[] = get_the_ID();
                $debate_link = get_post_meta(get_the_ID(), 'debate_link', true);
                $imagem_fundo = get_post_meta(get_the_ID(), 'imagem', true);
                $debate_status = get_post_meta(get_the_ID(), 'debate_status', true);
                $debate_periodo_para = get_post_meta(get_the_ID(), 'debate_periodo_para', true);

        ?>
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
                            <header style="background-image: url(<?php echo $imagem_fundo; ?>); background-position: center;">
                                <div class="text-center">
                                    <a href="<?php echo $debate_link; ?>"><?php the_post_thumbnail('medium', array('class' => "img-adptive mt-lg", 'alt' => get_the_title())); ?></a>
                                </div>
                            </header>
                            <div class="description">
                                <p>
                                    <?php the_excerpt(); ?>
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <a href="<?php echo $debate_link; ?>" class="btn btn-danger font-roboto">
                                                <?php echo ($debate_status == "aberto" ? "Participe do debate!" : "Confira como foi este debate!"); ?>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right mt-xs">
                                            <span class="fontsize-sm text-orange"><i class="fa fa-exclamation-triangle"></i> <?php echo ($debate_status == "aberto" ? "Debate aberto até o" : "Debate encerrado"); ?> dia <?php echo pd_converter_datacorrida($debate_periodo_para); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>
        <?php
        $debates_recentes = new WP_Query(array( 'post_type' => 'debate', 'post__not_in' => $posts_exibidos, 'posts_per_page' => 2 ));


        if ($debates_recentes->have_posts()) { ?>

        <section class="mt-lg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="red font-roboto">Debates recentes</h2>
                    </div>
                </div>
                <div class="row">

                    <?php
                        while($debates_recentes->have_posts()):
                            $debates_recentes->the_post();

                            $posts_exibidos[] = get_the_ID();
                            $debate_link = get_post_meta(get_the_ID(), 'debate_link', true);
                            $imagem_fundo = get_post_meta(get_the_ID(), 'imagem', true);
                            $debate_status = get_post_meta(get_the_ID(), 'debate_status', true);
                            $debate_periodo_para = get_post_meta(get_the_ID(), 'debate_periodo_para', true);
                    ?>
                    <div class="col-md-6">
                        <div class="debate-item">
                            <header style="background-image: url(<?php echo $imagem_fundo; ?>); background-position: center;">
                                <div class="text-center">
                                    <a href="<?php echo $debate_link; ?>"><?php the_post_thumbnail('medium', array('class' => "img-adptive mt-lg", 'alt' => get_the_title())); ?></a>
                                </div>
                            </header>
                            <div class="description">
                                <p>
                                    <?php the_excerpt(); ?>
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            <a href="<?php echo $debate_link; ?>" class="btn btn-danger font-roboto">
                                                <?php echo ($debate_status == "aberto" ? "Participe do debate!" : "Confira como foi este debate!"); ?>
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-right mt-xs">
                                            <span class="fontsize-sm text-orange"><i class="fa fa-exclamation-triangle"></i> <?php echo ($debate_status == "aberto" ? "Debate aberto até o" : "Debate encerrado"); ?> dia <?php echo pd_converter_datacorrida($debate_periodo_para); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <?php } ?>
        <?php
        $outros_debates = new WP_Query(array( 'post_type' => 'debate', 'post__not_in' => $posts_exibidos ));


        if ($outros_debates->have_posts()) { ?>

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
                        while($outros_debates->have_posts()): $outros_debates->the_post();

                            $link = get_post_meta(get_the_ID(), 'debate_link', true);
                            $inicio = get_post_meta(get_the_ID(), 'debate_periodo_de', true);
                            $fim = get_post_meta(get_the_ID(), 'debate_periodo_para', true);
                            $resultados = get_post_meta(get_the_ID(), 'debate_resultados', true);
                        ?>

                        <section class="mt-md divider-bottom pb-md">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="<?php echo $link; ?>" target="_blank"><?php the_post_thumbnail('thumb-debate-pagina', array('class' => 'img-adptive')); ?></a>
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
        <?php } ?>
    </div>
<?php get_template_part('mini-tutorial'); ?>
<?php get_footer(); ?>