<?php
/**
 * Plugin Name: Team dazzler  
 * Version: 1.1
 * Description:  Team plugin will manage your teams on your wordpress site easily, you can add unlimited team member with darg & drop builder  
 * Author: Dazzlersoft
 * Author URI: http://www.dazzlersoftware.com
 * Plugin URI: http://dazzlersoftware.com/teams-plugin-for-wordpress/
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
 /**
 * DEFINE PATHS
 */
define("dazzler_team_m_directory_url", plugin_dir_url(__FILE__));
define("dazzler_team_m_text_domain", "dazzler_team_m");

require_once("ink/install.php");

function dazzler_team_m_default_data() {
	
	$Settings_Array = serialize( array(
				"team_mb_name_clr" 	 => "#000000",
				"team_mb_pos_clr" => "#000000",
				"team_mb_desc_clr" => "#000000",
				"team_mb_social_icon_clr"   => "#ffffff",
				"team_mb_social_icon_clr_bg"   => "#e5e5e5",
				"team_mb_name_ft_size"   => 18,
				"team_mb_pos_ft_size"   => 14,
				"team_mb_desc_ft_size"   => 14,
				"font_family"   => "Open Sans",
				"team_layout"   => 4,
				"custom_css"   => "",
				"team_mb_wrap_bg_clr"   => "#1e73be",
				"team_mb_opacity" => 80,
				"design"   => 1,
				
		) );

	add_option('Team_M_default_Settings', $Settings_Array);
}
register_activation_hook( __FILE__, 'dazzler_team_m_default_data' );

add_action('admin_menu' , 'dazzler_team_m_recom_menu');
function dazzler_team_m_recom_menu() {
	$submenu = add_submenu_page('edit.php?post_type=team_member', __('More_Free_Plugins', dazzler_team_m_text_domain), __('More Free Plugins', dazzler_team_m_text_domain), 'administrator', 'dazzler_team_m_recom_page', 'dazzler_team_m_recom_page_funct');
	
	//add hook to add styles and scripts for Responsive Accordion plugin admin page
    add_action( 'admin_print_styles-' . $submenu, 'dazzler_team_m_recom_js_css' );
	}
	function dazzler_team_b_recom_js_css(){
		wp_enqueue_style('dazzler_team_m_bootstrap_css_recom', dazzler_team_m_directory_url.'assets/css/bootstrap.css');
		wp_enqueue_style('dazzler_ac_help_css', dazzler_team_m_directory_url.'assets/css/help.css');
	}
function dazzler_team_m_recom_page_funct(){
	require_once('ink/admin/free.php');
}

 if(!function_exists('dazz_hex2rgb_teams')) {
    function dazz_hex2rgb_teams($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       return $rgb; // returns an array with the rgb values
    }
}
/**
 * CPT CLASS
 */
 
require_once("ink/admin/menu.php");

/**
 * SHORTCODE
 */
 
 require_once("template/shortcode.php");
?>