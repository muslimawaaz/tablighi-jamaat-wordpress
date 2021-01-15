<link href="http://allfont.net/allfont.css?fonts=agency-fb" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<style type="text/css">
  #masthead, .ab-user-links, #main-nav, .ab-primary-menu-wrapper{      display: none;    }
</style>
<?php 
global $wpdb;
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'masjid', true);
if (!$masjid_id) {
	echo "Please select masjid.";
	exit;
}
?>
<script type="text/javascript">
  $(".entry-title").first().html('<?php echo get_masjid_name($masjid_id); ?>');
  $(".entry-title").first().css("fontSize", "25px");
  $(".entry-title").first().css("color", "green");
  $(".entry-title").first().css("text-transform", "capitalize");
  $(".entry-title").first().css("cursor", "pointer");
  $(".entry-title").first().click(function() {
        window.location.href = "/masjid";
    });
</script>
<?php
if(isset($_POST["add"]) && $_POST["place"]){
	$result = $wpdb->insert('place',
		array(
				'place' => $_POST["place"],
				't_place'	=> $_POST["t_place"],
				'masjid'	 => $masjid_id,
				'admin'			=> $user_id
			));
	if($result){
		$_SESSION["message"]='Galli Added successfully.';
		?>
	    <script type="text/javascript">
	        window.location.href = "<?php echo get_permalink(); ?>";
	    </script>
	    <?php
	}
}
if (isset($_POST["save"])) {
	$result = $wpdb->update('place',
			array(
					'place'	=> $_POST["place"],
					't_place'	=> $_POST["t_place"]
			),array(
					'id' 		=> $_POST["place_id"],
					'masjid' => $masjid_id,
					'admin'			=> $user_id
			));
	if($result){
		$_SESSION["message"]='Galli Updated successfully.';
		?>
	    <script type="text/javascript">
	        window.location.href = "<?php echo get_permalink(); ?>";
	    </script>
	    <?php
	}
}
if ($_SESSION["message"] && !$_POST["place"]) {
		echo '<h3 style="color:red">'.$_SESSION["message"].'</h3>';
		$_SESSION["message"] = '';
}
if (isset($_POST["edit"])) {
	echo '<form action="" method="POST">
	<b>Edit:</b><br>
		<input type="hidden" name="place_id" value="'.$_POST["place_id"].'">
		Place Name: <input type="text" name="place" value="'.$_POST["place"].'" style="width:200px" autofocus><br>
		వీధి పేరు: <input type="text" name="t_place" value="'.$_POST["t_place"].'" style="width:200px">
		<input type="submit" name="save" value="Save" class="ui teal button">
	</form>';
} else {
	?>
	<form action="" method="POST">
	<b>Add Galli / Area:</b><br>
		Place Name: <input type="text" name="place" style="width:200px"><br>
		వీధి పేరు: <input type="text" name="t_place" style="width:200px">
		<input type="submit" name="add" value="Add" class="ui green button">
	</form>
	<?php
}
?>
<table class="ui striped table unstackable very compact">
	<thead>
		<tr>
			<th>Sl.No.</th>
			<th>Place Name</th>
			<th>వీధి పేరు</th>
			<th>Edit</th>
		</tr>
	</thead>
	<?php
	$rows = $wpdb->get_results("SELECT * FROM place WHERE masjid = $masjid_id ORDER BY place");
	foreach ($rows as $row) {
		echo '<tr><td>'.++$i.'.</td>
			<td><a href="/place/?id='.$row->id.'">'.$row->place.'</a></td>
			<td><a href="/place/?id='.$row->id.'">'.$row->t_place.'</a></td>
			<td>';
		if ($row->admin==$user_id) {
			echo '<form method="post">
				<input type="hidden" name="place_id" value="'.$row->id.'">
				<input type="hidden" name="place" value="'.$row->place.'">
				<input type="hidden" name="t_place" value="'.$row->t_place.'">
				<input type="submit" name="edit" value="Edit" class="ui blue button">
			</form>';
		}
		echo '<tr>';
	}
	?>
</table>
<?php
if (count($rows)) {
	?>
	<a href="/add-person/" class="ui green button">Add Person</a>
	<?php
}