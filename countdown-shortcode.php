<?php
/*
 * Plugin Name: Countdown Shortcode
 * Description: This plugin will add a shortcode `[countdown]` which uses the jQuery Countdown library
 * Version: 1.0.0
 * Author: Bernhard Kau
 * Author URI: http://kau-boys.de
 * Plugin URI: https://github.com/2ndkauboy/countdown-shortcode
 * Text Domain: countdown-shortcode
 * Domain Path: /languages
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
*/

function countdown_shortcode_load_textdomain() {
	load_plugin_textdomain( 'countdown-shortcode', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'countdown_shortcode_load_textdomain' );

/**
 * @param $atts array The shortcode attributes.
 *
 * @return string The shortcode output.
 */
function countdown_shortcode_render( $atts ) {

	wp_enqueue_script( 'countdown-shortcode' );

	$a = shortcode_atts( array(
		'final_date' => '',
		'format' => __( '%w weeks %d days %H hours %M minutes %S seconds', 'countdown-shortcode' ),
	), $atts );

	$countdown_container_id = 'countdown-container-' . random_int( 0, 1000 );

	$content = '<div id="' . esc_attr( $countdown_container_id ) . '"></div>
				<script>
					jQuery(document).ready(function($){
						$("#' . esc_js( $countdown_container_id ) . '").countdown("' . esc_js( $a['final_date'] ) . '", function(event) {
							$(this).html(event.strftime("' . $a['format'] . '"));
						});
					});
				</script>';

	return $content;
}
add_shortcode( 'countdown', 'countdown_shortcode_render' );

function countdown_shortcode_register_script() {
	wp_register_script( 'countdown-shortcode', plugins_url( '/js/jquery.countdown.min.js' , __FILE__ ), array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'countdown_shortcode_register_script' );