<?php
    get_header();

    $query_array = array ('post_type' => 'publicacao', 'posts_per_page' => 9);
    if(!empty($_POST)) {

        if (isset($_POST['filter-name'])) {
            $query_array['s'] = $_POST['filter-name'];
        }

        if (isset($_POST['sort-option'])) {
            switch($_POST['sort-option']) {
                case 'pub_number':
                    $query_array['orderby'] = 'meta_value_num';
                    $query_array['meta_key'] = 'pub_number';
                    break;
                case 'title':
                    $query_array['orderby'] = 'title';
                    break;
            }
            $query_array['order'] = 'ASC';
        }
    }
    query_posts( $query_array);

    //TODO: Como adicionar diversos autores e mostrá-los?
    $autores = false;
?>
    <div class="conteudo">
        <div class="container mt-sm">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="font-roboto red">
                    <a href="<?php echo site_url("/"); ?>"><?php echo get_bloginfo('title'); ?></a>
                    </h2>
                </div>
             </div>
        </div>
        <div class="container">
            <div class="row mt-md" id="publicacoes">
                <div class="col-md-8">
<!-- TODO: Automatizar a publicação em destaque.... Como? -->
                    <div class="panel panel-default" id="publicacao-destaque">
                      <div class="panel-heading">
<!-- TODO: colocar panel title, retornar para h3, remover mb-0 mt-0 -->
                        <h5 class="font-roboto red mb-0 mt-0">
                            Publicação em Destaque
                        </h5>
                      </div><?php the_post(); ?>
                      <div class="panel-body">
                        <div class="col-xs-6 col-md-4">
                            <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
                              <div class="destaque text-center">
                               <p><?php the_title(); ?></p>
                              </div>
                            </a>
                        </div>
                        <div class="description col-md-8">
                            <h4 class="font-roboto red"><a href="<?php echo get_post_permalink(); ?>">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></a></h4>
                            <p><mark>Data: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?></mark></p>
                            <p><?php the_excerpt(); ?><a href="<?php echo get_post_permalink(); ?>">Leia mais</a></p>
                            <?php if($autores) { ?><p><small><a href="#">Ver autores</a></small></p> <?php } ?>

                            <div class="row">
                             <div id="social-bar" class="col-md-4">
                                  <small>
                                    <a href="#" class="nounderline">
                                        <span class="fa-stack fa-lg">
                                          <i class="fa fa-square-o fa-stack-2x"></i>
                                          <i class="fa fa-facebook fa-stack-1x"></i>
                                        </span>
                                    </a>
                                  </small>
                                  <small>  
                                    <a href="#" class="nounderline">
                                        <span class="fa-stack fa-lg">
                                          <i class="fa fa-square-o fa-stack-2x"></i>
                                          <i class="fa fa-twitter fa-stack-1x"></i>
                                        </span>
                                    </a>
                                  </small>  
                                  <small>
                                    <a href="#" class="nounderline">
                                        <span class="fa-stack fa-lg">
                                          <i class="fa fa-square-o fa-stack-2x"></i>
                                          <i class="fa fa-linkedin fa-stack-1x"></i>
                                        </span>
                                    </a>
                                  </small>  
                             </div> 
                             <div class="col-md-8 text-right">
                                <div class="btn-group mt-sm" role="group">
                                    <div class="btn-group mt-sm" role="group">
                                        <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                                    </div>
                                    <div class="btn-group btn-danger mt-sm" role="group">
                                        <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default btn-danger">VISUALIZAR</a>
                                    </div>
                                </div>
                             </div>  
                           </div>   
                        </div>
                      </div>
                    </div><!-- Fim da Publicação em destaque -->
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default" id="info-publicacao">
                      <div class="panel-heading">
<!-- TODO: colocar panel title, retornar para h3, remover mb-0 mt-0 -->
                           <h5 class="font-roboto red mb-0 mt-0">Sobre Publicações</h5>
                      </div>
                      <div class="panel-body">
                        <div class="description">
                            <p>Apresentamos aqui a Série Pensando o Direito: pesquisas que partem da observação da realidade e do diálogo entre mais de um campo do saber para compreender grandes temas e orientar o governo em sua capacidade de atuar  sobre a vida dos cidadãos por meio de políticas públicas.</p>
                            <p>Pensar o Direito não significa teorizá-lo, mas buscar, na prática, respostas que possam colaborar para a criação e para o aperfeiçoamento de leis e instituições. Com dados concretos, estas publicações apresentam soluções de real potencial transformador, contribuindo para a consolidação do processo democrático de produção de normas. Esse é o objetivo do Ministério da Justiça.</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="container mt-sm">
           <form id="sort-filter-form" action="/pensandoodireito/publicacao" method="post">
                <div class="row">
                  <div class="col-sm-10">
                   <div class="input-group">
                      <input type="text" name="filter-name" class="form-control" placeholder="Buscar publicação..." value="<?php if(isset($_POST['filter-name']) && $_POST['filter-name']!=""){echo $_POST['filter-name'];}?>">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" >Buscar</button>
                      </span>
                    </div><!-- /input-group -->
                </div> <!-- /col-lg -->
                <div class="col-sm-2">
                 <div class="input-group">
                      <select name="sort-option" class="form-control" onChange="jQuery('#sort-filter-form').submit();">
                          <option disabled <?php if(!isset($_POST['sort-option'])){ echo 'selected';}?>>Ordenar por:</option>
                          <option value="title" <?php if(isset($_POST['sort-option']) && $_POST['sort-option'] == "title"){ echo 'selected';}?>>Nome</option>
                          <option value="pub_number" <?php if(isset($_POST['sort-option']) && $_POST['sort-option'] == "pub_number"){ echo 'selected';}?>>Volume</option>
                      </select>
                    </div><!-- /input-group -->
                 </div> <!-- /col-lg -->
                </div>
           </form>
        </div>
        <div class="container mt-md">
            <div id="lista-publicacoes">
            <?php
                $counter = 0;
                while (have_posts()) : the_post();
                    $ids[] = get_the_ID();
                    if ($counter % 4 == 0) { ?> <div class="row"> <?php } ?>

                    <!-- inicio card -->
                    <div class="col-sm-3">
                        <div class="thumbnail">
                        <a href="<?php echo get_post_permalink(); ?>" class="nounderline">
                           <div class="capa">
                            <div class="ribbon-wrapper">
                              <div class="ribbon">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></div>
                            </div>
                            <div class="card">
                            <p><?php the_title(); ?></p>
                            </div>
                           </div>
                        </a>
                          <div class="caption small">
                            <h6><a href="<?php echo get_post_permalink(); ?>">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?> | <?php the_title(); ?></a></h6>
                            <p><mark>Data: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?></mark></p>
                            <p><?php the_excerpt(); ?></p><?php if($autores) { ?><p><small><a href="#">Ver autores</a></small></p> <?php } ?>

                             <div id="social-bar">
                                  <small>
                                    <a href="#" class="nounderline">
                                        <span class="fa-stack fa-lg">
                                          <i class="fa fa-square-o fa-stack-2x"></i>
                                          <i class="fa fa-facebook fa-stack-1x"></i>
                                        </span>
                                    </a>
                                  </small>
                                  <small>
                                    <a href="#" class="nounderline">
                                        <span class="fa-stack fa-lg">
                                          <i class="fa fa-square-o fa-stack-2x"></i>
                                          <i class="fa fa-twitter fa-stack-1x"></i>
                                        </span>
                                    </a>
                                  </small>
                                  <small>
                                    <a href="#" class="nounderline">
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
                                  if( ! empty($dld_file)) { ?>
                                      <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                                  <?php } else { ?>
                                      <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                                  <?php }?>
                              </div>
                              <div class="btn-group btn-danger mt-sm" role="group">
                                  <a href="<?php echo get_post_permalink(); ?>" class="btn btn-default btn-danger">VISUALIZAR</a>
                              </div>
                          </div>
                        </div>
                    </div>
                    <!-- fim card -->

                    <?php if (($counter+1) % 4 == 0) { ?> </div> <?php }
                    $counter++;
                endwhile;
            ?>
                <div class="row text-center">
                  <button type="button" class="btn btn-danger">Mostrar mais publicações</button>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();