<?php
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

/**
 * Outputs content at the beginning of the settings section
 *
 * This function outputs the section title, the reset button, the reset info
 * div, and the colorpicker div.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_settings_section_callback () {
	print '<p>Default settings for embedding Waves</p>';
	print '<div id="colorpicker" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;left:600px;display:none;"></div>';
}

/**
 * Outputs the bgcolor field in the settings section
 *
 * This function gets the option from the database and sets the value to it.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_shortcodes_callback_bgcolor () {
	$bgcolor = '#ffffff';
	if ( get_option( 'wp_wave_shortcodes_bgcolor' ) )
		$bgcolor = get_option( 'wp_wave_shortcodes_bgcolor' );

	print '<input class="farbitize" name="wp_wave_shortcodes_bgcolor" id="wp_wave_shortcodes_bgcolor" type="text" value="' . $bgcolor . '" />';
	print '<span class="description">Default: #ffffff</span>';
}

/**
 * Outputs the color field in the settings section
 *
 * This function gets the option from the database and sets the value to it.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_shortcodes_callback_color () {
	$color = '#000000';
	if ( get_option( 'wp_wave_shortcodes_color' ) )
		$color = get_option( 'wp_wave_shortcodes_color' );

	print '<input class="farbitize" name="wp_wave_shortcodes_color" id="wp_wave_shortcodes_color" type="text" value="' . $color . '" />';
	print '<span class="description">Default: #000000</span>';
}

/**
 * Outputs the font field in the settings section
 *
 * This function gets the option from the database and sets the value to it.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_shortcodes_callback_font () {
	$font = 'Arial';
	if ( get_option( 'wp_wave_shortcodes_font' ) )
		$font = get_option( 'wp_wave_shortcodes_font' );

	print '<input name="wp_wave_shortcodes_font" id="wp_wave_shortcodes_font" type="text" value="' . $font . '" />';
	print '<span class="description">Default: Arial</span>';
}

/**
 * Outputs the size field in the settings section
 *
 * This function gets the option from the database and sets the value to it.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_shortcodes_callback_size () {
	$size = '10pts';
	if ( get_option( 'wp_wave_shortcodes_size' ) )
		$size = get_option( 'wp_wave_shortcodes_size' );

	print '<input name="wp_wave_shortcodes_size" id="wp_wave_shortcodes_size" type="text" value="' . $size . '" />';
	print '<span class="description">Default: 10pts</span>';
}

/**
 * Outputs the width field in the settings section
 *
 * This function gets the option from the database and sets the value to it.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_shortcodes_callback_width () {
	$width = '100%';
	if ( get_option( 'wp_wave_shortcodes_width' ) )
		$width = get_option( 'wp_wave_shortcodes_width' );

	print '<input name="wp_wave_shortcodes_width" id="wp_wave_shortcodes_width" type="text" value="' . $width . '" />';
	print '<span class="description">Default: 100%</span>';
}

/**
 * Outputs the height field in the settings section
 *
 * This function gets the option from the database and sets the value to it.
 *
 * @author       Joshua French <josh.23.french@gmail.com>
 * @copyright    Joshua French 2009
 * @since        1.0
 */
function wp_wave_shortcodes_callback_height () {
	$height = '100%';
	if (get_option( 'wp_wave_shortcodes_height' ) )
		$height = get_option( 'wp_wave_shortcodes_height' );

	print '<input name="wp_wave_shortcodes_height" id="wp_wave_shortcodes_height" type="text" value="' . $height . '" />';
	print '<span class="description">Default: 100%</span>';
}