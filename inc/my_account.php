<?php
$user_id = get_current_user_id();
if (!$user_id) {
	echo do_shortcode('[firebase_otp_login]');
} else {
	?>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script>
	<?php
	global $wpdb;
	$meta = get_user_meta($user_id);
	$userdata = get_userdata($user_id);
	if (!$meta["person"][0]) {
		// search for number in database
		$phone = $userdata->user_login;
		$rows = $wpdb->get_results("SELECT * FROM person where phone='$phone' OR phone2='$phone'");
		print_r($rows);
	} else {
		$masjid = $wpdb->get_row("SELECT masjid from person where id=$person");
		if ($masjid) {
			echo 'MASJID ID: '.$masjid;
		} else {
			?>
			<form method="POST">
				<table>
					<tr>
						<td>Select Masjid</td>
						<td>
							<select name="masjid">
								<option value="masjid_id">Masjid</option>
								<option value="masjid_id">Masjid</option>
							</select>
						</td>
					</tr>
				</table>
			</form>
			<a href="/add-masjid" class="button">ADD NEW MASJID</a>
			<?php
			if ($_POST["masjid"]) {
				$wpdb->update('person',array('masjid'=>$masjid),array('id'=>$person));
				redirect_to_same();
			}
		}
	}
if (!$meta["masjid"][0]) {
	if(isset($_POST["submit1"])){
	    $data["pincode"] = $_POST["pincode"];
	    foreach ($data as $key => $value) {
	        update_user_meta($user_id, $key, $value);
	    }
	    ?>
	    <script type="text/javascript">
	        window.location.href = "<?php echo get_permalink(); ?>";
	    </script>
	    <?php
	}
	$data["pincode"] = $meta["pincode"][0];
	?>
	<form method="post" enctype="multipart/form-data">
	    <table class="ui collapsing striped table">
	        <tr>
	            <td>Pincode</td>
	            <td><input type="text" name="pincode">
	            </td>
	        </tr>
	        <tr>
	            <td></td>
	            <td><input type="submit" name="submit1" value="Save" class="ui blue mini button"></td>
	        </tr>
	    </table>
	</form>
    <script type="text/javascript">
        $('input[name=pincode]').val('<?php echo $data["pincode"]; ?>');
    </script>
	<?php
	if ($meta["pincode"][0]) {
		$pincode = $meta["pincode"][0];
		if(isset($_POST["submit2"])){
		    $data["town"] = $_POST["town"];
		    foreach ($data as $key => $value) {
		        update_user_meta($user_id, $key, $value);
		    }
		    ?>
		    <script type="text/javascript">
		        window.location.href = "<?php echo get_permalink(); ?>";
		    </script>
		    <?php
		}
		$data["town"] = $meta["town"][0];
		?>
		<hr>
		<form method="post" enctype="multipart/form-data">
		    <table class="ui collapsing striped table">
		        <tr><td>Town</td>
		        <?php
		        global $wpdb;
		        $town_opts = $wpdb->get_results("SELECT id,town FROM pincode WHERE pincode = $pincode",ARRAY_A);
		        ?>
		        <td><select class="ui search dropdown" name="town">
		                <option value="">Select</option>
		        <?php
		        foreach ($town_opts as $key) { 
		            echo '<option value="'.$key["id"].'">'.$key["town"].'</option>';
		        }
		        ?>
		            </select>
		            <script type="text/javascript">
		                $(".ui.dropdown").dropdown();
		            </script>
		        </td>
		        </tr>
		        <tr>
		            <td></td>
		            <td><input type="submit" name="submit2" value="Save" class="ui blue mini button"></td>
		        </tr>
		    </table>
		</form>
		<script type="text/javascript">
	        $('select[name=town]').val('<?php echo $data["town"]; ?>');
	        x = $('select[name=town]').children('option[value="<?php echo $data["town"]; ?>"]').text();
	        $("select[name=user]").parent().children(".text").html(x);
	        y = $('select[name=town]').parent().children(".text");
	        y.html(x);
	        y.css("color","black");
	    </script>
		<?php
	}
	if ($meta["town"][0]) {
	    if(isset($_POST["submit3"])){
		    $data["masjid"] = $_POST["masjid"];
		    $admin_made = $wpdb->update('masjid',
		    	array('admin'=>$user_id),
		    	array('admin'=>NULL,'id'=>$data["masjid"])
		    );
		    if ($admin_made) {
		    	$data["masjid_admin"] = $_POST["masjid"];
		    }
		    foreach ($data as $key => $value) {
		        update_user_meta($user_id, $key, $value);
		    }
		    ?>
		    <script type="text/javascript">
		        window.location.href = "<?php echo get_permalink(); ?>";
		    </script>
		    <?php
		}
	    if ($_POST["action"]=='Add') {
        	$row["masjid"] = $_POST["masjid"];
        	$row["town"] = $meta["town"][0];
    		$result = $wpdb->insert('masjid',$row);
    		if ($result==1) {
    			$_SESSION["message"] = "Masjid added successfully";
    		} else {
    			$_SESSION["message"] = "Error occured while adding Masjid";
    		}
    		?>
		    <script type="text/javascript">
		        window.location.href = "<?php echo get_permalink(); ?>";
		    </script>
		    <?php
	    }
		if ($_SESSION["message"]) {
			echo '<h2 style="color:green">'.$_SESSION["message"].'</h2>';
			if (!$_POST["action"]=='Add') {
				$_SESSION["message"] = '';
			}
		}
		$data["masjid"] = $meta["masjid"][0];
		?><hr>
		Masjid cannot be changed after saved.
		<form method="post" enctype="multipart/form-data">
		    <table class="ui collapsing striped table">
		        <tr><td>Select Masjid</td>
		        <?php
		        $town = $meta["town"][0];
		        $masjid_opts = $wpdb->get_results("SELECT id,masjid FROM masjid where town=$town",ARRAY_A);
		        ?>
		        <td><select class="ui search dropdown" name="masjid">
		                <option value="">Select</option>
				        <?php
				        foreach ($masjid_opts as $key) { 
				            echo '<option value="'.$key["id"].'">'.$key["masjid"].'</option>';
				        }
				        ?>
		            </select>
		            <script type="text/javascript">
		                $(".ui.dropdown").dropdown();
		            </script>
		        </td>
		        </tr>
		        <tr>
		            <td></td>
		            <td><input type="submit" name="submit3" value="Save" class="ui blue mini button"></td>
		        </tr>
		    </table>
		</form>
	    <script type="text/javascript">
	        $('select[name=masjid]').val('<?php echo $data["masjid"]; ?>');
	        x = $('select[name=masjid]').children('option[value="<?php echo $data["masjid"]; ?>"]').text();
	        $("select[name=user]").parent().children(".text").html(x);
	        y = $('select[name=masjid]').parent().children(".text");
	        y.html(x);
	        y.css("color","black");
	    </script>
	    <hr>
	    <i>Cannot find your masjid in the above list:</i>
	    <form method="POST" enctype="multipart/form-data">
	    <table class="ui blue striped table collapsing">
	        <tr>
	            <td>Add New Masjid</td>
	            <td><input type="text" name="masjid"></td>
	        </tr>
            <tr row-id="">
                <td></td>
                <td><input type="submit" name="action" value="Add" class="ui green mini button"></td>
            </tr>
        </table>
        </form>
		<?php
	}
} else {
	$masjid_id = $meta["masjid"][0];
	$masjid = $wpdb->get_row("SELECT id,masjid FROM masjid where id=$masjid_id");
	echo "You have selected masjid !!!";
	echo '<br>Masjid ID: '.$masjid->id;
	echo '<br>Masjid Name: <ins>'.$masjid->masjid.'</ins>';
}
}