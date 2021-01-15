<link href="http://allfont.net/allfont.css?fonts=agency-fb" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>

<?php
global $wpdb;
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'masjid', true);
$place_id = $_GET["id"];
$place = $wpdb->get_row("SELECT * FROM places WHERE ID = $place_id AND masjid = $masjid_id");
if ($masjid_id && $place) {
	echo '<h1>'.$place->place_name.'</h1>';
	$rows = $wpdb->get_results("SELECT * FROM persons WHERE place = $place_id");
	print_r($rows);
}