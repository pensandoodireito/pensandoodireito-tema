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
	$destaques            = new WP_Query( $destaque_query_array ); ?>

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
					<div class="fill has-background" style="background-image:url(<?php echo $background_img_url ?>)">
						<a href=" <?php echo get_post_meta( get_the_ID(), 'destaque_link', true ) ?>">
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

						<div class="fill has-background" style="background-image:url(<?php echo $src ?>)">
							<a href="<?php echo get_post_meta( get_the_ID(), 'destaque_link', true ) ?>"><span></span></a>
						</div>
						<?php
					}
				}
				if ( $texto_destaque ) { ?>
					<div class="carousel-caption">
						<p>
							<a href="<?php echo get_post_meta( get_the_ID(), 'destaque_link', true ) ?>"><?php echo $texto_destaque ?></a>
						</p>
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
<?php get_template_part( 'front', 'publicacoes' ); ?>
<?php get_footer(); ?>
