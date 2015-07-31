<?php

// Register Custom Post Type
function parceiro_post_type() {

    $labels = array(
        'name'                => _x( 'Parceiros', 'Post Type General Name', 'pensandoodireito' ),
        'singular_name'       => _x( 'Parceiro', 'Post Type Singular Name', 'pensandoodireito' ),
        'menu_name'           => __( 'Parceiros', 'pensandoodireito' ),
        'name_admin_bar'      => __( 'Parceiros', 'pensandoodireito' ),
        'parent_item_colon'   => __( 'Parceiro pai:', 'pensandoodireito' ),
        'all_items'           => __( 'Todos parceiros', 'pensandoodireito' ),
        'add_new_item'        => __( 'Adicionar novo parceiro', 'pensandoodireito' ),
        'add_new'             => __( 'Adicionar novo', 'pensandoodireito' ),
        'new_item'            => __( 'Novo parceiro', 'pensandoodireito' ),
        'edit_item'           => __( 'Editar parceiro', 'pensandoodireito' ),
        'update_item'         => __( 'Atualizar parceiro', 'pensandoodireito' ),
        'view_item'           => __( 'Ver parceiro', 'pensandoodireito' ),
        'search_items'        => __( 'Buscar parceiro', 'pensandoodireito' ),
        'not_found'           => __( 'Não encontrado', 'pensandoodireito' ),
        'not_found_in_trash'  => __( 'Não encontrado na lixeira', 'pensandoodireito' ),
    );
    $args = array(
        'label'               => __( 'parceiro', 'pensandoodireito' ),
        'description'         => __( 'Descrição do Parceiro', 'pensandoodireito' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor' , 'thumbnail' ), //'editor',
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
        'register_meta_box_cb' => 'add_parceiro_metaboxes', //Para adicionar novos campos
        'rewrite'             => array( 'slug' => 'parceiros', 'with_front' => false),
    );

    // Metaboxes adicionadas seguindo o tutorial: http://wptheming.com/2010/08/custom-metabox-for-post-type/
    // and also thanks to @sterndata at #wordpress irc channel for the help
    // http://wpbin.io/dfwy8d
    function add_parceiro_metaboxes() {
        // Adiciona um campo para upload de vídeo ou imagem do parceiro.
        add_meta_box('wpt_parceiro_link', 'Link do parceiro', 'wpt_parceiro_link', 'parceiro', 'normal', 'high');
    }

    function wpt_parceiro_link($post) {
        $link = get_post_meta($post->ID, 'parceiro_link', true);
?>

        <label for="parceiro_link">
        Digite abaixo o link para o qual o parceiro irá direcionar<br/>
        Link: <input type="text" name="parceiro_link" id="parceiro_link" size="80" value="<?php echo $link; ?>"/>
        </label>
        <input type="hidden" name="parceirometa_noncename" id="parceirometa_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<?php
    }

    add_action('save_post', 'wpt_save_parceiro_meta', 1, 2); // save the custom fields
    // Save the Metabox Data
    function wpt_save_parceiro_meta($post_id, $post) {

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !isset($_POST['parceirometa_noncename']) || !wp_verify_nonce( $_POST['parceirometa_noncename'], plugin_basename(__FILE__) )) {
            return $post->ID;
        }

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if ( !current_user_can( 'edit_post', $post->ID )) {
            return $post->ID;
        }

        $parceiro_meta = get_post_meta($post->ID);

        if ( isset( $_REQUEST['parceiro_link'] ) && $_REQUEST['parceiro_link'] != '' ) {
            $parceiro_meta['parceiro_link'] = $_REQUEST['parceiro_link'];
        }

        // Add values of $events_meta as custom fields
        foreach ($parceiro_meta as $key => $value) { // Cycle through the $events_meta array!
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

    register_post_type( 'parceiro', $args );

}

// Hook into the 'init' action
add_action( 'init', 'parceiro_post_type', 0 );