<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

<?php 
//global $wpdb;
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'masjid', true);
if($masjid_id){
if(!isset($_GET["show"])){
	echo '<form>No. of members: 
	<input type="number" name="noof" style="width:100px;">
	<input type="submit" name="show" value="Create">
</form>';
} else {
  echo '<form autocomplete="off" method="POST">
  Jamath Date: <input type="date" name="jamath_date" style="width:150px"><br>
Jamath Waqth: <select name="tashkeel_jamath" id="tashkeel_jamath1" class="ui dropdown">
	<option value="--">--</option>
    <option value="3days">3days</option>
    <option value="40days">40days</option>
    <option value="4months">4months</option>
    <option value="Berone">Berone</option>
    <option value="Masturath 3days">Masturath 3days</option>
    <option value="Masturath 10days">Masturath 10days</option>
    <option value="Masturath 40days">Masturath 40days</option>
    <option value="Masturath Berone">Masturath Berone</option>
</select>';
    $rows = $wpdb->get_results("SELECT ID,person_name,identifier FROM persons WHERE masjid = $masjid_id");
	foreach($rows as $row){
      $options .= '<option value="'.$row->ID.'">'.$row->person_name.' - '.$row->identifier.'</option>';
    }
  for($i = 1; $i <= $_GET["noof"]; $i++){
  echo '
  <input type="hidden" autocomplete="off">
<hr>
<div class="ui form">
  <div class="field" id="main_div" val="1" style=" max-width:300px">
    <label>Member '.$i.'</label>
    <select class="ui search dropdown" name="mem'.$i.'" style="display:inline;">
    	<option value="--">--</option>
      	'.$options.'
    </select>
  </div>
</div>
<script type="text/javascript">
	$("select.dropdown").dropdown();
</script>';
  }
  echo '<input type="submit" name="submit" value="Submit"></form>';
}
}