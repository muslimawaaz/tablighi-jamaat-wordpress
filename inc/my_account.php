<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.css" integrity="sha512-YYS7fyqDxVE/yJ1280i8KjA+nC7wAtv2u/qkulKbdMpmp8DBWX0Wj+HtILsFyvq+fouCwCyr0hasPAz1eBlvwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.css" integrity="sha512-5StPzJo8hFyTvXfJ31FMB37EXRMVeUg+J3yvUNOJcL83MEMr7VrhZSNsoL3GDmUDBGBBhoTjnJx0Ql7cH9LY7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.js" integrity="sha512-8F/2JIwyPohlMVdqCmXt6A6YQ9X7MK1jHlwBJv2YeZndPs021083S2Z/mu7WZ5g0iTlGDYqelA9gQXGh1F0tUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.js" integrity="sha512-MCuLP92THkMwq8xkT2cQg5YpF30l3qzJuBRf/KsbQP1czFkRYkr2dSkCHmdJETqVmvIq5Y4AOVE//Su+cH+8QA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
error_reporting(E_ERROR | E_PARSE);
global $wpdb;
top:
$user_id = get_current_user_id();
if (!$user_id) {
	echo do_shortcode('[firebase_otp_login]');
} else {
	if ($_POST["select_person"]) {
		update_user_meta($user_id,'person',$_POST['select_person']);
		$wpdb->update('person',array('user'=>$user_id),array('id'=>$_POST['select_person']));
	}
	$person_id = get_user_meta($user_id, 'person', true);
	$userdata = get_userdata($user_id);
	if (!$person_id) {
		$phone = substr($userdata->user_login, -10);
		// search for number in database
		$persons = $wpdb->get_results("SELECT id,person,father FROM person WHERE phone='$phone' OR phone2='$phone'");
		if (count($persons)) {
			?>
			<h3>Persons with same phone number found.</h3>
			<table>
			<?php
			foreach ($persons as $person) {
				?>
				<tr>
					<td><b>Name: </b><?php echo $person->person; ?><br>
						<b>Father Name: </b><?php echo $person->father; ?>
					</td>
					<td><form method="POST">
							<input type="hidden" name="select_person" value="<?php echo $person->id; ?>">
							<button>SELECT</button>
						</form>
					</td>
				</tr>
				<?php
			}
			echo '</table>';
		} else {
			create_person($user_id);
			goto top;
		}
	} else {
		$masjid_id = $wpdb->get_var("SELECT masjid FROM person WHERE id=$person_id");
		if ($masjid_id) {
			show_masjid_details($masjid_id);
		} else {
			$extra_details = get_user_meta($user_id,'extra_details',true);
			if ($_POST['extra_details']) {
			if (!$extra_details["country"] && !$extra_details["district"] && !$extra_details["town"] && !$extra_details["masjid"]) {
				if ($_POST["add"]) {
					$wpdb->insert('country',array('country'=>$_POST['country_name']));
					$details['country'] = $wpdb->insert_id;
				} else {
					$details["country"] = $_POST['country'];
				}
			} else if ($extra_details["country"]) {
				if ($_POST["add"]) {
					$wpdb->insert('district',array('district'=>$_POST['district_name'],'country'=>$extra_details["country"]));
					$details['district'] = $wpdb->insert_id;
				} else {
					$details["district"] = $_POST['district'];
				}
			} else if ($extra_details["district"]) {
				if ($_POST["add"]) {
					$wpdb->insert('town',array('town'=>$_POST['town_name'],'district'=>$extra_details["district"]));
					$details['town'] = $wpdb->insert_id;
				} else {
					$details["town"] = $_POST['town'];
				}
			} else if ($extra_details["town"]) {
				if ($_POST["add"]) {
					$wpdb->insert('masjid',array(
						'masjid'=>$_POST['masjid_name'],
						'town'=>$extra_details["town"],
						'added_by'=>$user_id
					));
					$details['masjid'] = $wpdb->insert_id;
				} else {
					$details["masjid"] = $_POST['masjid'];
				}
				$wpdb->update('person',array('masjid'=>$details["masjid"]),array('id'=>$person_id));
				update_user_meta($user_id,'extra_details',$details);
				clear_form_data();
				goto top;
			}
			update_user_meta($user_id,'extra_details',$details);
			}
			$extra_details = get_user_meta($user_id,'extra_details',true);
			if (!$extra_details["country"] && !$extra_details["district"] && !$extra_details["town"] && !$extra_details["masjid"]) {
				echo select_entity("country",'','');
			} else if ($extra_details["country"]) {
				echo select_entity("district","country",$extra_details["country"]);
			} else if ($extra_details["district"]) {
				echo select_entity("town","district",$extra_details["district"]);
			} else if ($extra_details["town"]) {
				echo select_entity("masjid","town",$extra_details["town"]);
			}
		}
	}
	if ($person_id) {
		?>
		<form>
			<table>
				<tr><td>Your Name</td><td><input type="text" name="person"></td></tr>
				<tr><td>Your Name</td><td><input type="text" name=""></td></tr>
			</table>
		</form>
		<?php
	}
}
clear_form_data();