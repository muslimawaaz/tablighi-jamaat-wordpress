<?php
// Redirect to same page after form submit //
function redirect_to_same(){
    ?>
    <script type="text/javascript">
        window.location.href = "<?php echo get_permalink(); ?>";
    </script>
    <?php
}

// User Logout function //
add_action('init','make_logout');
function make_logout(){
    if (isset($_GET["logout"])) {
        if ($_GET["logout"]=="yes") {
            wp_logout();
            $logout_redirect = "/login";
            if ( wp_redirect( $logout_redirect ) ) {
                exit;
            }
        }
    }
}

// Remove ADMIN Bar for non-admin users //
add_action("after_setup_theme", "remove_admin_bar");
function remove_admin_bar() {
    if (!current_user_can("administrator") && !is_admin()) {
      show_admin_bar(false);
    }
}

// ADD settings link below your Plugin
// add_filter("plugin_action_links_$plugin", "my_plugin_settings_link" );
$plugin = plugin_basename(__FILE__); 
function my_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=plugin-options.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

// Enable shortcode working in Widgets
// add_filter("widget_text", "do_shortcode");

// Send SMS
// 'https://www.fast2sms.com/dev/bulk?authorization=GNZC1Ak26qSHntL3Wdh5YDcJrzEVlm0wI9BOpiT4R7sexQKavF6IRVoep2TLdxQZgEmvj5UtXnHhz9bO&sender_id=FSTSMS&language=english&route=qt&numbers='.$num.'&message=28047&variables={AA}&variables_values='.$ran_no

function awaaz_head(){
  echo '
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
  	$(".user-link").first().attr("href","#content");
    $(".ab-login").html("<a href=/masjid>Login</a>");
    $("#wp-logout").attr("href","'.wp_logout_url('https://www.muslimawaaz.com/masjid/').'");
  });
  </script>
  <style>
  	#li-nav-notifications, #li-nav-profile{ display:none; } 
  </style>';
}
add_action('wp_head','awaaz_head');

function my_action_prsn_save() {
  $user_id = get_current_user_id();
	$masjid_id = get_user_meta($user_id, 'masjid', true);
	if(get_person_masjid($_POST["id"]) == $masjid_id){
		check_ajax_referer( 'my-special-string', 'security' );
		global $wpdb;
		$wpdb->update('person',
			      array('person' => $_POST["person"]),
			      array('id'      => $_POST["id"]));
		echo $_POST["person"];
	} else {
		echo '<span style="color:red"><i class="exclamation icon red"></i>Error occured.</span>';
	}
	die(); 
}
add_action( 'wp_ajax_my_action', 'my_action_prsn_save' );

function my_action_ident_save() {
	$user_id = get_current_user_id();
	$masjid_id = get_user_meta($user_id, 'masjid', true);
	if(get_person_masjid($_POST["id"]) == $masjid_id){

		check_ajax_referer( 'my-special-string', 'security' );
		//global $wpdb;
		$wpdb->update('person',
		          array('identifier' => $_POST["identifier"]),
		          array('id'      => $_POST["id"]));
		echo $_POST["identifier"];
	} else {
		echo '<span style="color:red"><i class="exclamation icon red"></i>Error occured.</span>';
	}
	die(); 
}
add_action( 'wp_ajax_my_action2', 'my_action_ident_save' );

function my_action_tashkeel_j_save() {
	$user_id = get_current_user_id();
	$masjid_id = get_user_meta($user_id, 'masjid', true);
	$id = $_POST["id"];
	if(get_person_masjid($id) == $masjid_id){
		check_ajax_referer( 'my-special-string', 'security' );
		global $wpdb;
		$old = $wpdb->get_var("SELECT tashkeel_jamath FROM person 
								WHERE id = $id");
		//$wpdb->show_errors(); $wpdb->print_error();
		$result = $wpdb->update('person',
		          array('tashkeel_jamath' => $_POST["tashkeel_j"]),
		          array('id'      		  => $_POST["id"]));
		if($result){
			$changes[0]['col'] = 'tashkeel_jamath';
			$changes[0]['old'] = $old;
			$changes[0]['new'] = $_POST["tashkeel_j"];
			$changes_ser = serialize($changes);
			$wpdb->insert('history',
			        array(	'table_name' 	=> 'person',
			        		'row_id'		=> $_POST["id"],
			      			'history'  		=> $changes_ser,
			      			'kind'			=> 'edit',
		      				'masjid'		=> $masjid_id
		        	));
		}
		//print_r($changes); 
		echo $_POST["tashkeel_j"];
	} else {
		echo '<span style="color:red"><i class="exclamation icon red"></i>Error occured.</span>';
	}
	die(); 
}
add_action( 'wp_ajax_my_action3', 'my_action_tashkeel_j_save' );

function my_action_tashkeel_d_save() {
	$user_id = get_current_user_id();
	$masjid_id = get_user_meta($user_id, 'masjid', true);
	$id = $_POST["id"];
	if(get_person_masjid($_POST["id"]) == $masjid_id){
		check_ajax_referer( 'my-special-string', 'security' );
		global $wpdb;
		$old = $wpdb->get_var("SELECT tashkeel_date FROM person 
								WHERE id = $id");
		$result = $wpdb->update('person',
		          array('tashkeel_date' => $_POST["tashkeel_d"]),
		          array('id'      		  => $_POST["id"]));
		if($result){
			$changes[0]['col'] = 'tashkeel_date';
			$changes[0]['old'] = $old;
			$changes[0]['new'] = $_POST["tashkeel_d"];
			$changes_ser = serialize($changes);
			$wpdb->insert('history',
			        array(	'author'		=> $user_id,
			        		'table_name' 	=> 'person',
			        		'row_id'		=> $_POST["id"],
			      			'history'  		=> $changes_ser,
			      			'kind'			=> 'edit',
		      				'masjid'		=> $masjid_id
		        	));
		}
		echo $_POST["tashkeel_d"];
	} else {
		echo '<span style="color:red"><i class="exclamation icon red"></i>Error occured.</span>';
	}
	die(); 
}
add_action( 'wp_ajax_my_action4', 'my_action_tashkeel_d_save' );

function my_action_response_save() {
	$user_id = get_current_user_id();
	$masjid_id = get_user_meta($user_id, 'masjid', true);
	$id = $_POST["id"];
	if(get_person_masjid($_POST["id"]) == $masjid_id){
		check_ajax_referer( 'my-special-string', 'security' );
		global $wpdb;
		$old = $wpdb->get_var("SELECT response FROM person 
								WHERE id = $id");
		$result = $wpdb->update('person',
		          array('response' => $_POST["response"]),
		          array('id'      		  => $_POST["id"]));
		if($result){
			$changes[0]['col'] = 'response';
			$changes[0]['old'] = $old;
			$changes[0]['new'] = $_POST["response"];
			$changes_ser = serialize($changes);
			$wpdb->insert('history',
			        array(	'author'		=> $user_id,
			        		'table_name' 	=> 'person',
			        		'row_id'		=> $_POST["id"],
			      			'history'  		=> $changes_ser,
			      			'kind'			=> 'edit',
		      				'masjid'		=> $masjid_id
		        	));
		}
		echo $_POST["response"];
	} else {
		echo '<span style="color:red"><i class="exclamation icon red"></i>Error occured.</span>';
	}
	die(); 
}
add_action( 'wp_ajax_my_action5', 'my_action_response_save' );
function get_person( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT person FROM person
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_t_person( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT t_name FROM person
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_person_identifier( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT identifier FROM person
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_t_person_identifier( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT t_identifier FROM person
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_person_masjid( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT masjid FROM person
		WHERE id = %d " , $id ));
		return $result;
}
function get_place( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT place FROM places
		WHERE id = %d " , $id ));
		return $result;
}
function get_t_place( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT t_place FROM places
		WHERE id = %d " , $id ));
		return $result;
}
function get_masjid_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT masjid FROM masjid
		WHERE id = %d " , $id ));
		return $result;
}
function get_t_masjid_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT t_masjid FROM masjid
		WHERE id = %d " , $id ));
		return $result;
}
function get_masjid_halqa( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT halqa FROM masjid
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_halqa_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT halqa FROM halqas
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_halqa_town( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT town FROM halqas
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}

function get_town_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
		SELECT town FROM towns
		WHERE id = %d " , $id ));
	if(strlen($id) > 3 ){
		return $id;
	} else {
		return $result;
	}
}
function get_district_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var("
		SELECT district FROM districts
		WHERE id = $id" );
	return $result;
}
function get_state_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var("
		SELECT state FROM states
		WHERE id = $id" );
	return $result;
}
function get_country_name( $id ){
	global $wpdb;
	$result = $wpdb->get_var("
		SELECT country FROM countries
		WHERE id = $id" );
	return $result;
}

function get_waqth_person( $id , $waqth ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(id) FROM person 
				WHERE waqth = %s
				AND masjid = %s", $waqth , $id ) );
	return $result;
}

function get_baligh_mard( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(id) FROM person 
				WHERE waqth = %s
				AND masjid = %s " , $waqth , $id ) );
	return $result;	
}
function get_waqth_person_in_town( $id , $waqth ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(id) FROM person 
				WHERE waqth = %s
				AND town = %s", $waqth , $id ) );
	return $result;
}
function get_baligh_mard_in_town( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(id) FROM person 
				WHERE waqth = %s
				AND town = %s " , $waqth , $id ) );
	return $result;	
}
function get_waqth_person_in_halqa( $id , $waqth ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(id) FROM person 
				WHERE waqth = %s
				AND halqa = %s", $waqth , $id ) );
	return $result;
}
function get_baligh_mard_in_halqa( $id ){
	global $wpdb;
	$result = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(id) FROM person 
				WHERE waqth = %s
				AND halqa = %s " , $waqth , $id ) );
	return $result;	
}
function get_icon_class($id){
	global $wpdb;
	$result = $wpdb->get_var("SELECT icon FROM work WHERE id = $id");
	return $result;
}
function get_icon_name($id){
	global $wpdb;
	$result = $wpdb->get_var("SELECT work FROM work WHERE id = $id");
	return $result;
}
function get_masjid_loc( $masjid_id ){
  global $wpdb;
  $result[0] = $wpdb->get_var("SELECT latitude FROM masjid WHERE id = $masjid_id");
  $result[1] = $wpdb->get_var("SELECT longitude FROM masjid WHERE id = $masjid_id");
  return $result;
}
?>