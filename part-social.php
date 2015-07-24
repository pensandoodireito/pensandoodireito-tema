<small>
    <a href="#" onClick="event.preventDefault(); window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo get_post_permalink(); ?>','Facebook');" class="nounderline">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-facebook fa-stack-1x"></i>
            </span>
    </a>
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