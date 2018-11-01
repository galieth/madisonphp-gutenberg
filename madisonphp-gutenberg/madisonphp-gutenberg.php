<?php
/**
* Plugin Name: Madisonphp - Gutenberg 
* Plugin URI: https://earthilnginteractive.com/madisonphp
* Description: A plugin that adjusts how gutenberg acts on our site.
* Version: 1.2
* Author: Earthling Interactive
* Author URI: https://earthlinginteractive.com
* License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
* Text Domain: madisonphp-gutenberg
* Domain Path: /languages
*/


function madison_gutenberg_disable_custom_colors() {
	add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'madison_gutenberg_disable_custom_colors' );

function madison_gutenberg_color_palette() {
	add_theme_support(
		'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'Black'),
				'slug' => 'black',
				'color' => '#2a2a2a',
			)
		)
	);
}
add_action( 'after_setup_theme', 'madison_gutenberg_color_palette' );

wp_enqueue_style( 'madisonphp-gutenberg', plugins_url( '/css/madisonphp-gutenberg.css', __FILE__ ),array(), '1.2');

?>