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

class internalLinks {

function __construct()
{
    wp_embed_register_handler(
        'internal_link',
        '#^('.home_url().'/.+)$#i',
        array(&$this, 'handler')
    );
    add_action('wp_head', array(&$this, 'wp_head'));
    add_shortcode('internal_link', array(&$this, 'display'));
}

public function wp_head()
{
    $url = plugins_url("", __FILE__).'/style.css';
    printf(
        '<link rel="stylesheet" type="text/css" media="all" href="%s" />'."\n",
        apply_filters("oembed-internal-link-stylesheet", $url)
    );
}

private function template()
{
    $w = get_option("thumbnail_size_w");
    $h = get_option("thumbnail_size_h");

    $html = '<div class="internal-link internal-link-%post_id%">';
    $html .= '<div class="post-thumb" style="width:'.intval($w).'px;height:'.intval($h).'px;">';
    $html .= '<a href="%post_url%">%post_thumb%</a>';
    $html .= '</div>';
    $html .= '<div class="post-content">';
    $html .= '<h4><a href="%post_url%">%post_title%</a></h4>';
    $html .= '<div class="post-excerpt">%post_excerpt%</div>';
    $html .= '</div>';
    $html .= '</div>';
    return apply_filters("oembed-internal-link-template", $html);
}

public function handler($matches, $attr, $url, $rawattr)
{
    $args = preg_split("/#/", $matches[1]);
    return "[internal_link url=\"{$matches[1]}\"]";
}

public function display($p){
    if (!isset($p['url']) || !$p['url']) {
        return ;
    }
    $id = url_to_postid($p['url']);
    $img = get_the_post_thumbnail($id, "thumbnail");
    $post = get_post($id);

    $tpl = $this->template();
    $tpl = str_replace('%post_id%', esc_html($id), $tpl);
    $tpl = str_replace('%post_title%', esc_html($post->post_title), $tpl);
    $tpl = str_replace('%post_excerpt%', esc_html($post->post_excerpt), $tpl);
    $tpl = str_replace('%post_thumb%', $img, $tpl);
    $tpl = str_replace('%post_url%', esc_url($p['url']), $tpl);

    return $tpl;
}

}

?>
