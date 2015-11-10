<!-- inicio card -->
<li>
  <div class="row">
    <div class="col-sm-2 col-xs-12">
      <div class="capa">
        <p class="fontsize-lg">Volume <br/>
          <span class="volume"><?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></span></p>
      </div>
    </div>
    <div class="col-sm-6 col-xs-12">
      <div class="descricao">
        <h4 class="red">
            <strong>
                <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" title="Download desta publicação">
                    <?php the_title(); ?>
                </a>
            </strong>
        </h4>

        <p>
            <a data-toggle="collapse" href="#resumo-<?php echo get_the_ID();?>" aria-expanded="false"
              aria-controls="resumo-<?php echo get_the_ID();?>"> Resumo <i class="fa fa-caret-down"></i></a>
        </p>
          <?php
          $lista_autores = get_autores_from_excerpt(get_the_excerpt());
          ?>
        <span class="collapse in" id="resumo-<?php echo get_the_ID();?>"><?php the_excerpt();?></span>

        <p>
          <small class="text-muted">
              Publicado em: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?><br/>
              <?php if(!empty($lista_autores)):?> Coordenação: <?php echo implode(' e ', $lista_autores);?><?php endif;?>
          </small>
        </p>
      </div>
    </div>
    <div class="col-sm-3 col-xs-12">
      <p><a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" class="btn btn-default"><i class="fa fa-download"></i> Download
          desta publicação </a></p>

        <ul class="list-inline social-icons text-muted mt-0">
            <li class="social-icons-rounded">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_post_permalink(); ?>"
                   target="_blank"
                   class="btn btn-rounded text-muted"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Compartilhe no Facebook"><i
                        class="fa fa-facebook"></i></a>
            </li>
            <li class="social-icons-rounded">
                <a href="https://twitter.com/share?hashtags=pensandoodireito&text=<?php echo the_title(); ?>&url=<?php echo get_post_permalink(); ?>"
                   target="_blank"
                   class="btn btn-rounded text-muted"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Compartilhe no Twitter"><i
                        class="fa fa-twitter"></i></a>
            </li>
            <li class="social-icons-rounded">
                <a
                    href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_post_permalink()); ?>&summary=<?php echo urlencode(get_the_excerpt()); ?>&source=http://pensando.mj.gov.br"
                    target="_blank" class="btn btn-rounded text-muted"
                    data-toggle="tooltip"
                    data-placement="top" title="Compartilhe no Linkedin"><i
                        class="fa fa-linkedin"></i></a>
            </li>
        </ul>
    </div>
  </div>
</li>
<!-- fim card -->
