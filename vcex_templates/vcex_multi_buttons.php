<?php
/**
 * Visual Composer Multi-Buttons
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 4.3.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Not needed in admin ever
if ( is_admin() ) {
	return;
}

// Required VC functions
if ( ! function_exists( 'vc_map_get_attributes' ) ) {
	vcex_function_needed_notice();
	return;
}

// Get shortcode attributes
$atts = vc_map_get_attributes( 'vcex_multi_buttons', $atts );

// Get buttons
$buttons = (array) vc_param_group_parse_atts( $atts['buttons'] );

// Buttons are required
if ( ! $buttons ) {
	return;
}

// Inline styles
$wrap_inline_style = array(
	'font_size'      => $atts['font_size'],
	'letter_spacing' => $atts['letter_spacing'],
	'font_family'    => $atts['font_family'],
	'font_weight'    => $atts['font_weight'],
	'text_align'     => $atts['align'],
	'border_radius'  => $atts['border_radius'],
);

// Load custom Google font if needed
wpex_enqueue_google_font( $atts['font_family'] );

// Define wrap attributes
$wrap_attrs = array(
	'class' => 'vcex-multi-buttons vcex-clr',
	'style' => vcex_inline_style( $wrap_inline_style, false ),
);

// Get responsive data
if ( $responsive_data = vcex_get_module_responsive_data( $atts ) ) {
	$wrap_attrs['data']  = $responsive_data['data'];
	$wrap_attrs['class'] .= ' wpex-rcss '. $responsive_data['uniqid'];
}

// Visibility
if ( $atts['visibility'] ) {
	$wrap_attrs['class'] .= ' ' . $atts['visibility'];
}

// Extra classname
if ( $atts['el_class'] ) {
	$wrap_attrs['class'] .= ' ' . vcex_get_extra_class( $atts['el_class'] );
}

// Full width buttons on mobile
if ( 'true' == $atts['small_screen_full_width'] ) {
	$wrap_attrs['class'] .= ' vcex-small-screen-full-width';
}

// Define output
$output = '<div ' . wpex_parse_attrs( $wrap_attrs ) . '>';

	// Count number of buttons
	$buttons_count = count( $buttons );

	// Loop through buttons
	$count = 0;
	foreach ( $buttons as $button ) {
		$count ++;

		// Button url is required
		if ( ! isset( $button['link'] ) ) {
			continue;
		}

		// Get link data
		$link_data = vcex_build_link( $button['link'] );

		// Link is required
		if ( ! isset( $link_data['url'] ) ) {
			continue;
		}

		// Sanitize text
		$text = isset( $button['text'] ) ? $button['text'] : __( 'Button', 'total' );

		// Get button style
		$style        = isset( $button['style'] ) ? $button['style'] : '';
		$color        = isset( $button['color'] ) ? $button['color'] : '';
		$custom_color = isset( $button['custom_color'] ) ? $button['custom_color'] : '';
		$hover_color  = isset( $button['custom_color_hover'] ) ? $button['custom_color_hover'] : '';

		// Fallback from original release to include only styles that make sense!
		if ( 'minimal-border' == $style ) {
			$style = 'outline';
		} elseif ( 'three-d' == $style || 'graphical' == $style ) {
			$style = 'flat';
		} elseif ( 'clean' == $style ) {
			$style = 'flat';
			$color = 'white';
		}

		// Button css
		$button_css = vcex_inline_style( array(
			'padding'      => $atts['padding'],
			'border_width' => $atts['border_width'] ? absint( $atts['border_width'] ) . 'px' : '',
		), false );
		if ( $atts['spacing'] ) {
			$margin = absint( $atts['spacing'] ) / 2 . 'px';
			$button_css .= 'margin:0 ' . $margin . ' ' . $margin . ';';
		}
		// Custom color
		if ( $custom_color
			&& $custom_color_css = wpex_get_button_custom_color_css( $style, $custom_color )
		) {
			$button_css .= ' ' . $custom_color_css;
		}

		// Define button attributes
		$attrs = array(
			'href'   => esc_url( $link_data['url'] ),
			'title'  => isset( $link_data['title'] ) ? $link_data['title'] : '',
			'class'  => wpex_get_button_classes( $style, $color ),
			'target' => isset( $link_data['target'] ) ? $link_data['target'] : '',
			'rel'    => isset( $link_data['rel'] ) ? esc_attr( $link_data['rel'] ) : '',
			'style'  => $button_css,
		);

		// Add animation to button classes
		if ( isset( $button['css_animation'] ) && 'none' != $button['css_animation'] ) {
			$attrs['class'] .= ' ' . vcex_get_css_animation( $button['css_animation'] );
		}

		// Add counter to button class => Useful for custom styling purposes
		$attrs['class'] .= ' vcex-count-' . $count;

		// Hover data/class
		if ( $custom_color || $hover_color ) {

			if ( 'outline' == $style && ! $hover_color ) {
				$hover_color = $custom_color;
			}

			if ( $hover_color ) {

				// Color
				if ( 'plain-text' == $style ) {
					$attrs['data-hover-color'] = $hover_color;
					$attrs['class'] .= ' wpex-data-hover';
				}

				// Backgrounds
				else {
					$attrs['data-hover-background'] = $hover_color;
					$attrs['class'] .= ' wpex-data-hover';
				}

			}

		}

		// Output button
		$output .= wpex_parse_html( 'a', $attrs, $text );

	}

$output .= '</div>';

echo $output;