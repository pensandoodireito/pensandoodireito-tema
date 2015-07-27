<?php get_header(); ?>
<div class="conteudo">
  <section id="destaque-home">
    <div class="container">
        <?php
            $destaque_query_array = array(
                'post_type' => 'destaque',
                'meta_query' => array(array(
                    'key' => 'destaque_ativo',
                    'value' => '1',
                    'compare' => '=',
                )
            ));
            $destaques = new WP_Query( $destaque_query_array );
        ?>
      <div id="carousel-destaques-home" class="carousel slide" data-ride="carousel">
        <!-- indicadores -->
        <ol class="carousel-indicators">
            <?php
                $counter = 0;
                while ( $counter < count($destaques->posts) ) {
                    echo '<li data-target="#carousel-destaques-home" data-slide-to="' . $counter . '"';
                    if ( $counter == 0 ) {
                        echo ' class="active"';
                    }
                    echo '">';
                    $counter++;
                }
            ?>
        </ol>
        <!-- Divs do carrossel -->
        <div class="carousel-inner" role="listbox">
        <?php
            $first_item = true;
            while ($destaques->have_posts()) {
                $destaques->the_post();
                $modelo_destaque = get_post_meta(get_the_ID(), 'modelo_destaque', true);

                $tipo_midia_img = True;
                if ( $modelo_destaque == 'video_texto' || $modelo_destaque == 'video_full' ) {
                    $tipo_midia_img = False;
                }

                echo '<div class="item';
                if ( $first_item ) {
                    echo ' active';
                    $first_item = false;
                }
                echo '">';
                  echo '<div class="row">';
                    if ( $modelo_destaque == 'video_full' || $modelo_destaque == 'img_full' ) {
                        echo '<div class="col-lg-12">';
                    } else {
                        echo '<div class="col-md-8">';
                    }

                    if ($tipo_midia_img) {
                        if ( $modelo_destaque == 'img_full' ) {
                            echo '<a href="';
                            echo get_post_meta(get_the_ID(), 'destaque_link', true);
                            echo '">';
                        }
                        echo '<img class="midia_imagem img-full" id="img_preview" src="' . get_post_meta(get_the_ID(), 'midia_destaque', true) . '"/>';
                        if ( $modelo_destaque == 'img_full' ) {
                             echo '</a>';
                        }

                    } else {
                        echo '<div class="embed-responsive embed-responsive-16by9">';
                            echo do_shortcode('[youtube id="' . getYoutubeIdFromUrl(get_post_meta(get_the_ID(), 'midia_destaque', true)) . '"]');
                        echo '</div>';
                    }

                    if ( $modelo_destaque == 'video_full' || $modelo_destaque == 'img_full' ) {
                        echo '</div>';
                    } else {
                        echo '</div>';
                        echo '<div class="col-md-4 col-mt-lg texto-destaque-home">';
                            echo '<p class="h1 font-roboto mt-lg">';
                                echo '<a href="';
                                echo get_post_meta(get_the_ID(), 'destaque_link', true);
                                echo '">';
                                    echo get_post_meta(get_the_ID(), 'destaque_texto', true);
                                echo '</a>';
                            echo '</p>';
                        echo '</div>';
                    }
                  echo '</div>';
                echo '</div>';
            }
        ?>
        </div>
        <!-- Controles -->
        <a class="left carousel-control" href="#carousel-destaques-home" role="button" data-slide="prev">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="right carousel-control" href="#carousel-destaques-home" role="button" data-slide="next">
          <i class="fa fa-chevron-right" aria-hidden="true"></i>
          <span class="sr-only">Próximo</span>
        </a>
      </div>
    </div>
  </section>
    <?php get_template_part('front', 'noticias'); ?>
    <?php get_template_part('destaque', 'debates'); ?>
    <?php get_template_part('mini-tutorial'); ?>
  <?php
  $fp_pub_query = new WP_Query(array (
  'post_type' => 'publicacao',
  'posts_per_page' => 1,
  'order' => 'DESC',
  'orderby' => 'meta_value_num',
      'meta_query' => array(
          array(
              'key'   => 'pub_number',
              'type' => 'NUMERIC'
          )
      )
  ));

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
          <?php get_template_part('agenda'); ?>
          </div>
      </div> <!-- /col-md-4 -->
    </div>
  </div>
</div>
<?php }
get_footer(); ?>
