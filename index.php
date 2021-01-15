<?php
/*
Plugin Name: Tablighi Jamaat
Plugin URI: https://www.haysky.com/
Description: Masjid List Plugin by Muslim Awaaz
Version: 1.0
Author: Sufyan
Author URI: https://www.sufyan.in/
License: GPLv2 or later
*/
//$wpdb->show_errors(); $wpdb->print_error();

//add_role('masjid','Masjid ID');
add_action( 'init', function(){ session_start(); });
date_default_timezone_set('Asia/Kolkata');

include 'inc/user_extra_fields.php';
include 'inc/register.php';
include 'inc/rest_api1.php';


function country_plugin_1589347903_admin_menu(){
    add_menu_page('Tablighi Jamaat','Tablighi Jamaat','manage_options','tablighi_jamath','tablighi_jamath_gdz','dashicons-admin-users','2');
    add_submenu_page('tablighi_jamath', 'Country','Country','manage_options','country_gdz','country_gdz');
    add_submenu_page('tablighi_jamath', 'State','State','manage_options','state_gdz','state_gdz');
    add_submenu_page('tablighi_jamath', 'District','District','manage_options','district_gdz','district_gdz');
    add_submenu_page('tablighi_jamath', 'Town','Town','manage_options','town_gdz','town_gdz');
    add_submenu_page('tablighi_jamath', 'Halqa','Halqa','manage_options','halqa_gdz','halqa_gdz');
    add_submenu_page('tablighi_jamath', 'Masjid','Masjid','manage_options','masjid_gdz','masjid_gdz');
	add_submenu_page('tablighi_jamath', 'Work List','Work List','manage_options','work_list','work_list');
}
add_action('admin_menu' , 'country_plugin_1589347903_admin_menu');

function country_gdz(){ include ('inc/loc/country.php'); }
function state_gdz(){ include ('inc/loc/state.php'); }
function district_gdz(){ include ('inc/loc/district.php'); }
function town_gdz(){ include ('inc/loc/town.php'); }
function halqa_gdz(){ include ('inc/loc/halqa.php'); }
function masjid_gdz(){ include ('inc/loc/masjid.php'); }
function tablighi_jamath_gdz(){ include ('inc/tablighi_jamath.php'); }

function masjid_timing(){
  include ('inc/admin/masjid_timing.php');
}
function ijtema_slip(){
	include ('inc/ijtema/ijtema_slip2.php');
}
add_shortcode('ijtema_slip','ijtema_slip');

function place_list(){
	include ('inc/place_list.php');
}
add_shortcode('place_list','place_list');

function place_data(){
	include ('inc/place_data.php');
}
add_shortcode('place_data','place_data');

function work_list(){
	include ('inc/work_list.php');
}

function my_history(){
	include ('inc/history.php');
}
add_shortcode('my_history','my_history');

function masjid_persons(){
	include ('inc/masjid_persons.php');
}
add_shortcode('masjid_persons','masjid_persons');

function tashkeel_add(){
	include ('inc/tashkeel_add.php');
}
add_shortcode('tashkeel_add','tashkeel_add');

function person_add(){
	include ('inc/person_add.php');
}
add_shortcode('person_add','person_add');

function masjid_add(){
	include ('inc/masjid_add.php');
}

function hsma_edit_profile(){
	include ('inc/person_edit.php');
}
add_shortcode('hsma_edit_profile','hsma_edit_profile');

function hsma_halqa(){
	include ('inc/hsma_halqa.php');
}
add_shortcode('hsma_halqa','hsma_halqa');


include ('inc/functions.php');
include ('inc/login.php');

require_once( 'inc/updater/BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new BFIGitHubPluginUpdater( __FILE__, 'muslimawaaz', 'tablighi-jamaat-wordpress');
}

add_shortcode('my_account',function(){ include 'inc/my_account.php'; });