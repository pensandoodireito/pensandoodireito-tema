<?php

define( 'ID_BLOG_PENSANDO_DIREITO', 1 );

include_once( get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'post-types.php' );

// Tamanhos de imagem pré-definidos
add_image_size( 'thumb-debate-capa', 300, 182, true );
add_image_size( 'thumb-debate-pagina', 230, 175, true );


function add_video_support() {
	//add_theme_support( 'post-formats', array('video') );
	add_post_type_support( 'video', 'post-formats' );
}

add_action( 'init', 'add_video_support' );

// http://www.wpbeginner.com/wp-themes/how-to-add-dynamic-widget-ready-sidebars-in-wordpress/
// Creating the widget
class video_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
			'video_widget',
			// Widget name will appear in UI
			__( 'Vídeo', 'wpb_widget_domain' ),

			// Widget description
			array( 'description' => __( 'Widget que mostra o último vídeo em destaque', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes

		$params    = array(
			'post_type'      => array( 'video' ),
			'pagination'     => false,
			'posts_per_page' => '1',
			'order'          => 'DESC',
			'meta_query'     => array(
				array(
					'key'     => 'video_destaque',
					'value'   => '1',
					'compare' => '=',
				),
			)
		);
		$the_query = new WP_Query( $params );

		echo $args['before_widget'];

		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				$youtube_url = get_post_meta( get_the_ID(), 'video_youtube_url' );
				$url_params  = parse_url( $youtube_url[0] );
				parse_str( $url_params['query'] );
				?>
				<div class="panel panel-default">
					<div class="panel-body">
						<header><h2><a href="/videos"><?php echo $title; ?></a></h2></header>
						<section class="embed-responsive embed-responsive-16by9 mt-sm">
							<iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $v; ?>"
							        frameborder="0" allowfullscreen>
							</iframe>
						</section>
						<section class="video-description">
							<h3><a href="<?php the_guid(); ?>"><?php the_title(); ?></a></h3>

							<p><?php the_excerpt(); ?></p>

							<p><a href="https://www.youtube.com/channel/UCTKceQBthsUpwYUcQfD4W8g" class="fontsize-sm"
							      target="_blank">Pensando o Direito no <i class="fa fa-youtube"></i> youtube</a></p>
						</section>
					</div>
				</div>
			<?php endwhile;
			//end of the loop
		endif;
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function video_load_widget() {
	register_widget( 'video_widget' );
}

add_action( 'widgets_init', 'video_load_widget' );

/**
 * Criando uma area de widgets
 *
 */
function widgets_novos_widgets_init() {

	register_sidebar( array(
		'name'          => 'Barra lateral',
		'id'            => 'sidebar_widgets',
		'before_widget' => '<section class="pensando-videos">',
		'after_widget'  => '</section>',
	) );
}

add_action( 'widgets_init', 'widgets_novos_widgets_init' );

// this adds jquery tooltip and styles it
function pensandoodireito_scripts() {
	wp_enqueue_script( 'pensandoodireto', get_stylesheet_directory_uri() . '/js/pensandoodireito.js', array(), false, true );
}

add_action( 'admin_enqueue_scripts', 'pensandoodireito_scripts' );

//teste de script
add_action( 'wp_enqueue_scripts', 'pensandoodireito_frontend_scripts' );
function pensandoodireito_frontend_scripts() {
	wp_enqueue_script( 'pensando_frontend', get_stylesheet_directory_uri() . '/js/pensando_frontend.js', array(
		'jquery',
		'jquery-ui-autocomplete'
	) );
}

//Script to ajax load more publicacoes
function publicacoes_scripts() {
	wp_enqueue_script( 'publicacoes', get_stylesheet_directory_uri() . '/js/publicacoes.js', array(), false, true );
	$publicacoes_data = array(
		'ajaxurl'     => admin_url( 'admin-ajax.php' ),
		'paginaAtual' => 3,
		'ajaxgif'     => get_template_directory_uri() . '/images/ajax-loader.gif'
	);

	wp_localize_script( 'publicacoes', 'publicacoes', $publicacoes_data );
}

add_action( 'wp_enqueue_scripts', 'publicacoes_scripts' );

/**
 * Registar post type publicação
 */
function publicacao_post_type() {

	$labels = array(
		'name'               => _x( 'Publicações', 'Post Type General Name', 'pensandooodireito' ),
		'singular_name'      => _x( 'Publicação', 'Post Type Singular Name', 'pensandooodireito' ),
		'menu_name'          => __( 'Publicações', 'pensandooodireito' ),
		'parent_item_colon'  => __( 'Publicação pai:', 'pensandooodireito' ),
		'all_items'          => __( 'Todas as publicações', 'pensandooodireito' ),
		'view_item'          => __( 'Ver publicação', 'pensandooodireito' ),
		'add_new_item'       => __( 'Adicionar publicação', 'pensandooodireito' ),
		'add_new'            => __( 'Adicionar nova', 'pensandooodireito' ),
		'edit_item'          => __( 'Editar Publicação', 'pensandooodireito' ),
		'update_item'        => __( 'Atualizar Publicação', 'pensandooodireito' ),
		'search_items'       => __( 'Buscar publicação', 'pensandooodireito' ),
		'not_found'          => __( 'Não enconrtado', 'pensandooodireito' ),
		'not_found_in_trash' => __( 'Não encontrado na lixeira', 'pensandooodireito' ),
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
		'label'                => __( 'publicacao', 'pensandooodireito' ),
		'description'          => __( 'Publicações do Pensando o Direito', 'pensandooodireito' ),
		'labels'               => $labels,
		'supports'             => $supports,
		'taxonomies'           => array( 'category', 'post_tag' ),
		'hierarchical'         => false,
		'public'               => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'show_in_nav_menus'    => true,
		'show_in_admin_bar'    => true,
		'menu_position'        => 5,
		'can_export'           => true,
		'has_archive'          => true,
		'exclude_from_search'  => false,
		'publicly_queryable'   => true,
		'capability_type'      => 'post',
		'register_meta_box_cb' => 'add_publicacao_metaboxes', //Para adicionar novos campos
		'rewrite'              => array( 'slug' => 'publicacoes', 'with_front' => false ),
	);

	// this adds jquery datepicker and styles it
	function dp_styles() {
		wp_enqueue_style( 'jquery-ui-datepicker-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
	}

	add_action( 'admin_print_styles', 'dp_styles' );
	function dp_scripts() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}

	add_action( 'admin_enqueue_scripts', 'dp_scripts' );

	// Metaboxes adicionadas seguindo o tutorial: http://wptheming.com/2010/08/custom-metabox-for-post-type/
	// and also thanks to @sterndata at #wordpress irc channel for the help
	// http://wpbin.io/dfwy8d
	function add_publicacao_metaboxes() {
		// Adiciona um campo para data da oficial da publicação, independente da data do post.
		add_meta_box( 'wpt_publicacao_data', 'Dados da Publicação', 'wpt_publicacao_data', 'publicacao', 'side', 'high' );
		// Adiciona um campo para anexar a versão as versões "web" e para Download da Publicação
		add_meta_box( 'wpt_publicacao_files', 'Arquivos da Publicação', 'wpt_publicacao_files', 'publicacao', 'side', 'high' );
		// Adiciona um campo para anexar a versão para Download da Publicação
		//add_meta_box('wpt_publicacao_dld_version','Versão para download', 'wpt_publicacao_dld_version', 'publicacao', 'side', 'high');
	}

	//Geração do HTML das metaboxes
	function wpt_publicacao_data() {
		global $post;

		// Campo necessário para verificar origem do dado
		echo '<input type="hidden" name="publicacaometa_noncename" id="publicacaometa_noncename" value="' .
		     wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

		// Recupera a variáveis, se já adicionadas
		$pub_date   = get_post_meta( $post->ID, 'pub_date', true );
		$pub_number = get_post_meta( $post->ID, 'pub_number', true );

		// Imprime o campo para Número da Publicação
		echo '<p><label>Número da Publicação</label><input type="number" name="pub_number" value="' . $pub_number . '" class="" required /></p>';

		// Imprime o campo para Data da Publicação
		echo '<p><label>Data da Publicação</label><input type="text" name="pub_date" value="' . $pub_date . '" class="datePick" required /></p>';
	}

	//Geração do HTML para upload dos arquivos
	function wpt_publicacao_files() {
		global $post;

		$pub_web_file = get_post_meta( $post->ID, 'pub_web_file', true );
		$pub_dld_file = get_post_meta( $post->ID, 'pub_dld_file', true );

		// Recupera arquivos caso já tenha sido adicionados
		//TODO: HOW TO RETRIEVE ALREADY UPDATED FILES, SO I CAN UPDATE THE POST WITHOU UPLOADING FILES AGAIN?
		$html = "<p><label>Versão Web</label>";
		if ( $pub_web_file ) {
			$html .= "<br/><a href='" . $pub_web_file . "' target='_blank'>Arquivo Atual</a>";
		}
		$html .= "<input type='file' name='pub_web_file' id='pub_web_file' value='' size='25'/></p>";
		$html .= "<p><label>Versão para Download</label>";
		if ( $pub_dld_file ) {
			$html .= "<br/><a href='" . $pub_dld_file . "' target='_blank'>Arquivo Atual</a>";
		}
		$html .= "<input type='file' name='pub_dld_file' id='pub_dld_file' value='' size='25'/></p>";
		echo $html;
	}

	// Save the Metabox Data
	function wpt_save_publicacao_meta( $post_id, $post ) {

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( ! isset( $_POST['publicacaometa_noncename'] ) || ! wp_verify_nonce( $_POST['publicacaometa_noncename'], plugin_basename( __FILE__ ) ) ) {
			return $post->ID;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		// Is the user allowed to edit the post or page?
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post->ID;
		}

		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		$publicacao_meta['pub_date']   = $_POST['pub_date'];
		$publicacao_meta['pub_number'] = $_POST['pub_number'];

		// Make sure the file array isn't empty
		if ( ! empty( $_FILES['pub_web_file']['name'] ) && ! empty( $_FILES['pub_dld_file']['name'] ) ) {

			// Setup the array of supported file types. In this case, it's just PDF.
			$supported_types = array( 'application/pdf' );

			// Get the file type of the upload
			$arr_web_file_type = wp_check_filetype( basename( $_FILES['pub_web_file']['name'] ) );
			$uploaded_web_type = $arr_web_file_type['type'];
			$arr_dld_file_type = wp_check_filetype( basename( $_FILES['pub_dld_file']['name'] ) );
			$uploaded_dld_type = $arr_dld_file_type['type'];

			// Check if the type is supported. If not, throw an error.
			if ( ! in_array( $uploaded_web_type, $supported_types ) ) {
				//TOOD: Improve this message
				wp_die( "O arquivo para web não é um PDF (formato permitido)." );
			}
			if ( ! in_array( $uploaded_dld_type, $supported_types ) ) {
				//TOOD: Improve this message
				wp_die( "O arquivo para download não é um PDF (formato permitido)." );
			}

			// Use the WordPress API to upload the file
			$upload_web = wp_upload_bits( $_FILES['pub_web_file']['name'], null, file_get_contents( $_FILES['pub_web_file']['tmp_name'] ) );
			$upload_dld = wp_upload_bits( $_FILES['pub_dld_file']['name'], null, file_get_contents( $_FILES['pub_dld_file']['tmp_name'] ) );

			if ( isset( $upload_web['error'] ) && $upload_web['error'] != 0 ) {
				wp_die( 'Erro ao salvar arquivo para Web. O erro foi: ' . $upload['error'] );
			} else {
				$publicacao_meta['pub_web_file'] = $upload_web['url'];
			}
			if ( isset( $upload_dld['error'] ) && $upload_dld['error'] != 0 ) {
				wp_die( 'Erro ao salvar arquivo para Download. O erro foi: ' . $upload['error'] );
			} else {
				$publicacao_meta['pub_dld_file'] = $upload_dld['url'];
			}
		}

		// Add values of $events_meta as custom fields
		foreach ( $publicacao_meta as $key => $value ) { // Cycle through the $events_meta array!
			if ( $post->post_type == 'revision' ) {
				return;
			} // Don't store custom data twice
			$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
			if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value
				update_post_meta( $post->ID, $key, $value );
			} else { // If the custom field doesn't have a value
				add_post_meta( $post->ID, $key, $value );
			}
			if ( ! $value ) {
				delete_post_meta( $post->ID, $key );
			} // Delete if blank
		}

	}

	add_action( 'save_post', 'wpt_save_publicacao_meta', 1, 2 ); // save the custom fields

	function pensandoodireito_update_edit_form() {
		echo ' enctype="multipart/form-data"';
	} // end update_edit_form
	add_action( 'post_edit_form_tag', 'pensandoodireito_update_edit_form' );

	//Registrando o post-type Publicação
	register_post_type( 'publicacao', $args );

}

function video_post_type() {

	$labels = array(
		'name'               => _x( 'Vídeos', 'Post Type General Name', 'pensandoodireito' ),
		'singular_name'      => _x( 'Vídeo', 'Post Type Singular Name', 'pensandoodireito' ),
		'menu_name'          => __( 'Vídeos', 'pensandoodireito' ),
		'name_admin_bar'     => __( 'Vídeos', 'pensandoodireito' ),
		'parent_item_colon'  => __( 'Vídeo pai:', 'pensandoodireito' ),
		'all_items'          => __( 'Todos vídeos', 'pensandoodireito' ),
		'add_new_item'       => __( 'Adicionar novo vídeo', 'pensandoodireito' ),
		'add_new'            => __( 'Adicionar novo', 'pensandoodireito' ),
		'new_item'           => __( 'Novo vídeo', 'pensandoodireito' ),
		'edit_item'          => __( 'Editar vídeo', 'pensandoodireito' ),
		'update_item'        => __( 'Atualizar vídeo', 'pensandoodireito' ),
		'view_item'          => __( 'Ver vídeo', 'pensandoodireito' ),
		'search_items'       => __( 'Buscar vídeo', 'pensandoodireito' ),
		'not_found'          => __( 'Não encontrado', 'pensandoodireito' ),
		'not_found_in_trash' => __( 'Não encontrado na lixeira', 'pensandoodireito' ),
	);

	$args = array(
		'label'                => __( 'debate', 'pensandoodireito' ),
		'description'          => __( 'Descrição do Debate', 'pensandoodireito' ),
		'labels'               => $labels,
		'supports'             => array( 'title', 'excerpt' ),
		'show_ui'              => true,
		'show_in_menu'         => true,
		'menu_position'        => 9,
		'show_in_admin_bar'    => true,
		'show_in_nav_menus'    => true,
		'has_archive'          => true,
		'exclude_from_search'  => false,
		'publicly_queryable'   => true,
		'public'               => true,
		'register_meta_box_cb' => 'add_video_metaboxes', //Para adicionar novos campos
		'rewrite'              => array( 'slug' => 'videos', 'with_front' => false ),
	);

	function add_video_metaboxes() {
		add_meta_box( 'pd_video_url', 'URL do Youtube:', 'pd_video_url', 'video', 'normal', 'default' );
		add_meta_box( 'pd_video_destaque', 'Vídeo em destaque', 'pd_video_destaque', 'video', 'side', 'high' );
	}

	function pd_video_url( $post ) {
		$youtube_url = get_post_meta( $post->ID, 'video_youtube_url', true );
		echo "<input type=\"url\" name=\"video_youtube_url\" value=\"{$youtube_url}\" size=\"100\" required />";
	}

	function pd_video_destaque( $post ) {
		$debate_destaque = get_post_meta( $post->ID, 'video_destaque', true );
		echo '<label><input type="checkbox" name="video_destaque" id="video_destaque" ';
		if ( $debate_destaque ) {
			echo 'checked';
		}
		echo ' value="destaque"/> Destacado</label>';
	}

	register_post_type( 'video', $args );


	add_action( 'save_post', 'pd_save_video_meta', 1, 2 ); // save the custom fields
	// Save the Metabox Data
	function pd_save_video_meta( $post_id, $post ) {

		$custom_youtube_field  = 'video_youtube_url';
		$custom_destaque_field = 'video_destaque';


		$youtube_url = null;
		if ( isset( $_POST[ $custom_youtube_field ] ) ) {
			$youtube_url = $_POST[ $custom_youtube_field ];
		} else {
			return $post->ID;
		}

		$destaque = isset( $_REQUEST[ $custom_destaque_field ] ) && $_REQUEST[ $custom_destaque_field ] == "destaque";

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( is_null( $youtube_url ) ) {
			return $post->ID;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		// Is the user allowed to edit the post or page?
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post->ID;
		}

		if ( $post->post_type == 'revision' ) {
			return;
		} // Don't store custom data twice

		set_post_format( $post, 'video' );

		if ( get_post_meta( $post->ID, $custom_youtube_field, false ) ) { // If the custom field already has a value
			update_post_meta( $post->ID, $custom_youtube_field, $youtube_url );
		} else { // If the custom field doesn't have a value
			add_post_meta( $post->ID, $custom_youtube_field, $youtube_url );
		}


		if ( get_post_meta( $post->ID, $custom_destaque_field, false ) ) { // If the custom field already has a value
			update_post_meta( $post->ID, $custom_destaque_field, $destaque );
		} else { // If the custom field doesn't have a value
			add_post_meta( $post->ID, $custom_destaque_field, $destaque );
		}

	}
}

add_action( 'init', 'video_post_type', 0 );

// Iniciarlizar publicação.
add_action( 'init', 'publicacao_post_type', 0 );

/**
 * Register Arquivo Debate Custom Post Type
 **/
function arq_debate_post_type() {

	$labels = array(
		'name'               => _x( 'Debates', 'Post Type General Name', 'pensandoodireito' ),
		'singular_name'      => _x( 'Debate', 'Post Type Singular Name', 'pensandoodireito' ),
		'menu_name'          => __( 'Debates', 'pensandoodireito' ),
		'name_admin_bar'     => __( 'Debates', 'pensandoodireito' ),
		'parent_item_colon'  => __( 'Debate pai:', 'pensandoodireito' ),
		'all_items'          => __( 'Todos debates', 'pensandoodireito' ),
		'add_new_item'       => __( 'Adicionar novo debate', 'pensandoodireito' ),
		'add_new'            => __( 'Adicionar novo', 'pensandoodireito' ),
		'new_item'           => __( 'Novo debate', 'pensandoodireito' ),
		'edit_item'          => __( 'Editar debate', 'pensandoodireito' ),
		'update_item'        => __( 'Atualizar debate', 'pensandoodireito' ),
		'view_item'          => __( 'Ver debate', 'pensandoodireito' ),
		'search_items'       => __( 'Buscar debate', 'pensandoodireito' ),
		'not_found'          => __( 'Não encontrado', 'pensandoodireito' ),
		'not_found_in_trash' => __( 'Não encontrado na lixeira', 'pensandoodireito' ),
	);
	$args   = array(
		'label'                => __( 'debate', 'pensandoodireito' ),
		'description'          => __( 'Descrição do Debate', 'pensandoodireito' ),
		'labels'               => $labels,
		'supports'             => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'         => false,
		'public'               => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'menu_position'        => 5,
		'show_in_admin_bar'    => true,
		'show_in_nav_menus'    => true,
		'can_export'           => true,
		'has_archive'          => true,
		'exclude_from_search'  => true,
		'publicly_queryable'   => true,
		'capability_type'      => 'post',
		'register_meta_box_cb' => 'add_debate_metaboxes', //Para adicionar novos campos
		'rewrite'              => array( 'slug' => 'debates', 'with_front' => false ),
	);

	// Metaboxes adicionadas seguindo o tutorial: http://wptheming.com/2010/08/custom-metabox-for-post-type/
	// and also thanks to @sterndata at #wordpress irc channel for the help
	// http://wpbin.io/dfwy8d
	function add_debate_metaboxes() {
		add_meta_box( 'pd_debate_status', 'Debate aberto', 'pd_debate_status', 'debate', 'side', 'high' );
		add_meta_box( 'pd_debate_destaque', 'Debate em destaque', 'pd_debate_destaque', 'debate', 'side', 'high' );
		add_meta_box( 'pd_debate_imagem_fundo', 'Imagem de fundo', 'pd_debate_imagem_fundo', 'debate', 'side', 'default' );
		add_meta_box( 'pd_debate_detalhes', 'Detalhes do debate', 'pd_debate_detalhes', 'debate', 'normal', 'default' );
	}

	function pd_debate_status( $post ) {
		$debate_aberto = "";
		echo '<input type="hidden" name="debatemeta_noncename" id="debatemeta_noncename" value="' . wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';
		wp_enqueue_script( 'pensandoodireto', get_stylesheet_directory_uri() . '/js/pensandoodireito.js', array(), false, true );
		wp_enqueue_media();

		$debate_aberto = get_post_meta( $post->ID, 'debate_aberto', true );
		echo '<input type="radio" name="debate_aberto" id="debate_aberto" ';
		if ( $debate_aberto == "aberto" ) {
			echo 'checked';
		}
		echo ' value="aberto"/> Aberto<br/>';
		echo '<input type="radio" name="debate_aberto" id="debate_encerrado" ';
		if ( $debate_aberto != "aberto" ) {
			echo 'checked';
		}
		echo ' value="encerrado"/> Encerrado';
	}

	function pd_debate_destaque( $post ) {
		$debate_destaque = get_post_meta( $post->ID, 'debate_destaque', true );
		echo '<input type="hidden" name="debate_destaque" value="comum" /> ';
		echo '<label><input type="checkbox" name="debate_destaque" id="debate_destaque" ';
		if ( $debate_destaque == "destaque" ) {
			echo 'checked';
		}
		echo ' value="destaque"/> Destacado</label>';
	}

	function pd_debate_imagem_fundo( $post ) {

		$imagem = get_post_meta( $post->ID, 'imagem', true );

		$midia_html = '<label for="imagem">';

		$midia_html .= '<input id="upload_debate_image_button" class="button midia_imagem" type="button" value="Selecione a Imagem"/>';
		$midia_html .= '<input id="imagem" type="text" size="25" name="imagem" value="' . $imagem . '"/>';
		$midia_html .= '<br/>';
		$midia_html .= '<div id="img_preview_frame">';
		if ( ! empty( $imagem ) && $imagem != "" ) {
			$midia_html .= '<img style="width: 100%;" class="img_preview" id="img_preview" src="' . $imagem . '"/>';
		}
		$midia_html .= '</div>';

		$midia_html .= '</label>';
		echo $midia_html;
	}

	function pd_debate_detalhes( $post ) {
		$link         = get_post_meta( $post->ID, 'debate_link', true );
		$periodo_de   = get_post_meta( $post->ID, 'debate_periodo_de', true ); //Como adicionar o widget?
		$periodo_para = get_post_meta( $post->ID, 'debate_periodo_para', true ); //Como adicionar o widget?
		$assunto      = get_post_meta( $post->ID, 'debate_assunto', true );
		$categoria    = get_post_meta( $post->ID, 'debate_categoria', true );
		$fases        = get_post_meta( $post->ID, 'debate_categoria', true );
		$resultados   = get_post_meta( $post->ID, 'debate_resultado', true );

		$debate_html = '<label for="debate_detalhes">';
		$debate_html .= '<strong>Link:</strong><br/><input type="url" name="debate_link" id="debate_link" size="80" value="' . $link . '"/><br/>';
		$debate_html .= '<strong>Período:</strong><br/>';
		$debate_html .= 'De: <input type="text" name="debate_periodo_de" value="' . $periodo_de . '" class="datePick" required> ';
		$debate_html .= 'Até: <input type="text" name="debate_periodo_para" value="' . $periodo_para . '" class="datePick" required><br/>';
		$debate_html .= '<strong>Assunto Principal:</strong><br/><input type="text" name="debate_assunto" id="debate_assunto" size="80" value="' . $assunto . '"/><br/>';
		$debate_html .= '<strong>Categoria:</strong><br/><input type="text" name="debate_categoria" id="debate_categoria" size="40" value="' . $categoria . '"/><br/>';
		$debate_html .= '<strong>Fases:</strong><br/><input type="text" name="debate_fases" id="debate_fases" size="40" value="' . $fases . '"/><br/>';
		$debate_html .= '<strong>Resultados:</strong><br/><input type="text" name="debate_resultadoso" id="debate_resultados" size="40" value="' . $resultados . '"/><br/>';
		$debate_html .= '</label>';

		echo $debate_html;
	}

	add_action( 'save_post', 'pd_save_debate_meta', 1, 2 ); // save the custom fields
	// Save the Metabox Data
	function pd_save_debate_meta( $post_id, $post ) {

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( ! isset( $_POST['debatemeta_noncename'] ) || ! wp_verify_nonce( $_POST['debatemeta_noncename'], plugin_basename( __FILE__ ) ) ) {
			return $post->ID;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		// Is the user allowed to edit the post or page?
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post->ID;
		}

		$debate_meta = get_post_meta( $post->ID );

		if ( isset( $_REQUEST['debate_aberto'] ) ) {
			$debate_meta['debate_aberto'] = $_REQUEST['debate_aberto'];
		}

		if ( isset( $_REQUEST['debate_destaque'] ) ) {
			$debate_meta['debate_destaque'] = $_REQUEST['debate_destaque'];
		}

		if ( isset( $_REQUEST['imagem'] ) && $_REQUEST['imagem'] != '' ) {
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
		foreach ( $debate_meta as $key => $value ) { // Cycle through the $events_meta array!
			if ( $post->post_type == 'revision' ) {
				return;
			} // Don't store custom data twice
			$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
			if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value
				update_post_meta( $post->ID, $key, $value );
			} else { // If the custom field doesn't have a value
				add_post_meta( $post->ID, $key, $value );
			}
			if ( ! $value ) {
				delete_post_meta( $post->ID, $key );
			} // Delete if blank
		}

	}

	add_action( 'post_edit_form_tag', 'pensandoodireito_update_edit_form' );

	// Add to admin_init function
	add_filter( 'manage_edit-debate_columns', 'add_new_debate_columns' );
	function add_new_debate_columns( $debate_columns ) {
		$new_columns['cb']            = '<input type="checkbox" />';
		$new_columns['title']         = _x( 'Debate', 'column name' );
		$new_columns['debate_aberto'] = 'Situação';

		return $new_columns;
	}

	add_action( 'manage_debate_posts_custom_column', 'my_manage_debate_columns', 10, 2 );
	function my_manage_debate_columns( $column, $post_id ) {
		global $post;

		switch ( $column ) {

			case 'debate_aberto' :

				/* Get the post meta. */
				$situacao = get_post_meta( $post_id, 'debate_aberto', true );

				if ( $situacao == 'aberto' ) {
					echo 'Aberto';
				} else {
					echo 'Encerrado';
				}

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

// Register Custom Post Type
function destaque_post_type() {

	$labels = array(
		'name'               => _x( 'Destaques', 'Post Type General Name', 'pensandoodireito' ),
		'singular_name'      => _x( 'Destaque', 'Post Type Singular Name', 'pensandoodireito' ),
		'menu_name'          => __( 'Destaques', 'pensandoodireito' ),
		'name_admin_bar'     => __( 'Destaques', 'pensandoodireito' ),
		'parent_item_colon'  => __( 'Destaque pai:', 'pensandoodireito' ),
		'all_items'          => __( 'Todos destaques', 'pensandoodireito' ),
		'add_new_item'       => __( 'Adicionar novo destaque', 'pensandoodireito' ),
		'add_new'            => __( 'Adicionar novo', 'pensandoodireito' ),
		'new_item'           => __( 'Novo destaque', 'pensandoodireito' ),
		'edit_item'          => __( 'Editar destaque', 'pensandoodireito' ),
		'update_item'        => __( 'Atualizar destaque', 'pensandoodireito' ),
		'view_item'          => __( 'Ver destaque', 'pensandoodireito' ),
		'search_items'       => __( 'Buscar destaque', 'pensandoodireito' ),
		'not_found'          => __( 'Não encontrado', 'pensandoodireito' ),
		'not_found_in_trash' => __( 'Não encontrado na lixeira', 'pensandoodireito' ),
	);
	$args   = array(
		'label'                => __( 'destaque', 'pensandoodireito' ),
		'description'          => __( 'Descrição do Destaque', 'pensandoodireito' ),
		'labels'               => $labels,
		'supports'             => array( 'title', 'thumbnail' ), //'editor',
		'hierarchical'         => false,
		'public'               => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'menu_position'        => 5,
		'show_in_admin_bar'    => true,
		'show_in_nav_menus'    => true,
		'can_export'           => true,
		'has_archive'          => true,
		'exclude_from_search'  => true,
		'publicly_queryable'   => true,
		'capability_type'      => 'post',
		'register_meta_box_cb' => 'add_destaque_metaboxes', //Para adicionar novos campos
		'rewrite'              => array( 'slug' => 'destaques', 'with_front' => false ),
	);

	// Metaboxes adicionadas seguindo o tutorial: http://wptheming.com/2010/08/custom-metabox-for-post-type/
	// and also thanks to @sterndata at #wordpress irc channel for the help
	// http://wpbin.io/dfwy8d
	function add_destaque_metaboxes() {
		// Adiciona um campo para upload de vídeo ou imagem do destaque.
		add_meta_box( 'wpt_destaque_ativo', 'Destaque ativo', 'wpt_destaque_ativo', 'destaque', 'side', 'high' );
		add_meta_box( 'wpt_destaque_link', 'Link do destaque', 'wpt_destaque_link', 'destaque', 'normal', 'high' );
		add_meta_box( 'wpt_destaque_modelo', 'Modelo do destaque', 'wpt_destaque_modelo', 'destaque', 'normal', 'high' );
		add_meta_box( 'wpt_destaque_midia', 'Mídia do Destaque', 'wpt_destaque_midia', 'destaque', 'normal', 'high' );
		add_meta_box( 'wpt_destaque_texto', 'Texto do Destaque', 'wpt_destaque_texto', 'destaque', 'normal', 'high' );
		add_meta_box( 'wpt_destaque_background', 'Imagem de background', 'wpt_destaque_background', 'destaque', 'side', 'low' );
	}

	function wpt_destaque_ativo( $post ) {
		echo '<input type="hidden" name="destaquemeta_noncename" id="destaquemeta_noncename" value="' . wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';
		wp_enqueue_script( 'pensandoodireto', get_stylesheet_directory_uri() . '/js/pensandoodireito.js', array(), false, true );
		wp_enqueue_media();

		$destaque_ativo = get_post_meta( $post->ID, 'destaque_ativo', true );
		echo '<input type="radio" name="destaque_ativo" id="destaque_ativo" ';
		if ( $destaque_ativo != 0 ) {
			echo 'checked';
		}
		echo ' value="1"/> Mostrar<br/>';
		echo '<input type="radio" name="destaque_ativo" id="destaque_ativo" ';
		if ( $destaque_ativo == 0 ) {
			echo 'checked';
		}
		echo ' value="0"/> Não mostrar';

	}

	function wpt_destaque_link( $post ) {
		$link = get_post_meta( $post->ID, 'destaque_link', true );

		$link_html = '<label for="destaque_link">';
		$link_html .= 'Digite abaixo o link para o qual o destaque irá direcionar<br/>';
		$link_html .= 'Link: <input type="text" name="destaque_link" id="destaque_link" size="80" value="' . $link . '"/>';
		$link_html .= '</label>';

		echo $link_html;

	}

	function wpt_destaque_modelo( $post ) {

		$modelo_destaque = get_post_meta( $post->ID, 'modelo_destaque', true );

		//Seletor de modelo de Destaque
		echo '<label for="modelo_destaque">Selecione o modelo de destaque que você deseja</label><br/>';
		echo '<div style="width: 46%; min-width: 185px; padding: 5px; display: inline-block; text-align: center;">';
		echo '<img src="' . get_stylesheet_directory_uri() . '/images/destaque_img_full.png" alt="Imagem" title="Imagem"/><br/>';
		echo '<input type="radio" name="modelo_destaque" id="modelo_destaque" onchange="destaque_controla_midia(this.value)" value="img_full"';
		if ( strpos( $modelo_destaque, 'img' ) !== false ) {
			echo ' checked';
		}
		echo '/>Imagem';
		echo '</div>';
		echo '<div style="width: 46%; min-width: 185px; padding: 5px; display: inline-block; text-align: center;">';
		echo '<img src="' . get_stylesheet_directory_uri() . '/images/destaque_video_full.png" alt="Vídeo" title="Vídeo"/><br/>';
		echo '<input type="radio" name="modelo_destaque" id="modelo_destaque" onchange="destaque_controla_midia(this.value)" value="video_full"';
		if ( strpos( $modelo_destaque, 'video' ) !== false ) {
			echo ' checked';
		}
		echo '/>Vídeo';
		echo '</div>';
	}

	function wpt_destaque_midia( $post ) {

		$midia_destaque     = get_post_meta( $post->ID, 'midia_destaque', true );
		$modelo_destaque    = get_post_meta( $post->ID, 'modelo_destaque', true );
		$background_img_url = get_post_meta( $post->ID, 'background_img_url', true );

		$midia_html = '';
		$isVideo    = $modelo_destaque == 'video_texto' || $modelo_destaque == 'video_full';

		if ( $isVideo ) {
			$img   = 'none';
			$video = 'block';
		} else {
			$img   = 'block';
			$video = 'none';
		}

		$midia_html .= '<p class="midia_video" style="display:' . $video . ';">Coloque a url do vídeo no youtube na caixa abaixo.</p>';
		$midia_html .= '<input id="midia_destaque" class="midia_video" type="text" size="80" name="midia_destaque" value="' . $midia_destaque . '" style="display:' . $video . ';" />';
		$midia_html .= '<div class="midia_imagem" style="display:' . $img . '" id="img_preview" >';

		if ( ! $isVideo ) {
			if ( $background_img_url ) {
				$midia_html .= '<div class="fill has-background" style="max-width:100%;height:auto;width:auto;background-image:url(' . $background_img_url . ')">';
				$midia_html .= '<a href="' . get_post_meta( get_the_ID(), 'destaque_link', true ) . '">';
				$midia_html .= get_the_post_thumbnail( null, 'post-thumbnail', array( 'style' => 'max-width:100%;height:auto;width:auto;' ) );
				$midia_html .= '</a></div>';
			} else {
				$midia_html .= get_the_post_thumbnail( null, 'post-thumbnail', array( 'style' => 'max-width:100%;height:auto;width:auto;' ) );
			}
		}

		$midia_html .= '</div>';

		if ( $midia_destaque && $midia_destaque != '' ) {
			if ( $isVideo && getYoutubeIdFromUrl( $midia_destaque ) ) {
				echo do_shortcode( '[youtube id="' . getYoutubeIdFromUrl( $midia_destaque ) . '"]' );
			}
		}

		$midia_html .= '</label>';
		echo $midia_html;
	}

	function wpt_destaque_texto( $post ) {
		$destaque_texto = get_post_meta( $post->ID, 'destaque_texto', true );

		echo '<label class="destaque_texto" for="destaque_texto">Digite o texto a ser utilizado na chamada.<br/>';
		echo '<textarea name="destaque_texto" id="destaque_texto" rows="3" cols="80" size="100px" maxlength="230">';
		echo $destaque_texto;
		echo '</textarea></label>';
	}

	function wpt_destaque_background( $post ) {
		$background_img_url = get_post_meta( $post->ID, 'background_img_url', true );

		?>
		<p class="hide-if-no-js">
			<input type="hidden" id="background_img_url" name="background_img_url" value="<?= $background_img_url ?>"/>
			<img id="background-image" src="<?= $background_img_url ?>" alt="Imagem de background"
			     style="max-width: 100%; height: auto; width: auto; display: <?= $background_img_url ? 'block' : 'none' ?>;"/>
			<a style="display: <?= $background_img_url ? 'none' : 'block'; ?>;" title="Configurar imagem de background"
			   href="javascript:;" id="set-background-image">Configurar imagem de background</a>
			<a style="display: <?= $background_img_url ? 'block' : 'none' ?>;" title="Remover imagem de background"
			   href="javascript:;" id="remove-background-image">Remover imagem de background</a>
		</p>
		<?php
	}

	add_action( 'save_post', 'wpt_save_destaque_meta', 1, 2 ); // save the custom fields
	// Save the Metabox Data
	function wpt_save_destaque_meta( $post_id, $post ) {

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( ! isset( $_POST['destaquemeta_noncename'] ) || ! wp_verify_nonce( $_POST['destaquemeta_noncename'], plugin_basename( __FILE__ ) ) ) {
			return $post->ID;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post->ID;
		}

		// Is the user allowed to edit the post or page?
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return $post->ID;
		}

		$destaque_meta = get_post_meta( $post->ID );

		if ( isset( $_REQUEST['modelo_destaque'] ) ) {
			$destaque_meta['modelo_destaque'] = $_REQUEST['modelo_destaque'];
		}

		if ( isset( $_REQUEST['midia_destaque'] ) && $_REQUEST['midia_destaque'] != '' ) {
			$destaque_meta['midia_destaque'] = $_REQUEST['midia_destaque'];
		}

		if ( isset( $_REQUEST['destaque_ativo'] ) ) {
			$destaque_meta['destaque_ativo'] = $_REQUEST['destaque_ativo'];
		}

		if ( isset( $_REQUEST['destaque_texto'] ) ) {
			$destaque_meta['destaque_texto'] = $_REQUEST['destaque_texto'];
		}

		if ( isset( $_REQUEST['destaque_link'] ) && $_REQUEST['destaque_link'] != '' ) {
			$destaque_meta['destaque_link'] = $_REQUEST['destaque_link'];
		}

		if ( isset( $_REQUEST['background_img_url'] ) ) {
			$destaque_meta['background_img_url'] = $_REQUEST['background_img_url'];
		}

		// Add values of $events_meta as custom fields
		foreach ( $destaque_meta as $key => $value ) { // Cycle through the $events_meta array!
			if ( $post->post_type == 'revision' ) {
				return;
			} // Don't store custom data twice
			$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely)
			if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value
				update_post_meta( $post->ID, $key, $value );
			} else { // If the custom field doesn't have a value
				add_post_meta( $post->ID, $key, $value );
			}
			if ( ! $value ) {
				delete_post_meta( $post->ID, $key );
			} // Delete if blank
		}

	}

	add_action( 'post_edit_form_tag', 'pensandoodireito_update_edit_form' );

	// Add to admin_init function
	add_filter( 'manage_edit-destaque_columns', 'add_new_destaque_columns' );
	function add_new_destaque_columns( $destaque_columns ) {
		$new_columns['cb']              = '<input type="checkbox" />';
		$new_columns['title']           = _x( 'Nome do Destaque', 'column name' );
		$new_columns['modelo_destaque'] = 'Modelo de Destaque';
		$new_columns['destaque_ativo']  = 'Ativo?';
		$new_columns['date']            = _x( 'Date', 'column name' );

		return $new_columns;
	}


	add_action( 'manage_destaque_posts_custom_column', 'my_manage_destaque_columns', 10, 2 );

	function my_manage_destaque_columns( $column, $post_id ) {
		global $post;

		switch ( $column ) {

			case 'modelo_destaque' :

				/* Get the post meta. */
				$modelo = get_post_meta( $post_id, 'modelo_destaque', true );

				if ( strpos( $modelo, 'img' ) !== false ) {
					printf( 'Imagem' );
				} else if ( strpos( $modelo, 'video' ) !== false ) {
					printf( 'Vídeo' );
				} else {
					echo 'Desconhecido';
				}

				break;

			case 'destaque_ativo' :

				$ativo = get_post_meta( $post_id, 'destaque_ativo', true );

				if ( empty( $ativo ) || $ativo == '' || $ativo == 0 || $ativo == false || $ativo == "0" ) {
					echo 'Desativado';
				} else {
					echo 'Ativo';
				}

				break;

			/* Just break out of the switch statement for everything else. */
			default :
				break;
		}
	}


	register_post_type( 'destaque', $args );

}

// Hook into the 'init' action
add_action( 'init', 'destaque_post_type', 0 );

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
function the_title_limit( $length, $replacer = '...' ) {
	$string = the_title( '', '', false );
	if ( strlen( $string ) > $length ) {
		$words      = explode( " ", $string );
		$word_index = 1;
		$output     = $words[0];
		while ( strlen( $output ) + strlen( $words[ $word_index ] ) < $length - 4 ) {
			$output .= ' ' . $words[ $word_index ];
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
function publicacoes_paginacao_infinita() {
	$paged      = $_POST['paged'];
	$destaqueID = $_POST['destaqueID'];

	$pubs_args = array(
		'paged'          => $paged,
		'post_type'      => 'publicacao',
		'posts_per_page' => 8,
		'post__not_in'   => array( $destaqueID ),
	);

	if ( ! empty( $_POST ) ) {
		if ( isset( $_POST['filter-name'] ) ) {
			$pubs_args['s'] = $_POST['filter-name'];
		}
		if ( isset( $_POST['sort-option'] ) ) {
			switch ( $_POST['sort-option'] ) {
				case 'pub_number':
					$pubs_args['orderby']  = 'meta_value_num';
					$pubs_args['meta_key'] = 'pub_number';
					break;
				case 'title':
					$pubs_args['orderby'] = 'title';
					break;
			}
		} else {
			$pubs_args['orderby']  = 'meta_value_num';
			$pubs_args['meta_key'] = 'pub_number';
		}
		if ( isset( $_POST['sort-order'] ) ) {
			$pubs_args['order'] = $_POST['sort-order'];
		} else {
			$pubs_args['order'] = 'DESC';
		}
	}

	$publicacoes = new WP_Query ( $pubs_args );

	$counter = 0;
	if ( $publicacoes->have_posts() ) {
		while ( $publicacoes->have_posts() ) {
			$publicacoes->the_post();
			if ( $counter % 4 == 0 ) { ?> <div class="row"> <?php }
			get_template_part( 'publicacao', 'card' );
			if ( ( $counter + 1 ) % 4 == 0 ) { ?> </div> <?php }
			$counter ++;
		}
	}

	exit;
}

add_action( 'wp_ajax_publicacoes_paginacao_infinita', 'publicacoes_paginacao_infinita' );
add_action( 'wp_ajax_nopriv_publicacoes_paginacao_infinita', 'publicacoes_paginacao_infinita' );

// Função que cria páginas (pages),
//   em especial focando nos 'endpoints'
function pd_create_pages() {
	// Página "o que é"
	pd_create_page( array( 'titulo' => 'O que é?', 'nome' => 'o-que-e' ) );

}

// Chama a função apenas quando há troca de tema
//   fundamentalmente quando o tema é ativado (e também desativado)
add_action( 'after_switch_theme', 'pd_create_pages' );

function pd_converter_datacorrida( $debate_periodo_para ) {
	$periodo_para_partes    = explode( '/', $debate_periodo_para );
	$periodo_para_timestamp = mktime( 0, 0, 0, $periodo_para_partes[1], $periodo_para_partes[0], $periodo_para_partes[2] );

	return date_i18n( 'd \d\e F \d\e Y', $periodo_para_timestamp );
}

// Criação de menus com base do blog 1 no ato de criação de novos sites
add_action( 'wpmu_new_blog', 'blog_creation' );

function blog_creation( $blog_id ) {

	// Muda para o tema pensando direito caso já não esteja nesse tema
	switch_to_blog( ID_BLOG_PENSANDO_DIREITO );

	// Pega os dados dos menus do tema anterior
	$menus = wp_get_nav_menus();

	foreach ( $menus as $menu ) {
		$menu->items = wp_get_nav_menu_items( $menu->term_id );

		foreach ( $menu->items as $item ) {

			// Se for uma página ou post type pega o post original
			if ( $item->type == 'post_type' ) {
				$item->orginal_post = get_post( (int) $item->object_id );
			}

		}
	}

	// Troca a conexão para salvar o menu no novo blog
	switch_to_blog( $blog_id );

	foreach ( $menus as $menu ) {

		//$menu_id = wp_create_nav_menu($menu->name);
		$menu_id = wp_update_nav_menu_object( 0, array(
			'menu-name'        => $menu->name,
			'menu-parent'      => $menu->parent,
			'menu-description' => $menu->description
		) );

		if ( isset( $menu->items ) ) {
			foreach ( $menu->items as $item ) {

				// Se for um menu para um post cria o post no novo blog
				if ( $item->type == 'post_type' ) {

					$data = array(
						'post_title'   => $item->orginal_post->post_title,
						'post_content' => $item->orginal_post->post_content,
						'post_status'  => $item->orginal_post->post_status,
						'post_type'    => $item->orginal_post->post_type
					);

					$new_post_id = wp_insert_post( $data );

					$item->object_id = is_int( $new_post_id ) ? $new_post_id : 0;
				}

				// Insere o item no menu
				wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'     => $item->title,
						'menu-item-classes'   => implode( " ", $item->classes ),
						'menu-item-url'       => $item->url,
						'menu-item-status'    => $item->post_status,
						'menu-item-object-id' => (int) $item->object_id,
						'menu-item-object'    => $item->object,
						'menu-item-type'      => $item->type
					)
				);

			}
		}
	}

	restore_current_blog();

}

add_action( 'wp_ajax_certificados', 'busca_nome_certificado' );
add_action( 'wp_ajax_nopriv_certificados', 'busca_nome_certificado' );
function busca_nome_certificado() {

	global $wpdb;

	$nomes_encontrados = $wpdb->get_results( $wpdb->prepare( "SELECT c.id as id, c.nome as nome, e.nome as nome_evento
                              FROM participantes c INNER JOIN evento e
                              ON (e.id = c.evento_id) WHERE c.nome like %s", '%' . $_POST['q'] . '%' ) );

	echo json_encode( $nomes_encontrados );

	die();
}

// Adiciona estilos adicionais para outros serviços
add_action( 'wp_print_styles', 'pensando_certificado_styles' );

function pensando_certificado_styles() {
	if ( is_page( 'certificados' ) ) {
		wp_enqueue_style( 'theme-certificados', get_stylesheet_directory_uri() . '/css/theme-certificados.css' );
	}
}
