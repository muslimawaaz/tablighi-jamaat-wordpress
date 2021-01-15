<?php
// add_action( 'personal_options_update', 'save_extra_user_profile_fields_bfk' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields_bfk' );

function save_extra_user_profile_fields_bfk( $user_id ) {
    if(!current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta($user_id, 'masjid', $_POST["masjid"]);
}

// add_action( 'show_user_profile', 'extra_user_profile_fields_bfk' );
add_action( 'edit_user_profile', 'extra_user_profile_fields_bfk' );

function extra_user_profile_fields_bfk( $user ) { 
    $user_id = $user->ID;
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
        <td>Masjid</td>
        <?php
        global $wpdb;
        $masjid_opts = $wpdb->get_results("SELECT id,masjid FROM masjid",ARRAY_A);
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
    </table>
    <script type="text/javascript">
        $('input').addClass('regular-text');
        $('select[name=masjid]').val('<?php echo get_the_author_meta('masjid', $user->ID); ?>');
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
<?php 
}

function new_modify_user_table_bfk( $column ) {
    $column['masjid'] = 'Masjid';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table_bfk' );

function new_modify_user_table_row_bfk( $val, $column_name, $user_id ) {
    $meta = get_user_meta($user_id);
    switch ($column_name) {
        case 'masjid' :
            $masjid = $meta['masjid'][0];
            return $masjid;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row_bfk', 10, 3 );