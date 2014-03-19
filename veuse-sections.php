<?php
/*
Plugin Name: Veuse Sections
Plugin URI: http://veuse.com/veuse-sections
Description: Creates a post-type for sections that can be inserted in pages. Fully localized. 
Version: 2.0
Author: Andreas Wilthil
Author URI: http://veuse.com
License: GPL3
Text Domain: veuse-sections
Domain Path: /languages
*/

__('Veuse Sections', 'veuse-portfolio' ); /* Dummy call for plugin name translation. */

class VeuseSections {

	private $pluginURI  = '';
	private $pluginPATH = '';
	
	function __construct(){
		
		$this->pluginURI  = plugin_dir_url(__FILE__) ;
		$this->pluginPATH = plugin_dir_path(__FILE__) ;
		
		add_action('init', array(&$this,'register_posttype'));
		add_action('admin_enqueue_scripts', array(&$this,'admin_enqueue_scripts'), 30);
		add_action('wp_enqueue_scripts', array(&$this,'enqueue_scripts'));
		add_action('plugins_loaded', array(&$this,'load_textdomain'));
		add_action('admin_menu', array(&$this,'my_admin_menu')); 
	}
	
	/* Localization
	============================================= */
	
	function load_textdomain() {
	    load_plugin_textdomain('veuse-sections', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}
	
	/* Enqueue scripts */

	function admin_enqueue_scripts() {
	
		//wp_enqueue_style('veuse-sections-admin-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/ui-lightness/jquery-ui.css', false,  '', false);
		wp_enqueue_style('veuse-sections-ui-multiselect-css', $this->pluginURI. 'assets/css/ui.multiselect.css', false,  '', false);
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('multiselect', $this->pluginURI . 'assets/js/ui.multiselect.js', array('jquery'), '', true);

	}
	
	function enqueue_scripts() {
	
		wp_enqueue_style('veuse-sections-css', $this->pluginURI. 'assets/css/veuse-sections.css', false,  '', 'all');
		wp_enqueue_script('veuse-sections-js', $this->pluginURI . 'assets/js/veuse-sections.js', array('jquery'), '', true);

	}
	
	
	/* Register post-type */
	
	function register_posttype() {
	
		$labels = array(
	        'name' => __( 'Sections', 'veuse-sections' ), // Tip: _x('') is used for localization
	        'singular_name' => __( 'Section', 'veuse-sections' ),
	        'add_new' => __( 'Add New Section', 'veuse-sections' ),
	        'add_new_item' => __( 'Add New Section','veuse-sections' ),
	        'edit_item' => __( 'Edit Section', 'veuse-sections' ),
	        'all_items' => __( 'All Sections','veuse-sections' ),
	        'new_item' => __( 'New Section','veuse-sections' ),
	        'view_item' => __( 'View Section','veuse-sections' ),
	        'search_items' => __( 'Search Sections','veuse-sections' ),
	        'not_found' =>  __( 'No Sections','veuse-sections' ),
	        'not_found_in_trash' => __( 'No Sections found in Trash','veuse-sections' ),
	        'parent_item_colon' => ''
	    );
	
		register_post_type('sections',
			array(
				'labels' => $labels,
				'public' => true,
				'show_ui' => true,
				'_builtin' => false, // It's a custom post type, not built in
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'page',
				'hierarchical' => true,
				'rewrite' => array("slug" => "sections"), // Permalinks
				'query_var' => "sections", // This goes to the WP_Query schema
				'supports' => array('title', 'editor'),
				'menu_position' => 20,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'map_meta_cap' => true,
				//'show_in_nav_menus' => false,
				'show_in_menu' => 'edit.php?post_type=page',
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => false
				
				)
			);
			
	}
	
	

	function my_admin_menu() { 
	    add_submenu_page('edit.php?post_type=page', __('New Section','veuse'), __('New Section','veuse'), 'manage_options', 'post-new.php?post_type=sections'); 
	}  
	
	
	
	/* Find template part

	Makes it possible to override the loop with
	a custom theme loop-slider.php
	
	============================================ */
	
	function veuse_sections_locate_part($file) {
	
		     if ( file_exists( get_stylesheet_directory().'/'. $file .'.php')){
		     	$filepath = get_stylesheet_directory().'/'. $file .'.php';
		     }
		     else {
		        $filepath = $this->pluginPATH . $file.'.php';
		       }
		     return $filepath;
	}
}

$veuse_sections = new VeuseSections;



require_once('page-meta.php');
require_once('section-meta.php');





function veuse_sections_top(){
	
	if(!is_page()) return;
	
	global $veuse_sections, $post;
		
	/* Add support for veuse-sections plugin */
		$sections = get_post_meta($post->ID,'veuse_sections_blocks_above',true);
			
		if(!empty($sections)){
			foreach($sections as $section) {
				$section = get_post($section);
				
				include($veuse_sections->veuse_sections_locate_part('section-block'));			
			}
		}

	
}

add_action('veuse_top_sections','veuse_sections_top');

function veuse_sections_bottom(){

	global $veuse_sections, $post;

	
	/* Add support for veuse-sections plugin */
		$sections = get_post_meta($post->ID,'veuse_sections_blocks_below',true);
			
		if(!empty($sections)){
			foreach($sections as $section) {
				$section = get_post($section);
				include($veuse_sections->veuse_sections_locate_part('section-block'));			
			}
		}

	
}

add_action('veuse_bottom_sections','veuse_sections_bottom');
?>