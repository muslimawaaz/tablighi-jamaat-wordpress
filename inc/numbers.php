<?php
$dob = date('Y-m-d', strtotime('-12 years'));
$kids = $wpdb->get_var($sql." AND dob > '$dob'");

$total = $wpdb->get_var($sql);
$total_4m = $wpdb->get_var($sql." AND waqth = '4months'");
$total_40d = $wpdb->get_var($sql." AND waqth = '40days'");
$total_3d = $wpdb->get_var($sql." AND waqth = '3days'");
$total_none = $wpdb->get_var($sql." AND (waqth = '' OR waqth = '--')");

$stu = $wpdb->get_var($sql." AND work = 1");
$stu_4m = $wpdb->get_var($sql." AND work = 1 AND waqth = '4months'");
$stu_40d = $wpdb->get_var($sql." AND work = 1 AND waqth = '40days'");
$stu_3d = $wpdb->get_var($sql." AND work = 1 AND waqth = '3days'");
$stu_none = $wpdb->get_var($sql." AND work = 1 AND (waqth = '' OR waqth = '--')");

$tea = $wpdb->get_var($sql." AND work = 2");
$tea_4m = $wpdb->get_var($sql." AND work = 2 AND waqth = '4months'");
$tea_40d = $wpdb->get_var($sql." AND work = 2 AND waqth = '40days'");
$tea_3d = $wpdb->get_var($sql." AND work = 2 AND waqth = '3days'");
$tea_none = $wpdb->get_var($sql." AND work = 2 AND (waqth = '' OR waqth = '--')");

$emp = $wpdb->get_var($sql." AND work = 19");
$emp_4m = $wpdb->get_var($sql." AND work = 19 AND waqth = '4months'");
$emp_40d = $wpdb->get_var($sql." AND work = 19 AND waqth = '40days'");
$emp_3d = $wpdb->get_var($sql." AND work = 19 AND waqth = '3days'");
$emp_none = $wpdb->get_var($sql." AND work = 19 AND (waqth = '' OR waqth = '--')");

$agr = $wpdb->get_var($sql." AND work = 15");
$agr_4m = $wpdb->get_var($sql." AND work = 15 AND waqth = '4months'");
$agr_40d = $wpdb->get_var($sql." AND work = 15 AND waqth = '40days'");
$agr_3d = $wpdb->get_var($sql." AND work = 15 AND waqth = '3days'");
$agr_none = $wpdb->get_var($sql." AND work = 15 AND (waqth = '' OR waqth = '--')");

$wrk = $wpdb->get_var($sql." AND (work > 3 AND work < 15)");
$wrk_4m = $wpdb->get_var($sql." AND (work > 3 AND work < 15) AND waqth = '4months'");
$wrk_40d = $wpdb->get_var($sql." AND (work > 3 AND work < 15) AND waqth = '40days'");
$wrk_3d = $wpdb->get_var($sql." AND (work > 3 AND work < 15) AND waqth = '3days'");
$wrk_none = $wpdb->get_var($sql." AND (work > 3 AND work < 15) AND (waqth = '' OR waqth = '--')");

$biz = $wpdb->get_var($sql." AND work = 16");
$biz_4m = $wpdb->get_var($sql." AND work = 16 AND waqth = '4months'");
$biz_40d = $wpdb->get_var($sql." AND work = 16 AND waqth = '40days'");
$biz_3d = $wpdb->get_var($sql." AND work = 16 AND waqth = '3days'");
$biz_none = $wpdb->get_var($sql." AND work = 16 AND (waqth = '' OR waqth = '--')");

$ret = $wpdb->get_var($sql." AND work = 18");
$ret_4m = $wpdb->get_var($sql." AND work = 18 AND waqth = '4months'");
$ret_40d = $wpdb->get_var($sql." AND work = 18 AND waqth = '40days'");
$ret_3d = $wpdb->get_var($sql." AND work = 18 AND waqth = '3days'");
$ret_none = $wpdb->get_var($sql." AND work = 18 AND (waqth = '' OR waqth = '--')");

$emp = $wpdb->get_var($sql." AND work = 19");
$emp_4m = $wpdb->get_var($sql." AND work = 19 AND waqth = '4months'");
$emp_40d = $wpdb->get_var($sql." AND work = 19 AND waqth = '40days'");
$emp_3d = $wpdb->get_var($sql." AND work = 19 AND waqth = '3days'");
$emp_none = $wpdb->get_var($sql." AND work = 19 AND (waqth = '' OR waqth = '--')");
?>
<table class="ui striped collapsing table">
	<thead>
		<tr>
			<th>Kids: <?php echo $kids; ?> (below 13yrs)</th>
			<th>Total</th>
			<th>Students</th>
			<th>Teachers</th>
			<th>Employees</th>
			<th>Agriculture</th>
			<th>Workers</th>
			<th>Business</th>
			<th>Retired</th>
		</tr>
	</thead>
	<tbody>
		<tr style="background-color: lightgrey">
			<th>Total persons</th>
			<td><b><?php echo $total; ?></b></td>
			<td><b><?php echo $stu; ?></b></td>
			<td><b><?php echo $tea; ?></b></td>
			<td><b><?php echo $emp; ?></b></td>
			<td><b><?php echo $agr; ?></b></td>
			<td><b><?php echo $wrk; ?></b></td>
			<td><b><?php echo $biz; ?></b></td>
			<td><b><?php echo $ret; ?></b></td>
		</tr>
		<tr>
			<th>4months</th>
			<td><?php echo $total_4m; ?></td>
			<td><?php echo $stu_4m; ?></td>
			<td><?php echo $tea_4m; ?></td>
			<td><?php echo $emp_4m; ?></td>
			<td><?php echo $agr_4m; ?></td>
			<td><?php echo $wrk_4m; ?></td>
			<td><?php echo $biz_4m; ?></td>
			<td><?php echo $ret_4m; ?></td>
		</tr>
		<tr>
			<th>40days</th>
			<td><?php echo $total_40d; ?></td>
			<td><?php echo $stu_40d; ?></td>
			<td><?php echo $tea_40d; ?></td>
			<td><?php echo $emp_40d; ?></td>
			<td><?php echo $agr_40d; ?></td>
			<td><?php echo $wrk_40d; ?></td>
			<td><?php echo $biz_40d; ?></td>
			<td><?php echo $ret_40d; ?></td>
		</tr>
		<tr>
			<th>3days</th>
			<td><?php echo $total_3d; ?></td>
			<td><?php echo $stu_3d; ?></td>
			<td><?php echo $tea_3d; ?></td>
			<td><?php echo $emp_3d; ?></td>
			<td><?php echo $agr_3d; ?></td>
			<td><?php echo $wrk_3d; ?></td>
			<td><?php echo $biz_3d; ?></td>
			<td><?php echo $ret_3d; ?></td>
		</tr>

		<tr>
			<th>None</th>
			<td><?php echo $total_none; ?></td>
			<td><?php echo $stu_none; ?></td>
			<td><?php echo $tea_none; ?></td>
			<td><?php echo $emp_none; ?></td>
			<td><?php echo $agr_none; ?></td>
			<td><?php echo $wrk_none; ?></td>
			<td><?php echo $biz_none; ?></td>
			<td><?php echo $ret_none; ?></td>
		</tr>
	</tbody>
</table>