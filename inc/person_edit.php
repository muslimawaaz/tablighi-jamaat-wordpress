<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css" integrity="sha512-8Tb+T7SKUFQWOPIQCaLDWWe1K/SY8hvHl7brOH8Nz5z1VT8fnf8B+9neoUzmFY3OzkWMMs3OjrwZALgB1oXFBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.min.css" integrity="sha512-OD0ScwZAE5PCg4nATXnm8pdWi0Uk0Pp2XFsFz1xbZ7xcXvapzjvcxxHPeTZKfMjvlwwl4sGOvgJghWF2GRZZDw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.css" integrity="sha512-YYS7fyqDxVE/yJ1280i8KjA+nC7wAtv2u/qkulKbdMpmp8DBWX0Wj+HtILsFyvq+fouCwCyr0hasPAz1eBlvwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.css" integrity="sha512-5StPzJo8hFyTvXfJ31FMB37EXRMVeUg+J3yvUNOJcL83MEMr7VrhZSNsoL3GDmUDBGBBhoTjnJx0Ql7cH9LY7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.js" integrity="sha512-8F/2JIwyPohlMVdqCmXt6A6YQ9X7MK1jHlwBJv2YeZndPs021083S2Z/mu7WZ5g0iTlGDYqelA9gQXGh1F0tUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.js" integrity="sha512-MCuLP92THkMwq8xkT2cQg5YpF30l3qzJuBRf/KsbQP1czFkRYkr2dSkCHmdJETqVmvIq5Y4AOVE//Su+cH+8QA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
global $wpdb;
$user_id = get_current_user_id();
if (!$user_id) {
	echo do_shortcode('[firebase_otp_login]');
} else {
	$masjid_id = get_user_meta($user_id, 'extra_details', true)["masjid"];
	if(!$masjid_id){
		echo 'Go to <a href="/my-account">My Account Page</a> and select Masjid';
	}
	$edit_id = $_GET["id"];
	if (!$edit_id) {
		$edit_id = get_user_meta($user_id,'person',true);
	}
	$added_by = $wpdb->get_var("SELECT added_by from person where id=$edit_id");
	if ($added_by!=$user_id) {
		?>
		<h2>You don't have access to edit this Person.</h2>
		<a href="#" onclick="history.back()" class="ui grey button">Go Back</a>
		<?php
	} else {
		$place_id = $wpdb->get_var("SELECT place FROM person WHERE id = $edit_id AND masjid = $masjid_id" );
		if ($_GET["place_id"]) {
			$if_place = '?masjid_id='.$masjid_id.'&place_id='.$place_id;
		}
		if($_POST["save_profile"]){
			$map = $_POST["map"];
			$map_arr = explode (", ", $map);
			$result = $wpdb->update('person', 
				array(
					'person' 		=> $_POST["person"],
					't_name' 		=> $_POST["t_name"],
					'phone' 		=> $_POST["phone"],
					'father' 		=> $_POST["father"],
					't_father' 		=> $_POST["t_father"],
					'dob' 			=> $_POST["dob"],
					'identifier' 	=> $_POST["identifier"],
					't_identifier'	=> $_POST["t_identifier"],
					'juma' 			=> $_POST["juma"],
					'waqth' 		=> $_POST["waqth"],
					'language' 		=> $_POST["language"],
					'place' 		=> $_POST["place"],
					'qwaqth' 		=> $_POST["qwaqth"],
					'work' 			=> $_POST["work"],
					'response' 		=> $_POST["response"],
					'tashkeel_date' => $_POST["tashkeel_date"],
					'tashkeel_jamath'=> $_POST["tashkeel_jamath"],
					'latitude'		=> $map_arr[0],
					'longitude'		=> $map_arr[1]
				),array('id' => $edit_id, 'added_by' => $user_id));
			// $wpdb->show_errors(); $wpdb->print_error();
			if($result){
			echo '<i class="checkmark blue icon"></i><span style="color: blue">New Data Updated successfully.</span>';
			}
		}
		$row = $wpdb->get_row("SELECT * FROM person WHERE id = $edit_id");
		$latitude		= $row->latitude;
		$longitude		= $row->longitude;
		$from = new DateTime( $dob );
		$to   = new DateTime('today');
		include 'person_form.php';
		?>
		<script type="text/javascript">
		$('input[name=person]').val('<?php echo $row->person; ?>');
		$('input[name=identifier]').val('<?php echo $row->identifier; ?>');
		$('input[name=t_identifier]').val('<?php echo $row->t_identifier; ?>');
		$('input[name=t_name]').val('<?php echo $row->t_name; ?>');
		$('input[name=phone]').val('<?php echo $row->phone; ?>');
		$('input[name=dob]').val('<?php echo $row->dob; ?>');
		$('input[name=father]').val('<?php echo $row->father; ?>');
		$('input[name=t_father]').val('<?php echo $row->t_father; ?>');
		$('input[name=response]').val('<?php echo $row->response; ?>');
		$('input[name=tashkeel_date]').val('<?php echo $row->tashkeel_date; ?>');
		$('select[name=tashkeel_jamath]').val('<?php echo $row->tashkeel_jamath; ?>');
		$('select[name=juma]').val('<?php echo $row->juma; ?>');
		$('select[name=waqth]').val('<?php echo $row->waqth; ?>');
		$('select[name=language]').val('<?php echo $row->language; ?>');
		$('select[name=qwaqth]').val('<?php echo $row->qwaqth; ?>');
		$('select[name=masjid]').val('<?php echo $row->masjid; ?>');
		$('select[name=place]').val('<?php echo $row->place; ?>');
		$('select[name=work]').val('<?php echo $row->work; ?>');
		$('.ui.dropdown').dropdown();
		</script>
		<?php
	}
}
?>
