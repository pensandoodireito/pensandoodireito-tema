<?php
get_header();
// Recuperando o "Post de Destaque", levando em consideração os filtros aplicados
$destaque_query_array = array(
    'post_type' => 'publicacao',
    'post_status' => array( 'publish' ),
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

query_posts($destaque_query_array);

$pub_ids = array();
$current_page = isset($_GET['page'])?$_GET['page']:1;

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

$lista_autores = wp_cache_get('lista_autores');
$volumes = wp_cache_get('volumes');
if(!$lista_autores){

    // WP_Query arguments
    $args = array (
        'post_type'              => array( 'publicacao' ),
        'pagination'             => false,
        'posts_per_page'         => '-1',
        'post_status'            => array( 'publish' )
    );
    $query = new WP_Query( $args );

    $volumes = array();

    // The Loop
    $lista_autores = array();
    while ( $query->have_posts() ) {
        $query->the_post();
        $volumes[] = array(
            'vol' => 'Volume ' . str_pad(get_post_meta(get_the_ID(), 'pub_number', true),2,'0', STR_PAD_LEFT).' - '.get_the_title(),
            'download' => get_post_meta(get_the_ID(), 'pub_dld_file', true)
        );
        $lista_autores = array_merge(get_autores_from_excerpt(get_the_excerpt()), $lista_autores);
    }
    $lista_autores = array_unique($lista_autores);
    sort($lista_autores);

    wp_cache_add('lista_autores', $lista_autores, '', 60 * 60 * 4);

    sort($volumes);
    $volumes = array_reverse($volumes);
    wp_cache_add('volumes', $volumes, '', 60 * 60 * 4);
}

$default_params = array();
if(isset($_GET['sort-option'])){
    $default_params['sort-option'] = $_GET['sort-option'];
}

if(isset($_GET['sort-order'])){
    $default_params['sort-order'] = $_GET['sort-order'];
}

if(isset($_GET['filter-name'])){
    $default_params['filter-name'] = $_GET['filter-name'];
}

the_post();
//Salvando ID da publicação em destaque
$destaqueID = get_the_ID();
$numero_publicacao = get_post_meta(get_the_ID(), 'pub_number', true);
$total_pages = ceil(count($volumes) / 10)+1;

?>
<div id="publicacoes">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="font-roboto red">Publicações</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="header-categories">
                    <div class="container">
                        <ul class="list-unstyled list-categories">
                            <li class="categories-master">
                                <a href="<?php echo get_post_type_archive_link('publicacao');?>" class="categorie-link">Última publicação</a>
                            </li>
                            <li class="categories-master">
                                <?php
                                if(isset($_GET['sort-order'])){
                                    $new_order = $_GET['sort-order'] == 'ASC'?'DESC':'ASC';
                                }else{
                                    $new_order = 'ASC';
                                }
                                $new_params = $default_params;
                                $new_params['sort-order'] = $new_order;
                                ?>
                                <a href="/publicacoes?<?php echo http_build_query($new_params);?>" class="categorie-link">
                                    <?php echo $new_order=='ASC'?'Reordenar crescente':'Reordenar decrescente';?>
                                </a>
                                <span class="text-muted fontsize-sm"><?php echo $new_order=='ASC'? '(1 - 100)':'(100 - 1)';?></span>
                            </li>
                            <li class="dropdown categories-master">
                                <a href="#" class="categorie-link" id="menu-autores" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">Por autor <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="menu-autores">
                                    <li class="categories-master">
                                        <?php foreach($lista_autores as $autor):?>
                                        <a href="/publicacoes?filter-name=<?php echo urlencode($autor);?>" class="categorie-link"><?php echo $autor;?></a>
                                        <?php endforeach;?>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown categories-master indice-dropdown">
                                <a href="#" class="categorie-link" id="menu-indice" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">Índice <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="menu-indice">
                                    <li class="categories-master">
                                        <?php foreach($volumes as $volume):?>
                                            <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true);?>" class="categorie-link" title="<?php echo htmlentities($volume['vol']);?>" target="_blank">
                                                <?php
                                                $volume_parts = explode(' ', $volume['vol']);
                                                echo implode(' ', array_slice($volume_parts,0,10));
                                                if(count($volume_parts) > 10) {echo ' ...';}
                                                ?>
                                            </a>
                                        <?php endforeach;?>
                                    </li>
                                </ul>
                            </li>
                            <?php /*
                            <li class="dropdown categories-master">
                                <a href="#" class="categorie-link" id="menu-mais" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">Mais <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="menu-mais">
                                    <li class="categories-master in">
                                        <a href="<?php echo get_post_type_archive_link('publicacao');?>?sort-option=title" class="categorie-link">Por título</a>
                                    </li>
                                </ul>
                            </li>
                            */?>
                            <li class="col-sm-3 pull-right">
                                <form id="sort-filter-form" action="<?php echo get_post_type_archive_link('publicacao'); ?>" method="get">
                                    <div class="input-group">
                                        <input type="text" name="filter-name" class="form-control" placeholder="Buscar em publicações... " value="<?php if (isset($_GET['filter-name']) && $_GET['filter-name'] != "") {
                                            echo $_GET['filter-name'];
                                        } ?>">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                          </span>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Fim da Publicação em destaque -->
        </div>

        <?php
        if(empty($default_params)):
            $download_link = get_post_meta(get_the_ID(), 'pub_dld_file', true);
        ?>
        <div class="publicacoes-box mt-md">
            <div class="col-md-8">
                <h3><span class="red font-roboto">Última publicação</span>
                    <?php /**<small class="ml-lg fontsize-sm"><a href="#" class="blue">Todas as publicações</a></small> **/ ?>
                </h3>
                <div class="row mt-md">
                    <div class="col-sm-4">
                        <div class="capa-principal">
                            <p class="fontsize-lg"><strong>Série Pensando o Direito</strong></p>

                            <p class="fontsize-lg">Volume <br/> <span class="volume"><?php echo $numero_publicacao; ?></span></p>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="descricao">
                            <h4 class="red h3"><strong><?php the_title_limit(70);?></strong></h4>

                            <p><?php the_content(); ?></p>

                            <p>
                                <small class="text-muted">
                                    Publicado em: <?php echo get_post_meta(get_the_ID(), 'pub_date', true); ?><br/>
                                    <?php
                                    $autores_destaque = get_autores_from_excerpt(get_the_excerpt());
                                    if(!empty($autores_destaque)):?>
                                        Coordenação: <?php echo implode(' ', $autores_destaque);
                                    endif;?>
                                </small>
                            </p>
                        </div>
                        <div class="row divider-top">
                            <div class="col-md-6">
                                <a href="<?php echo $download_link;?>" class="btn btn-danger">
                                    <i class="fa fa-download"></i>
                                    Download volume <?php echo $numero_publicacao; ?>
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
                                        <a
                                            href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_post_permalink()); ?>&summary=<?php echo urlencode(get_the_excerpt()); ?>&source=http://pensando.mj.gov.br"
                                            target="_blank" class="btn btn-rounded text-muted"
                                            data-toggle="tooltip"
                                            data-placement="top" title="Compartilhe no Linkedin"><i
                                                class="fa fa-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php /** @todo quando existir página de autor exibirá foto do autor
            * <div class="col-md-4">
                * <!-- imagem do autor -->
                * <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/publicacoes/autor.jpg" class="img-adptive img-thumbnail autor" alt="Autor">
            * </div>**/
            ?>
            <div class="col-md-4">
                <div class="well publicacoes-oquee">
                    <h4 class="font-roboto red">
                        <strong>
                            Série Pensando o Direito:<br/>
                            O que são as Publicações?
                        </strong>
                    </h4>
                    <p>Desde a criação do Projeto Pensando o Direito, as pesquisas desenvolvidas
                        pelas
                        equipes contratadas resultam em relatórios completos e em publicações
                        resumidas
                        que sintetizam os principais dados levantados a partir dos processos de
                        investigação desenvolvidos.</p>

                    <p><strong><a href="#">Todas as publicações</a></strong></p>

                    <p><strong><a href="#">Editais de participacao</a></strong></p>
                </div>
            </div>

        </div>
        <div class="row mt-lg">
            <div class="col-lg-12">
                <h2 class="font-roboto red">Publicações anteriores</h2>
            </div>
        </div>
        <?php endif;?>
        <div class="row mt-lg">
            <div class="col-md-12">
                <ul class="list-unstyled publicacoes-list">
                    <?php
                    //Limitando tamanho do excerto apresentado
                    add_filter( 'excerpt_length', 'custom_excerpt_length_200', 999 );
                    $pubs_args = array(
                        'post_type' => 'publicacao',
                        'post_status' => array( 'publish' ),
                        'posts_per_page' => 10,
                        'paged' => $current_page,
                        'post__not_in' => array($destaqueID),
                        'order' => $order,
                        'orderby' => 'meta_value_num',
                        'meta_key' => 'pub_number'
                    );
                    if ( !empty($_GET) ) {
                        if ( isset($_GET['filter-name']) ) {
                            $pubs_args['s'] = $_GET['filter-name'];
                        }
                        if ( isset($_GET['sort-option']) ) {
                            switch ($_GET['sort-option']) {
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
                        if ( isset($_GET['sort-order']) ) {
                            $pubs_args['order'] = $_GET['sort-order'];
                        } else {
                            $pubs_args['order'] = 'DESC';
                        }
                    }

                    $publicacoes = new WP_Query ($pubs_args);

                    $counter = 0;
                    while ($publicacoes->have_posts()) : $publicacoes->the_post();
                        get_template_part('publicacao','card');
                        $counter++;
                    endwhile;
                    ?>
                    <?php if(!$publicacoes->have_posts()):?>
                    <li>Nenhum resultado encontrado.</li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
      <script>
        var publicacoesPaginasMaximas = <?php echo $publicacoes->max_num_pages; ?>;
        var destaqueID = <?php echo $destaqueID; ?>;
      </script>
    </div>
  </div>
</div>
<?php
get_footer();
