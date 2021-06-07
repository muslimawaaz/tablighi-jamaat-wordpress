<form action="" method="post">
<table class="ui fixed table green">
	<tr>
		<td colspan="2">
		<center>
		<input type="submit" name="save_profile" value="Save" class="ui green button" id="btn_save1">
		<i class="" id="save_icon1"></i>
		</center>
		</td>
	</tr>
	<tr><td>Name</td>
		<td>
			<div class="speech">
			  <input type="text" name="person" id="person" />
			  <i class="microphone blue big icon" id="mic_person" onclick="startDictation('person')" ></i>
			</div>  
		</td>
	</tr>
	<tr>
		<td>పేరు</td>
		<td>
			<input type="text" name="t_name" id="t_name" />
		</td>
	</tr> 
	<tr><td>Identifier</td>
		<td>
		  	<div class="speech">
		  	<input type="text" name="identifier" id="identifier">
			<i class="microphone blue big icon" id="mic_identifier" onclick="startDictation('identifier')" ></i>
			</div>
		</td>
	</tr>
	<tr><td>గుర్తు</td>
		<td><input type="text" name="t_identifier" id="t_identifier"></td>
	</tr>
	<tr><td>Phone</td>
		<td>
			<div class="speech">
			<input type="text" maxlength="15" name="phone" id="phone" onchange="remove_spaces()">
			<i class="microphone blue big icon" id="mic_phone" onclick="startDictation('phone')" ></i>
			</div>
		</td>
	</tr>
	<tr><td>Work</td>
		<td>
			<select name="work" class="ui dropdown" id="work1">';
		  	<?php 
			  $works = $wpdb->get_results("SELECT * FROM work");
			  foreach ($works as $work) {
				  echo '<option value="'.$work->id.'">'.$work->work.'</option>';
			  }
				?>
			</select>
		</td>
	</tr>			
	<tr><td>Date of Birth</td>
		<td><input type="date" name="dob"></td>
	</tr>
	<tr><td>Father</td>
		<td>
			<div class="speech">
			<input type="text" name="father" id="father">
			<i class="microphone blue big icon" id="mic_father" onclick="startDictation('father')" ></i>
			</div>
		</td>
	</tr>
	<tr><td>తండ్రి</td>
		<td><input type="text" name="t_father" id="t_father"></td>
	</tr>
	<tr><td>Place / Area</td>
		<td>
			<select name="place" id="place1" class="ui dropdown">
			<?php
			$places  = $wpdb->get_results("SELECT * FROM place WHERE masjid = $masjid_id");
			foreach ($places as $place){
				echo '<option value="'.$place->id.'">'.$place->place.'</option>';
			}
			?>
		</select>
		</td>
	</tr>
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
	<tr>
	  	<td>Response: - <i class="microphone blue big icon" id="mic_response" onclick="startDictation('response')"></i></td>
	  	<td>
		  <input type="text" name="response" id="response" rows="5">
	  	</td>
	</tr>
	<tr>
		<td>Tashkeel date</td>
		<td><input type="date" name="tashkeel_date"></td>
	</tr>
	<tr>
		<td>Tashkeel Jamath</td>
		<td><select name="tashkeel_jamath" id="tashkeel_jamath1" class="ui dropdown">
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
				<option value="3days">3days</option>
				<option value="40days">40days</option>
				<option value="4months">4months</option>
				<option value="Berone">Berone</option>
			</select>
		</td>
	</tr>
	<tr><td>Waqth ma masturath</td>
		<td><select name="qwaqth" id="qwaqth1" class="ui dropdown">
				<option value="3days">3days</option>
				<option value="10days">10days</option>
				<option value="40days">40days</option>
				<option value="Berone">Berone</option>
			</select>
		</td>
	</tr>
	<tr><td>Language:</td>
		<td><select name="language" id="language1" class="ui dropdown">
			<option value="Urdu">Urdu</option>
			<option value="Telugu">Telugu</option>
			<option value="English">English</option>
			<option value="Hindi">Hindi</option>
		</select></td>
	</tr>
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
<style type="text/css">
	.green.button{
		max-width: 150px;
	}
	.microphone.icon{ float:right; }
	.speech {border: 1px solid #DDD; width: 300px; padding: 0; margin: 0}
	.speech input {border: 0; width: 240px; display: inline-block; height: 30px;}
	.speech i {float: right; width: 40px }
</style>
<script type="text/javascript">
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
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
	$('#btn_save1').click(function(){
		$('#save_icon1').addClass('sync alternate icon loading green large');
		$('#save_icon2').addClass('sync alternate icon loading green large');
	});
	$('#btn_save2').click(function(){
		$('#save_icon1').addClass('sync alternate icon loading green large');
		$('#save_icon2').addClass('sync alternate icon loading green large');
	});
</script>
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