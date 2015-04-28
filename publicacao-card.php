<?php
//TODO: Como adicionar diversos autores e mostrá-los?
$autores = false;
?>
<!-- inicio card -->
<div class="col-md-3">
  <div class="thumbnail">
    <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
      <div class="capa">
        <div class="ribbon-wrapper">
          <div class="ribbon">
            Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?>
          </div>
        </div>
        <div class="card">
          <p><?php the_title_limit(70); ?></p>
        </div>
      </div>
    </a>
    <div class="caption small">
      <h6>
        <a href="<?php echo get_post_permalink(); ?>">
          Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?>
          | <?php the_title(); ?>
        </a>
      </h6>
      <p>
        <mark>Data: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?></mark>
      </p>
      <div class="description-publicacao">
        <p><?php the_excerpt(); ?></p>
      </div>
      <?php if ($autores) { ?>

        <p>
          <small><a href="#">Ver autores</a></small>
        </p>
      <?php } ?>
      <div class="social-bar">
        <small>
          <!--a href="#" class="nounderline"-->
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-facebook fa-stack-1x"></i>
            </span>
          <!--/a-->
        </small>
        <small>
          <a href="#" onClick="event.preventDefault(); window.open('https://twitter.com/share?hashtags=pensandoodireito&text=<?php echo the_title(); ?>&url=<?php echo get_post_permalink(); ?>','Tweet');" class="nounderline">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-twitter fa-stack-1x"></i>
            </span>
          </a>
        </small>
        <small>
          <a href="#" onClick="event.preventDefault(); window.open('https://www.linkedin.com/shareArticle?mini=true&title=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_post_permalink()); ?>&summary=<?php echo urlencode(get_the_excerpt()); ?>&source=http://participacao.mj.gov.br');" class="nounderline">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-linkedin fa-stack-1x"></i>
            </span>
          </a>
        </small>
      </div>
      </br>
      <div class="btn-group mt-sm" role="group">
        <?php
        $dld_file = get_post_meta(get_the_ID(), 'pub_dld_file', true);
        if (!empty($dld_file)) { ?>
          <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" class="btn btn-default">
            <span class="fa fa-download"></span> BAIXAR
          </a>
        <?php } else { ?>
          <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default">
            <span class="fa fa-download"></span> BAIXAR
          </a>
        <?php } ?>
      </div>
      <div class="btn-group mt-sm" role="group">
        <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default btn-danger">VISUALIZAR</a>
      </div>
    </div>
  </div>
</div>
<!-- fim card -->