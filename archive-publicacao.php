<?php
get_header();

// Recuperando o "Post de Destaque", levando em consideração os filtros aplicados
$destaque_query_array = array(
    'post_type' => 'publicacao',
    'posts_per_page' => 1,
    'order' => 'DESC',
    'orderby' => 'meta_value_num',
    'meta_query' => array(
        array(
            'key'   => 'pub_number',
            'type' => 'NUMERIC'
        )
    )
);
if ( !empty($_POST) ) {
    if ( isset($_POST['filter-name']) ) {
        $destaque_query_array['s'] = $_POST['filter-name'];
    }
    if ( isset($_POST['sort-option']) ) {
        switch ($_POST['sort-option']) {
            case 'pub_number':
                $destaque_query_array['orderby'] = 'meta_value_num';
                $destaque_query_array['meta_key'] = 'pub_number';
                break;
            case 'title':
                $destaque_query_array['orderby'] = 'title';
                break;
        }
    } else {
      $pubs_args['orderby'] = 'meta_value_num';
      $pubs_args['meta_key'] = 'pub_number';
    }
    if ( isset($_POST['sort-order']) ) {
      $pubs_args['order'] = $_POST['sort-order'];
    } else {
      $pubs_args['order'] = 'DESC';
    }
}

query_posts($destaque_query_array);

$pub_ids = array();

//TODO: Como adicionar diversos autores e mostrá-los?
$autores = false;

//Função para filtrar o tamanho do 'excerpt'
//  focada na publicação em destaque
function custom_excerpt_length_530( $length ) {
  return 530;
}

//Função para filtrar o tamanho do 'excerpt'
//  focada nas publicações listadas
function custom_excerpt_length_200( $length ) {
  return 200;
}
add_filter( 'excerpt_length', 'custom_excerpt_length_530', 999 );

//Salvando ID da publicação em destaque
$destaqueID = get_the_ID();
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
                  <p><?php the_title_limit(70); ?></p>
                </div>
              </a>
            </div>
            <div class="description col-md-8">
              <h4 class="font-roboto red"><a href="<?php echo get_post_permalink(); ?>">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?></a></h4>
                <p><mark>Data: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?></mark></p>
                <p><?php the_excerpt(); ?><a href="<?php echo get_post_permalink(); ?>">Leia mais</a></p>
                <?php if ($autores) { ?>
                  <p>
                  </p> <?php } ?>
                <div class="row">
                  <div id="social-bar" class="col-md-4">
                    <?php get_template_part('part', 'social'); ?>
                  </div>
                  <div class="col-md-8 text-right">
                    <div class="btn-group mt-sm" role="group">
                      <div class="btn-group mt-sm" role="group">
                        <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                      </div>
                      <div class="btn-group mt-sm" role="group">
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
      <form id="sort-filter-form" action="<?php echo get_post_type_archive_link('publicacao'); ?>" method="post">
        <div class="row">
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="filter-name" class="form-control" placeholder="Buscar publicação..." value="<?php if (isset($_POST['filter-name']) && $_POST['filter-name'] != "") {
                echo $_POST['filter-name'];
              } ?>">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit" >Buscar</button>
              </span>
            </div><!-- /input-group -->
          </div> <!-- /col-lg -->
          <div class="col-sm-2">
            <div class="input-group">
              <select name="sort-option" class="form-control" onChange="jQuery('#sort-filter-form').submit();">
                <option disabled <?php
                  if (!isset($_POST['sort-option'])) {
                     echo 'selected';
                  } ?>>Ordenar por:</option>
                <option value="title" <?php
                  if (isset($_POST['sort-option']) && $_POST['sort-option'] == "title") {
                    echo 'selected';
                  } ?>>Nome</option>
                <option value="pub_number" <?php
                  if (isset($_POST['sort-option']) && $_POST['sort-option'] == "pub_number") {
                    echo 'selected';
                  } ?>>Volume</option>
              </select>
            </div><!-- /input-group -->
          </div> <!-- /col-lg -->
        </div>
      </form>
    </div>
    <div class="container mt-md">
      <div id="lista-publicacoes">
        <?php
          //Limitando tamanho do excerto apresentado
          add_filter( 'excerpt_length', 'custom_excerpt_length_200', 999 );

          $pubs_args = array(
            'post_type' => 'publicacao',
            'posts_per_page' => 8,
            'post__not_in' => array($destaqueID),
            'order' => 'DESC',
            'orderby' => 'meta_value_num',
            'meta_key' => 'pub_number'
          );
          if ( !empty($_POST) ) {
            if ( isset($_POST['filter-name']) ) {
              $pubs_args['s'] = $_POST['filter-name'];
            }
            if ( isset($_POST['sort-option']) ) {
              switch ($_POST['sort-option']) {
                case 'pub_number':
                  $pubs_args['orderby'] = 'meta_value_num';
                  $pubs_args['meta_key'] = 'pub_number';
                  break;
                case 'title':
                  $pubs_args['orderby'] = 'title';
                  break;
              }
            } else {
              $pubs_args['orderby'] = 'meta_value_num';
              $pubs_args['meta_key'] = 'pub_number';
            }
            if ( isset($_POST['sort-order']) ) {
              $pubs_args['order'] = $_POST['sort-order'];
            } else {
              $pubs_args['order'] = 'DESC';
            }
          }

          $publicacoes = new WP_Query ($pubs_args);

          $counter = 0;
          while ($publicacoes->have_posts()) : $publicacoes->the_post();
            if ($counter % 4 == 0) { ?> <div class="row"> <?php }
            get_template_part('publicacao','card');
            if (($counter + 1) % 4 == 0) { ?> </div> <?php }
                $counter++;
          endwhile;
        ?>
      </div>
      <script>
        var publicacoesPaginasMaximas = <?php echo $publicacoes->max_num_pages; ?>;
        var destaqueID = <?php echo $destaqueID; ?>;
      </script>
      <div class="row text-center">
        <button id="mais-publicacoes" type="button" class="btn btn-danger" onclick="carregar_publicacoes()">Mostrar mais publicações</button>
      </div>
    </div>
  </div>
</div>
<?php
get_footer();
