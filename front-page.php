<?php get_header(); ?>
<div class="conteudo">
	<section id="destaque-home">
		<div class="container">
			<div id="carousel-destaques-home" class="carousel slide" data-ride="carousel">
				<!-- indicadores -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-destaques-home" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-destaques-home" data-slide-to="1"></li>
					<li data-target="#carousel-destaques-home" data-slide-to="2"></li>
				</ol>
				<!-- Divs do carrossel -->
				<div class="carousel-inner" role="listbox">
					<div class="item">
						<div class="row">
							<div class="col-lg-12">
								<a href="<?php echo get_post_type_archive_link('pauta'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icone-debates.png" class="img-full" alt="Debate"></a>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row">
							<div class="col-md-8">
								<div class="embed-responsive embed-responsive-16by9">
									<iframe width="100%" height="100%" src="//www.youtube.com/embed/-w-58hQ9dLk?controls=0" frameborder="0" allowfullscreen=""></iframe>
								</div>
							</div>
							<div class="col-md-4 mt-lg"><p class="h1 font-roboto mt-lg">
								<a href="">Lorem ipsum dolor</a>
							</p></div>
						</div>
					</div>
					<div class="item active">
						<div class="row">
							<div class="col-md-4 mt-lg">
								<p class="h1 font-roboto mt-lg">
									<a href="">Lorem ipsum dolor</a>
								</p>
							</div>
							<div class="col-md-8">
								<a href="<?php echo get_post_type_archive_link('pauta'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icone-debates.png" class="img-full" alt="Debate"></a>
							</div>
						</div>
					</div>
					
				</div>
				<!-- Controles -->
				<a class="left carousel-control" href="#carousel-destaques-home" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Anterior</span>
				</a>
				<a class="right carousel-control" href="#carousel-destaques-home" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Próximo</span>
				</a>
			</div>
		</div>
	</section>
	<?php get_template_part('destaque', 'debates'); ?>
	<?php get_template_part('mini-tutorial'); ?>
	<?php get_template_part('front', 'noticias'); ?>
	<?php
	$fp_pub_query = new WP_Query(array (
	'post_type' => 'publicacao',
	'posts_per_page' => 1));
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
			<div class="col-md-4">
				<div class="well box-publicacao">
					<h5 class="red">Saiba mais sobre a série Pensando o Direito</h5>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet cursus metus, nec feugiat sablandit diam facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet</p>
					<strong><a href="<?php echo get_post_type_archive_link('publicacao'); ?>">Todas as publicações</a></strong></br>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }
get_footer(); ?>