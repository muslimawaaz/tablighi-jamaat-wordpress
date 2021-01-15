<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>

<meta name="viewport" content="width=1024, initial-scale=1.0">

<style type="text/css">
  #masthead, .ab-user-links, #main-nav, .ab-primary-menu-wrapper{      display: none;    }
  button.ui {    height: 35px;  }
  form      {    display:inline;  }
</style>



<?php 
global $wpdb;
if(is_user_logged_in()){
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'masjid_id', true);
$place_id = $_GET["place_id"];
if($masjid_id){
  $caps = 'view_edit';
}
?>
<script type="text/javascript">
  $(".entry-title").first().html('<a href="/masjid"><?php echo get_masjid_name($masjid_id); ?></a>');
  $("title").first().html('<?php echo get_masjid_name($masjid_id); ?>');
  <?php if($_GET["place_id"]){ ?>
    $(".entry-title").first().append('<?php echo ' > <a style="color:red;" href="/masjid/?masjid_id='.$_GET["masjid_id"].'&place_id='.$_GET["place_id"].'&show=Search">'.get_place_name($_GET["place_id"]); ?></a>');
    $("title").first().html('<?php echo get_place_name($_GET["place_id"]).' - '.get_masjid_name($masjid_id); ?>');
  <?php } ?>
  $(".entry-title").first().css("fontSize", "20px");
  $(".entry-title").first().css("color", "green");
  $(".entry-title").first().css("display", "inline");
  $(".entry-title").first().css("text-transform", "capitalize");
</script>
<?php
$masjid_view = get_user_meta($user_id, 'masjid_view', true);
if(($masjid_id) || ($masjid_view)){
  if($masjid_view){
    $masjid_id = $masjid_view;
  }

$rows = $wpdb->get_results("SELECT * FROM history WHERE table_name = 'persons' AND masjid = $masjid_id");
$user = $wpdb->get_results("SELECT ID,user_login FROM wp_users", OBJECT_K );
print_r($users);
?>
<h3>Persons Edit history</h3>
<table class="ui striped table very compact collapsing sortable">
	<thead>
		<tr>
			<th>Edit ID</th>
			<th>Person ID</th>
			<th>Name</th>
			<th>Changes Made</th>
		</tr>
	</thead>
<?php foreach($rows as $row){ 
	$changes = unserialize($row->changes);
	echo '<tr>
			<td>#'.$row->ID.'</td>
			<td><b>'.$row->row_id.'</b></td>
			<td>'.get_person_name($row->row_id).'</td><td>';
	$i = 0;
	//print_r($changes);
	foreach($changes as $change){
		echo '<span class="key">'.$changes[$i]['col'].': </span>
		<i class="hand point right outline icon"></i>
		<span class="old">'.$changes[$i]['old'].'</span> 
		<i class="arrow right icon"></i>
		<span class="new">'.$changes[$i]['new'].'</span>
		<br>';
		$i++;
	}
	echo '<span class="date_time">
		'.$row->kind.' <i class="clock outline icon"></i>';
	//$date_time = date('Y-M-d',$row->date_time);
	$author = $row->author;
	echo $row->date_time.' GMT by <ins><b>'.$user[$author]->user_login.'<b></ins></span></td></tr>';
	} ?>
</table>
<style type="text/css">
	.key{
		color: #d4009b;
		font-weight: bold;
	}
	.old {
	    color: brown;
	}
	.new {
	    color: blue;
	}
	.date_time{	font-size: 80%; color: grey; font-style: italic; float: left;}
</style>
<script type="text/javascript">
	$('table').tablesort();
</script>
<?php 
}
 else {
  echo 'You are not allowed here.';
}
//update_user_meta($user_id, 'masjid_id','0');
} else {
?>
<p id="login_error" style="color:red"></p>

<form action="" method="POST">
  <table class="ui striped table">
    <tr>
      <td>Username
      </td>
      <td><input type="text" name="username"></td>
    </tr>
    <tr>
      <td>Password
      </td>
      <td><input type="password" name="pwd"></td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="submit" name="login" value="OK"
            class="ui blue button">
      </td>
    </tr>
  </table>
  
</form>
<?php
}
//$date_time = date('h:i:s a m/d/Y',$row->date_time);


//date_default_timezone_set("Asia/Kolkata");
//echo date('d-m-Y h:i:s A');
 ?>