<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class dazzler_team_m {
	private static $instance;
    public static function forge() {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }
	
	private function __construct() {
		add_action('admin_enqueue_scripts', array(&$this, 'dazzler_team_m_admin_scripts'));
        if (is_admin()) {
			add_action('init', array(&$this, 'team_m_register_cpt'), 1);
			add_action('add_meta_boxes', array(&$this, 'dazzler_team_m_meta_boxes_group'));
			add_action('admin_init', array(&$this, 'dazzler_team_m_meta_boxes_group'), 1);
			add_action('save_post', array(&$this, 'add_team_m_save_meta_box_save'), 9, 1);
			add_action('save_post', array(&$this, 'team_m_settings_meta_box_save'), 9, 1);
		}
    }
	// admin scripts
	public function dazzler_team_m_admin_scripts(){
		if(get_post_type()=="team_member"){
			
			wp_enqueue_script('theme-preview');
			wp_enqueue_media();
			wp_enqueue_script('jquery-ui-datepicker');
			//color-picker css n js
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style('thickbox');
			wp_enqueue_script( 'dazzler_team_m-color-pic', dazzler_team_m_directory_url.'assets/js/color-picker.js', array( 'wp-color-picker' ), false, true );
			wp_enqueue_style('dazzler_team_m-panel-style', dazzler_team_m_directory_url.'assets/css/panel-style.css');
			 wp_enqueue_script('dazzler_team_m-media-uploads',dazzler_team_m_directory_url.'assets/js/media-upload-script.js',array('media-upload','thickbox','jquery')); 
			//font awesome css
			wp_enqueue_style('dazzler_team_m-font-awesome', dazzler_team_m_directory_url.'assets/css/font-awesome/css/font-awesome.min.css');
			wp_enqueue_style('dazzler_team_m_bootstrap', dazzler_team_m_directory_url.'assets/css/bootstrap.css');
			wp_enqueue_style('dazzler_team_m_jquery-css', dazzler_team_m_directory_url .'assets/css/ac_jquery-ui.css');
			
			//css line editor
			wp_enqueue_style('dazzler_team_m_line-edtor', dazzler_team_m_directory_url.'assets/css/jquery-linedtextarea.css');
			wp_enqueue_script( 'dazzler_team_m-line-edit-js', dazzler_team_m_directory_url.'assets/js/jquery-linedtextarea.js');
			
			wp_enqueue_script( 'dazzler_tabs_bootstrap-js', dazzler_team_m_directory_url.'assets/js/bootstrap.js');
			
			//tooltip
			wp_enqueue_style('dazzler_team_m_tooltip', dazzler_team_m_directory_url.'assets/tooltip/darktooltip.css');
			wp_enqueue_script( 'dazzler_team_m-tooltip-js', dazzler_team_m_directory_url.'assets/tooltip/jquery.darktooltip.js');
			
			// tab settings
			wp_enqueue_style('dazzler_team_m_settings-css', dazzler_team_m_directory_url.'assets/css/settings.css');
			
			
		}
	}
	public function team_m_register_cpt(){
		require_once('cpt-reg.php');
		add_filter( 'manage_edit-team_member_columns', array(&$this, 'team_member_columns' )) ;
		add_action( 'manage_team_member_posts_custom_column', array(&$this, 'team_member_manage_columns' ), 10, 2 );
	}
	function team_member_columns( $columns ){
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Teams' ),
            'count' => __( 'Team Count' ),
            'shortcode' => __( 'Teams Shortcode' ),
            'date' => __( 'Date' )
        );
        return $columns;
    }

    function team_member_manage_columns( $column, $post_id ){
        global $post;
		$TotalCount =  get_post_meta( $post_id, 'dazzler_team_m_count', true );
		if(!$TotalCount || $TotalCount==-1){
		$TotalCount =0;
		}
        switch( $column ) {
          case 'shortcode' :
            echo '<input style="width:225px" type="text" value="[TEAM_M id='.$post_id.']" readonly="readonly" />';
            break;
			case 'count' :
            echo $TotalCount;
            break;
          default :
            break;
        }
    }
	// metaboxes
	public function dazzler_team_m_meta_boxes_group(){
		add_meta_box('team_m_add', __('Add Team Panel', dazzler_team_m_text_domain), array(&$this, 'dazzler_add_team_m_meta_box_function'), 'team_member', 'normal', 'low' );
		add_meta_box ('team_m_shortcode', __('Team Shortcode', dazzler_team_m_text_domain), array(&$this, 'dazzler_pic_team_m_shortcode'), 'team_member', 'normal', 'low');
		add_meta_box('team_m_setting', __('Team Settings', dazzler_team_m_text_domain), array(&$this, 'dazzler_add_team_m_setting_function'), 'team_member', 'side', 'low');
	}
	
	public function dazzler_add_team_m_meta_box_function($post){
		require_once('add-team.php');
	}
	public function add_team_m_save_meta_box_save($PostID){
		require('data-post/team-save-data.php');
	}
	public function team_m_settings_meta_box_save($PostID){
		require('data-post/team-settings-save-data.php');
	}
	public function dazzler_pic_team_m_shortcode(){
		require('team-shortcode-css.php');
	}
	
	
	
	public function dazzler_add_team_m_setting_function($post){
		require_once('settings.php');
	}
	
	 
	
}
global $dazzler_team_m;
$dazzler_team_m= dazzler_team_m::forge();
	

?>