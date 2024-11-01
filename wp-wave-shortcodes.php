<?php
/*
Plugin Name: Wave Shortcodes
Plugin URI: http://code.google.com/p/wp-wave-shortcodes/
Description: Gives you a shortcode to embed a Wave in your WordPress page/post.
Author: Joshua French
Version: 1.0
*/

/*  Copyright 2009 Joshua French  (email : josh.23.french@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

global $wave_ids, $wp_wave_shortcodes_defaults;
$wave_ids = array();
$wp_wave_shortcodes_defaults = array(
	'id'       => NULL,
	'width'    => get_option( 'wp_wave_shortcodes_width' ),
	'height'   => get_option( 'wp_wave_shortcodes_height' ),
	'bgcolor'  => get_option( 'wp_wave_shortcodes_bgcolor' ),
	'color'    => get_option( 'wp_wave_shortcodes_color' ),
	'font'     => get_option( 'wp_wave_shortcodes_font' ),
	'fontsize' => absint( get_option( 'wp_wave_shortcodes_size' ) ) );

/**
 * Outputs the Wave embed API js
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_head () {
?>
<script src='http://wave-api.appspot.com/public/embed.js' type='text/javascript'></script>
<?php
}

function wp_wave_footer () {
	global $wave_ids;
	// init each wave
?>
<script type='text/javascript'>
	jQuery(document).ready(function($){
		<?php
			$i = 0;
			foreach( $wave_ids as $wave_id => $UIConfig) {
			$i++;
				?>
var wavePanel<?php print $i; ?> = new WavePanel( 'http://wave.google.com/a/wavesandbox.com/' );
wavePanel<?php print $i; ?>.loadWave( 'wavesandbox.com!w+<?php print $wave_id; ?>' );
wavePanel<?php print $i; ?>.setUIConfig( '<?php print $UIConfig['bgcolor']; ?>', '<?php print $UIConfig['color']; ?>', '<?php print $UIConfig['font']; ?>', '<?php print $UIConfig['fontsize']; ?>' )
wavePanel<?php print $i; ?>.init( document.getElementById( 'waveframe-<?php print $wave_id;?>' ) );
				<?php
			}
		?>
	});
</script>
<?php
}

/**
 * The function called upon do_action( 'init' )
 *
 * This function adds jQuery to the page, if it's not already. It also adds the
 * media button if the user is editing the page/post and can.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_init () {
	wp_enqueue_script( 'jquery' );
	if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) == 'true' ) {
	    add_action( 'media_buttons', 'wp_wave_buttons', 11 ); // 11 priority makes the button appear after the default buttons
	}
}

/**
 * Outputs the media button above the post edit box
 *
 * This function does some fancy work to determine the plugin url, then outputs
 * the button HTML. It is called on do_action( 'media_buttons' )
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_buttons () {
	$p = WP_PLUGIN_URL;
	if ( substr( $_SERVER["HTTP_REFERER"], 0, 5 ) == "https" && substr( WP_PLUGIN_URL, 0, 5 ) != "https" )
		$p = 'https' . substr( WP_PLUGIN_URL, 4, strlen( WP_PLUGIN_URL ) );
	$x = $p . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) );
/**
 * @TODO Change the above to included the uri trick that begins with just the
 *       protocol.. ie. //www.example.com/path/to/file.ext
 */
	$wave_iframe_src = apply_filters( 'wave_iframe_src', $x.'embed-dialog.php?' );
	$wave_title = __( 'Add Wave' );
	print '<a href="' . $wave_iframe_src . '" id="add_wave" class="thickbox" title="' . $wave_title . '" onclick="return false;"><img src="' . $x . 'wave-embed.gif" alt="' . $wave_title . '" /></a>';
}

/**
 * The WordPress Shortcode API callback for the 'wave' shortcode
 *
 * This function gets the attributes that are in the shortcode and merges them
 * with the defaults that are in the database. It then checks to make sure
 * they are valid. The options are added to the $wave_ids array and the
 * corresponding div is written to the page.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @global       array $wave_ids
 * @global       array $wp_wave_shortcodes_defaults
 * @param        array [$atts] Attributes that WordPress extracts from the shortcode
 * @return       string An HTML div containing some of the code to embed that Wave
 * @since        1.0
 * @staticvar    boolean $head Determines if there are any Waves to be embedded.
 */
function wp_wave_embed ( array $atts ) {
	static $head = false;
	global $wave_ids, $wp_wave_shortcodes_defaults;
	// defaults: setUIConfig('white', 'black', 'Arial', '13px');
	extract( shortcode_atts( $wp_wave_shortcodes_defaults, $atts ) );
	
	// no ID, no wave
	if ( NULL == $id ) {
		return;
	}
	
	// regex-check width ... is this even helpful, or is it a waste of time? (never trust the luser, but what could it hurt?)
	if ( preg_match( '/^(auto|inherit|\d+\s?(%|px|pts|em|cm|in))(;?)$/', $width, $width2 ) )
		$width = intval( rtrim( $width2[0], ';' ) );
	else
		$width = $wp_wave_shortcodes_defaults['width'];

	// and height
	if ( preg_match('/^(auto|inherit|\d+\s?(%|px|pts|em|cm|in))(;?)$/', $height, $height2 ) )
		$height = rtrim( $height2[0], ';' );
	else
		$height = $wp_wave_shortcodes_defaults['height'];
	
	// and bgcolor
	if( preg_match('/^\#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})(;?)$/', $bgcolor, $bgcolor2 ) )
		$bgcolor = rtrim( $bgcolor2[0], ';' );
	else
		$bgcolor = $wp_wave_shortcodes_defaults['bgcolor'];

	// and color
	if( preg_match('/^\#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})(;?)$/', $color, $color2 ) )
		$color = rtrim( $color2[0], ';' );
	else
		$color = $wp_wave_shortcodes_defaults['color'];

	// add id to wave_ids
	$wave_ids[$id] = array(
		'bgcolor'  => $bgcolor,
		'color'    => $color,
		'font'     => $font,
		'fontsize' => $fontsize );

	// construct & return the wave div
	return '<div id="waveframe-' . $id . '" style="width: ' . $width . '; height: ' . $height . '"></div>';
}

/**
 * The function called on do_action( 'admin_init' )
 *
 * This function adds jQuery, farbtastic, and the farbtastic css to the output.
 * It also adds each setting to the section. The callbacks are located in
 * settings-callbacks.php to keep the code from being too cluttered.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_settings_init () {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'farbtastic' );
	wp_enqueue_style( 'farbtastic' );

	add_settings_section( 'wp_wave_shortcodes', 'wp-wave-shortcodes embed defaults', 'wp_wave_settings_section_callback', 'general' );

	add_settings_field( 'wp_wave_shortcodes_bgcolor', 'Background Color', 'wp_wave_shortcodes_callback_bgcolor', 'general', 'wp_wave_shortcodes' );
	register_setting( 'general','wp_wave_shortcodes_bgcolor' );

	add_settings_field( 'wp_wave_shortcodes_color', 'Text Color', 'wp_wave_shortcodes_callback_color', 'general', 'wp_wave_shortcodes' );
	register_setting( 'general','wp_wave_shortcodes_color' );

	add_settings_field( 'wp_wave_shortcodes_font', 'Font Family', 'wp_wave_shortcodes_callback_font', 'general', 'wp_wave_shortcodes' );
	register_setting( 'general','wp_wave_shortcodes_font' );

	add_settings_field( 'wp_wave_shortcodes_size', 'Font Size', 'wp_wave_shortcodes_callback_size', 'general', 'wp_wave_shortcodes' );
	register_setting( 'general','wp_wave_shortcodes_size' );

	add_settings_field( 'wp_wave_shortcodes_width', 'Width', 'wp_wave_shortcodes_callback_width', 'general', 'wp_wave_shortcodes' );
	register_setting( 'general','wp_wave_shortcodes_width' );

	add_settings_field( 'wp_wave_shortcodes_height', 'Height', 'wp_wave_shortcodes_callback_height', 'general', 'wp_wave_shortcodes' );
	register_setting( 'general','wp_wave_shortcodes_height' );

	require_once 'settings-callbacks.php';
}

/**
 * Outputs the js to control the color picker, etc. in options-general.php
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_admin_footer () {
	?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		var fg = jQuery.farbtastic('#colorpicker');
		jQuery('.farbitize').each(function() {
			fg.linkTo(jQuery(this));
			fg.setColor(jQuery(this).val());
			jQuery(this).click(function() {
				jQuery('#colorpicker').show();
				fg.linkTo(jQuery(this));
			}).click();
			jQuery('#colorpicker').hide();
		});
		jQuery(document).mousedown(function(){
			jQuery('#colorpicker').hide();
		});
	});
</script>
<?php
}

add_shortcode( 'wave', 'wp_wave_embed' );
add_action( 'admin_init', 'wp_wave_settings_init' );
add_action( 'init', 'wp_wave_init' );
add_action( 'wp_head', 'wp_wave_head' );
add_action( 'wp_footer', 'wp_wave_footer' );
add_action( 'admin_footer-options-general.php', 'wp_wave_admin_footer' );