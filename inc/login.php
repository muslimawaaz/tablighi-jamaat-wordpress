<?php
$login_shortcode = 'my_new_login_form';
function login_form_qwh(){
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/table.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <?php
    $user_id = get_current_user_id();
    $logout_redirect = get_permalink();
    if($user_id){
        echo 'You are already logged in. <a href="'.wp_logout_url( $logout_redirect ).'"><b>Logout</b></a>';
    } else {
        ?>
        <form method="post" enctype="multipart/form-data">
        <span id="login_error"></span>
        <table class="ui collapsing striped table">
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
                <td></td>
                <td><input type="submit" name="login" value="Login" class="ui blue mini button"></td>
            </tr>
        </table>
        </form>
        <?php
    }
}
add_shortcode($login_shortcode,'login_form_qwh');

function do_login_qwh(){
    if(isset($_POST["login"])){
        $login_redirect = site_url();
        $captcha_response["success"] = true;
        
    $data["phone"] = $_POST["phone"];
    $userdata["password"] = $_POST["password"];
        $username = $_POST["phone"];
        if (site_url()[4]=="s") {
            $in = 8;
        } else {
            $in = 7;
        }
        $user_email = $username.'@'.substr(site_url(), $in);
        $password = $_POST["password"];
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = true;
        if(!$captcha_response["success"]){
            function invalid_captcha_qwh(){
                ?>
                <script type="text/javascript">
                window.onload = function() {
                    login_error = document.getElementById('login_error');
                    login_error.innerHTML = '<span style="color:red">Captcha Invalid. Please try again.</span>';
                };
                </script>
                <?php
            }
            add_action('wp_footer','invalid_captcha_qwh');
        } else {
            $user = wp_signon( $creds, false );
            get_currentuserinfo();
            if ( is_wp_error($user) ){
                $GLOBALS["login_error"] = $user->get_error_message();
                function my_login_error_qwh(){
                    ?>
                    <script type="text/javascript">
                    window.onload = function() {
                        login_error = document.getElementById('login_error');
                        login_error.innerHTML = '<span style="color:red"><?php echo $GLOBALS["login_error"]; ?></span>';
                    };
                    </script>
                    <?php
                }
                add_action('wp_footer','my_login_error_qwh');
            } else {
                if ( wp_redirect( $login_redirect ) ) {
                    exit;
                }
            }
        }
    }
}
add_action( 'init', 'do_login_qwh' );