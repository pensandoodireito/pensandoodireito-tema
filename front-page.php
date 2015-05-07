<?php get_header(); ?>
<div class="conteudo">
    
    <section id="destaque-home">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/EHHmVbNNvHQ?controls=1&autohide=1"></iframe>
                    </div>
                </div>
                <div class="col-md-4 description-destaque font-roboto mt-lg">
                    <h6 class="font-roboto"><?php echo get_bloginfo('title'); ?></h6>
                    <h2 class="font-roboto">O que é?</h2>
                    <p>Apresentamos aqui a Série Pensando o Direito: pesquisas que partem da observação da realidade e do diálogo entre mais de um campo do saber para compreender grandes temas e orientar o governo em sua capacidade de atuar  sobre a vida dos cidadãos por meio de políticas públicas.</p>
                </div>
            </div>
        </div>
    </section>
    <?php get_template_part('destaque', 'debates'); ?>
    <?php get_template_part('mini-tutorial'); ?>
    <?php get_template_part('noticias'); ?>
    <?php
    $fp_pub_query = new WP_Query(array (
    'post_type' => 'publicacao',
    'posts_per_page' => 1));
    if ($fp_pub_query->have_posts()) {
    $fp_pub_query->the_post();?>
    <div class="container">
        <div class="row mt-md" id="publicacoes">
            <div class="col-md-8" id="publicacao-destaque">
                <h3 class="font-roboto red">Publicações da Série Pensando o Direito</h3>
                <div class="panel-body">
                    <div class="col-xs-6 col-md-4">
                      <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
                        <div class="destaque text-center">
                            <p><?php the_title(); ?></p>
                        </div>
                      </a>
                    </div>
                    <div class="description col-md-8">
                        <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
                          <h4 class="font-roboto red">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></h4>
                        </a>
                        <p><mark>Data da publicação: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?></mark></p>
                        <p><?php the_excerpt(); ?> <a href="<?php echo get_post_permalink(); ?>">Leia mais</a></p>
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <div class="btn-group mt-sm" role="group">
                                    <?php
                                    $dld_file = get_post_meta(get_the_ID(), 'pub_dld_file', true);
                                    if( ! empty($dld_file)) { ?>
                                    <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                                    <?php } else { ?>
                                    <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                                    <?php }?>
                                    <a href="<?php echo get_post_permalink(); ?>" class="btn btn-danger">VISUALIZAR</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AGENDA -->
            <div class="col-md-4">
                <div class="panel panel-danger">
                  <div class="panel-heading">
                    <div class="pull-right"> 
                        <i class="fa fa-calendar fa-4x fa-inverse"></i> 
                    </div>
                    <h5 class="font-roboto red"><strong>Acompanhe nossa agenda </strong></h5>
                    <small class="text-muted">Semana: 20 a 24 de abril</small>
                  </div>
                  <div class="panel-body box-agenda">
                    <p><strong>20 de abril</strong></p>
                    <ul class="list-unstyled"> 
                        <li class="mb-sm">  
                          <span><i class="fa fa-angle-right"></i> 14h</span> | <span><a href="#"> Nome do evento</a></span><br>
                          <span><i class="fa fa-map-marker text-danger"></i><small> Nome do local</small></span>
                        </li>
                        <li class="mb-sm">  
                          <span><i class="fa fa-angle-right"></i> 14h</span> | <span>Nome do evento não sou link</span><br>
                          <span><i class="fa fa-map-marker text-danger"></i><small> Nome do local</small></span>
                        </li>
                    </ul><hr>
                    <p><strong>23 de abril</strong></p>
                    <ul class="list-unstyled">
                        <li class="mb-sm">  
                          <span><i class="fa fa-angle-right"></i> 14h</span> | <span> Nome do evento não sou link</span><br>
                          <span><i class="fa fa-map-marker text-danger"></i><small> Nome do local</small></span>
                        </li>
                        <li class="mb-sm">  
                          <span><i class="fa fa-angle-right"></i> 14h</span> | <span><a href="#"> Nome do evento</a></span><br>
                          <span><i class="fa fa-map-marker text-danger"></i><small> Nome do local</small></span>
                        </li>
                    </ul><hr>
                    <p><strong>24 de abril</strong></p>
                    <ul class="list-unstyled">
                        <li class="mb-sm">  
                          <span><i class="fa fa-angle-right"></i> 14h</span> | <span><a href="#"> Nome do evento</a></span><br>
                          <span><i class="fa fa-map-marker text-danger"></i><small> Nome do local</small></span>
                        </li>
                        <li class="mb-sm">  
                          <span><i class="fa fa-angle-right"></i> 14h</span> | <span><a href="#"> Nome do evento</a></span><br>
                          <span><i class="fa fa-map-marker text-danger"></i><small> Nome do local</small></span>
                        </li>
                    </ul><hr>  
                    <small class="text-warning">Acompanhe sempre nossa agenda!</small>    
                  </div><!-- end box-agenda -->
                </div> 
            </div> <!-- /col-md-4 -->


        </div>
    </div>
</div>
<?php }
get_footer(); ?>
