<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Avani
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses avani_header_style()
 */
function avani_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'avani_custom_header_args', array(
		'default-image'          => '',
		'width'                  => 1366,
		'height'                 => 320,
		'flex-width'             => true,
		'flex-height'            => true,
		'header-text'            => true,
		'default-text-color'     => '',
		'wp-head-callback'       => 'avani_header_style',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	) ) );
}
add_action( 'after_setup_theme', 'avani_custom_header_setup' );

if ( ! function_exists( 'avani_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see avani_custom_header_setup().
	 */
	function avani_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
		 */
		if ( HEADER_TEXTCOLOR === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;