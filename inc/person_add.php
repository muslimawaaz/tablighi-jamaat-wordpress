<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css" integrity="sha512-8Tb+T7SKUFQWOPIQCaLDWWe1K/SY8hvHl7brOH8Nz5z1VT8fnf8B+9neoUzmFY3OzkWMMs3OjrwZALgB1oXFBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.min.css" integrity="sha512-OD0ScwZAE5PCg4nATXnm8pdWi0Uk0Pp2XFsFz1xbZ7xcXvapzjvcxxHPeTZKfMjvlwwl4sGOvgJghWF2GRZZDw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.css" integrity="sha512-YYS7fyqDxVE/yJ1280i8KjA+nC7wAtv2u/qkulKbdMpmp8DBWX0Wj+HtILsFyvq+fouCwCyr0hasPAz1eBlvwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.css" integrity="sha512-5StPzJo8hFyTvXfJ31FMB37EXRMVeUg+J3yvUNOJcL83MEMr7VrhZSNsoL3GDmUDBGBBhoTjnJx0Ql7cH9LY7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.js" integrity="sha512-8F/2JIwyPohlMVdqCmXt6A6YQ9X7MK1jHlwBJv2YeZndPs021083S2Z/mu7WZ5g0iTlGDYqelA9gQXGh1F0tUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.js" integrity="sha512-MCuLP92THkMwq8xkT2cQg5YpF30l3qzJuBRf/KsbQP1czFkRYkr2dSkCHmdJETqVmvIq5Y4AOVE//Su+cH+8QA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style type="text/css">
  button.ui {    height: 35px;  }
  form      {    display:inline;  }
  .person{   color:blue; cursor:pointer; font-size: 16px;  }
</style>

<?php 
global $wpdb;
$user_id = get_current_user_id();
if (!$user_id) {
	echo "Please Login";
	login_form_qwh();
	exit;
}
$masjid_id = get_user_meta($user_id, 'extra_details', true)["masjid"];
if(!$masjid_id){
	?>
	<h2>Please select Masjid in My Account page</h2>
	<a href="<?php echo site_url(); ?>/my-account" class="ui green button">My Account</a>
	<?php
	exit;
}
?>
<script type="text/javascript">
  $(".entry-title").first().html('<i class="arrow left green icon"></i><?php echo get_masjid_name($masjid_id); ?>');
  $(".entry-title").first().css("fontSize", "25px");
  $(".entry-title").first().css("color", "green");
  $(".entry-title").first().css("text-transform", "capitalize");
  $(".entry-title").first().css("cursor", "pointer");
  $(".entry-title").first().click(function(){
        window.location.href = "<?php echo site_url(); ?>/persons";
    });
</script>
<script type="text/javascript">
	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php
	if($_POST["save_profile"]=='Add Person'){
		$phone 		= $_POST["phone"];
		$person= $_POST["person"];
		$father 	= $_POST["father"];
		$dob 		= $_POST["dob"];
  	if($_POST["age"]){
      $age = $_POST["age"];
      list($year,$month,$day) = explode("-", date("Y-m-d"));
      $range = $year - $age;
      $time = strtotime("{$range}-{$month}-{$day}");
      $dob = date('Y-m-d', $time);
    }
		$map 		= $_POST["map"];
		$map_arr 	= explode (", ", $map); 
		$result 	= $wpdb->insert( 'person' , 
			array(
					'person' 		=> $_POST["person"],
					't_name' 		=> $_POST["t_name"],
					'phone' 		=> $_POST["phone"],
					'father' 		=> $_POST["father"],
					't_father' 		=> $_POST["t_father"],
					'dob' 			=> $dob,
					'identifier' 	=> $_POST["identifier"],
					't_identifier'	=> $_POST["t_identifier"],
					'juma' 			=> $_POST["juma"],
					'waqth' 		=> $_POST["waqth"],
					'language' 		=> $_POST["language"],
					'place' 		=> $_POST["place"],
					'qwaqth' 		=> $_POST["qwaqth"],
					'work' 			=> $_POST["work"],
					'response' 		=> $_POST["response"],
					'tashkeel_date' => $_POST["tashkeel_date"],
					'tashkeel_jamath'=> $_POST["tashkeel_jamath"],
					'latitude'		=> $map_arr[0],
					'longitude'		=> $map_arr[1],
        	'added_by'			=> $user_id,
        	'masjid'			=> $masjid_id
			)); 
			echo '<div id="add" class="added">New Person Added successfully.</div>';
	}
	
include 'person_form.php';
?>
<script type="text/javascript">
	$('input[name=save_profile]').val("Add Person");
	$('.ui.dropdown').dropdown();
</script>