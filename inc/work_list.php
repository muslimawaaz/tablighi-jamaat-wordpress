<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/form.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/table.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
<?php
global $wpdb;
if(isset($_POST["add"])){
$wpdb->insert( 
	'work', 
	array( 
		'work' => $_POST["work"], 
		'icon'    => $_POST["icon"]
		)
		);
}

if(isset($_POST["edit"])){
	$id = $_POST["id"];
	$row = $wpdb->get_row( "SELECT * FROM work WHERE id = $id", ARRAY_A );
?>
<h1>Edit here</h1>
<form action="" method="POST" id="edit form">
  <input type="hidden" name="id" value="<?php echo $id; ?>" >
  <table class="i striped table">
	<tr>
      <td>Work</td>
      <td><input type="text" name="work" value="<?php echo $row["work"]; ?>" ></td>
    </tr>
    <tr>
      <td>Icon:</td>
      <td>
        <input type="text" name="icon" id="iconinp" 
               onchange="run()" value="<?php echo $row["icon"]; ?>">
        <i class="" id="icon"></i>
        <script type="text/javascript">
          function run(){
            var x = $('#iconinp').val();
            //alert(x);
            $('#icon').attr('class',x);
          }
        </script>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="save" value="Save"></td>
      </tr>
  </table>
</form>
<?php } else {	?>

<h2>Add</h2>
	<form action="" method="POST">
	<table class="ui striped table">
		<tr>
			<td>Work</td>
			<td><input type="text" name="work"></td>
		</tr>
		<tr>
			<td>Icon Class</td>
			<td>
				<input type="text" name="icon" id="iconinp" onchange="run()">
				<i class="" id="icon"></i>
				<script type="text/javascript">
					function run(){
						var x = $('#iconinp').val();
						//alert(x);
						$('#icon').attr('class',x+' big icon');
					}
				</script>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="add" value="Add"></td>
		</tr>
	</table>
</form>
<?php
}
if(isset($_POST["save"])){
	$wpdb->update( 
	'work', 
	array( 
		'work'=> $_POST["work"],	
		'icon' => $_POST["icon"]
	), 
	array( 'id' => $_POST["id"] ));
	}  
	$works = $wpdb->get_results("SELECT * FROM work");
?>
<h1>Work list:</h1>
<table class="ui striped table">
	<thead>
	<tr>
		<th>No.</th>
		<th>  Work   </th>
		<th>  Icon   </th>
		<th>  Edit   </th>
	</tr>
	</thead>

 <?php
foreach ( $works as $work ) 
{
 echo '<tr>
 			<td>'.++$i.'.</td>
			<td>     '.$work->work.' </td>
			<td><i class="'.$work->icon.' big icon" title="'.$work->work.'">  </td>
			<td>
				<form method="POST">
					<input type="hidden" name="id" value="'.$work->id.'">
					<input type="submit" name="edit" value="Edit" class="ui mini blue button">
				</form>
			</td>
		</tr>';

}
?>
</table>