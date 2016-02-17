<?php

/**
 * Created by PhpStorm.
 * User: josafafilho
 * Date: 12/1/15
 * Time: 19:23
 */
class Pensando_API_Noticias extends WP_JSON_CustomPostType {
	protected $base = '/noticias';
	protected $type = 'post';

//	public function register_filters() {
//		aplicar algum filtro ou alterar variaveis se necessário
//		parent::register_filters();
//
//		add_filter( 'json_prepare_post', array( $this, 'json_api_prepare_post_filter' ), 10, 3 );
//	}

	public function register_routes( $routes ) {

		$routes[ $this->base ] = array(
			array( array( $this, 'get_noticias' ), WP_JSON_Server::READABLE ),
		);

		$routes[ $this->base . '/(?P<id>\d+)' ] = array(
			array( array( $this, 'get_noticia' ), WP_JSON_Server::READABLE ),
		);

		return $routes;
	}

	public function get_noticias( $filter = array(), $context = 'view', $type = null, $page = 1 ) {
		//aplicar algum filtro ou alterar variaveis se necessário

		return parent::get_posts( $filter, $context, $type, $page );
	}

	public function get_noticia( $id, $context = 'view' ) {
		return parent::get_post( $id, $context );
	}
}
