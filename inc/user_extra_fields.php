<?php
// add_action( 'personal_options_update', 'save_extra_user_profile_fields_bfk' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields_bfk' );

function save_extra_user_profile_fields_bfk( $user_id ) {
    if(!current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta($user_id, 'extra_details', array('masjid' => $_POST["masjid"]));
    update_user_meta($user_id, 'masjids', $_POST["masjid_admin"]);
}

// add_action( 'show_user_profile', 'extra_user_profile_fields_bfk' );
add_action( 'edit_user_profile', 'extra_user_profile_fields_bfk' );

function extra_user_profile_fields_bfk( $user ) { 
    $user_id = $user->ID;
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.css" integrity="sha512-YYS7fyqDxVE/yJ1280i8KjA+nC7wAtv2u/qkulKbdMpmp8DBWX0Wj+HtILsFyvq+fouCwCyr0hasPAz1eBlvwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.css" integrity="sha512-5StPzJo8hFyTvXfJ31FMB37EXRMVeUg+J3yvUNOJcL83MEMr7VrhZSNsoL3GDmUDBGBBhoTjnJx0Ql7cH9LY7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.js" integrity="sha512-8F/2JIwyPohlMVdqCmXt6A6YQ9X7MK1jHlwBJv2YeZndPs021083S2Z/mu7WZ5g0iTlGDYqelA9gQXGh1F0tUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.min.js" integrity="sha512-MCuLP92THkMwq8xkT2cQg5YpF30l3qzJuBRf/KsbQP1czFkRYkr2dSkCHmdJETqVmvIq5Y4AOVE//Su+cH+8QA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
        <td>Masjid</td>
        <?php
        global $wpdb;
        $masjid_opts = $wpdb->get_results("SELECT id,masjid,town FROM masjid",ARRAY_A);
        $town_opts = $wpdb->get_results("SELECT id,town,district FROM town",OBJECT_K);
        $district_opts = $wpdb->get_results("SELECT id,district FROM district",OBJECT_K);
        ?>
        <td><select class="ui search dropdown" name="masjid">
                <option value="">Select</option>
                <?php
                foreach ($masjid_opts as $key) { 
                    echo '<option value="'.$key["id"].'">'.$town_opts[$key["town"]]->town.', '.$key["masjid"].'</option>';
                }
                ?>
            </select>
        </td>
        </tr>
        <tr>
        <td>Masjid Admin</td>
        <td><select class="ui search dropdown" multiple="" name="masjid_admin[]">
                <option value="">Select</option>
                <?php
                foreach ($masjid_opts as $key) { 
                    echo '<option value="'.$key["id"].'">'.$town_opts[$key["town"]]->town.', '.$key["masjid"].'</option>';
                }
                ?>
            </select>
        </td>
        </tr>
    </table>
    <?php 
    $masjid_admin = get_the_author_meta('masjids', $user->ID, true);
    foreach ($masjid_admin as $value) {
        $str .='"'.$value.'",';
    }
    $str = substr($str, 0, -1);
    ?>
    <script type="text/javascript">
        $('input').addClass('regular-text');
        $('select[name=masjid]').val('<?php echo get_the_author_meta('extra_details', $user->ID, true)["masjid"]; ?>');
        values = [<?php echo $str; ?>];
        $.each(values, function(i,e){
            $('select[name="masjid_admin[]"] option[value="'+e+'"]').prop("selected", true);
        });
        // Hide some default options //
            
            $('.user-url-wrap').hide();
            $('.user-description-wrap').hide();
            $('.user-profile-picture').hide();
            $('.user-rich-editing-wrap').hide();
            $('.user-admin-color-wrap').hide();
            $('.user-comment-shortcuts-wrap').hide();
            $('.show-admin-bar').hide();
            $('.user-language-wrap').hide();
            //*/
    </script>
    <script type="text/javascript">
        $(".ui.dropdown").dropdown();
    </script>
<?php 
}

function new_modify_user_table_bfk( $column ) {
    $column['masjid'] = 'Masjid';
    $column['masjid_admin'] = 'Masjid Admin';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table_bfk' );

function new_modify_user_table_row_bfk( $val, $column_name, $user_id ) {
    $extra = get_user_meta($user_id,'extra_details',true);
    $masjid_admin = get_user_meta($user_id,'masjids',true);
    switch ($column_name) {
        case 'masjid' :
            $masjid = '';
            if (is_array($extra)) {
                if (array_key_exists('masjid', $extra)) {
                    $id = $extra["masjid"];
                    $masjid = get_town_name(get_masjid_town($id)).', '.get_masjid_name($id);
                }
            }
            return $masjid;
        case 'masjid_admin' :
            $masjid = '';
            if (is_array($masjid_admin)) {
                foreach ($masjid_admin as $id) {
                    $masjid .= get_town_name(get_masjid_town($id)).', '.get_masjid_name($id).'<br>';
                }
            }
            return $masjid;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row_bfk', 10, 3 );