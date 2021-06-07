<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script>

<style type="text/css">
  #masthead, .ab-user-links, #main-nav, 
  .ab-primary-menu-wrapper{      
  	/*display: none;*/
  }
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
$masjid_id = get_user_meta($user_id, 'masjid', true);
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
	if($_POST["add"]){
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
			'phone' 		=> $phone,
			'person' 	=> $person,
			'father' 		=> $father,
			'dob' 			=> $dob,
			'identifier' 	=> $_POST["identifier"],
			'juma'			=> $_POST["juma"],
			'waqth' 		=> $_POST["waqth"],
			'language' 		=> $_POST["language"],
			'place' 		=> $_POST["place"],
			'masjid' 		=> $_POST["work"],
			'qwaqth' 		=> $_POST["qwaqth"],
			'work' 			=> $work,
            'tashkeel_date' => $_POST["tashkeel_date"],
            'tashkeel_jamath' => $_POST["tashkeel_jamath"],
            'latitude'		=> $map_arr[0],
        	'longitude'		=> $map_arr[1],
        	'admin'			=> $user_id
			)); 

		if($result){
			echo '<div id="add" class="added">New Person Added successfully.</div>';
		}
	}
	
?>
<p style="font-size:20px">Add Person</p>

<form action="" method="post">
<table class="ui table green">
		<?php 
		  
        //$dob = '1996-07-20';
		//$from = new DateTime( $dob );
		//$to   = new DateTime('today');
		//echo $from->diff($to)->y;
		?>
		<tr><td>
		<table class="ui striped table">
		<tr><td>Name
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
                  remove_spaces();
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
              //var x = $('#phone').val().replace(/\s/g, "");
              var y = $('#age').val().replace(/\s/g, "");
              //$('#phone').val(x);
            $('#age').val(y);
          }
          </script>
        </td>
		<td>
        	<div class="speech">
              <input type="text" name="person" id="person" autofocus="">
              <i class="microphone blue big icon" id="mic_person" onclick="startDictation('person')" ></i>
            </div>   
        </td></tr>
          
		
        <tr><td>Phone : - <i class="mobile alternate icon green right"></i></td>
		<td>
        	<div class="speech">
            <input type="text" name="phone" id="phone" maxlength="15">
            <i class="microphone blue big icon" id="mic_phone" onclick="startDictation('phone')" ></i>
            </div>  
        </td></tr>
        
          
		<tr><td>Work</td>
			<td>
				<select name="work" class="ui dropdown" id="work1">
                <?php
				$rows = $wpdb->get_results("SELECT * FROM work");
				foreach ($rows as $row) {
					echo '<option value="'.$row->id.'">'.$row->work.'</option>';
				}
               ?>
				</select>
			</td>
		</tr>
		<tr><td>Identifier <i class="info circle green icon"></i></td>
		<td>
        	<div class="speech">
          	<input type="text" name="identifier" id="identifier">
        	<i class="microphone blue big icon" id="mic_identifier" onclick="startDictation('identifier')" ></i>
            </div>
        </td></tr>
		<tr><td>Date of Birth</td>
		<td><input type="date" name="dob" style="width:35vw; max-width:140px"> or  
          Age: 
          <div class="speech" style="width:35vw; display:inline;">
        	<input  type="number" name="age" style="width:15vw; max-width:100px; border: 1px solid black" id="age">
            <i class="microphone blue big icon" id="mic_age" onclick="startDictation('age')" ></i>
            </div>
        </td></tr>
		<tr><td>Father</td>
		<td>
        	<div class="speech">
        	<input type="text" name="father" id="father" value="<?php echo $father; ?>">
            <i class="microphone blue big icon" id="mic_father" onclick="startDictation('father')" ></i>
            </div>
        </td></tr>
		<tr><td>Place / Area</td>
		<td>
			<select name="place" id="place1" class="ui search dropdown">
        <?php
		$rows  = $wpdb->get_results("SELECT * FROM place WHERE masjid = $masjid_id ORDER BY place");
		foreach ($rows as $row){
			echo '<option value="'.$row->id.'">'.$row->place.'</option>';
		} ?>
				</select>
          <script type="text/javascript">
              $('#place1').val('<?php echo $_POST["place"]; ?>');
          </script>
			</td>
		</tr>
  		<tr>
			<td>Map location &nbsp;
				<?php 
				if(($latitude) && ($longitude)){
				    echo '<a href="https://www.google.com/maps/dir/15.858451,78.270564/'.
				          $latitude.','.$longitude.'/" target="_blank" style="color:#e03997">
				              <i class="external alternate icon large"></i></a>';
				}
				?>
			</td>
			<td><input type="text" name="map" style="max-width:300px"
				<?php if($latitude){
					echo 'value="'.$latitude.', '.$longitude.'"';
					}
				?>
				>
			</td>
		</tr>
               </table>
		</td><td>
		<table class="ui striped table">
        <tr>
        	<td>Tashkeel date</td>
            <td><input type="date" name="tashkeel_date"></td>
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
		<tr><td>Juma</td>
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
		<td><select name="waqth" id="waqth1" class="ui dropdown">
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
			<td><?php echo get_masjid_name($masjid_id); ?></td>
		</tr>
	</table></td></tr>
		<tr>
			<td colspan="2">
				<center>
					<input type="submit" name="add" value="Add" class="ui green button" id="btn_save1">
					<i class="" id="save_icon1"></i>
				</center>
			</td>
		</tr>
</table>
</form>
<script>
  $('#btn_save1').click(function(){
    $('#save_icon1').addClass('sync alternate icon loading green large');
    $('#save_icon2').addClass('sync alternate icon loading green large');
  });
  $('#btn_save2').click(function(){
    $('#save_icon1').addClass('sync alternate icon loading green large');
    $('#save_icon2').addClass('sync alternate icon loading green large');
  });
  $('.ui.dropdown').dropdown();
</script>
<script type="text/javascript">
	$('#juma1 option[value="<?php echo $juma; ?>"]').attr('selected','selected');
	$('#waqth1 option[value="<?php echo $waqth; ?>"]').attr('selected','selected');
	$('#language1 option[value="<?php echo $language; ?>"]').attr('selected','selected');
	$('#qwaqth1 option[value="<?php echo $qwaqth; ?>"]').attr('selected','selected');
	$('#town1 option[value="<?php echo $town; ?>"]').attr('selected','selected');
	$('#halqa1 option[value="<?php echo $halqa; ?>"]').attr('selected','selected');
	$('#masjid1 option[value="<?php echo $masjid_id; ?>"]').attr('selected','selected');
	$('#place1 option[value=<?php echo $place; ?>]').attr('selected','selected');
	$('#work1 option[value="<?php echo $work; ?>"]').attr('selected','selected');
</script>
<style type="text/css">
	input,select{
		width: 200px
	}
	.added{
		color:red;
		font-size:20px;
	}
</style>