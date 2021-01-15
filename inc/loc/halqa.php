<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script><link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.js"></script>
<?php
if(is_admin()) {
    echo '<div style="padding-top: 20px; padding-right: 20px">';
}
$table_name = 'halqa';
global $wpdb;
if($_POST["action"]){
    $data["halqa"] = $_POST["halqa"];
    $data["town"] = $_POST["town"];
    if($_POST["action"]=='Add'){
        $wpdb->insert($table_name,$data);
    } else if($_POST["action"]=='Add New' || $_POST["action"]=='Edit'){
    ?>
    <form method="POST" enctype="multipart/form-data">
        <h2 id="small_frm">Add New Here</h2>
        <input type="hidden" name="id">
        <table class="ui blue striped table collapsing">
        <tr>
            <td>Halqa</td>
            <td><input type="text" name="halqa">
            </td>
        </tr>
        <tr><?php
                    $country_opts = $wpdb->get_results("SELECT id,country FROM country");
                    ?>
                <td>Country</td>
                <td><select name="country">
                                <option value="">Select</option>
                        <?php
                        foreach ($country_opts as $key) { 
                            echo '<option value="'.$key->id.'" >'.$key->country.'</option>';
                        }
                        ?>
                    </select>
                    <script type="text/javascript">
                        $('select[name=country]').on('change',function(){
                            var x = $('select[name=country]').val();
                            $('select[name=state] option').hide();
                            $('select[name=state] option.prnt_'+x).show();
                        });
                    </script>
                </td>
            </tr>
            <tr><?php
                    $state_opts = $wpdb->get_results("SELECT id,state,country FROM state");
                    ?>
                <td>State</td>
                <td><select name="state">
                                <option value="">Select</option>
                        <?php
                        foreach ($state_opts as $key) { 
                            echo '<option value="'.$key->id.'" class="prnt_'.$key->country.'">'.$key->state.'</option>';
                        }
                        ?>
                    </select>
                    <script type="text/javascript">
                        $('select[name=state]').on('change',function(){
                            var x = $('select[name=state]').val();
                            $('select[name=district] option').hide();
                            $('select[name=district] option.prnt_'+x).show();
                        });
                    </script>
                </td>
            </tr>
            <tr><?php
                    $district_opts = $wpdb->get_results("SELECT id,district,state FROM district");
                    ?>
                <td>District</td>
                <td><select name="district">
                                <option value="">Select</option>
                        <?php
                        foreach ($district_opts as $key) { 
                            echo '<option value="'.$key->id.'" class="prnt_'.$key->state.'">'.$key->district.'</option>';
                        }
                        ?>
                    </select>
                    <script type="text/javascript">
                        $('select[name=district]').on('change',function(){
                            var x = $('select[name=district]').val();
                            $('select[name=town] option').hide();
                            $('select[name=town] option.prnt_'+x).show();
                        });
                    </script>
                </td>
            </tr>
            <tr><?php
                    $town_opts = $wpdb->get_results("SELECT id,town,district FROM town");
                    ?>
                <td>Town</td>
                <td><select name="town">
                                <option value="">Select</option>
                        <?php
                        foreach ($town_opts as $key) { 
                            echo '<option value="'.$key->id.'" class="prnt_'.$key->district.'">'.$key->town.'</option>';
                        }
                        ?>
                    </select>
                </td>
        </tr>
            <tr row-id="">
                <td></td>
                <td><input type="submit" name="action" value="Add" class="ui blue mini button"></td>
            </tr>
        </table>
        </form>
        <style type="text/css">
            .ui.dropdown{
                width: 100% !important;
            }
        </style>
        <?php
    }
    if($_POST["action"]=='Edit'){
        $id = $_POST["id"];
        $row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id",ARRAY_A);
        $data = $row;
        ?>
        <script type="text/javascript">
            $('input[name=action]').val('Save');
            $('input[name=id]').val('<?php echo $_POST["id"]; ?>');
            $('#small_frm').html('Edit Here');
        </script>
    <script type="text/javascript">
        $('input[name=halqa]').val('<?php echo $data["halqa"]; ?>');
        <?php $town = $data["town"]; ?>
        $('select[name=town]').val('<?php echo $town; ?>');
        <?php
        $district = $wpdb->get_var("SELECT district FROM town WHERE id = $town");
        $state = $wpdb->get_var("SELECT state FROM district WHERE id = $district");
        $country = $wpdb->get_var("SELECT country FROM state WHERE id = $state");
        ?>
        $('select[name=district]').val('<?php echo $district; ?>');
        $('select[name=state]').val('<?php echo $state; ?>');
        $('select[name=country]').val('<?php echo $country; ?>');
    </script>
        <?php
    }
    if($_POST["action"]=='Save'){
        $id = $_POST["id"];
        $wpdb->update($table_name,$data,array('id' => $id));
    }
    if($_POST["action"]=='Delete'){
        $id = $_POST["id"];
        $wpdb->delete($table_name,array('id' => $id));
    }
} 
if(($_POST["action"]!='Edit') && $_POST["action"]!='Add New') {
    ?>
    <form method="POST"><input type="submit" name="action" value="Add New" class="ui green mini button"></form><br>
    <div style="overflow-x:auto">
    <table id="myTable" class="ui unstackable celled table dataTable">
        <thead>
            <tr>
                <th>Halqa</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
            $town_opts = $wpdb->get_results("SELECT id,town FROM town",OBJECT_K);
            foreach($rows as $row){
                echo '<tr>';
                echo '<td>'.$row->halqa.'</td>';
                echo '<td>'.$town_opts[$row->town]->town.'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    </div>
    <form method="post" id="action_form">
        <input type="hidden" name="id">
        <input type="hidden" name="action">
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $("td:last-child").append('<br><i class="trash alternate red icon" onclick="delete_now(this)"></i> <i class="edit blue icon" onclick="edit_now(this)"></i>');
        });
        function edit_now(x){
            var id = $(x).parent().parent().attr("row-id");
            var frm = $("#action_form")
            frm.children("input[name=id]").val(id);
            frm.children("input[name=action]").val("Edit");
            frm.submit();
        }
        function delete_now(x){
            var id = $(x).parent().parent().attr("row-id");
            var frm = $("#action_form")
            frm.children("input[name=id]").val(id);
            frm.children("input[name=action]").val("Delete");
            if (confirm("Do you want to delete?")) {
            frm.submit();
            }
        }
    </script>
    <style type="text/css">
        .edit.icon, .trash.icon{
            float: right !important;
            font-size: 150%;
            cursor: pointer;
            padding-top: 2px;
        }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#myTable").DataTable( {
            dom: "Blfrtip",
            buttons: [
                "csv", "excel", "pdf", "print"
            ]
        } );
    } );
    </script>
    <?php
}
if(is_admin()) {
    echo '</div>';
}
