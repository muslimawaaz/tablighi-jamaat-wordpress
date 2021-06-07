<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.js"></script>

<?php
if(is_admin()) {
    echo '<div style="padding-top: 20px; padding-right: 20px">';
}
$table_name = 'country';
global $wpdb;
if (isset($_FILES["import"])) {
    if (pathinfo($_FILES["import"]["name"],PATHINFO_EXTENSION)==="csv") {
        $targetPath = dirname(__FILE__)."/" .rand(11,99). $_FILES["import"]["name"];
        move_uploaded_file($_FILES["import"]["tmp_name"], $targetPath);
        $handle = fopen($targetPath, "r");
        $imported = 0; $failed = 0;
        while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if (!$col) {
                for ($i=0; $i < count($filesop); $i++) { 
                    $col[$i] = $filesop[$i];
                }
            } else {
                for ($i=0; $i < count($filesop); $i++) { 
                    $data[$col[$i]] = sanitize_text_field($filesop[$i]); 
                }
                $wpdb->insert($table_name,$data);
                if ($wpdb->insert_id) {
                    $imported++;
                } else {
                    $failed++;
                }
            }
        }
        echo $imported." rows imported. ".$failed." rows failed.";
        fclose($handle);
        unlink($targetPath);
        if (function_exists("redirect_to_same")) {
            redirect_to_same();
        }
    } else {
        $message = "Invalid File Type. Upload Excel File.";
        echo $message;
    }
}
if($_POST["action"]){
    $data["country"] = $_POST["country"];
    if($_POST["action"]=='Add'){
        $wpdb->insert($table_name,$data);
        if(function_exists("redirect_to_same")){
            redirect_to_same();
        }
    } else if($_POST["action"]=='Add New' || $_POST["action"]=='Edit'){
    ?>
    <?php
    $columns = rawurlencode('"country"');
    ?>
    <h2>Import from CSV (excel)</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="import">
        <input type="submit" name="import_csv" value="Import (csv)" class="ui grey button">
        <a href="data:text/plain;charset=UTF-8,<?php echo $columns; ?>" download="filename.csv">Download Sample CSV</a>
    </form>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        <h2 id="small_frm">Add New Here</h2>
        <input type="hidden" name="id">
        <table class="ui blue striped table collapsing">
        <tr>
            <td>Country</td>
            <td><input type="text" name="country" >
            </td>
        </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="action" value="Add" class="ui blue button"></td>
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
        $('input[name=country]').val('<?php echo $data["country"]; ?>');
    </script>
        <?php
    }
    if($_POST["action"]=='Save'){
        $id = $_POST["id"];
        $wpdb->update($table_name,$data,array('id' => $id));
        if(function_exists("redirect_to_same")){
            redirect_to_same();
        }
    }
    if($_POST["action"]=='Delete'){
        $id = $_POST["id"];
        $wpdb->delete($table_name,array('id' => $id));
        if(function_exists("redirect_to_same")){
            redirect_to_same();
        }
    }
} 
if(($_POST["action"]!='Edit') && $_POST["action"]!='Add New') {
    ?>
    <form method="POST"><input type="submit" name="action" value="Add New" class="ui green button"></form><br>
    <div style="overflow-x:auto">
    <table id="myTable" class="ui unstackable celled table dataTable">
        <thead>
            <tr>
                <th>Country</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
            foreach($rows as $row){
                echo '<tr row-id="'.$row->id.'">';
                echo '<td>'.$row->country.'</td>';
            ?>
            <td>
                <form method="post">
                <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                <input type="submit" name="action" class="ui blue button" value="Edit">
                <input type="submit" name="action" class="ui red button" value="Delete">
                </form>
            </td>
            <?php
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#myTable").DataTable( {
            dom: "Blfrtip",
            buttons: [
                "csv", "excel", "pdf", "print"
            ],
             "pageLength": 50
        } );
    } );
    </script>
    <?php
}
if(is_admin()) {
    echo '</div>';
}