<?php
/**
 * Plugin Name: WP COVID-19 Schema
 * Plugin URI: https://www.sweans.com/wp-covid-19-schema/
 * Author: Sweans
 * Author URI: https://sweans.com
 * Description: WP COVID-19 Schema plugin adds a schema snippet in the WordPress websites of schools and hospitals to serve the specific purpose of announcements.
 * Version: 1.0.5
 * Text Domain: wp-covid-schema
 * License: GPL3
 *
 * @package Schema Pack
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$plugin_directory = plugin_dir_url(__FILE__);
require_once( plugin_dir_path(__FILE__) . '/inc/settings/settings.php' );

if (!function_exists('swwpcs_add_to_admin_toolbar')) {
	function swwpcs_add_to_admin_toolbar($admin_bar){
		$admin_bar->add_menu(
			array(
				'id'    => 'swwpcs-test-schema',
				'title' => 'Test COVID-19 Schema',
				'href'  => 'https://search.google.com/structured-data/testing-tool#url=' . swwpcs_get_test_link(),
				'meta'  => array(
					'target' => '_blank',
					'rel'    => 'noopener',
				),
			)
		);
	}
}
if(get_option('swwpcs_testing_facility_enable') || get_option('swwpcs_school_closure_enable')) { 
	add_action('admin_bar_menu', 'swwpcs_add_to_admin_toolbar', 100);
}

if (!function_exists('swwpcs_hook_schema')) {
	function swwpcs_hook_schema() {

		$show_schema = false;
		$swwpcs_testing_facility_enable = get_option('swwpcs_testing_facility_enable');
		$swwpcs_testing_facility_schema_control = get_option('swwpcs_testing_facility_schema_control');
		$swwpcs_school_closure_enable = get_option('swwpcs_school_closure_enable');
		$swwpcs_school_closure_schema_control = get_option('swwpcs_school_closure_schema_control');

		$testing_facility_enabled_on_current_page = ( $swwpcs_testing_facility_enable && ( $swwpcs_testing_facility_schema_control == "all" || ( $swwpcs_testing_facility_schema_control == "home" && ( is_home() || is_front_page())) || ( ( $swwpcs_testing_facility_schema_control == "post" || $swwpcs_testing_facility_schema_control == "page" ) && ( get_the_ID() == get_option('swwpcs_testing_facility_schema_page_post_id') ) ) ) );

		$school_closure_enabled_on_current_page = ( $swwpcs_school_closure_enable && ( $swwpcs_school_closure_schema_control == "all" || ( $swwpcs_school_closure_schema_control == "home" && ( is_home() || is_front_page())) || ( ( $swwpcs_school_closure_schema_control == "post" || $swwpcs_school_closure_schema_control == "page" ) && ( get_the_ID() == get_option('swwpcs_school_closure_schema_page_post_id') ) ) ) );

		if($testing_facility_enabled_on_current_page) {

			$markup = '<!-- Schema added by WP COVID-19 Schema Plugin -->';
			$markup .= '<script type="application/ld+json">';
			$markup .= swwpcs_get_json_data_testing_facility();
			$markup .= '</script>';
			$markup .= '<!-- / Schema added by WP COVID-19 Schema Plugin -->';
			
			echo $markup;
		}
		
		if($school_closure_enabled_on_current_page) {

			$markup = '<!-- Schema added by WP COVID-19 Schema Plugin -->';
			$markup .= '<script type="application/ld+json">';
			$markup .= swwpcs_get_json_data_school_closure();
			$markup .= '</script>';
			$markup .= '<!-- / Schema added by WP COVID-19 Schema Plugin -->';
			
			echo $markup;
		}
		
	}
}

add_action('wp_head', 'swwpcs_hook_schema');

if (!function_exists('swwpcs_activate')) {
	function swwpcs_activate(){
		register_uninstall_hook( __FILE__, 'swwpcs_uninstall' );
	}
	register_activation_hook( __FILE__, 'swwpcs_activate' );
}

if (!function_exists('swwpcs_uninstall')) {
	function swwpcs_uninstall(){
		delete_option('swwpcs_enable');
		delete_option('swwpcs_name');
		delete_option('swwpcs_text');
		delete_option('swwpcs_date_posted');
		delete_option('swwpcs_article_url');
		delete_option('swwpcs_testing_facility_name');
	}
}

if (!function_exists('swwpcs_get_test_link')) {
	function swwpcs_get_test_link(){
		
		if(is_admin()) {
			return get_bloginfo('url');
		}
		global $wp;
		return home_url( $wp->request );

	}
}

if (!function_exists('swwpcs_get_json_data_testing_facility')) {
	function swwpcs_get_json_data_testing_facility(){		
		$array = [
			'@context' => 'http://schema.org',
			'@type' => 'SpecialAnnouncement',
			'name' => esc_html(get_option('swwpcs_testing_facility_announcement_name')),
			'text' => esc_html(get_option('swwpcs_testing_facility_desc_text')),
			'datePosted' => esc_html(get_option('swwpcs_testing_facility_date_posted')),
			'url' => esc_html(get_option('swwpcs_testing_facility_article_url')),
			'category' => 'https://www.wikidata.org/wiki/Q81068910',
			'announcementLocation' => array(
				'@type' => "CovidTestingFacility",
				'name' => esc_html(get_option('swwpcs_testing_facility_name')),
				'url' => esc_html(get_bloginfo('url')),
				'image' => esc_html(get_option('swwpcs_testing_facility_image'))
			)
		];
		
		if(get_option('swwpcs_testing_facility_date_expires')) {
			$array["expires"] = get_option('swwpcs_testing_facility_date_expires');
		}

		if(get_option('swwpcs_testing_facility_price_range')) {
			$array["announcementLocation"]["priceRange"] = get_option('swwpcs_testing_facility_price_range');
		}

		if(get_option('swwpcs_testing_facility_address')) {
			$array["announcementLocation"]["address"] = get_option('swwpcs_testing_facility_address');
		}
		
		if(get_option('swwpcs_testing_facility_telephone')) {
			$array["announcementLocation"]["telephone"] = get_option('swwpcs_testing_facility_telephone');
		}

		return wp_json_encode($array);

	}
}

if (!function_exists('swwpcs_get_json_data_school_closure')) {
	function swwpcs_get_json_data_school_closure(){		

		$array = [
			'@context' => 'http://schema.org',
			'@type' => 'SpecialAnnouncement',
			'name' => esc_html(get_option('swwpcs_school_closure_announcement_name')),
			'text' => esc_html(get_option('swwpcs_school_closure_desc_text')),
			'datePosted' => esc_html(get_option('swwpcs_school_closure_date_posted')),
			'expires' => esc_html(get_option('swwpcs_school_closure_expires')),			
			'category' => 'https://www.wikidata.org/wiki/Q81068910',
			'schoolClosuresInfo' => esc_html(get_option('swwpcs_school_closure_article_link')),
		];

		if(get_option('swwpcs_school_closure_web_feed_enable')) {
			$array["webFeed"] = array(
				'@type' => "DataFeed",
				'@url' => esc_html(get_option('swwpcs_school_closure_feed_url')),
				'encodingFormat' => esc_html(get_option('swwpcs_school_closure_encoding_format')),
			);
		}

		$array["announcementLocation"] = array(
			"@type" => "School",
			"name" => esc_html(get_option('swwpcs_school_closure_location_name')),
			"url" => esc_html(get_bloginfo('url')),
			"location" => esc_html(get_option('swwpcs_school_closure_location'))
		);

		return wp_json_encode($array);

	}
}


if (!function_exists('swwpcs_migrate_settings')) {

	function swwpcs_migrate_settings() {
		if(get_option('swwpcs_enable')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_enable', get_option('swwpcs_enable'));
			delete_option('swwpcs_enable');
		}
		if(get_option('swwpcs_schema_control')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_schema_control', get_option('swwpcs_schema_control'));
			delete_option('swwpcs_schema_control');
		}
		if(get_option('swwpcs_schema_page_post_id')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_schema_page_post_id', get_option('swwpcs_schema_page_post_id'));
			delete_option('swwpcs_schema_page_post_id');
		}
		if(get_option('swwpcs_name')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_announcement_name', get_option('swwpcs_name'));
			delete_option('swwpcs_name');
		}
		if(get_option('swwpcs_text')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_desc_text', get_option('swwpcs_text'));
			delete_option('swwpcs_text');
		}
		if(get_option('swwpcs_date_posted')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_date_posted', get_option('swwpcs_date_posted'));
			delete_option('swwpcs_date_posted');
		}
		if(get_option('swwpcs_article_url')) {
			swwpcs_update_settings( 'swwpcs_testing_facility_article_url', get_option('swwpcs_article_url'));
			delete_option('swwpcs_article_url');
		}	
	}
	
}

// Migrating Old Settings
swwpcs_migrate_settings();	
