<?php
    $sb_pub_query = new WP_Query(array (
        'post_type' => 'publicacao',
        'posts_per_page' => 4,
        'post__not_in' => array($post->ID)));
    if( $sb_pub_query->have_posts() ) { ?>
        <h6>Outras Publicações:</h6>
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-unstyled">
                    <?php while ($sb_pub_query->have_posts()) : $sb_pub_query->the_post(); ?>
                        <li class=" tooltiped"
                            alt="<?php
                            $myExcerpt = get_the_excerpt();
                            $tags = array("<p>", "</p>");
                            $myExcerpt = str_replace($tags, "", $myExcerpt);
                            echo $myExcerpt;
                            ?>"
                            title="<?php
                            $myExcerpt = get_the_excerpt();
                            $tags = array("<p>", "</p>");
                            $myExcerpt = str_replace($tags, "", $myExcerpt);
                            echo $myExcerpt;
                            ?>">
                            <!-- card lateral -->
                            <a href="<?php echo get_post_permalink(); ?>"
                               class="nounderline tooltiped"
                               alt="<?php
                               $myExcerpt = get_the_excerpt();
                               $tags = array("<p>", "</p>");
                               $myExcerpt = str_replace($tags, "", $myExcerpt);
                               echo $myExcerpt;
                               ?>"
                               title="<?php
                               $myExcerpt = get_the_excerpt();
                               $tags = array("<p>", "</p>");
                               $myExcerpt = str_replace($tags, "", $myExcerpt);
                               echo $myExcerpt;
                               ?>">
                                <div class="capa tooltiped mt-md"
                                     alt="<?php
                                     $myExcerpt = get_the_excerpt();
                                     $tags = array("<p>", "</p>");
                                     $myExcerpt = str_replace($tags, "", $myExcerpt);
                                     echo $myExcerpt;
                                     ?>"
                                     title="<?php
                                     $myExcerpt = get_the_excerpt();
                                     $tags = array("<p>", "</p>");
                                     $myExcerpt = str_replace($tags, "", $myExcerpt);
                                     echo $myExcerpt;
                                     ?>">
                                    <div class="card tooltiped"
                                         alt="<?php
                                         $myExcerpt = get_the_excerpt();
                                         $tags = array("<p>", "</p>");
                                         $myExcerpt = str_replace($tags, "", $myExcerpt);
                                         echo $myExcerpt;
                                         ?>"
                                         title="<?php
                                         $myExcerpt = get_the_excerpt();
                                         $tags = array("<p>", "</p>");
                                         $myExcerpt = str_replace($tags, "", $myExcerpt);
                                         echo $myExcerpt;
                                         ?>">
                                        <p><?php the_title_limit(70); ?></p>
                                    </div>
                                </div>
                            </a>
                            <!-- /card lateral -->
                        </li>
                    <?php endwhile; ?>
                <ul>
                <a href="<?php echo get_post_type_archive_link('publicacao'); ?>" class="btn btn-link" >Ver todas</a>
            </div> <!-- panel body -->
        </div> <!-- panel -->
    <?php }
 ?>
