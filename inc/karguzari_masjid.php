<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/tab.min.css" integrity="sha512-NxWghIwNoV7V1IAHt4HwVnmsG/FuuViHaXFP0tsZS0D9snWm4SLGSdfB5XogpAWYXabp2t+XY9L184PQg2IuEA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script>
<meta name="viewport" content="width=1024, initial-scale=1.0">
<?php 
global $wpdb;
if(is_user_logged_in()){
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'extra_details', true)["masjid"];
$masjid_admin = get_user_meta($user_id, 'masjids', true);
if (!$masjid_admin) {
  $masjid_admin = array();
}
$masjid_name = $wpdb->get_var("SELECT masjid from masjid where id=$masjid_id");
$cols = $wpdb->get_col("SELECT kdate from karguzari_masjid WHERE masjid = $masjid_id");
$today = date('Y-m-d');
if(isset($_POST["add"])){ 
	$kdate	= $_POST["kdate"];
	$prevdate = date('Y-m-d', strtotime('-1 months',strtotime($kdate)));
	$kmonth = date('Y-m', strtotime($prevdate));
	$data["kdate"] = $_POST["kdate"];
	$data["kmonth"] = $kmonth;
	$data["masjid"] = $masjid_id;
	$data["ulama_saal"] = $_POST["ulama_saal"];
	$data["ulama_4m40d"] = $_POST["ulama_4m40d"];
	$data["total_4m"] = $_POST["total_4m"];
	$data["active_4m"] = $_POST["active_4m"];
	$data["total_40d"] = $_POST["total_40d"];
	$data["active_40d"] = $_POST["active_40d"];
	$data["total_3d"] = $_POST["total_3d"];
	$data["active_3d"] = $_POST["active_3d"];
	$data["yearly_4m"] = $_POST["yearly_4m"];
	$data["monthly_10d"] = $_POST["monthly_10d"];
	$data["daily_8h"] = $_POST["daily_8h"];
	$data["q_40d"] = $_POST["q_40d"];
	$data["q_10d"] = $_POST["q_10d"];
	$data["q_3d"] = $_POST["q_3d"];
	$data["tq_40d"] = $_POST["tq_40d"];
	$data["tq_10d"] = $_POST["tq_10d"];
	$data["tq_3d"] = $_POST["tq_3d"];
	$data["weekly_taleem"] = $_POST["weekly_taleem"];
	$data["houses"] = $_POST["houses"];
	$data["men"] = $_POST["men"];
	$data["students"] = $_POST["students"];
	$data["maktab"] = $_POST["maktab"];
	$data["centers"] = $_POST["centers"];
	$data["dinath"] = $_POST["dinath"];
	$data["c_mashora"] = $_POST["c_mashora"];
	$data["c_25h"] = $_POST["c_25h"];
	$data["c_mashora_a"] = $_POST["c_mashora_a"];
	$data["c_25h_a"] = $_POST["c_25h_a"];
	$data["mehnath_times"] = $_POST["mehnath_times"];
	$data["mehnath_times_a"] = $_POST["mehnath_times_a"];
	$data["gasht1"] = $_POST["gasht1"];
	$data["gasht1_a"] = $_POST["gasht1_a"];
	$data["gasht2"] = $_POST["gasht2"];
	$data["gasht2_a"] = $_POST["gasht2_a"];
	$data["j_3d"] = $_POST["j_3d"];
	$data["j_3d_a"] = $_POST["j_3d_a"];
	$data["jc_students"] = $_POST["jc_students"];
	$data["jc_students_a"] = $_POST["jc_students_a"];
	$data["h_taleem"] = $_POST["h_taleem"];
	$data["h_taleem_a"] = $_POST["h_taleem_a"];
	$data["h_5amal"] = $_POST["h_5amal"];
	$data["h_5amal_a"] = $_POST["h_5amal_a"];
	$data["c_shab"] = $_POST["c_shab"];
	$data["c_shab_a"] = $_POST["c_shab_a"];
	$data["j_berone"] = $_POST["j_berone"];
	$data["j_berone_a"] = $_POST["j_berone_a"];
	$data["j_4m"] = $_POST["j_4m"];
	$data["j_4m_a"] = $_POST["j_4m_a"];
	$data["j_40d"] = $_POST["j_40d"];
	$data["j_40d_a"] = $_POST["j_40d_a"];
	$data["qj_40d"] = $_POST["qj_40d"];
	$data["qj_40d_a"] = $_POST["qj_40d_a"];
	$data["qj_10d"] = $_POST["qj_10d"];
	$data["qj_10d_a"] = $_POST["qj_10d_a"];
	$data["qj_3d"] = $_POST["qj_3d"];
	$data["qj_3d_a"] = $_POST["qj_3d_a"];
	$data["qj_berone"] = $_POST["qj_berone"];
	$data["qj_berone_a"] = $_POST["qj_berone_a"];
	$data["c_2m"] = $_POST["c_2m"];
	$data["c_2m_a"] = $_POST["c_2m_a"];
	$data["village_work"] = $_POST["village_work"];
	$wpdb->insert( 'karguzari_masjid',$data);
}
if(isset($_POST["kdate"]) || $_POST["add_new"]){
	$kdate = $_POST["kdate"];
	$row = $wpdb->get_row("SELECT * FROM karguzari_masjid WHERE masjid = $masjid_id AND kdate = '$kdate'",ARRAY_A);
	if ($kdate) {
		$prevdate = date('Y-m-d', strtotime('-1 months',strtotime($kdate)));
		$kmonth = date('Y-m', strtotime($prevdate));
	} else {
		$prevdate = date('Y-m-d', strtotime('-1 months',strtotime($today)));
		$kmonth = date('Y-m', strtotime($prevdate));
	}
	$pre = $wpdb->get_row("SELECT * FROM karguzari_masjid WHERE masjid = $masjid_id AND kmonth = '$kmonth'",ARRAY_A);
	// print_r($row);
	// $wpdb->show_errors(); $wpdb->print_error();
	if ($_POST["add_new"]) {
		$row = $pre;
	}
	?>
	<i id="pre_values_label"></i>
	<form action="" method="POST" id="karguzari_form">
	<table class="ui table striped green collapsing">
		<thead>
			<tr>
				<th colspan="3"><h4><?php echo $masjid_name; ?></h4></th>
				<th>Date: <input type="date" name="kdate" value="<?php echo $today; ?>"></th>
			</tr>
		</thead>
		<tr>
			<td>Saal lagaye hue Ulama e Ekram</td>
			<td><input type="number" name="ulama_saal"></td>
			<td>40days / 4months lagaye hue Ulama e Ekram</td>
			<td><input type="number" name="ulama_4m40d"></td>
		</tr>
		<tr>
			<td>Waqth lagaye hue sathi:</td>
			<td>4months:<input type="number" name="total_4m"> <br>Mutharrik:<input type="number" name="active_4m"> </td>
			<td>40days:<input type="number" name="total_40d"> <br>Mutharrik:<input type="number" name="active_40d"> </td>
			<td>3days:<input type="number" name="total_3d"> <br>Mutharrik:<input type="number" name="active_3d"> </td>
		</tr>
		<tr>
			<td>Ek tihai tartib ke sathi</td>
			<td>Salana 4months: <input type="number" name="yearly_4m"> </td>
			<td>Mahana 10din: <input type="number" name="monthly_10d"> </td>
			<td>Rozana 8 hrs: <input type="number" name="daily_8h">
			</td>
		</tr>
		<tr>
			<td>Waqth lagaye hue masturath</td>
			<td>40days: <input type="number" name="q_40d"> </td>
			<td>10days: <input type="number" name="q_10d"> </td>
			<td>3days : <input type="number" name="q_3d"> </td>
		</tr>
		<tr>
			<td>Tartib se Waqth lagane wale masturath</td>
			<td>40days: <input type="number" name="tq_40d"> </td>
			<td>10days: <input type="number" name="tq_10d"> </td>
			<td>3days : <input type="number" name="tq_3d"></td>
		</tr>
		<tr>
			<td>Hafte wari Taleem</td>
			<td><input type="number" name="weekly_taleem"></td>
			<td></td><td></td>
		</tr>
		<tr>
			<td>No. of houses</td>
			<td><input type="number" name="houses"></td>
			<td>Baligh mard</td>
			<td><input type="number" name="men"></td>
		</tr>
		<tr>
			<td>Talaba ki tedad</td>
			<td><input type="number" name="students"></td>
			<td>Maktab hai ya nahi</td>
			<td><input type="number" name="maktab"></td>
		</tr>
		<tr>
			<td>Zimmedari ke centers</td>
			<td><input type="number" name="centers"></td>
			<td>Mehnath ke liye diye gaye dihath</td>
			<td><input type="number" name="dinath"></td>
		</tr>
	</table>
	<table class="ui table striped collapsing green">
		<thead>
			<tr>
				<th rowspan="2">Umur</th>
				<th colspan="2">Previous Month</th>
				<th colspan="2">Present Month</th>
			</tr>
			<tr>
				<th>Karguzari</th>
				<th>Azaim</th>
				<th>Karguzari</th>
				<th>Azaim</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Rozana Mashore me baithne wale</td>
				<td><span class="sblue"></span><input type="number" name="pre_c_mashora"></td>
				<td><span class="plusg">+</span><input type="number" name="pre_c_mashora_a"></td>
				<td><span class="sblue"></span><input type="number" name="c_mashora"></td>
				<td><span class="plusg">+</span><input type="number" name="c_mashora_a"></td>
			</tr>
			<tr>
				<td>Rozana 2.5 hours ki mehnath</td>
				<td><span class="sblue"></span><input type="number" name="pre_c_25h"></td>
				<td><span class="plusg"></span><input type="number" name="pre_c_25h_a"></td>
				<td><span class="sblue"></span><input type="number" name="c_25h"></td>
				<td><span class="plusg"></span><input type="number" name="c_25h_a"></td>
			</tr>
			<tr>
				<td>Masjid ki abaadi ki mehnath kitne waqth horahi hai?</td>
				<td><span class="sblue"></span><input type="number" name="pre_mehnath_times"></td>
				<td><span class="plusg"></span><input type="number" name="pre_mehnath_times_a"></td>
				<td><span class="sblue"></span><input type="number" name="mehnath_times"></td>
				<td><span class="plusg"></span><input type="number" name="mehnath_times_a"></td>
			</tr>
			<tr>
				<td rowspan="2">Hafthe wari gasht me shirkath karne wale</td>
				<td>(1) : <input type="number" name="pre_gasht1"></td>
				<td><span class="plusg"></span><input type="number" name="pre_gasht1_a"></td>
				<td>(1) : <input type="number" name="gasht1"></td>
				<td><span class="plusg"></span><input type="number" name="gasht1_a"></td>
			</tr>
			<tr>
				<td>(2) : <input type="number" name="pre_gasht2"></td>
				<td><span class="plusg"></span></span><input type="number" name="pre_gasht2_a"></td>
				<td>(2) : <input type="number" name="gasht2"></td>
				<td><span class="plusg"></span></span><input type="number" name="gasht2_a"></td>
			</tr>
			<tr>
				<td>Is maah me kitne talaba jamath me gaye</td>
				<td><span class="sblue"></span><input type="number" name="pre_jc_students"></td>
				<td><span class="plusg"></span><input type="number" name="pre_jc_students_a"></td>
				<td><span class="sblue"></span><input type="number" name="jc_students"></td>
				<td><span class="plusg"></span><input type="number" name="jc_students_a"></td>
			</tr>
			<tr>
				<td>Rozana taleem wale gharon ki tedad</td>
				<td><span class="ihome"></span><input type="number" name="pre_h_taleem"></td>
				<td><span class="plusg"></span><input type="number" name="pre_h_taleem_a"></td>
				<td><span class="ihome"></span><input type="number" name="h_taleem"></td>
				<td><span class="plusg"></span><input type="number" name="h_taleem_a"></td>
			</tr>
			<tr>
				<td>Panch amaal ke saath</td>
				<td><span class="ihome"></span><input type="number" name="pre_h_5amal"></td>
				<td><span class="plusg"></span><input type="number" name="pre_h_5amal_a"></td>
				<td><span class="ihome"></span><input type="number" name="h_5amal"></td>
				<td><span class="plusg"></span><input type="number" name="h_5amal_a"></td>
			</tr>
			<tr>
				<td>Markaz me shab guzari karne wale sathi</td>
				<td><span class="sblue"></span><input type="number" name="pre_c_shab"></td>
				<td><span class="plusg"></span><input type="number" name="pre_c_shab_a"></td>
				<td><span class="sblue"></span><input type="number" name="c_shab"></td>
				<td><span class="plusg"></span><input type="number" name="c_shab_a"></td>
			</tr>
			<tr>
				<td>2 months Banglewali masjid me lagane wale</td>
				<td><span class="sblue"></span><input type="number" name="pre_c_2m"></td>
				<td><span class="plusg"></span><input type="number" name="pre_c_2m_a"></td>
				<td><span class="sblue"></span><input type="number" name="c_2m"></td>
				<td><span class="plusg"></span><input type="number" name="c_2m_a"></td>
			</tr>
			<tr>
				<td>Dehathon me kya mehnath hui</td>
				<td colspan="2">
					<input type="text" name="pre_village_work">
				</td>
				<td colspan="2">
					<input type="text" name="village_work">	
				</td>
			</tr>
		</tbody>
	</table>
	<table class="ui table striped collapsing green">
		<thead>
			<tr>
				<th colspan="3" style="text-align: center;">Mardana Jamath</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>3days</td>
			<td><span class="jblue"></span></i><input type="number" name="j_3d"></td>
			<td><span class="plusg"></span></i><input type="number" name="j_3d_a"></td>
		</tr>
		<tr>
			<td>40days</td>
			<td><span class="jblue"></span><input type="number" name="j_40d"></td>
			<td><span class="plusg"></span><input type="number" name="j_40d_a"></td>
		</tr>
		<tr>
			<td>4months</td>
			<td><span class="jblue"></span><input type="number" name="j_4m"></td>
			<td><span class="plusg"></span><input type="number" name="j_4m_a"></td>
		</tr>
		<tr>
			<td>Berone</td>
			<td><span class="jblue"></span><input type="number" name="j_berone"></td>
			<td><span class="plusg"></span><input type="number" name="j_berone_a"></td>
		</tr>
		</tbody>
	</table>
	<table class="ui table striped collapsing green">
		<thead>
			<tr>
				<th colspan="3" style="text-align: center;">Ma Masturath Jamath</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>40days:</td>
				<td><span class="jblac"></span><input type="number" name="qj_40d"></td>
				<td><span class="plusg"></span><input type="number" name="qj_40d_a"></td>
			</tr>
			<tr>
				<td>10days:</td>
				<td><span class="jblac"></span><input type="number" name="qj_10d"></td>
				<td><span class="plusg"></span><input type="number" name="qj_10d_a"></td>
			</tr>
			<tr>
				<td>3days:</td>
				<td><span class="jblac"></span><input type="number" name="qj_3d"></td>
				<td><span class="plusg"></span><input type="number" name="qj_3d_a"></td>
			</tr>
			<tr>
				<td>Berone</td>
				<td><span class="jblac"></span><input type="number" name="qj_berone"></td>
				<td><span class="plusg"></span><input type="number" name="qj_berone_a"></td>
			</tr>
			<tr>
				<td colspan="3">
					<input type="submit" name="add" value="Add">
				</td>
			</tr>
		</tbody>
	</table>
	<div style="clear: both"></div>
	</form>
	<script type="text/javascript">
		$('#pre_values_label').val('Values taken from previous karguzari:');
		$('input[name=kdate]').val('<?php echo $row["kdate"]; ?>');
		$('input[name=ulama_saal]').val('<?php echo $row["ulama_saal"]; ?>');
		$('input[name=ulama_4m40d]').val('<?php echo $row["ulama_4m40d"]; ?>');
		$('input[name=total_4m]').val('<?php echo $row["total_4m"]; ?>');
		$('input[name=active_4m]').val('<?php echo $row["active_4m"]; ?>');
		$('input[name=total_40d]').val('<?php echo $row["total_40d"]; ?>');
		$('input[name=active_40d]').val('<?php echo $row["active_40d"]; ?>');
		$('input[name=total_3d]').val('<?php echo $row["total_3d"]; ?>');
		$('input[name=active_3d]').val('<?php echo $row["active_3d"]; ?>');
		$('input[name=yearly_4m]').val('<?php echo $row["yearly_4m"]; ?>');
		$('input[name=monthly_10d]').val('<?php echo $row["monthly_10d"]; ?>');
		$('input[name=daily_8h]').val('<?php echo $row["daily_8h"]; ?>');
		$('input[name=q_40d]').val('<?php echo $row["q_40d"]; ?>');
		$('input[name=q_10d]').val('<?php echo $row["q_10d"]; ?>');
		$('input[name=q_3d]').val('<?php echo $row["q_3d"]; ?>');
		$('input[name=tq_40d]').val('<?php echo $row["tq_40d"]; ?>');
		$('input[name=tq_10d]').val('<?php echo $row["tq_10d"]; ?>');
		$('input[name=tq_3d]').val('<?php echo $row["tq_3d"]; ?>');
		$('input[name=weekly_taleem]').val('<?php echo $row["weekly_taleem"]; ?>');
		$('input[name=houses]').val('<?php echo $row["houses"]; ?>');
		$('input[name=men]').val('<?php echo $row["men"]; ?>');
		$('input[name=students]').val('<?php echo $row["students"]; ?>');
		$('input[name=maktab]').val('<?php echo $row["maktab"]; ?>');
		$('input[name=centers]').val('<?php echo $row["centers"]; ?>');
		$('input[name=dinath]').val('<?php echo $row["dinath"]; ?>');

		$('input[name=c_mashora]').val('<?php echo $row["c_mashora"]; ?>');
		$('input[name=c_mashora_a]').val('<?php echo $row["c_mashora_a"]; ?>');
		$('input[name=c_25h]').val('<?php echo $row["c_25h"]; ?>');
		$('input[name=c_25h_a]').val('<?php echo $row["c_25h_a"]; ?>');
		$('input[name=mehnath_times]').val('<?php echo $row["mehnath_times"]; ?>');
		$('input[name=mehnath_times_a]').val('<?php echo $row["mehnath_times_a"]; ?>');
		$('input[name=gasht1]').val('<?php echo $row["gasht1"]; ?>');
		$('input[name=gasht1_a]').val('<?php echo $row["gasht1_a"]; ?>');
		$('input[name=gasht2]').val('<?php echo $row["gasht2"]; ?>');
		$('input[name=gasht2_a]').val('<?php echo $row["gasht2_a"]; ?>');
		$('input[name=jc_students]').val('<?php echo $row["jc_students"]; ?>');
		$('input[name=jc_students_a]').val('<?php echo $row["jc_students_a"]; ?>');
		$('input[name=h_taleem]').val('<?php echo $row["h_taleem"]; ?>');
		$('input[name=h_taleem_a]').val('<?php echo $row["h_taleem_a"]; ?>');
		$('input[name=h_5amal]').val('<?php echo $row["h_5amal"]; ?>');
		$('input[name=h_5amal_a]').val('<?php echo $row["h_5amal_a"]; ?>');
		$('input[name=c_shab]').val('<?php echo $row["c_shab"]; ?>');
		$('input[name=c_shab_a]').val('<?php echo $row["c_shab_a"]; ?>');
		$('input[name=c_2m]').val('<?php echo $row["c_2m"]; ?>');
		$('input[name=c_2m_a]').val('<?php echo $row["c_2m_a"]; ?>');
		$('input[name=village_work]').val('<?php echo $row["village_work"]; ?>');
		
		$('input[name=j_3d]').val('<?php echo $row["j_3d"]; ?>');
		$('input[name=j_3d_a]').val('<?php echo $row["j_3d_a"]; ?>');
		$('input[name=j_40d]').val('<?php echo $row["j_40d"]; ?>');
		$('input[name=j_40d_a]').val('<?php echo $row["j_40d_a"]; ?>');
		$('input[name=j_4m]').val('<?php echo $row["j_4m"]; ?>');
		$('input[name=j_4m_a]').val('<?php echo $row["j_4m_a"]; ?>');
		$('input[name=j_berone]').val('<?php echo $row["j_berone"]; ?>');
		$('input[name=j_berone_a]').val('<?php echo $row["j_berone_a"]; ?>');
		$('input[name=qj_40d]').val('<?php echo $row["qj_40d"]; ?>');
		$('input[name=qj_40d_a]').val('<?php echo $row["qj_40d_a"]; ?>');
		$('input[name=qj_10d]').val('<?php echo $row["qj_10d"]; ?>');
		$('input[name=qj_10d_a]').val('<?php echo $row["qj_10d_a"]; ?>');
		$('input[name=qj_3d]').val('<?php echo $row["qj_3d"]; ?>');
		$('input[name=qj_3d_a]').val('<?php echo $row["qj_3d_a"]; ?>');
		$('input[name=qj_berone]').val('<?php echo $row["qj_berone"]; ?>');
		$('input[name=qj_berone_a]').val('<?php echo $row["qj_berone_a"]; ?>');

		$('input[name=pre_c_mashora]').val('<?php echo $pre["c_mashora"]; ?>');
		$('input[name=pre_c_mashora_a]').val('<?php echo $pre["c_mashora_a"]; ?>');
		$('input[name=pre_c_25h]').val('<?php echo $pre["c_25h"]; ?>');
		$('input[name=pre_c_25h_a]').val('<?php echo $pre["c_25h_a"]; ?>');
		$('input[name=pre_mehnath_times]').val('<?php echo $pre["mehnath_times"]; ?>');
		$('input[name=pre_mehnath_times_a]').val('<?php echo $pre["mehnath_times_a"]; ?>');
		$('input[name=pre_gasht1]').val('<?php echo $pre["gasht1"]; ?>');
		$('input[name=pre_gasht1_a]').val('<?php echo $pre["gasht1_a"]; ?>');
		$('input[name=pre_gasht2]').val('<?php echo $pre["gasht2"]; ?>');
		$('input[name=pre_gasht2_a]').val('<?php echo $pre["gasht2_a"]; ?>');
		$('input[name=pre_jc_students]').val('<?php echo $pre["jc_students"]; ?>');
		$('input[name=pre_jc_students_a]').val('<?php echo $pre["jc_students_a"]; ?>');
		$('input[name=pre_h_taleem]').val('<?php echo $pre["h_taleem"]; ?>');
		$('input[name=pre_h_taleem_a]').val('<?php echo $pre["h_taleem_a"]; ?>');
		$('input[name=pre_h_5amal]').val('<?php echo $pre["h_5amal"]; ?>');
		$('input[name=pre_h_5amal_a]').val('<?php echo $pre["h_5amal_a"]; ?>');
		$('input[name=pre_c_shab]').val('<?php echo $pre["c_shab"]; ?>');
		$('input[name=pre_c_shab_a]').val('<?php echo $pre["c_shab_a"]; ?>');
		$('input[name=pre_c_2m]').val('<?php echo $pre["c_2m"]; ?>');
		$('input[name=pre_c_2m_a]').val('<?php echo $pre["c_2m_a"]; ?>');
		$('input[name=pre_village_work]').val('<?php echo $pre["village_work"]; ?>');

		$('input[name=pre_c_mashora]').attr('disabled','');
		$('input[name=pre_c_mashora_a]').attr('disabled','');
		$('input[name=pre_c_25h]').attr('disabled','');
		$('input[name=pre_c_25h_a]').attr('disabled','');
		$('input[name=pre_mehnath_times]').attr('disabled','');
		$('input[name=pre_mehnath_times_a]').attr('disabled','');
		$('input[name=pre_gasht1]').attr('disabled','');
		$('input[name=pre_gasht1_a]').attr('disabled','');
		$('input[name=pre_gasht2]').attr('disabled','');
		$('input[name=pre_gasht2_a]').attr('disabled','');
		$('input[name=pre_jc_students]').attr('disabled','');
		$('input[name=pre_jc_students_a]').attr('disabled','');
		$('input[name=pre_h_taleem]').attr('disabled','');
		$('input[name=pre_h_taleem_a]').attr('disabled','');
		$('input[name=pre_h_5amal]').attr('disabled','');
		$('input[name=pre_h_5amal_a]').attr('disabled','');
		$('input[name=pre_c_shab]').attr('disabled','');
		$('input[name=pre_c_shab_a]').attr('disabled','');
		$('input[name=pre_c_2m]').attr('disabled','');
		$('input[name=pre_c_2m_a]').attr('disabled','');
		$('input[name=pre_village_work]').attr('disabled','');

		$('input[disabled]').css('background-color','#f7f7f7');
		<?php
		if ($_POST["kdate"]) {
			?>
			$('#karguzari_form input').css('background-color','#f7f7f7');
			$('#karguzari_form input').attr('readonly','');
			<?php
		}
		?>
	</script>
	<?php
}
?>
<div style="clear: both"></div>
<?php
echo '<h4>Old Karguzar pages of '.$masjid_name.': Click on date to open</h4>';
foreach ($cols as $col) {
	echo '
		<form action="" method="POST">
			<input type="submit" name="kdate" value="'.$col.'" class="ui blue button">
		</form>
	';
}
}
?>
<form method="post"><input type="submit" name="add_new" value="Add New"></form>
<script type="text/javascript">
	$('.ihome').html('<i class="large icon red home"></i>');
	$('.plusg').html('<i class="large icon green add "></i>');
	$('.sblue').html('<i class="large icon blue user "></i>');
	$('.jblue').html('<i class="	  icon blue users circular inverted "></i>');
	$('.jblac').html('<i class="	  icon black users circular inverted "></i>');
</script>

<style type="text/css">
	table td, table th {
		border: 1px solid black; /* var(--nv-light-bg); */
	}
	table{
		float: left;
		display: inline;
	}
	thead{
		text-align: center;
		font-size: 120%
	}
	input[type=number]{
		width: 70px;
		height: 30px;
		padding: 5px;
	}
	form{
		display: inline;
	}
</style>