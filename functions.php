<?php

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
    );

    // this adds jquery datepicker and styles it
    function dp_styles() {
        wp_enqueue_style('jquery-ui-datepicker-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    }
    add_action('admin_print_styles', 'dp_styles');
    function dp_scripts() {
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('datePick-datepicker', get_template_directory_uri() . '/js/date-picker-class.js', array(), '20150311', true );
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
        if ( !wp_verify_nonce( $_POST['publicacaometa_noncename'], plugin_basename(__FILE__) )) {
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

    function update_edit_form() {
        echo ' enctype="multipart/form-data"';
    } // end update_edit_form
    add_action('post_edit_form_tag', 'update_edit_form');

    //Registrando o post-type Publicação
    register_post_type( 'publicacao', $args );

}

// Iniciarlizar publicação.
add_action( 'init', 'publicacao_post_type', 0 );
