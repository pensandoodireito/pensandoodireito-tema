<?php

// this adds jquery tooltip and styles it
function pensandoodireito_scripts() {
    wp_enqueue_script( 'pensandoodireto', get_stylesheet_directory_uri() . '/js/pensandoodireito.js' , array(), false, true );
}
add_action( 'admin_enqueue_scripts', 'pensandoodireito_scripts' );

//Script to ajax load more publicacoes
function publicacoes_scripts() {
  wp_enqueue_script( 'publicacoes', get_stylesheet_directory_uri() . '/js/publicacoes.js' , array(), false, true );
  $publicacoes_data = array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'paginaAtual' => 3,
    'ajaxgif' => get_template_directory_uri() . '/images/ajax-loader.gif'
  );

  wp_localize_script( 'publicacoes', 'publicacoes', $publicacoes_data );
}
add_action( 'wp_enqueue_scripts', 'publicacoes_scripts' );

/**
 * Registar post type publicação
 */
function publicacao_post_type() {

    $labels = array(
        'name'                => _x( 'Publicações', 'Post Type General Name', 'pensandooodireito' ),
        'singular_name'       => _x( 'Publicação', 'Post Type Singular Name', 'pensandooodireito' ),
        'menu_name'           => __( 'Publicações', 'pensandooodireito' ),
        'parent_item_colon'   => __( 'Publicação pai:', 'pensandooodireito' ),
        'all_items'           => __( 'Todas as publicações', 'pensandooodireito' ),
        'view_item'           => __( 'Ver publicação', 'pensandooodireito' ),
        'add_new_item'        => __( 'Adicionar publicação', 'pensandooodireito' ),
        'add_new'             => __( 'Adicionar nova', 'pensandooodireito' ),
        'edit_item'           => __( 'Editar Publicação', 'pensandooodireito' ),
        'update_item'         => __( 'Atualizar Publicação', 'pensandooodireito' ),
        'search_items'        => __( 'Buscar publicação', 'pensandooodireito' ),
        'not_found'           => __( 'Não enconrtado', 'pensandooodireito' ),
        'not_found_in_trash'  => __( 'Não encontrado na lixeira', 'pensandooodireito' ),
    );

    $supports = array(
        'title',
        'editor',
        'excerpt',
        'thumbnail',
        'comments',
        'trackbacks',
        'revisions',
        'custom-fields',
    );

    $args = array(
        'label'               => __( 'publicacao', 'pensandooodireito' ),
        'description'         => __( 'Publicações do Pensando o Direito', 'pensandooodireito' ),
        'labels'              => $labels,
        'supports'            => $supports,
        'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'register_meta_box_cb' => 'add_publicacao_metaboxes', //Para adicionar novos campos
        'rewrite'             => array( 'slug' => 'publicacoes', 'with_front' => false),
    );

    // this adds jquery datepicker and styles it
    function dp_styles() {
        wp_enqueue_style('jquery-ui-datepicker-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }
    add_action('admin_print_styles', 'dp_styles');
    function dp_scripts() {
        wp_enqueue_script('jquery-ui-datepicker');
    }
    add_action( 'admin_enqueue_scripts', 'dp_scripts' );

    // Metaboxes adicionadas seguindo o tutorial: http://wptheming.com/2010/08/custom-metabox-for-post-type/
    // and also thanks to @sterndata at #wordpress irc channel for the help
    // http://wpbin.io/dfwy8d
    function add_publicacao_metaboxes() {
        // Adiciona um campo para data da oficial da publicação, independente da data do post.
        add_meta_box('wpt_publicacao_data','Dados da Publicação', 'wpt_publicacao_data', 'publicacao', 'side', 'high');
        // Adiciona um campo para anexar a versão as versões "web" e para Download da Publicação
        add_meta_box('wpt_publicacao_files','Arquivos da Publicação', 'wpt_publicacao_files', 'publicacao', 'side', 'high');
        // Adiciona um campo para anexar a versão para Download da Publicação
        //add_meta_box('wpt_publicacao_dld_version','Versão para download', 'wpt_publicacao_dld_version', 'publicacao', 'side', 'high');
    }

    //Geração do HTML das metaboxes
    function wpt_publicacao_data() {
        global $post;

        // Campo necessário para verificar origem do dado
        echo '<input type="hidden" name="publicacaometa_noncename" id="publicacaometa_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

        // Recupera a variáveis, se já adicionadas
        $pub_date = get_post_meta($post->ID, 'pub_date', true);
        $pub_number = get_post_meta($post->ID, 'pub_number', true);

        // Imprime o campo para Número da Publicação
        echo '<p><label>Número da Publicação</label><input type="number" name="pub_number" value="' . $pub_number . '" class="" required /></p>';

        // Imprime o campo para Data da Publicação
        echo '<p><label>Data da Publicação</label><input type="text" name="pub_date" value="' . $pub_date . '" class="datePick" required /></p>';
    }

    //Geração do HTML para upload dos arquivos
    function wpt_publicacao_files(){
        global $post;

        $pub_web_file = get_post_meta($post->ID, 'pub_web_file', true);
        $pub_dld_file = get_post_meta($post->ID, 'pub_dld_file', true);

        // Recupera arquivos caso já tenha sido adicionados
        //TODO: HOW TO RETRIEVE ALREADY UPDATED FILES, SO I CAN UPDATE THE POST WITHOU UPLOADING FILES AGAIN?
        $html  = "<p><label>Versão Web</label>";
        if( $pub_web_file ) {
            $html .= "<br/><a href='" . $pub_web_file . "' target='_blank'>Arquivo Atual</a>";
        }
        $html .= "<input type='file' name='pub_web_file' id='pub_web_file' value='' size='25'/></p>";
        $html .= "<p><label>Versão para Download</label>";
        if( $pub_dld_file ) {
            $html .= "<br/><a href='" . $pub_dld_file . "' target='_blank'>Arquivo Atual</a>";
        }
        $html .= "<input type='file' name='pub_dld_file' id='pub_dld_file' value='' size='25'/></p>";
        echo $html;
    }

    // Save the Metabox Data
    function wpt_save_publicacao_meta($post_id, $post) {

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !isset($_POST['publicacaometa_noncename']) || !wp_verify_nonce( $_POST['publicacaometa_noncename'], plugin_basename(__FILE__) )) {
            return $post->ID;
        }

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if ( !current_user_can( 'edit_post', $post->ID ))
            return $post->ID;

        // OK, we're authenticated: we need to find and save the data
        // We'll put it into an array to make it easier to loop though.
        $publicacao_meta['pub_date'] = $_POST['pub_date'];
        $publicacao_meta['pub_number'] = $_POST['pub_number'];

        // Make sure the file array isn't empty
        if(!empty($_FILES['pub_web_file']['name']) && !empty($_FILES['pub_dld_file']['name'])) {

            // Setup the array of supported file types. In this case, it's just PDF.
            $supported_types = array('application/pdf');

            // Get the file type of the upload
            $arr_web_file_type = wp_check_filetype(basename($_FILES['pub_web_file']['name']));
            $uploaded_web_type = $arr_web_file_type['type'];
            $arr_dld_file_type = wp_check_filetype(basename($_FILES['pub_dld_file']['name']));
            $uploaded_dld_type = $arr_dld_file_type['type'];

            // Check if the type is supported. If not, throw an error.
            if( !in_array($uploaded_web_type, $supported_types) ) {
                //TOOD: Improve this message
                wp_die("O arquivo para web não é um PDF (formato permitido).");
            }
            if( !in_array($uploaded_dld_type, $supported_types) ){
                //TOOD: Improve this message
                wp_die("O arquivo para download não é um PDF (formato permitido).");
            }

            // Use the WordPress API to upload the file
            $upload_web = wp_upload_bits($_FILES['pub_web_file']['name'], null, file_get_contents($_FILES['pub_web_file']['tmp_name']));
            $upload_dld = wp_upload_bits($_FILES['pub_dld_file']['name'], null, file_get_contents($_FILES['pub_dld_file']['tmp_name']));

            if(isset($upload_web['error']) && $upload_web['error'] != 0) {
                wp_die('Erro ao salvar arquivo para Web. O erro foi: ' . $upload['error']);
            } else {
                $publicacao_meta['pub_web_file'] = $upload_web['url'];
            }
            if(isset($upload_dld['error']) && $upload_dld['error'] != 0) {
                wp_die('Erro ao salvar arquivo para Download. O erro foi: ' . $upload['error']);
            } else {
                $publicacao_meta['pub_dld_file'] = $upload_dld['url'];
            }
        }

        // Add values of $events_meta as custom fields
        foreach ($publicacao_meta as $key => $value) { // Cycle through the $events_meta array!
            if( $post->post_type == 'revision' ) return; // Don't store custom data twice
            $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
            if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
                update_post_meta($post->ID, $key, $value);
            } else { // If the custom field doesn't have a value
                add_post_meta($post->ID, $key, $value);
            }
            if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
        }

    }
    add_action('save_post', 'wpt_save_publicacao_meta', 1, 2); // save the custom fields

    function pensandoodireito_update_edit_form() {
        echo ' enctype="multipart/form-data"';
    } // end update_edit_form
    add_action('post_edit_form_tag', 'pensandoodireito_update_edit_form');

    //Registrando o post-type Publicação
    register_post_type( 'publicacao', $args );

}

// Iniciarlizar publicação.
add_action( 'init', 'publicacao_post_type', 0 );

/**
 * Register Arquivo Debate Custom Post Type
 **/
function arq_debate_post_type() {

    $labels = array(
        'name'                => _x( 'Debates', 'Post Type General Name', 'pensandoodireito' ),
        'singular_name'       => _x( 'Debate', 'Post Type Singular Name', 'pensandoodireito' ),
        'menu_name'           => __( 'Debates', 'pensandoodireito' ),
        'name_admin_bar'      => __( 'Debates', 'pensandoodireito' ),
        'parent_item_colon'   => __( 'Debate pai:', 'pensandoodireito' ),
        'all_items'           => __( 'Todos debates', 'pensandoodireito' ),
        'add_new_item'        => __( 'Adicionar novo debate', 'pensandoodireito' ),
        'add_new'             => __( 'Adicionar novo', 'pensandoodireito' ),
        'new_item'            => __( 'Novo debate', 'pensandoodireito' ),
        'edit_item'           => __( 'Editar debate', 'pensandoodireito' ),
        'update_item'         => __( 'Atualizar debate', 'pensandoodireito' ),
        'view_item'           => __( 'Ver debate', 'pensandoodireito' ),
        'search_items'        => __( 'Buscar debate', 'pensandoodireito' ),
        'not_found'           => __( 'Não encontrado', 'pensandoodireito' ),
        'not_found_in_trash'  => __( 'Não encontrado na lixeira', 'pensandoodireito' ),
    );
    $args = array(
        'label'               => __( 'debate', 'pensandoodireito' ),
        'description'         => __( 'Descrição do Debate', 'pensandoodireito' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'register_meta_box_cb' => 'add_debate_metaboxes', //Para adicionar novos campos
        'rewrite'             => array( 'slug' => 'debate', 'with_front' => false),
    );

    // Metaboxes adicionadas seguindo o tutorial: http://wptheming.com/2010/08/custom-metabox-for-post-type/
    // and also thanks to @sterndata at #wordpress irc channel for the help
    // http://wpbin.io/dfwy8d
    function add_debate_metaboxes() {
        add_meta_box('pd_debate_status', 'Debate aberto', 'pd_debate_status', 'debate', 'side', 'high');
        add_meta_box('pd_debate_imagem', 'Imagem do debate', 'pd_debate_imagem', 'debate', 'side', 'default');
        add_meta_box('pd_debate_detalhes', 'Detalhes do debate', 'pd_debate_detalhes', 'debate', 'normal', 'default');
    }

    function pd_debate_status($post) {
        echo '<input type="hidden" name="debatemeta_noncename" id="debatemeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
        wp_enqueue_script( 'pensandoodireto', get_stylesheet_directory_uri() . '/js/pensandoodireito.js' , array(), false, true );
        wp_enqueue_media();

        $debate_aberto = get_post_meta($post->ID, 'debate_aberto', true);
        echo '<input type="radio" name="debate_aberto" id="debate_aberto" ';
        if ($destaque_ativo == "aberto") {
            echo 'checked';
        }
        echo ' value="aberto"/> Aberto<br/>';
        echo '<input type="radio" name="debate_aberto" id="debate_encerrado" ';
        if ($destaque_ativo != "aberto") {
            echo 'checked';
        }
        echo ' value="encerrado"/> Encerrado';
    }

    function pd_debate_imagem($post) {

        $imagem = get_post_meta($post->ID, 'imagem', true);

        $midia_html = '<label for="imagem">';

        $midia_html .= '<input id="upload_debate_image_button" class="button midia_imagem" type="button" value="Selecione a Imagem"/>';
        $midia_html .= '<input id="imagem" type="text" size="25" name="imagem" value="' . $imagem . '"/>';
        $midia_html .= '<br/>';
        $midia_html .= '<div id="img_preview_frame">';
        if ( !empty($imagem) && $imagem != "" ) {
            $midia_html .= '<img style="width: 100%;" class="img_preview" id="img_preview" src="' . $imagem . '"/>';
        }
        $midia_html .= '</div>';

        $midia_html .= '</label>';
        echo $midia_html;
    }

    function pd_debate_detalhes($post) {
        $link = get_post_meta($post->ID, 'debate_link', true);
        $periodo_de = get_post_meta($post->ID, 'debate_periodo_de', true); //Como adicionar o widget?
        $periodo_para = get_post_meta($post->ID, 'debate_periodo_para', true); //Como adicionar o widget?
        $assunto = get_post_meta($post->ID, 'debate_assunto', true);
        $categoria = get_post_meta($post->ID, 'debate_categoria', true);
        $fases = get_post_meta($post->ID, 'debate_categoria', true);
        $resultados = get_post_meta($post->ID, 'debate_resultado', true);

        $debate_html = '<label for="debate_detalhes">';
        $debate_html .= '<strong>Link:</strong><br/><input type="url" name="debate_link" id="debate_link" size="80" value="' . $link . '"/><br/>';
        $debate_html .= '<strong>Perído:</strong><br/>';
        $debate_html .= 'De: <input type="text" name="debate_periodo_de" value="' . $periodo_de . '" class="datePick" required> ';
        $debate_html .= 'Até: <input type="text" name="debate_periodo_para" value="' . $periodo_para . '" class="datePick" required><br/>';
        $debate_html .= '<strong>Assunto Principal:</strong><br/><input type="text" name="debate_assunto" id="debate_assunto" size="80" value="' . $assunto . '"/><br/>';
        $debate_html .= '<strong>Categoria:</strong><br/><input type="text" name="debate_categoria" id="debate_categoria" size="40" value="' . $categoria . '"/><br/>';
        $debate_html .= '<strong>Fases:</strong><br/><input type="text" name="debate_fases" id="debate_fases" size="40" value="' . $fases . '"/><br/>';
        $debate_html .= '<strong>Resultados:</strong><br/><input type="text" name="debate_resultadoso" id="debate_resultados" size="40" value="' . $resultados . '"/><br/>';
        $debate_html .= '</label>';

        echo $debate_html;
    }

    add_action('save_post', 'pd_save_debate_meta', 1, 2); // save the custom fields
    // Save the Metabox Data
    function pd_save_debate_meta($post_id, $post) {

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !isset($_POST['debatemeta_noncename']) || !wp_verify_nonce( $_POST['debatemeta_noncename'], plugin_basename(__FILE__) )) {
            return $post->ID;
        }

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if ( !current_user_can( 'edit_post', $post->ID )) {
            return $post->ID;
        }

        $debate_meta = get_post_meta($post->ID);

        if ( isset( $_REQUEST['debate_aberto'] ) ) {
            $debate_meta['debate_aberto'] = $_REQUEST['debate_aberto'];
        }

        if ( isset( $_REQUEST['imagem']  ) && $_REQUEST['imagem'] != '' ) {
            $debate_meta['imagem'] = $_REQUEST['imagem'];
        }

        if ( isset( $_REQUEST['debate_link'] ) ) {
            $debate_meta['debate_link'] = $_REQUEST['debate_link'];
        }

        if ( isset( $_REQUEST['debate_periodo_de'] ) ) {
            $debate_meta['debate_periodo_de'] = $_REQUEST['debate_periodo_de'];
        }

        if ( isset( $_REQUEST['debate_periodo_para'] ) ) {
            $debate_meta['debate_periodo_para'] = $_REQUEST['debate_periodo_para'];
        }

        if ( isset( $_REQUEST['debate_assunto'] ) ) {
            $debate_meta['debate_assunto'] = $_REQUEST['debate_assunto'];
        }

        if ( isset( $_REQUEST['debate_categoria'] ) ) {
            $debate_meta['debate_categoria'] = $_REQUEST['debate_categoria'];
        }

        if ( isset( $_REQUEST['debate_fases'] ) ) {
            $debate_meta['debate_fases'] = $_REQUEST['debate_fases'];
        }

        if ( isset( $_REQUEST['debate_resultados'] ) ) {
            $debate_meta['debate_resultados'] = $_REQUEST['debate_resultados'];
        }

        // Add values of $events_meta as custom fields
        foreach ($debate_meta as $key => $value) { // Cycle through the $events_meta array!
            if( $post->post_type == 'revision' ) return; // Don't store custom data twice
            $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
            if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
                update_post_meta($post->ID, $key, $value);
            } else { // If the custom field doesn't have a value
                add_post_meta($post->ID, $key, $value);
            }
            if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
        }

    }

    add_action('post_edit_form_tag', 'pensandoodireito_update_edit_form');

    // Add to admin_init function
    add_filter('manage_edit-debate_columns', 'add_new_debate_columns');
    function add_new_debate_columns($debate_columns) {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = _x('Debate', 'column name');
        $new_columns['debate_aberto'] = 'Situação';

        return $new_columns;
    }

    add_action( 'manage_debate_posts_custom_column', 'my_manage_debate_columns', 10, 2 );
    function my_manage_debate_columns( $column, $post_id ) {
        global $post;

        switch( $column ) {

            case 'debate_aberto' :

                /* Get the post meta. */
                $situacao = get_post_meta( $post_id, 'debate_aberto', true );

                if ( $situacao == 'aberto' )
                    echo 'Aberto';
                else
                    echo 'Encerrado';

                break;

            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }

    register_post_type( 'debate', $args );
}
// Hook into the 'init' action
add_action( 'init', 'arq_debate_post_type', 0 );

/*add_action( 'widgets_init', 'pensandoodireito_widgets_init' );
function pensandoodireito_widgets_init()
{
    register_sidebar(array(
        'name' => __('Outras Publicações', 'pensandoodireito'),
        'id' => 'pensando-outras-publicacoes',
        'description' => '',
        'class' => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'));

}*/

//Function used to limit the 'publicacao' title when printing it on the page.
function the_title_limit($length, $replacer = '...') {
  $string = the_title('','',FALSE);
  if(strlen($string) > $length) {
    $words = explode(" ", $string);
    $word_index = 1;
    $output = $words[0];
    while (strlen($output) + strlen($words[$word_index]) < $length - 4) {
        $output .= ' ' . $words[$word_index];
        $word_index += 1;
    }
    $output .= ' ...';
  } else {
    $output = $string;
  }
  echo $output;
}

/**
 * Função ajax pra paginação infinita
 */
function publicacoes_paginacao_infinita(){
    $paged = $_POST['paged'];
    $destaqueID = $_POST['destaqueID'];

    $pubs_args = array(
      'paged' => $paged,
      'post_type' => 'publicacao',
      'posts_per_page' => 4,
      'post__not_in' => array($destaqueID ),
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
    if ($publicacoes->have_posts()) {
        while ($publicacoes->have_posts()) {
          $publicacoes->the_post();
            if ($counter % 4 == 0) { ?> <div class="row"> <?php }
            get_template_part('publicacao','card');
            if (($counter + 1) % 4 == 0) { ?> </div> <?php }
            $counter++;
        }
    }

    exit;
}

add_action('wp_ajax_publicacoes_paginacao_infinita', 'publicacoes_paginacao_infinita');
add_action('wp_ajax_nopriv_publicacoes_paginacao_infinita', 'publicacoes_paginacao_infinita');

// Função que cria páginas (pages),
//   em especial focando nos 'endpoints'
function pd_create_pages() {
  // Página "o que é"
  pd_create_page( array('titulo' => 'O que é?', 'nome' => 'o-que-e') );

  // Página "parceiros"
  pd_create_page( array(
   'titulo' => 'Parceiros',
   'nome' => 'parceiros',
   'conteudo' => '<p>Parcerias estabelecidas pela SAL/MJ com instituições acadêmicas, centros de pesquisa, ONG’s e também com demais entes públicos para a consecução dos objetivos próprios do Projeto Pensando o Direito.</p>
        <ul id="lista-parceiros">
        <li>Associação dos Advogados de São Paulo</li>
        <li>Associação dos Juízes para a Democracia</li>
        <li>Associação Nacional dos Defensores Públicos (Anadep)</li>
        <li>Associações de defensoria</li>
        <li>Central dos Movimentos Populares</li>
        <li>Centro Feminista de Estudos e Assessoria (CFEMEA)</li>
        <li>Comitê Gestor da Internet no Brasil (CGI.br)</li>
        <li>Conselho Nacional de Justiça (CNJ)</li>
        <li>Conselho Nacional do Ministério Público</li>
        <li>Cultura Digital & Democracia</li>
        <li>Defensoria Pública</li>
        <li>Defensoria Pública da União</li>
        <li>Defensoria Pública do Estado de São Paulo</li>
        <li>Departamento Jurídico XI de Agosto</li>
        <li>Escritório Modelo da PUC-SP</li>
        <li>Estratégia Nacional de Combate à Lavagem de Dinheiro (ENCCLA)</li>
        <li>Estratégia Nacional de Justiça e Segurança Pública (Enasp)</li>
        <li>Federação Nacional de Estudantes de Direito (Fened)</li>
        <li>Fórum Justiça</li>
        <li>Instituo Brasileiro de Direito Processual</li>
        <li>Instituto Beta para Internet e Democracia (Ibidem)</li>
        <li>Instituto Brasileiro de Ciências Criminais (IBCCrim)</li>
        <li>Instituto Brasileiro de Defesa do Consumidor (Idec)</li>
        <li>Instituto Brasileiro de Direito de Família</li>
        <li>Instituto Brasileiro de Direito Urbanístico (IBDU)</li>
        <li>Instituto Carioca de Criminologia (ICC)</li>
        <li>Instituto Pólis</li>
        <li>Instituto Scarance</li>
        <li>Instituto Sou da Paz</li>
        <li>InternetLab</li>
        <li>Intervozes (coletivo)</li>
        <li>Movimento do Ministério Público Democrático (MPD)</li>
        <li>Movimento dos Trabalhadores Rurais Sem-Terra (MST)</li>
        <li>Movimento dos Trabalhadores Sem-Teto (MTST)</li>
        <li>Oboré (empresa)</li>
        <li>Oficina de Imagens</li>
        <li>Ordem dos Advogados do Brasil (OAB)</li>
        <li>Organização Internacional de Polícia Criminal (Interpol)</li>
        <li>Pastoral Carcerária</li>
        <li>Projeto Cala-boca já morreu</li>
        <li>Proteste - Associação Brasileira de Defesa do Consumidor</li>
        <li>Rede Nacional de Advogados e Advogados Populares (Renap)</li>
        <li>Sociedade Brasileira de Direito Público (SBDP)</li>
        <li>Terra de Direitos</li>
        <li>União dos Movimentos de Moradia de São Paulo</li>
        <li>Via Campesina</li>
        <li>World Wide Web Consortium (W3C)</li>
        </ul>'
  ) );

}

// Chama a função apenas quando há troca de tema
//   fundamentalmente quando o tema é ativado (e também desativado)
add_action('after_switch_theme', 'pd_create_pages');





