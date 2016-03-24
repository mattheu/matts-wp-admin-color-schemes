<?php
/**
Plugin Name: Matts Admin Color Schemes
Plugin URI: http://matth.eu
Description: Yet Even more admin color schemes
Version: 1.0
Author: Mattheu
Author URI: http://matth.eu
Text Domain: admin_schemes
Domain Path: /languages
*/

/*
Copyright 2013 Kelly Dwan, Mel Choyce, Dave Whitley, Kate Whitley

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
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class MACS_Color_Schemes {

	/**
	 * List of colors registered in this plugin.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $colors List of colors registered in this plugin.
	 *                    Needed for registering colors-fresh dependency.
	 */
	private $colors = array(
		'fern', 'matt2', 'matt3'
	);

	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_default_css' ) );
		add_action( 'admin_init' , array( $this, 'add_colors' ) );
	}

	/**
	 * Register color schemes.
	 */
	function add_colors() {
		$suffix = is_rtl() ? '-rtl' : '';

		wp_admin_css_color(
			'fern', __( 'Fern', 'admin_schemes' ),
			plugins_url( "fern/colors$suffix.css", __FILE__ ),
			array( '#353129', '#484A47', '#c1d973', '#81AFB5' ),
			array( 'base' => '#ECEBCA', 'focus' => '#c1d973', 'current' => '#c1d973' )
		);

		wp_admin_css_color(
			'autumn', __( 'Autumn', 'admin_schemes' ),
			plugins_url( "autumn/colors$suffix.css", __FILE__ ),
			array( '#52504C', '#65625d', '#cb992f', '#cb2f2f' ),
			array( 'base' => '#65625d', 'focus' => '#cb992f', 'current' => '#cb992f' )
		);

		wp_admin_css_color(
			'crimson', __( 'Crimson', 'admin_schemes' ),
			plugins_url( "crimson/colors$suffix.css", __FILE__ ),
			array( '#821116', '#9C0D13', '#E8A41E', '#E5E3DE' ),
			array( 'base' => '#ECEBCA', 'focus' => '#cb992f', 'current' => '#cb992f' )
		);

		wp_admin_css_color(
			'deep-sea', __( 'Deep Sea', 'admin_schemes' ),
			plugins_url( "deep-sea/colors$suffix.css", __FILE__ ),
			array( '#0F1F27', '#193441', '#7FAB6F', '#437D9A' ),
			array( 'base' => '#ECEBCA', 'focus' => '#cb992f', 'current' => '#cb992f' )
		);

	}

	/**
	 * Make sure core's default `colors.css` gets enqueued, since we can't
	 * @import it from a plugin stylesheet. Also force-load the default colors
	 * on the profile screens, so the JS preview isn't broken-looking.
	 */
	function load_default_css() {

		global $wp_styles, $_wp_admin_css_colors;

		$color_scheme = get_user_option( 'admin_color' );

		$scheme_screens = apply_filters( 'acs_picker_allowed_pages', array( 'profile', 'profile-network' ) );
		if ( in_array( $color_scheme, $this->colors ) || in_array( get_current_screen()->base, $scheme_screens ) ){
			$wp_styles->registered[ 'colors' ]->deps[] = 'colors-fresh';
		}

	}

}
global $acs_colors;
$acs_colors = new MACS_Color_Schemes;

