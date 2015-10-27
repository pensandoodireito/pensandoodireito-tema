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
						Volume <?php echo get_post_meta( get_the_ID(), 'pub_number', true ); ?>
					</div>
				</div>
				<div class="card">
					<p><?php the_title_limit( 70 ); ?></p>
				</div>
			</div>
		</a>

		<div class="caption small">
			<h6>
				<a href="<?php echo get_post_permalink(); ?>">
					Volume <?php echo get_post_meta( get_the_ID(), 'pub_number', true ); ?>
					| <?php the_title(); ?>
				</a>
			</h6>

			<p>
				<mark>Data: <?php echo get_post_meta( get_the_ID(), 'pub_date', true ); ?></mark>
			</p>
			<div class="description-publicacao">
				<p><?php the_excerpt(); ?></p>
			</div>
			<?php if ( $autores ) { ?>

				<p>
					<small><a href="#">Ver autores</a></small>
				</p>
			<?php } ?>
			<div class="social-bar">
				<?php get_template_part( 'part', 'social' ); ?>
			</div>
			</br>
			<div class="btn-group mt-sm" role="group">
				<?php
				$dld_file = get_post_meta( get_the_ID(), 'pub_dld_file', true );
				if ( ! empty( $dld_file ) ) { ?>
					<a href="<?php echo get_post_meta( get_the_ID(), 'pub_dld_file', true ); ?>"
					   class="btn btn-default">
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