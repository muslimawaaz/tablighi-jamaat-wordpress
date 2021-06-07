<?php
$id = get_query_var('id');
global $wpdb;
if (!$id) {
	$user_id = get_current_user_id();
	if ($user_id) {
		$person_id = get_user_meta($user_id, 'person', true);
		$person = $wpdb->get_row("SELECT id,masjid FROM person where id=$person_id");
		if ($person->masjid) {
			show_masjid_details($person->masjid);
		} else {
			echo 'Go to <a href="/my-account">My Account Page</a> and select Masjid';
		}
	} else {
		echo do_shortcode('[firebase_otp_login]');
	}
} else {
	show_masjid_details($id);
}
?>