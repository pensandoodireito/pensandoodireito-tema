<section id="destaque-home-debates">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="font-roboto red">Debates</h3>
            </div>
            <div class="col-md-6 text-right">
                <p class="mt-sm">
                <strong class="mt-xs ml-md"><a href="<?php echo get_post_type_archive_link('debate'); ?>">Veja todos os debates</a></strong>
                </p>
            </div>
        </div>
        <div class="row" id="debates-home">
            <?php

            $debates = new WP_Query( array('post_type' => 'debate') );

            while ( $debates->have_posts() ) {
                $debates->the_post();

                $debate_link = get_post_meta(get_the_ID(), 'debate_link', true);
                $imagem = get_post_meta(get_the_ID(), 'imagem', true);
                $status = get_post_meta(get_the_ID(), 'debate_aberto', true);

            ?>
            <div class="col-sm-4 debate-box">
                <div class="">
                    <div class="text-center">
                        <a href="<?php echo $debate_link ?>"><?php the_post_thumbnail('medium', array( 'class' => 'img-full' )) ?></a>
                    </div>
                    <div class="description">
                        <strong class="red"><a href="<?php echo $debate_link; ?>"><?php the_title(); ?></a></strong><?php echo $status; ?><span></span>
                        <p><small><?php the_excerpt(); ?></small></p>
                    </div>
                </div>
            </div>
            <?php
            }

            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>