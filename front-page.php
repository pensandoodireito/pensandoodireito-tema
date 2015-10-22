<?php get_header(); ?>

	<div class="conteudo">
		<?php
		$destaque_query_array = array(
			'post_type'  => 'destaque',
			'meta_query' => array(
				array(
					'key'     => 'destaque_ativo',
					'value'   => '1',
					'compare' => '=',
				)
			)
		);
		$destaques = new WP_Query( $destaque_query_array ); ?>

		<div id="destaque-home" class="carousel slide" data-ride="carousel">
			<?php if ( $destaques->found_posts > 1 ) { ?>
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php
					$counter = 0;
					while ( $counter < count( $destaques->posts ) ) {
						echo '<li data-target="#carousel-destaques-home" data-slide-to="' . $counter . '"';
						if ( $counter == 0 ) {
							echo ' class="active"';
						}
						echo '" data-pause="true">';
						$counter ++;
					}
					?>
				</ol>
			<?php } ?>

			<!-- Wrapper for Slides -->
			<div class="carousel-inner" role="listbox">
                <?php
                $first_item = true;
                while ( $destaques->have_posts() ) {
                echo '<div class="item';
                if ( $first_item ) {
                    echo ' active';
                    $first_item = false;
                }
                echo '">';

                $destaques->the_post();
                $modelo_destaque = get_post_meta( get_the_ID(), 'modelo_destaque', true );
                $isVideo         = ( $modelo_destaque == 'video_texto' || $modelo_destaque == 'video_full' );

                if ( $isVideo ) { ?>
                    <div class="fill">
                        <?php echo do_shortcode( '<iframe src="http://www.youtube.com/embed/' . getYoutubeIdFromUrl( get_post_meta( get_the_ID(), 'midia_destaque', true ) ) . '" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>' ); ?>
                    </div>
                    <?php
                } else { //is image :)

                    $background_img_url = get_post_meta( get_the_ID(), 'background_img_url', true );
                    $texto_destaque     = get_post_meta( get_the_ID(), 'destaque_texto', true );
                    if ( $background_img_url ) { ?>
                        <div class="fill has-background" style="background-image:url(<?php echo  $background_img_url ?>)">
                            <a href=" <?php echo  get_post_meta( get_the_ID(), 'destaque_link', true ) ?>">
                                <?php the_post_thumbnail( 'post-thumbnail', array(
                                    'class' => 'img-adptive',
                                    'alt'   => 'destaque'
                                ) ); ?>
                            </a>
                        </div>
                        <?php
                    } else {
                        $bgImage = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'post-thumbnail' );

                        if ( $bgImage ) {
                            list( $src, $width, $height ) = $bgImage; ?>

                            <div class="fill has-background" style="background-image:url(<?php echo  $src ?>)">
                                <a href="<?php echo  get_post_meta( get_the_ID(), 'destaque_link', true ) ?>"><span></span></a>
                            </div>
                            <?php
                        }
                    }
                    if ( $texto_destaque ) { ?>
                        <div class="carousel-caption">
                            <p><a href="<?php echo  get_post_meta( get_the_ID(), 'destaque_link', true ) ?>"><?php echo  $texto_destaque ?></a></p>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
		<?php } ?>
		</div>

		<?php if ( $destaques->found_posts > 1 ) { ?>
			<!-- Controls -->
			<a class="left carousel-control" href="#destaque-home" data-slide="prev">
				<span class="icon-prev"></span>
			</a>
			<a class="right carousel-control" href="#destaque-home" data-slide="next">
				<span class="icon-next"></span>
			</a>
		<?php } ?>
	</div>


<?php get_template_part( 'front', 'noticias' ); ?>
<?php get_template_part( 'destaque', 'debates' ); ?>
<?php get_template_part( 'mini-tutorial' ); ?>
<?php
$fp_pub_query = new WP_Query( array(
	'post_type'      => 'publicacao',
	'posts_per_page' => 1,
	'order'          => 'DESC',
	'orderby'        => 'meta_value_num',
	'meta_query'     => array(
		array(
			'key'  => 'pub_number',
			'type' => 'NUMERIC'
		)
	)
) );

if ( $fp_pub_query->have_posts() ) {
	$fp_pub_query->the_post(); ?>
	<div class="container">
		<div class="row mt-lg" id="publicacoes">
			<div class="col-md-8" id="publicacao-destaque">
				<h2 class="font-roboto red">Publicações da Série Pensando o Direito</h2>

				<div class="row mt-md">
					<div class="col-xs-12 col-sm-4 text-center">
						<a href="<?php echo get_post_permalink(); ?>" class="nounderline">
							<div class="destaque text-center">
								<p><?php the_title(); ?></p>
							</div>
						</a>
					</div>
					<div class="description col-xs-12 col-sm-8">
						<a href="<?php echo get_post_permalink(); ?>" class="nounderline">
							<h4 class="font-roboto red">
								Volume <?php echo get_post_meta( get_the_ID(), 'pub_number', true ); ?></h4>
						</a>

						<p>
							<mark>Data da
								publicação: <?php echo get_post_meta( get_the_ID(), 'pub_date', true ); ?></mark>
						</p>
						<p><?php the_excerpt(); ?> <a href="<?php echo get_post_permalink(); ?>">Leia mais</a></p>

						<div class="row">
							<div class="col-md-12 text-left">
								<div class="btn-group mt-sm" role="group">
									<?php
									$dld_file = get_post_meta( get_the_ID(), 'pub_dld_file', true );
									if ( ! empty( $dld_file ) ) { ?>
										<a href="<?php echo get_post_meta( get_the_ID(), 'pub_dld_file', true ); ?>"
										   class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
									<?php } else { ?>
										<a href="<?php echo get_post_permalink(); ?>" class="btn btn-default"><span
												class="fa fa-download"></span> BAIXAR</a>
									<?php } ?>
									<a href="<?php echo get_post_permalink(); ?>" class="btn btn-danger">VISUALIZAR</a>
								</div>
								<p class="mt-md"><a href="<?php echo site_url( "/publicacoes" ); ?>"><strong>Todas as
											publicações</strong></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }
get_footer(); ?>