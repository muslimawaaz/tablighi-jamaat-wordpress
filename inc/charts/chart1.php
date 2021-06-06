<?php
global $wpdb;
//$wpdb->show_errors(); $wpdb->print_error();
$a = $wpdb->get_var("SELECT COUNT(waqth) FROM person 
		WHERE masjid = $masjid_id
		AND waqth = 'Berone'");
$b = $wpdb->get_var("SELECT COUNT(waqth) FROM person 
		WHERE masjid = $masjid_id
		AND waqth = '4months'");
$c = $wpdb->get_var("SELECT COUNT(waqth) FROM person 
		WHERE masjid = $masjid_id
		AND waqth = '40days'");
$d = $wpdb->get_var("SELECT COUNT(waqth) FROM person 
		WHERE masjid = $masjid_id
		AND waqth = '3days'");
$e = $wpdb->get_var("SELECT COUNT(waqth) FROM person 
		WHERE masjid = $masjid_id
		AND (waqth = '' OR waqth = '--') ");

$total = $wpdb->get_var("SELECT COUNT(ID) FROM person 
		WHERE masjid = $masjid_id");

?>
<!doctype html>
<html>

<head>
	
	<script src="https://www.chartjs.org/dist/2.7.3/Chart.bundle.js"></script>
	<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
</head>

<body>
	<div id="container" style="width: 100%; max-width:600px">
		<canvas id="canvas" style="display:none; height:500px"></canvas>
	</div>
	
	<script>
		
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['No. of persons' ],
			datasets: [{
				label: 'Berone',
				backgroundColor: '#8ea4ff',
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [ <?php echo $a; ?>	]
			}, {
				label: '4 Months',
				backgroundColor: '#a4ff8e',
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [ <?php echo ($a+$b); ?>	]
			},{
				label: '40 Days',
				backgroundColor: '#8effef',
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [ <?php echo ($a+$b+$c); ?>	]
			},{
				label: '3 Days',
				backgroundColor: '#ffdb8e',
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [ <?php echo ($a+$b+$c+$d); ?>	]
			},{
				label: 'Others',
				backgroundColor: 'white',
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [ <?php echo $e; ?>	]
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: '<?php echo get_masjid_name($masjid_id).". Total: ".$total; ?>'
					}
				}
			});

		};

		
		var colorNames = Object.keys(window.chartColors);
		
	</script>
</body>

</html>
