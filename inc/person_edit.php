<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.js"></script>

<style>
  #masthead, .ab-user-links, #main-nav, .ab-primary-menu-wrapper{      display: none;    }
  select{	width:100%; }
  .microphone.icon{ float:right; }
</style>
<script type="text/javascript">
	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<center>
<span style="font-size:22px; font-weight:bold;">Edit Person</span>
</center>
<?php
global $wpdb;
$user_id = get_current_user_id();
if (!$user_id) {
	echo "Please login.";
	login_form_qwh();
	exit;
}
$masjid_id = get_user_meta($user_id, 'masjid', true);
if(!$masjid_id){
	?>
	<h2>Please select Masjid in My Account page</h2>
	<a href="<?php echo site_url(); ?>/my-account" class="ui green button">My Account</a>
	<?php
	exit;
}
$edit_id = $_GET["id"];
$admin = $wpdb->get_var("SELECT admin from person where id=$edit_id");
if (!$admin) {
	?>
	<h2>This person is not added by you. So you cannot edit.</h2>
	<a href="#" onclick="history.back()" class="ui grey button">Go Back</a>
	<?php
	exit;
}
$place_id = $wpdb->get_var("SELECT place FROM person WHERE id = $edit_id AND masjid = $masjid_id" );
if ($_GET["place_id"]) {
	$if_place = '?masjid_id='.$masjid_id.'&place_id='.$place_id;
}
?>
<script type="text/javascript">
	$(".entry-title").first().html('<a href="<?php echo site_url(); ?>/masjid/<?php echo $if_place; ?>"><i class="arrow left green icon"></i><?php echo get_masjid_name($masjid_id); ?></a>');
	$(".entry-title").first().css("fontSize", "25px");
	$(".entry-title").first().css("color", "green");
	$(".entry-title").first().css("text-transform", "capitalize");
	$(".entry-title").first().css("cursor", "pointer");
</script>
<?php 
	if($_POST["save_profile"]){
		$map 		= $_POST["map"];
		$map_arr 	= explode (", ", $map);
		
		$result 	= $wpdb->update( 'person' , 
			array(
				'person' 		=> $_POST["person"],
				't_name' 		=> $_POST["t_name"],
				'phone' 		=> $_POST["phone"],
				'father' 		=> $_POST["father"],
				't_father' 		=> $_POST["t_father"],
				'dob' 			=> $_POST["dob"],
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
	        	'tashkeel_jamath' => $_POST["tashkeel_jamath"],
	        	'latitude'		=> $map_arr[0],
	        	'longitude'		=> $map_arr[1]  
	        ),
			array( 'id' 	=> $edit_id ,
				'masjid'	=> $masjid_id,
				'admin'		=> $user_id
			)
		);
		// $wpdb->show_errors(); $wpdb->print_error();
		if($result){
			echo '<i class="checkmark blue icon"></i><span style="color: blue">New Data Updated successfully.</span>';
		}
	}
	$row = $wpdb->get_row("SELECT * FROM person WHERE id = $edit_id AND masjid = $masjid_id" );
	$phone    		= $row->phone;
	$dob   	 		= $row->dob;
	$father     	= $row->father;
	$t_father     	= $row->t_father;
	$juma       	= $row->juma;
	$waqth      	= $row->waqth;
	$person			= $row->person;
	$t_name			= $row->t_name;
	$identifier 	= $row->identifier;
	$t_identifier 	= $row->t_identifier;
	$language   	= $row->language;
	$place    		= $row->place;
	$masjid  		= $row->masjid;
	$qwaqth  		= $row->qwaqth;
	$work   		= $row->work;
	$response		= $row->response;
	$tashkeel_date 	= $row->tashkeel_date;
	$tashkeel_jamath= $row->tashkeel_jamath;
  	$latitude		= $row->latitude;
  	$longitude		= $row->longitude;
?>
<form action="" method="post">
<table class="ui fixed table green">
		<?php 
		$from = new DateTime( $dob );
		$to   = new DateTime('today');
		//echo $from->diff($to)->y;
  		?>
  		<tr>
			<td colspan="2">
				<center>
                  <input type="submit" name="save_profile" value="Save" class="ui green button" id="btn_save1">
                  <i class="" id="save_icon1"></i>
				</center>
			</td>
		</tr>
		<tr><td>
		<table class="ui striped table">
		<tr><td>Name</td>
		<td>
        	<div class="speech">
              <input type="text" name="person" id="person" value="<?php echo $person; ?>" />
              <i class="microphone blue big icon" id="mic_person" onclick="startDictation('person')" ></i>
            </div>  
        </td></tr>
        <tr>
        	<td>పేరు</td>
			<td>
	        	<input type="text" name="t_name" id="t_name" value="<?php echo $t_name; ?>" />
	        </td>
	    </tr> 
	    <tr><td>Identifier</td>
		<td>
          	<div class="speech">
          	<?php echo '<input type="text" name="identifier" id="identifier" value="'.$identifier.'">'; ?>
        	<i class="microphone blue big icon" id="mic_identifier" onclick="startDictation('identifier')" ></i>
            </div>
        </td></tr>
        <tr><td>గుర్తు</td>
			<td><?php echo '<input type="text" name="t_identifier" id="t_identifier" value="'.$t_identifier.'">'; ?></td>
		</tr>      
		<tr><td>Phone</td>
		<td>
            <div class="speech">
            <input type="text" maxlength="15" name="phone" id="phone" onchange="remove_spaces()" value="<?php echo $phone; ?>">
            <i class="microphone blue big icon" id="mic_phone" onclick="startDictation('phone')" ></i>
            </div>
        </td></tr>
          
		<tr><td>Work</td>
			<td>
				<select name="work" class="ui dropdown" id="work1">';
              	<?php 
                  $rows = $wpdb->get_results("SELECT * FROM work");
                  foreach ($rows as $row) {
                      echo '<option value="'.$row->id.'">'.$row->work.'</option>';
                  }
  				?>
				</select>
			</td>
		</tr>
		        
		<tr><td>Date of Birth</td>
		<td><input type="date" name="dob" value="<?php echo $dob; ?>"></td></tr>
		<tr><td>Father</td>
		<td>
        	<div class="speech">
        	<input type="text" name="father" id="father" value="<?php echo $father; ?>">
            <i class="microphone blue big icon" id="mic_father" onclick="startDictation('father')" ></i>
            </div>
        </td></tr>

        <tr><td>తండ్రి</td>
			<td><input type="text" name="t_father" id="t_father" value="<?php echo $t_father; ?>"></td>
		</tr>
        <?php echo '<tr><td>Place / Area</td>
		<td>
			<select name="place" id="place1" class="ui dropdown">';
		$rows  = $wpdb->get_results("SELECT * FROM place WHERE masjid = $masjid_id");
		foreach ($rows as $row){
			echo '<option value="'.$row->id.'">'.$row->place.'</option>';
		}
		echo '</select>
		</td>
		</tr>'; ?>
		<tr>
			<td>Map location &nbsp;
				<?php 
                  if(($latitude) && ($longitude)){
                      $arr = get_masjid_loc( $masjid_id );
                      echo '<a href="https://www.google.com/maps/dir/'.$arr[0].','.$arr[1].'/'.
                            $latitude.','.$longitude.'/" target="_blank" style="color:#e03997">
                                <i class="external alternate icon large"></i></a>';
                  }
				?>
			</td>
			<td><input type="text" name="map" 
				<?php if($latitude){
						echo 'value="'.$latitude.', '.$longitude.'"';
					}
				?>>
			</td>
		</tr>
		</table>
		</td><td>
		<table class="ui striped table">
        <tr>
          	<td>Response: - <i class="microphone blue big icon" id="mic_response" onclick="startDictation('response')" ></i></td>
          	<td>
              <input type="text" name="response" id="response" rows="5" value="<?php echo $response; ?>">
          	</td>
        </tr>
        <tr>
        	<td>Tashkeel date</td>
            <td><input type="date" name="tashkeel_date" value="<?php echo $tashkeel_date; ?>"></td>
        </tr>
        <tr>
        	<td>Tashkeel Jamath</td>
            <td><select name="tashkeel_jamath" id="tashkeel_jamath1" class="ui dropdown">
              		<option value="--">--</option>
                    <option value="3days">3days</option>
                    <option value="40days">40days</option>
                    <option value="4months">4months</option>
                    <option value="Berone">Berone</option>
                    <option value="Masturath 3days">Masturath 3days</option>
                    <option value="Masturath 10days">Masturath 10days</option>
                    <option value="Masturath 40days">Masturath 40days</option>
                    <option value="Masturath Berone">Masturath Berone</option>
              	</select>
            </td>
        </tr>
		<tr><td>Monthly which Juma</td>
		<td><select name="juma" id="juma1" class="ui dropdown">
				<option value="--">--</option>
				<option value="Juma 1">Juma 1</option>
				<option value="Juma 2">Juma 2</option>
				<option value="Juma 3">Juma 3</option>
				<option value="Juma 4">Juma 4</option>
				<option value="Juma 5">Juma 5</option>
			</select>
		</td></tr>
		<tr><td>Waqth</td>
		<td>
        	<select name="waqth" id="waqth1" class="ui dropdown">
				<option value="--">--</option>
				<option value="3days">3days</option>
				<option value="40days">40days</option>
				<option value="4months">4months</option>
				<option value="Berone">Berone</option>
			</select>
		</td></tr>
		<tr><td>Waqth ma masturath</td>
		<td><select name="qwaqth" id="qwaqth1" class="ui dropdown">
				<option value="--">--</option>
				<option value="3days">3days</option>
				<option value="10days">10days</option>
				<option value="40days">40days</option>
				<option value="Berone">Berone</option>
			</select>
		</td></tr>
		<tr><td>Language:</td>
			<td><select name="language" id="language1" class="ui dropdown">
				<option value="Urdu">Urdu</option>
				<option value="Telugu">Telugu</option>
				<option value="English">English</option>
				<option value="Hindi">Hindi</option>
			</select></td>
		</tr>
		<tr><td>Masjid</td>
		<td><?php echo get_masjid_name($masjid_id); ?></td></tr>
	</table></td></tr>
		<tr>
			<td colspan="2">
				<center>
                  <input type="submit" name="save_profile" value="Save" id="btn_save2" class="ui green button">
                  <i class="" id="save_icon2"></i>
				</center>
			</td>
		</tr>
</table>
</form>
<style>
   .speech {border: 1px solid #DDD; width: 300px; padding: 0; margin: 0}
   .speech input {border: 0; width: 240px; display: inline-block; height: 30px;}
   .speech i {float: right; width: 40px }
</style>
<script>
  function startDictation(transcript) {

    if (window.hasOwnProperty('webkitSpeechRecognition')) {

      var recognition = new webkitSpeechRecognition();

      recognition.continuous = false;
      recognition.interimResults = false;

      recognition.lang = "en-US";
      recognition.start();
      $('#mic_'+transcript).attr('class','microphone big red icon');

      recognition.onresult = function(e) {
        document.getElementById(transcript).value
          = e.results[0][0].transcript;

        recognition.stop();
        $('#mic_'+transcript).attr('class','microphone big blue icon');
        //document.getElementById('labnol').submit();
      };

      recognition.onerror = function(e) {
        recognition.stop();
        $('#mic_'+transcript).attr('class','microphone big blue icon');
      }

    }
  }
  function remove_spaces() {
    var y = $('#phone').val().replace(/\s/g, "");
    $('#phone').val(y);
  }
</script>
<script>
  $('#btn_save1').click(function(){
    $('#save_icon1').addClass('sync alternate icon loading green large');
    $('#save_icon2').addClass('sync alternate icon loading green large');
  });
  $('#btn_save2').click(function(){
  	$('#save_icon1').addClass('sync alternate icon loading green large');
    $('#save_icon2').addClass('sync alternate icon loading green large');
  });
</script>
<script type="text/javascript">
	$('#tashkeel_jamath1').val('<?php echo $tashkeel_jamath; ?>');
    $('#juma1').val('<?php echo $juma; ?>');
	$('#waqth1').val('<?php echo $waqth; ?>');
	$('#language1').val('<?php echo $language; ?>');
	$('#qwaqth1').val('<?php echo $qwaqth; ?>');
	$('#masjid1').val('<?php echo $masjid; ?>');
	$('#place1').val('<?php echo $place; ?>');
	$('#work1').val('<?php echo $work; ?>');
  
  var person = $('#person').val();
  person2 = person.replace(/\\/g, "");
  $('#person').val(person2);
  
  var identifier = $('#identifier').val();
  identifier2 = identifier.replace(/\\/g, "");
  $('#identifier').val(identifier2);
  
  var father = $('#father').val();
  father2 = father.replace(/\\/g, "");
  $('#father').val(father2);
  
  var response = $('#response').val();
  response2 = response.replace(/\\/g, "");
  $('#response').val(response2);

</script>
<style type="text/css">
	input,select{
      width:100%;
  }
  .green.button{
  	max-width: 150px;
  }
</style>