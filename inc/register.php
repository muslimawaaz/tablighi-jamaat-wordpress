<?php
$register_shortcode = 'my_new_register_form';
function registration_form_qoy(){
    ?>
    <!-- CSS and JS -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script>
    <!-- CSS and JS -->
    <?php
    $user_id = get_current_user_id();
    $logout_redirect = get_permalink();
    // print_r($_SESSION);
    if($user_id){
        echo 'You are already logged in. <a href="'.wp_logout_url( $logout_redirect ).'"><b>Logout</b></a>';
    } elseif(!$_GET["otp_sent"]) {
        ?>
        <form method="post" enctype="multipart/form-data">
        <span style="color: red"><?php echo $_SESSION["error"]; $_SESSION["error"]=''; ?></span>
        <table class="ui collapsing striped table" id="register_table">
            <tr>
                <td>Phone</td>
                <td><input type="text" name="phone">
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"> <i class="ui large eye icon slash"></i>
                    <script type="text/javascript">
                        var x = $(".eye.icon");
                        x.on("click",function(){
                            if (x.hasClass("slash")) {
                                x.removeClass("slash");
                                x.parent().children("input").attr("type","text");
                            } else {
                                x.addClass("slash");
                                x.parent().children("input").attr("type","password");
                            }
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
                    <div class="g-recaptcha" data-sitekey="6Lef6xcUAAAAANxWfqQLSQENYd8ZXDPFPBcpBfim"></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="send_otp" value="Register" class="ui blue button">
                </td>
            </tr>
        </table>
        </form>
        <?php
    } elseif($_GET["otp_sent"]){
        ?>
        <h2>Enter OTP</h2>
        <form method="post" enctype="multipart/form-data">
        <table class="ui collapsing striped table">
            <tr>
                <td>Enter OTP</td>
                <td>
                    <input type="text" name="otp" maxlength="5" onkeypress="return isNumber(event)">
                </td>
            </tr>
            <tr>
	            <td colspan="2">
	                <script src='https://www.google.com/recaptcha/api.js' async defer></script>
	                <div class="g-recaptcha" data-sitekey="6Lef6xcUAAAAANxWfqQLSQENYd8ZXDPFPBcpBfim"></div>
	            </td>
	        </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="register" value="Submit"></td>
            </tr>
        </table>
    	</form>
        <script type="text/javascript">
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
        </script>
    	<?php
    }
}
add_shortcode($register_shortcode,'registration_form_qoy');

function do_register_qoy(){
    global $wpdb;
    if(isset($_POST["g-recaptcha-response"])){
        $captcha = $_POST["g-recaptcha-response"];
        if(!$captcha){
          echo '<h2>Please check the captcha form.</h2>';
          exit;
        }
        $secretKey = "___your___API___key";
        $ip = $_SERVER['REMOTE_ADDR'];
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretKey).'&response='.urlencode($captcha);
        $response = file_get_contents($url);
        $GLOBALS["captcha_response"] = json_decode($response,true);
    }
    if (isset($_GET["otp_sent"])) {
        session_start();
        $GLOBALS["send_otp"] = $_SESSION["send_otp"];
    }
    if (isset($_POST["send_otp"])) {
        session_start();
        $_SESSION["send_otp"] = 'yes';
        $_SESSION["phone"] = $_POST["phone"];
        $_SESSION["password"] = $_POST["password"];
        ?>
        <script type="text/javascript">
            window.location.href = '<?php echo get_permalink(); ?>?otp_sent=1';
        </script>
        <?php
    } 
    if(isset($_POST["register"])){
        session_start();
    	$register_redirect = site_url();
        $data["phone"] = $_SESSION["phone"];
        $userdata["password"] = $_SESSION["password"];
        $username = $_SESSION["phone"];
        if (site_url()[4]=="s") {
            $in = 8;
        } else {
            $in = 7;
        }
        $user_email = $username.'@'.substr(site_url(), $in);
        $password = $_SESSION["password"];
        $user_id = username_exists( $username );
        if(!$GLOBALS["captcha_response"]["success"]){
            $_SESSION["error"] = 'Captcha Invalid. Please try again.';
        } else {
            if ( !$user_id  ) {
                global $wpdb;
                $phone = $_SESSION["phone"];
                $otp = $_SESSION["otp"];
                $_SESSION["tries"] = $_SESSION["tries"];
                if($_SESSION["tries"] < 5){
                    $_SESSION["tries"] = $_SESSION["tries"] + 1;
                }
                if (($otp == $_POST["otp"]) /* && ($_SESSION["tries"] < 5) */  ) {
                    $user_id = wp_create_user( $username, $password, $user_email );
                    $non_meta = array("username","email","user_email","useremail", 
                                        "password", "pwd", "pass_word", "display_name");
                    wp_update_user($userdata);
                    foreach ($data as $key => $value) {
                        if(!in_array($key,$non_meta)){
                            update_user_meta($user_id, $key, $value);
                        }
                    }
                    $creds = array();
                    $creds['user_login'] = $username;
                    $creds['user_password'] = $password;
                    $creds['remember'] = true;
                    $user = wp_signon( $creds, false );
                    get_currentuserinfo();
                    if ( wp_redirect( $register_redirect ) ) {
                        exit;
                    }
                } else {
                    $_SESSION["error"] = 'OTP is wrong.';
                }
            } else {
                $_SESSION["error"] = 'User already exists.';
            }
        }
        ?>
        <script type="text/javascript">
            window.location.href = '<?php echo get_permalink(); ?>?otp_sent=1';
        </script>
        <?php
    }
    if($_GET["otp_sent"] && $_SESSION["send_otp"]=='yes'){
        $ran_no = rand(11111,99999);
        $num = $_SESSION["phone"];
        $otp_time = strtotime(date("Y-m-d h:i:sa"));
        $curl = curl_init();
        $url = 'https://www.fast2sms.com/dev/bulk?authorization=___your___API___key&sender_id=FSTSMS&language=english&route=qt&numbers='.$num.'&message=28047&variables='.urlencode('{AA}').'&variables_values='.$ran_no;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
        ));

        echo $ran_no;
        // $sms_response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode('{"return":true,"request_id":"i0c7uml91ytrxnd","message":["Message sent successfully"]}');
        if($res->return){
            $_SESSION["otp"] = $ran_no;
            $_SESSION["send_otp"] = '';
            // echo 'OTP sent successfully.';
        }
    }
}
add_action( 'init', 'do_register_qoy' );
