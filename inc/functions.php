<?php
// Redirect to same page after form submit //
function redirect_to_same0(){
    ?>
    <script type="text/javascript">
        window.location.href = "<?php echo get_permalink(); ?>";
    </script>
    <?php
}
function clear_form_data(){
    ?>
    <script>
	if ( window.history.replaceState ) {
		window.history.replaceState( null, null, window.location.href );
	}
	</script><?php
}

function create_person($user_id){
	global $wpdb;
	$user_id = get_current_user_id();
	$phone = substr(get_userdata($user_id)->user_login,-10);
	$wpdb->insert('person',array('user'=>$user_id, 'phone'=>$phone,'added_by'=>$user_id));
	$id = $wpdb->insert_id;
	update_user_meta($user_id,'person',$id);
}
function select_entity($entity,$key, $value){
	global $wpdb;
	$result = '';
	if ($key && $value) {
		$sql .=  'WHERE '.$key.'=\''.$value.'\'';
		$pre = $wpdb->get_var("SELECT ".$key." FROM ".$key." WHERE id='$value'");
		$result .= '<p>'.ucwords($key).': <b>'.$pre.' selected</b></p>';
	}
	$rows = $wpdb->get_results("SELECT * FROM $entity $sql",ARRAY_A);
	$result .= '<form method="POST" id="select_form">Select: '.ucwords($entity).'
		<select class="ui search dropdown" name="'.$entity.'">';
	foreach ($rows as $row) {
		$result .= '<option value="'.$row["id"].'">'.$row[$entity].'</option>';
	}
	$result .= '</select>
	<script type="text/javascript">
        $(".ui.dropdown").dropdown();
    </script>
    <button>SELECT</button>
	<input type="hidden" name="extra_details" value="1">
	</form>
	<button type="button" id="add_new" onclick="$(\'#add_form\').toggle();">ADD NEW</button>
	<form method="POST" id="add_form" style="display:none">
		<input type="hidden" name="extra_details" value="1">
		<br><p><b>Add New '.ucwords($entity).' Name in '.$pre.'</b></p>
		<input type="text" name="'.$entity.'_name">
		<input type="submit" name="add" value="SUBMIT">
	</form>';
	return $result;

}

function show_masjid_details($masjid_id){
	global $wpdb;
	$masjid = $wpdb->get_row("SELECT * FROM masjid WHERE id=$masjid_id");
	$town_id = $masjid->town;
	$town = $wpdb->get_row("SELECT * FROM town WHERE id='$town_id'");
	$district_id = $town->district;
	$district = $wpdb->get_row("SELECT * FROM district WHERE id='$district_id'");
	$country_id = $district->country;
	$country = $wpdb->get_row("SELECT * FROM country WHERE id='$country_id'");
	?>
	<table>
		<tr><td>Masjid</td><td><?php echo $masjid->masjid; ?></td></tr>
		<tr><td>Town</td><td><?php echo $town->town; ?></td></tr>
		<tr><td>District</td><td><?php echo $district->district; ?></td></tr>
		<tr><td>Country</td><td><?php echo $country->country; ?></td></tr>
	</table>
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