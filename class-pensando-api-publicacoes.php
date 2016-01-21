<?php

/**
 * Created by PhpStorm.
 * User: josafafilho
 * Date: 12/1/15
 * Time: 19:23
 */
class Pensando_API_Publicacoes extends WP_JSON_CustomPostType {
	protected $base = '/publicacoes';
	protected $type = 'publicacao';

	public function register_filters() {
		parent::register_filters();

		add_filter( 'query_vars', array( $this, 'query_vars_filter' ) );
		add_filter( 'json_prepare_post', array( $this, 'json_api_prepare_post_filter' ), 10, 3 );
	}

	public function register_routes( $routes ) {

		$routes[ $this->base ] = array(
			array( array( $this, 'get_publicacoes' ), WP_JSON_Server::READABLE ),
		);

		$routes[ $this->base . '/(?P<id>\d+)' ] = array(
			array( array( $this, 'get_publicacao' ), WP_JSON_Server::READABLE ),
		);

		return $routes;
	}

	public function get_publicacoes( $filter = array(), $context = 'view', $type = null, $page = 1 ) {
		$filter['orderby']  = 'meta_value_num';
		$filter['meta_key'] = 'pub_number';

		return parent::get_posts( $filter, $context, $type, $page );
	}

	public function get_publicacao( $id, $context = 'view' ) {
		return parent::get_post( $id, $context );
	}


	public function query_vars_filter( $vars ) {
		$vars[] = 'meta_key';

		return $vars;
	}

	/**
	 * Filtro para incluir apenas os campos referentes a publicação
	 *
	 * @param $post_response
	 * @param $post
	 * @param $context
	 *
	 * @return mixed
	 */
	public function json_api_prepare_post_filter( $post_response, $post, $context ) {

		if ( $post['post_type'] == $this->type ) {
			$dldField         = get_post_meta( $post['ID'], "pub_dld_file", true );
			$volumeField      = get_post_meta( $post['ID'], "pub_number", true );
			$dateField        = get_post_meta( $post['ID'], "pub_date", true );
			$coordenacaoField = get_post_meta( $post['ID'], "pub_coordenacao", true );

			/*Campos relacionados a publicação*/

			$publicacao['url']         = $dldField;
			$publicacao['file_size']   = $this->get_file_size( $dldField );
			$publicacao['volume']      = $volumeField;
			$publicacao['date']        = $dateField;
			$publicacao['coordenacao'] = $coordenacaoField;

			list( $title, $subtitle ) = $this->parse_title( $post_response['title'] );

			/*Campos do Post*/
			$publicacao['ID']             = $post_response['ID'];
			$publicacao['title']          = $title;
			$publicacao['subtitle']       = $subtitle;
			$publicacao['content']        = $post_response['content'];
			$publicacao['link']           = $post_response['link'];
			$publicacao['slug']           = $post_response['slug'];
			$publicacao['featured_image'] = $post_response['featured_image'];
			$publicacao['meta']           = $post_response['meta'];

			return $publicacao;
		} else {
			return $post_response;
		}
	}

	public function parse_title( $title ) {
		$subtitle = '';
		$parts    = preg_split( "/[:–-]/", $title );

		if ( $parts ) {
			$title = $parts[0];

			for ( $i = 1; $i < count( $parts ); $i ++ ) {
				$trimmed = trim( $parts[ $i ] );
				if ( strlen( $trimmed ) > 0 ) {
					$subtitle .= $trimmed . ' ';
				}
			}
		}

		return array( trim( $title ), trim( $subtitle ) );
	}

	private function get_file_size( $url ) {

		$filepath = str_replace( "/wp-content", "", parse_url( $url, PHP_URL_PATH ) );

		$path = WP_CONTENT_DIR . $filepath;

		if ( file_exists( $path ) ) {
			return filesize( $path );
		}

		return 0;
	}
}
