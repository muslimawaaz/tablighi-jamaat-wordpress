<?php
/*
Plugin Name: Tablighi Jamaat
Plugin URI: https://www.haysky.com/
Description: Plugin by Muslim Awaaz
Version: 1.0
Author: Sufyan
Author URI: https://www.sufyan.in/
License: GPLv2 or later
*/
// $wpdb->show_errors(); $wpdb->print_error();

//add_role('masjid','Masjid ID');
date_default_timezone_set('Asia/Kolkata');

add_action( 'init',	function(){
    add_rewrite_rule(
        'masjid/([0-9]+)/?$',
        'index.php?pagename=masjid&id=$matches[1]',
        'top' );
    add_rewrite_rule(
        'halqa/([0-9]+)/?$',
        'index.php?pagename=halqa&id=$matches[1]',
        'top' );
});
add_filter( 'query_vars',function( $query_vars ){
    $query_vars[] = 'id';
    return $query_vars;
});
add_filter('auth_cookie_expiration', function(){
    return YEAR_IN_SECONDS * 2;
});

function country_plugin_1589347903_admin_menu(){
    add_menu_page('Tablighi Jamaat','Tablighi Jamaat','manage_options','tablighi_jamath','tablighi_jamath_gdz','dashicons-admin-users','2');
    add_submenu_page('tablighi_jamath', 'Country','Country','manage_options','country_gdz','country_gdz');
    add_submenu_page('tablighi_jamath', 'District','District','manage_options','district_gdz','district_gdz');
    add_submenu_page('tablighi_jamath', 'Town','Town','manage_options','town_gdz','town_gdz');
    add_submenu_page('tablighi_jamath', 'Halqa','Halqa','manage_options','halqa_gdz','halqa_gdz');
    add_submenu_page('tablighi_jamath', 'Masjid','Masjid','manage_options','masjid_gdz','masjid_gdz');
	add_submenu_page('tablighi_jamath', 'Work List','Work List','manage_options','work_list','work_list');
}
add_action('admin_menu' , 'country_plugin_1589347903_admin_menu');

function country_gdz(){ include ('inc/loc/country.php'); }
function district_gdz(){ include ('inc/loc/district.php'); }
function town_gdz(){ include ('inc/loc/town.php'); }
function halqa_gdz(){ include ('inc/loc/halqa.php'); }
function masjid_gdz(){ include ('inc/loc/masjid.php'); }
function work_list(){ include ('inc/work_list.php'); }
function tablighi_jamath_gdz(){ include ('inc/tablighi_jamath.php'); }
function masjid_timing(){ include ('inc/admin/masjid_timing.php'); }

add_shortcode('ijtema_slip',	function(){ include 'inc/ijtema/ijtema_slip2.php'; });
add_shortcode('place_list',		function(){ include 'inc/place_list.php'; });
add_shortcode('place_data',		function(){ include 'inc/place_data.php'; });
add_shortcode('my_history',		function(){ include ('inc/history.php'); });
add_shortcode('masjid_persons',	function(){ include ('inc/masjid_persons.php'); });
add_shortcode('tashkeel_add',	function(){ include ('inc/tashkeel_add.php'); });
add_shortcode('person_add',		function(){ include ('inc/person_add.php'); });
add_shortcode('person_edit',	function(){ include ('inc/person_edit.php'); });
add_shortcode('halqa',			function(){ include ('inc/halqa.php'); });
add_shortcode('masjid_wari_jamath',	function(){ include 'inc/masjid_wari_jamath.php'; });
add_shortcode('masjid',			function(){ include 'inc/masjid.php'; });
add_shortcode('my_account',	    function(){ include 'inc/my_account.php'; });
add_shortcode('karguzari_masjid',     function(){ include 'inc/karguzari_masjid.php'; });


include 'inc/functions.php';
include 'inc/user_extra_fields.php';

require_once( 'inc/updater/BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new BFIGitHubPluginUpdater( __FILE__, 'muslimawaaz', 'tablighi-jamaat-wordpress');
}
