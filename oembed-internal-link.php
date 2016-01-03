<?php
/*
Plugin Name: oEmbed Intarnal Link
Author: Takayuki Miyauchi
Plugin URI: http://firegoby.jp/wp/oembed-internal-link
Description: Display thumbnail link from URL.
Version: 0.5.0
Author URI: http://firegoby.jp/
Domain Path: /languages
Text Domain: oembed-internal-link
*/

new internalLinks();

class internalLinks
{
	function __construct()
	{
		wp_embed_register_handler(
			'internal_link',
			'#^(' . home_url() . '/.+)$#i',
			array( $this, 'handler' )
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
	}

	public function wp_enqueue_scripts()
	{
		$url = apply_filters( "oembed_internal_link_stylesheet", plugins_url( "", __FILE__ ).'/style.css' );

		if ( $url ) {
			wp_enqueue_style(
				'oembed_internal_link_stylesheet',
				apply_filters( "oembed_internal_link_stylesheet", $url ),
				array(),
				'v0.5.0'
			);
		}
	}

	private function template()
	{
		$html = '<div class="internal-link internal-link-%post_id%">';
		$html .= '<div class="post-thumb">';
		$html .= '<a href="%post_url%">%post_thumb%</a>';
		$html .= '</div>';
		$html .= '<div class="post-content">';
		$html .= '<h4><a href="%post_url%">%post_title%</a></h4>';
		$html .= '<div class="post-excerpt">%post_excerpt%</div>';
		$html .= '</div>';
		$html .= '</div>';
		return apply_filters( "oembed_internal_link_template", $html );
	}

	public function handler( $matches, $attr, $url, $rawattr )
	{
		return $this->display( $url );
	}

	public function display( $url )
	{
		$id = url_to_postid( $url );
		$img = get_the_post_thumbnail( $id, apply_filters( "oembed_internal_link_thumbnail_size", "thumbnail" ) );
		$post = get_post( $id );

		$tpl = $this->template();
		$tpl = str_replace( '%post_id%', esc_html( $id ), $tpl );
		$tpl = str_replace( '%post_title%', esc_html( $post->post_title ), $tpl );
		$tpl = str_replace( '%post_excerpt%', esc_html( $post->post_excerpt ), $tpl );
		$tpl = str_replace( '%post_thumb%', $img, $tpl );
		$tpl = str_replace( '%post_url%', esc_url( $url ), $tpl );

		return $tpl;
	}

}

?>
