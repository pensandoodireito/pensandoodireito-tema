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
	<section id="publicacoes">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="font-roboto red">Série Pensando o Direito:
						<a href="<?php echo site_url( "/publicacoes" ); ?>">Publicações</a>
					</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="publicacoes-box mt-md">
						<div class="col-md-8">
							<h3><span class="red font-roboto">Última publicação</span>
								<small class="ml-lg fontsize-sm">
									<a href="<?php echo site_url( "/publicacoes" ); ?>" class="blue">
										Todas as publicações
									</a>
								</small>
							</h3>

							<div class="row mt-md">
								<div class="col-sm-4">
									<div class="capa capa-principal">
										<p class="fontsize-lg"><strong>Série Pensando o Direito</strong></p>

										<p class="fontsize-lg">
											Volume <br/>
											<span class="volume">
												<?php echo get_post_meta( get_the_ID(), 'pub_number', true ); ?>
											</span>
										</p>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="descricao">
										<h4 class="red"><strong><?php the_title(); ?></strong></h4>

										<p><?php the_content(); ?></p>

										<p>
											<small class="text-muted">
												Publicado em:
												<?php echo get_post_meta( get_the_ID(), 'pub_date', true ); ?>
												<?php $coordenacao = get_post_meta( get_the_ID(), 'pub_coordenacao', true ); ?>
												<?php if ( $coordenacao ) { ?>
													<br/>
													Coordenação: <?php echo $coordenacao; ?>
												<?php } ?>
											</small>
										</p>
									</div>
									<div class="row divider-top">
										<div class="col-md-6">
											<a href="<?php echo get_post_meta( get_the_ID(), 'pub_dld_file', true ); ?>"
											   class="btn btn-danger" target="_blank"><i class="fa fa-download"></i>
												Download volume <?php echo get_post_meta( get_the_ID(), 'pub_number', true ); ?>
											</a>
										</div>
										<div class="col-md-6">
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
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_post_permalink()); ?>&summary=<?php echo urlencode(get_the_excerpt()); ?>&source=http://pensando.mj.gov.br"
                                                       target="_blank" class="btn btn-rounded text-muted"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="Compartilhe no Linkedin"><i class="fa fa-linkedin"></i></a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="well publicacoes-oquee">

								<h4 class="font-roboto red">
									<strong>
										Série Pensando o Direito:<br/>
										O que são as Publicações?
									</strong>
								</h4>

								<p>
									Desde a criação do Projeto Pensando o Direito, as pesquisas desenvolvidas
									pelas equipes contratadas resultam em relatórios completos e em publicações
									resumidas que sintetizam os principais dados levantados a partir dos processos de
									investigação desenvolvidos.
								</p>

								<p>
									<strong>
										<a href="<?php echo site_url( "/publicacoes" ); ?>">Todas as publicações</a>
									</strong>
								</p>

								<p>
									<strong>
										<a href="<?php echo site_url( "/editais" ); ?>">Editais</a>
									</strong>
								</p>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>