<div class="row mt-md" id="publicacao">
  <div class="col-md-9">
    <h2 class="font-roboto red">
    <a href="<?php echo get_post_permalink(); ?>">
      Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?> | <?php the_title_limit(70); ?>
    </a>
    </h2>
    <div class="description">
      <p><mark>Data da publicação: <?php the_date(); ?></mark></p>

        <!--p><?php the_excerpt(); ?></p-->
        <p><?php the_content(); ?></p>

      <p><small><a href="#">Ver autores</a></small></p>
    </div>
    <div class="row">
      <div id="social-bar" class="col-md-4">
        <?php get_template_part('part', 'social'); ?>
      </div>
      <div class="col-md-8 text-right">
        <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" target="_blank" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
      </div>
      </div><!-- row -->
      </br>
      <!--div id="pdf" style="border:1px solid red"-->
      <iframe src="<?php echo get_post_meta(get_the_ID(), 'pub_web_file', true); ?>" seamless id="pdf" width="100%" height="600px"></iframe>
      <!--/div-->
      <div class="btn-group btn-group-justified">
        <div class="btn-group" role="group">
          <?php
          $prev_post = get_previous_post();
          if($prev_post) { ?>
          <button type="button" class="btn btn-default btn-lg" onClick="window.location='<?php echo get_permalink($prev_post->ID); ?>'"><i class="fa fa-angle-left"></i> Anterior</button>
          <?php } else { ?>
          <button type="button" class="btn btn-default btn-lg disabled" disabled><i class="fa fa-angle-left"></i> Anterior</button>
          <?php } ?>
        </div>

        <div class="btn-group" role="group">
          <?php
          $next_post = get_next_post();
          if($next_post) { ?>
          <button type="button" class="btn btn-default btn-lg" onClick="window.location='<?php echo get_permalink($next_post->ID); ?>'">Próxima <i class="fa fa-angle-right"></i></button>
          <?php } else { ?>
          <button type="button" class="btn btn-default btn-lg disabled" disabled>Próxima <i class="fa fa-angle-right"></i></button>
          <?php } ?>
        </div>

      </div>
    </div>
    <div class="col-md-3">
      <?php get_sidebar('publicacao');?>
      <!-- Outras Publicações SIDEBAR -->
    </div>
  </div>
