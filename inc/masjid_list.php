<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>


<?php
global $wpdb;
$ds = $wpdb->get_results("SELECT * FROM halqas");
if(isset($_POST["edit"])){
    $ID = $_POST["ID"];
    $row = $wpdb->get_row("SELECT * FROM masjids WHERE ID = $ID", ARRAY_A);
    ?>
    <h2>Edit here:</h2>
    <form method="POST" action="">
    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
	<table class="ui striped table">
		<tr>
			<td>Masjid</td>
			<td><input type="text" name="masjid" value="<?php echo $row["masjid"]; ?>"></td>
		</tr>
		<tr>
			<td>Halqa:</td>
			<td>
				<select name="halqa" id="halqa">
				<?php 
				foreach($ds as $d){
					echo '<option value="'.$d->ID.'">'.$d->halqa.'</option>';
				} ?>
				</select>
				<script type="text/javascript">
					$('#halqa').val('<?php echo $row["halqa"]; ?>');
				</script>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="save" value="Save"></td>
		</tr>
	</table>
	</form>
	<?php 
} else { 
	?>
	<h1>Add New Masjid:</h1>
	<form method="POST" action="">
		<table>
			<tr>
				<td>Masjid Name:</td>
				<td><input type="text" name="masjid"></td>
				<td>Halqa:</td>
				<td>
					<select name="halqa">
					<?php 
					foreach($ds as $d){
						echo '<option value="'.$d->ID.'">'.$d->halqa.'</option>';
					} ?>
					</select>
				</td>
				<td></td>
				<td><input type="submit" name="add" value="Add"></td>
			</tr>
		</table>
	</form>
	<?php 
}
if(isset($_POST["save"])){
    $wpdb->update( 
        	'masjids', 
        	array( 
        		'masjid' => $_POST["masjid"],
        		'halqa'	 => $_POST["halqa"]
        	), 
        	array( 'ID' => $_POST["ID"] ));
}
if(isset($_POST["add"])){
    $wpdb->insert( 'masjids', 
    	array( 'masjid' => $_POST["masjid"],
				'halqa' => $_POST["halqa"]));

}
$halqas = $wpdb->get_results("SELECT * FROM halqas",OBJECT_K);
$towns = $wpdb->get_results("SELECT * FROM towns",OBJECT_K);
$districts = $wpdb->get_results("SELECT * FROM districts",OBJECT_K);
$masjids = $wpdb->get_results("SELECT * FROM masjids");
?>
	<table class="ui striped table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Masjids</th>
				<th>Halqa</th>
				<th>Town</th>
				<th>Districts</th>
				<th>Edit</th>
			</tr>
		</thead>
<?php
foreach($masjids as $masjid){
	$halqa_id = $masjid->halqa;
	$town_id  = $halqas[$halqa_id]->town;
	$district_id = $towns[$town_id]->district;
 echo '<tr>
		<td><b>#'.$masjid->ID.'</b></td>
		<td>'.$masjid->masjid.'</td>
		<td>'.get_halqa_name($halqa_id).' Halqa </td>
		<td>'.$towns[$town_id]->town.'</td>
		<td>'.$districts[$district_id]->district.'</td>
		<td>
			<form method="POST">
				<input type="hidden" name="ID" value="'.$masjid->ID.'">
				<input type="submit" name="edit" value="Edit">
			</form>
		</td>
	</tr>';
}
?>
</table>