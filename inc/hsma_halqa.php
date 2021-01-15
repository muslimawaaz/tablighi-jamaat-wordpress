<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>

<meta name="viewport" content="width=1024, initial-scale=1.0">
<style type="text/css">
  #masthead, .ab-user-links, #main-nav, .ab-primary-menu-wrapper{      display: none;    }
</style>
<?php 
global $wpdb;
if(is_user_logged_in()){
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'masjid', true);
$place_id = $_GET["place_id"];
$halqa_id = $wpdb->get_var("SELECT halqa FROM masjid WHERE id = $masjid_id");
$masjid = $wpdb->get_results("SELECT id,masjid FROM masjid WHERE halqa = $halqa_id", OBJECT_K);
$masjid_ids = $wpdb->get_col("SELECT id FROM masjid WHERE halqa = $halqa_id");
$txt = '(';
foreach ($masjid_ids as $id) {
	$txt .= "'".$id."',";
}
$txt = substr_replace($txt ,"", -1);
$txt .= ')';
$sql = "SELECT COUNT(id) FROM person WHERE masjid IN $txt";
$halqa_name = get_halqa_name($halqa_id);

echo '<h1>'.$halqa_name.'</h1>';
include (dirname(__FILE__).'/numbers.php');
?>


<h1>Masjids:</h1>
<ol>
	<?php
	global $wpdb;
	$halqas = $wpdb->get_results($wpdb->prepare("
		SELECT * FROM masjid 
		WHERE halqa = %d " , $halqa_id ));
	foreach( $masjid as $masjid ){
		echo '<li>'.$masjid->masjid.'</li>';
	}
	?>
</ol>
<?php
}