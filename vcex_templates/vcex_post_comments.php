<?php
/**
 * Visual Composer Comments
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 4.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Not needed in admin ever
if ( is_admin() || ! function_exists( 'comments_template' ) ) {
	return;
}

// Required VC functions
if ( ! function_exists( 'vc_map_get_attributes' ) || ! function_exists( 'vc_param_group_parse_atts' ) ) {
	vcex_function_needed_notice();
	return;
}

// Get and extract shortcode attributes
$atts = vc_map_get_attributes( 'vcex_post_comments', $atts );

// Define wrapper attributes
$wrap_attrs = array(
	'class' => 'vcex-comments clr',
);

// Extra classname
if ( $atts['el_class'] ) {
	$wrap_attrs['class'] .= ' ' . vcex_get_extra_class( $atts['el_class'] );
}

// Visibility
if ( $atts['visibility'] ) {
	$wrap_attrs['class'] .= ' ' . $atts['visibility'];
}

// Output comments
echo '<div ' . wpex_parse_attrs( $wrap_attrs ) . '>';

	comments_template();

echo '</div>';