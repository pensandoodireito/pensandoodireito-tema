<?php get_header(); ?>
   <div class="conteudo">
 
        <section id="destaque-home">
            <div class="container">
                <div class="row">
                    <div class="col-xs-7">
                    <!-- 4:3 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/EHHmVbNNvHQ?controls=1&autohide=1"></iframe>
                    </div>
                    </div>
                    <div class="col-xs-4 description-destaque font-roboto">
                        <h6 class="font-roboto"><?php echo get_bloginfo('title'); ?></h6>
                        <h2 class="font-roboto">O que é?</h2>
                        <p>Apresentamos aqui a Série Pensando o Direito: pesquisas que partem da observação da realidade e do diálogo entre mais de um campo do saber para compreender grandes temas e orientar o governo em sua capacidade de atuar  sobre a vida dos cidadãos por meio de políticas públicas.</p>
                    </div>
                </div>
            </div>
        </section>
    </br>    
    <div class="container">
        <h2 class="font-roboto red">Participe dos debates!</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet cursus metus, nec feugiat sablandit diam facilisis.</p>
    </div>

<?php get_template_part('mini-tutorial'); ?>

 <section id="destaque-home-debates">       
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="font-roboto red">Debates Abertos:</h3>
                </div>
                <div class="col-md-6 text-right">
                    <p class="mt-sm">
                        <strong class="mt-xs ml-md"><a href="#">Veja todos os debates</a></strong>
                    </p>
                </div>
            </div>
            <div class="row" id="debates-home">
                <div class="col-md-4">
                    <div class="">
                     <a href="#">   
                        <div class="text-center">
                            <img src="/wp-content/themes/marcocivil-tema/images/logo.png" class="img-adaptative" alt="Debate">
                        </div>
                        <div class="description">
                            <strong class="red">Título do Debate</strong>
                            <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet cursus metus, nec feugiat sablandit diam facilisis. </small></p>
                        </div>
                     </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                     <a href="#">   
                        <div class="text-center">
                            <img src="/wp-content/themes/dadospessoais-tema/images/logo.png" class="img-adaptative" alt="Debate">
                        </div>
                        <div class="description">
                            <strong class="red">Título do Debate</strong>
                            <p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet cursus metus, nec feugiat sablandit diam facilisis. </small></p>
                        </div>
                     </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                     <a href="#">   
                        <div class="text-center">
                            <a href="/blog/pauta"><img src="/wp-content/themes/pensandoodireito-tema/images/icone-debates.png" class="img-adaptative" alt="Debate"></a>
                        </div>
                        <div class="description">
                            <strong class="red">Comece um debate</strong>
                            <p><small>Tem algum assunto que quer ver debatido? Faça sua sugestão aqui.</small></p>
                        </div>
                     </a>
                    </div>

                </div>                
            </div>
        </div>
     </section>   
    </div>

<?php
    $fp_pub_query = new WP_Query(array (
        'post_type' => 'publicacao',
        'posts_per_page' => 1));
    $fp_pub_query->the_post();?>

    <div class="container">
            <div class="row mt-md" id="publicacoes">
                <div class="col-md-8" id="publicacao-destaque">
                        <h3 class="font-roboto red">Publicações da Série Pensando o Direito</h3>
                      <div class="panel-body">
                        <div class="col-xs-6 col-md-4">
                            <a href="#" class="nounderline">
                              <div class="destaque text-center"> 
                               <p><?php the_title(); ?></p>
                              </div>
                            </a>
                        </div>
                        <div class="description col-md-8">
                            <h4 class="font-roboto red">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></h4>
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
                                 </div>
                                 <div class="btn-group btn-danger mt-sm" role="group">
                                     <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default btn-danger">VISUALIZAR</a>
                                 </div>
                             </div>
                           </div>   
                        </div>
                    </div>
                </div>
                <div class="col-md-4 well box-publicacao">
                    <h5 class="red">Saiba mais sobre a série Pensando o Direito</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet cursus metus, nec feugiat sablandit diam facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet</p>
                    <strong><a href="publicacao">Todas as publicações</a></strong></br>
                    </div>
                </div>
            </div>
        </div>

<?php get_footer(); ?>
