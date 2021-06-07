<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<?php 
global $wpdb;
$user_id = get_current_user_id();
if (!$user_id) {
	echo do_shortcode('[firebase_otp_login]');
} else {
	$masjid_id = get_user_meta($user_id, 'extra_details', true)["masjid"];
	if (!$masjid_id) {
		echo 'Go to <a href="/my-account">My Account Page</a> and select Masjid';
	} else {
		$table_name = 'place';
		if($_POST["action"]){
			$data["place"] = $_POST["place"];
			$data["t_place"] = $_POST["t_place"];
			$data["added_by"] = $user_id;
			$data["masjid"] = $masjid_id;
			if($_POST["action"]=='Add'){
				$wpdb->insert($table_name,$data);
			} else if($_POST["action"]=='Add New' || $_POST["action"]=='Edit'){
			?>
			<hr>
			<form method="POST" enctype="multipart/form-data">
				<h2 id="small_frm">Add New Here</h2>
				<input type="hidden" name="id">
				<table class="ui blue striped table collapsing">
				<tr>
					<td>Place</td>
					<td><input type="text" name="place" >
					</td>
				</tr>
				<tr>
					<td>వీధి పేరు</td>
					<td><input type="text" name="t_place" >
					</td>
				</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="action" value="Add" class="ui blue button"></td>
					</tr>
				</table>
				</form>
				<style type="text/css">
					.ui.dropdown{
						width: 100% !important;
					}
				</style>
				<?php
			}
			if($_POST["action"]=='Edit'){
				$id = $_POST["id"];
				$row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id",ARRAY_A);
				$data = $row;
				?>
				<script type="text/javascript">
					$('input[name=action]').val('Save');
					$('input[name=id]').val('<?php echo $_POST["id"]; ?>');
					$('#small_frm').html('Edit Here');
				</script>
			<script type="text/javascript">
				$('input[name=place]').val('<?php echo $data["place"]; ?>');
				$('input[name=t_place]').val('<?php echo $data["t_place"]; ?>');
			</script>
				<?php
			}
			if($_POST["action"]=='Save'){
				$id = $_POST["id"];
				$wpdb->update($table_name,$data,array('id' => $id));
			}
			// if($_POST["action"]=='Delete'){
			// 	$id = $_POST["id"];
			// 	$wpdb->delete($table_name,array('id' => $id));
			// }
		} 
		if(($_POST["action"]!='Edit') && $_POST["action"]!='Add New') {
			?>
			<form method="POST"><input type="submit" name="action" value="Add New" class="ui green button"></form><br>
			<div style="overflow-x:auto">
			<table id="myTable" class="ui unstackable celled table dataTable">
				<thead>
					<tr>
						<th>Place</th>
						<th>వీధి పేరు</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
					foreach($rows as $row){
						echo '<tr row-id="'.$row->id.'">';
						echo '<td>'.$row->place.'</td>';
						echo '<td>'.$row->t_place.'</td>';
						if ($row->added_by==$user_id) {
							?>
							<td>
								<form method="post">
								<input type="hidden" name="id" value="<?php echo $row->id; ?>">
								<input type="submit" name="action" class="ui blue button" value="Edit">
								<!-- <input type="submit" name="action" class="ui red button" value="Delete"> -->
								</form>
							</td>
							<?php
						} else {
							echo '<td><i>Not added by you.</i></td>';
						}
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
			</div>
			<?php
		}
	}
}
clear_form_data();