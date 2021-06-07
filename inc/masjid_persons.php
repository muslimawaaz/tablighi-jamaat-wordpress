<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.min.css" integrity="sha512-OD0ScwZAE5PCg4nATXnm8pdWi0Uk0Pp2XFsFz1xbZ7xcXvapzjvcxxHPeTZKfMjvlwwl4sGOvgJghWF2GRZZDw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css" integrity="sha512-8Tb+T7SKUFQWOPIQCaLDWWe1K/SY8hvHl7brOH8Nz5z1VT8fnf8B+9neoUzmFY3OzkWMMs3OjrwZALgB1oXFBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/table.min.css" integrity="sha512-NtvxKmBWfr6sEZ3y/qV4DTXPEXpP/VZZV5BEaCFxUukf7/cyktgYpfsxs2ERvisbDXfnLJfswd2DYEj0h+qAFA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<link href="https://fonts.googleapis.com/css?family=Mandali|Suranna&display=swap" rel="stylesheet">
<style type="text/css">
  input[type=number]{      width: 90px; height: 30px; padding: 5px;    }
  .kids     {    text-decoration: overline;    }
  .teens    {    text-decoration: underline;     }
  .work-name{    visibility:hidden; font-size:1px;    }
  button.ui {    height: 35px;  }
  form      {    display:inline;  }
  .person{   color:blue; cursor:pointer;  }
  .waqBerone{
    background-color:#c4cfff;
  }
  .waq4months{
    background-color:#a4ff8e;
  }
  .waq40days{
    background-color:#8effef;
  }
  .waq3days{
    background-color:#ffdb8e;
  }
</style>
<meta name="viewport" content="width=1024, initial-scale=1.0">
<?php 
global $wpdb;
if(is_user_logged_in()){
$user_id = get_current_user_id();
$masjid_id = get_user_meta($user_id, 'extra_details', true)["masjid"];

$places = $wpdb->get_results("SELECT * FROM place WHERE masjid = $masjid_id ORDER BY place ASC");
if (!$places) {
  ?>
  <h1>Places / Areas / Galli / Street</h1>
  <p>A place / street can have 25 to 50 houses. First divide the masjid area into some places. You can have about 20 places. Places can be named after person name or any landmark in that place.</p>
  <p>Examples:</p>
  <ol>
    <li>Abdulla bhai galli</li>
    <li>Vali bhai galli</li>
    <li>Bazar area</li>
    <li>Masjid ki galli</li>
    <li>Masjid ke piche galli</li>
    <li>Main road area</li>
  </ol>
  <p>In this way you can give names to places. After places added. You can add persons.</p>
  <a href="<?php echo site_url(); ?>/place-list/" class="ui green button">Add Place / Galli</a>
  <?php
  exit;
}
$persons = $wpdb->get_var("SELECT COUNT(id) from person where masjid=$masjid_id");
$place_opts = $wpdb->get_results("SELECT id,place FROM place WHERE masjid = $masjid_id",OBJECT_K);
$t_place_opts = $wpdb->get_results("SELECT id,t_place FROM place WHERE masjid = $masjid_id",OBJECT_K);

$place_id = $_GET["place_id"];
$tel = $_GET["telugu"];
if($masjid_id){
  $caps = 'view_edit';
}

if(($masjid_id)){
  if ($tel) {
    $masjid_name = get_t_masjid_name($masjid_id);
    $place = $t_place_opts[$_GET["place_id"]]->t_place;
  } else {
    $masjid_name = get_masjid_name($masjid_id);
    $place = $place_opts[$_GET["place_id"]]->place;
  }
?>
<!--<button id="charts_btn" class="ui red button"><i class="chart bar icon"></i>Chart</button>-->
<div id="nums_div" style="display: none; padding: 10px;">
<?php 
if($_GET["place_id"]){
  $place_id = $_GET["place_id"];
  $sql = "SELECT COUNT(id) FROM person WHERE place = $place_id ";
} else {
  $sql = "SELECT COUNT(id) FROM person WHERE masjid = $masjid_id ";
}
if ($tel) {
  $link_tel = '&telugu=1';
}
if ($place_id) {
  $link_pl = '?&place_id='.$place_id;
}
if ($_GET["full_list"]) {
  $link_full = '&full_list=1';
}
include (dirname(__FILE__).'/numbers.php'); ?>
</div>
<form method="GET">
  <?php
  if ($tel) {
    echo '<input type="hidden" name="telugu" value="1">';
    echo 'వీధి :- 
    <select name="place_id" id="place_id" class="ui dropdown">';
      foreach ($places as $place) {
        echo '<option value="'.$place->id.'">'.$place->t_place.'</option>';
      }
    echo '</select>';
  } else {
    echo 'Place :- <select name="place_id" id="place_id" class="ui dropdown">';
        foreach ($places as $place) {
          echo '<option value="'.$place->id.'">'.$place->place.'</option>';
        }
    echo '</select>';
  }
  ?>
  
  <script type="text/javascript">
    $("#place_id").val('<?php echo $_GET["place_id"]; ?>');
  </script>
  <button onclick="search();" class="ui blue button"><i class="search icon"></i></button>
</form>
<!--
  <button onclick="filter()"  class="ui purple button"><i class="filter icon"></i>Filters</button>
  <span id="filter_btns" style="display:none">
  <button onclick="students();" class="ui button" id="stu_btn">
    <i class="user pink icon"></i>Students
  </button>
  <button onclick="teachers();" class="ui button" id="tch_btn">
    <i class="book pink icon"></i>Teachers
  </button>
  </span>
  -->
<button class="ui blue button" id="nums_btn"><i class="server icon"></i><span id="btn_numbers">Numbers</span></button>
<script type="text/javascript">
  $('#nums_btn').on('click',function(){
    $('#nums_div').toggle();
  });
</script>
<?php
echo '<a id="a_full" href="?full_list=1'.$link_tel.'"><button class="ui red button">Full List</button></a>';
if ($tel) {
  echo '<a href="'.get_permalink().$link_pl.$link_full.'"><button class="ui violet button">English</button></a>';
} else {
  echo '<a href="'.get_permalink().'?telugu=1'.$link_pl.$link_full.'"><button class="ui violet button">తెలుగు</button></a>';
}
?>
<button class="ui grey button" id="btn_print">Print</button>
<script type="text/javascript">
  $('#tophead').show();
  $('#btn_print').on('click',function(){
    $('#tophead').hide();
    $('#btns_waqth').hide();
    $('#btns_juma').hide();
    $('#primary').css('width','90%');
    window.print();
  });
</script>
<div style="padding-top: 10px" id="btns_waqth"><span>Waqth</span> : - 
  <button onclick="waqth_filter('Berone')" class="ui violet button">Berone</button>
  <button onclick="waqth_filter('4months')" class="ui green button">4 Months</button>
  <button onclick="waqth_filter('40days')" class="ui blue button">40days</button>
  <button onclick="waqth_filter('3days')" class="ui orange button">3days</button>
  <button onclick="waqth_filter('all')" class="ui pink button">All</button>
  <button onclick="waqth_filter('--')" class="ui button">None</button>
</div>
<div style="padding-top: 10px" id="btns_juma"><span>Juma</span> : - 
  <button onclick="juma_filter('1')" class="ui button">1</button>
  <button onclick="juma_filter('2')" class="ui button">2</button>
  <button onclick="juma_filter('3')" class="ui button">3</button>
  <button onclick="juma_filter('4')" class="ui button">4</button>
  <button onclick="juma_filter('5')" class="ui button">5</button>
  <button onclick="waqth_filter('all')" class="ui pink button">All</button>
  <button onclick="juma_filter('')" class="ui button">None</button>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.js"></script>
<table clas="ui very compact sortable table green" id="main_table">
  <thead>
    <tr id="hrow">
          <th style="width: 25px;"></th>
          <th>Name</th>
          <th>Tashkeel Details</th>
          <th style="width: 80px;">Juma</th>
          <th style="width: 50px;">Waqth</th>
          <th style="width: 50px;">Masturath</th>
          <th style="width: 150px;">Place</th>
          <!--
            <th style="width: 30px;">Map</th>
            <th>Age</th>
            <th><i class="handshake outline icon"></i></th>-->
    </tr>
  </thead>
<?php
if(!$place_id){
  $n_stu = $wpdb->get_var("SELECT COUNT(id) FROM person WHERE masjid = $masjid_id AND work = 1");
  $n_tch = $wpdb->get_var("SELECT COUNT(id) FROM person WHERE masjid = $masjid_id AND work = 2");
  $rows = $wpdb->get_results("SELECT * FROM person 
        WHERE masjid = $masjid_id 
        ORDER BY tashkeel_date DESC
        LIMIT 100");
  // $wpdb->show_errors(); $wpdb->print_error();
}
if(isset($_GET["place_id"])){
  $place_id = $_GET["place_id"];
  $rows = $wpdb->get_results("SELECT * FROM person WHERE place = $place_id ORDER BY tashkeel_date DESC");
  $n_stu = $wpdb->get_var("SELECT COUNT(id) FROM person WHERE place = $place_id AND work = 1");
  $n_tch = $wpdb->get_var("SELECT COUNT(id) FROM person WHERE place = $place_id AND work = 2");
  $dif_place = '&place_id='.$place_id;
} else if (isset($_GET["full_list"])){
  $rows = $wpdb->get_results("SELECT * FROM person 
        WHERE masjid = $masjid_id 
        ORDER BY tashkeel_date DESC");
}
?>
<script type="text/javascript">
  $('#stu_btn').append(' - <?php echo $n_stu; ?>');
  $('#tch_btn').append(' - <?php echo $n_tch; ?>'); 
</script>
 <?php
  foreach ($rows as $row) {
    echo '<tr class="rows work'.$row->work.' waq'.$row->waqth.' qaq'.$row->qwaqth.' all juma'.$row->juma[5].'">';
    $from = new DateTime( $row->dob );
    $to   = new DateTime('today');
    $ag   = $from->diff($to)->y;
    if($ag > 100){
      $age = '';
    } elseif($ag < 10) { $age = '0'.$ag; 
    } else { $age = $ag; }
  echo '<td title="'.$row->id.'">'.++$i.'</td>';
  /*
  echo '<td>';
  if(($row->latitude) && ($row->longitude)){
    $arr = get_masjid_loc( $masjid_id );
    echo '<span class="work-name">'.($row->latitude+$row->longitude).'</span>';
    echo '<a href="https://www.google.com/maps/dir/'.$arr[0].','.$arr[1].'/'.
          $row->latitude.','.$row->longitude.'/" target="_blank" style="color:#e03997">
              <i class="external alternate icon large"></i></a>';
  }
  echo '</td>';
  */
  echo '<td>';
  echo '<b><span id="person'.$row->id.'">';
if ($row->added_by==$user_id) {
  echo '<a href="'.site_url().'/person-edit/?id='.$row->id. $dif_place .'">';
}
  if ($tel && $row->t_name) {
    echo $row->t_name;
  } else {
    echo $row->person;
  }
  if ($row->added_by==$user_id) {
    echo '</a>';
  }
  echo '</span></b>';
    
  if($row->identifier){
    echo '<br><i class="info circle green icon"></i> <span id="identifier_name'.$row->id.'">';
    if ($tel && $row->t_identifier) {
      echo $row->t_identifier; 
    } else {
      echo $row->identifier;
    }
    echo '</span>';
  }
  if($row->phone){ echo '<br><a href="tel:'.$row->phone.'"><i class="phone horizontally flipped green icon"></i> <b>'.$row->phone.'</a></b>'; }
  if(strlen($row->father) > 5){ 
    echo '<br>';
    if ($tel && $row->t_father) {
      echo 'తండ్రి: '.$row->t_father; 
    } else {
      echo 'S/o: '.$row->father;
    }
  }
  if((strlen($row->father) < 5) && ($row->father)){ 
    echo '<br>S/o: '.get_person($row->father); 
  }

  echo '</td>
        <td>';
  if($row->admin==$user_id){
    echo ' <i class="edit red icon" id="tashkeel_d_edit'.$row->id.'" 
                    onclick="tashkeel_d_edit('.$row->id.')" ></i> 
    <i class="checkmark green large icon" id="tashkeel_d_save'.$row->id.'" 
          onclick="tashkeel_d_save('.$row->id.')" style="display:none"></i>';
  }
  echo '<span id="tashkeel_d_name'.$row->id.'">';
  if($row->tashkeel_date != '0000-00-00'){ 
    echo $row->tashkeel_date; 
  }
  echo '</span>';

  if($row->admin==$user_id){
  echo ' <br><i class="edit red icon" id="tashkeel_j_edit'.$row->id.'" 
            onclick="tashkeel_j_edit('.$row->id.')"></i> 
        <i class="checkmark green large icon" id="tashkeel_j_save'.$row->id.'" 
            onclick="tashkeel_j_save('.$row->id.')" style="display:none"></i>';
  }
  echo '<br><span id="tashkeel_j_name'.$row->id.'" class="tsk'.$row->tashkeel_jamath.'">'.$row->tashkeel_jamath.'</span>';
  if($row->admin==$user_id && 0){
    echo '<br><i class="edit red icon" id="response_edit'.$row->id.'" 
              onclick="response_edit('.$row->id.')"></i> 
          <i class="checkmark green large icon" id="response_save'.$row->id.'" 
              onclick="response_save('.$row->id.')" style="display:none"></i>';
    }
    echo '<br>';
    echo ' <i class="edit red icon" id="response_edit'.$row->id.'" onclick="response_edit('.$row->id.')"></i> 
              <i class="checkmark green icon" id="response_save'.$row->id.'" 
        onclick="response_save('.$row->id.')" style="display:none"></i>';
    echo '<span id="response_name'.$row->id.'">'.$row->response.'</span></td>
    <td>'.$row->juma.'</td>
    <td>'.$row->waqth.'</td>
    <td>'.$row->qwaqth.'</td>
    <td>';
    if ($tel) {
      echo $t_place_opts[$row->place]->t_place;
    } else {
      echo $place_opts[$row->place]->place;
    }
    echo '</td>';
    echo '</tr>';
  }
?>
</table>
<script type="text/javascript">
  $(document).ready(function() {
      $("#main_table").DataTable( {
          dom: "lfrtip",
           "pageLength": 100
      } );
  } );
  </script>
<?php
if ($tel) {
  ?>
  <script type="text/javascript">
    $('#btn_addperson').html('వ్యక్తిని జోడించు');
    $('#btn_places').html('వీధులు');
    $('#btn_numbers').html('సంఖ్యలు');
    $('#btn_logout').html('లాగౌట్');
    $('#a_full button').html('పూర్తి జాబితా');
    $('div#btns_waqth span').html('సమయం');
    $('div#btns_waqth button:nth-child(2)').html('బేరూన్');
    $('div#btns_waqth button:nth-child(3)').html('4నెలలు');
    $('div#btns_waqth button:nth-child(4)').html('40రోజులు');
    $('div#btns_waqth button:nth-child(5)').html('3రోజులు');
    $('div#btns_waqth button:nth-child(6)').html('అన్నీ');
    $('div#btns_waqth button:nth-child(7)').html('ఇతరులు');

    $('div#btns_juma span').html('జుమా');
    $('div#btns_juma button:nth-child(7)').html('అన్నీ');
    $('div#btns_juma button:nth-child(8)').html('ఇతరులు');

    $('#hrow :nth-child(2)').html('పేరు');
    $('#hrow :nth-child(3)').html('తష్కీల్ వివరాలు');
    $('#hrow :nth-child(4)').html('జుమ');
    $('#hrow :nth-child(5)').html('సమయం');
    $('#hrow :nth-child(6)').html('మస్తురాత్');
    $('#hrow :nth-child(7)').html('వీధి');

    $('span.tskBerone').html('బేరూన్');
    $('span.tsk4months').html('4నెలలు');
    $('span.tsk40days').html('40రోజులు');
    $('span.tsk3days').html('3రోజులు');

    $('tr.juma1 td:nth-child(4)').html('జుమా1');
    $('tr.juma2 td:nth-child(4)').html('జుమా2');
    $('tr.juma3 td:nth-child(4)').html('జుమా3');
    $('tr.juma4 td:nth-child(4)').html('జుమా4');

    $('tr.waqBerone td:nth-child(5)').html('బేరూన్');
    $('tr.waq4months td:nth-child(5)').html('4నెలలు');
    $('tr.waq40days td:nth-child(5)').html('40రోజులు');
    $('tr.waq3days td:nth-child(5)').html('3రోజులు');

    $('tr.qaqBerone td:nth-child(6)').html('బేరూన్');
    $('tr.qaq40days td:nth-child(6)').html('40రోజులు');
    $('tr.qaq10days td:nth-child(6)').html('10రోజులు');
    $('tr.qaq3days td:nth-child(6)').html('3రోజులు');
  </script>
  <?php
}
?>
<?php
if(!$_GET["full_list"]){
  echo '<a href="?full_list=1"><button class="ui red button">Full List</button></a>';
}
if($caps == 'view_edit'){ ?>
  <script type="text/javascript">
  function search(){
    var search_form = $('#search_form');
    search_form.submit();
  }
  function filter(){
    $('#filter_btns').toggle();
    if($('#filter_btns').hasClass("blue")){
      $('#filter_btns').removeClass("blue");
      $('tr.rows').show();
    } else {
      $('#filter_btns').addClass("blue");
      $('#tch_btn').removeClass("blue");
      $('#stu_btn').removeClass("blue");
      $('tr.rows').hide();
    }
    
    $('#htr').show();
  }
  function students(){
    $('.work1').toggle();
    $('#htr').show();
    if($('#stu_btn').hasClass("blue")){
      $('#stu_btn').removeClass("blue");
    } else {
      $('#stu_btn').addClass("blue");
    }
  }
  function teachers(){
    $('.work2').toggle();
    if($('#tch_btn').hasClass("blue")){
      $('#tch_btn').removeClass("blue");
    } else {
      $('#tch_btn').addClass("blue");
    }
  }
  function waqth_filter(waqth){
    $('.all').hide();
    $('.waq'+waqth).show();
    $('.'+waqth).show();
    if(waqth!='all'){
      $('tr.rows.waq'+waqth).each(function(i, obj) {
        var x = i+1;
        $(obj).children('td:nth-child(1)').html(x);
      });
    } else {
      $('tr.all').each(function(i, obj) {
        var x = i+1;
        $(obj).children('td:nth-child(1)').html(x);
      });
    }
  }
  function juma_filter(juma){
    $('.juma1').hide();
    $('.juma2').hide();
    $('.juma3').hide();
    $('.juma4').hide();
    $('.juma5').hide();
    $('.juma').hide();
    $('.juma'+juma).show();
    if(juma!='all'){
      $('tr.juma'+juma).each(function(i, obj) {
        var x = i+1;
        $(obj).children('td:nth-child(1)').html(x);
      });
    } else {
      $('tr.all').each(function(i, obj) {
        var x = i+1;
        $(obj).children('td:nth-child(1)').html(x);
      });
    }
  }
  function response_edit(id){
    $('#response_edit'+id).css('display','none');
    $('#response_save'+id).css('display','inline');
    var response = $('#response_name'+id).html();
    $('#response_name'+id).html('<input type="text" style="width: 80%" id="response_change'+id+'" onkeypress="response_e(event,'+id+')" autofocus="">');
    $('#response_change'+id).val(response);
  };
  function response_save(id){
    $('#response_save'+id).removeClass('checkmark');
    $('#response_save'+id).addClass('loading sync alternate');
    $('#response_save'+id).removeAttr('style');
    var response = $('#response_change'+id).val();
    var data = {
      action      : 'my_action5',
      security    : MyAjax.security,
      response  : response,
      id          : id
    };

    $.post(MyAjax.ajaxurl, data, function(response) {
      $('#response_save'+id).addClass('checkmark');
      $('#response_save'+id).removeClass('loading sync alternate');
      $('#response_save'+id).css('display','none');
      $('#response_edit'+id).css('display','inline');
      $('#response_name'+id).html(response);
    });
  };
  function response_e(e,id){
    if(e.keyCode === 13){
        $("#response_save"+id).trigger( "click" );
    }
  }
  function tashkeel_d_edit(id){
    $('#tashkeel_d_edit'+id).css('display','none');
    $('#tashkeel_d_save'+id).css('display','inline');
    var tashkeel_d = $('#tashkeel_d_name'+id).html();
    $('#tashkeel_d_name'+id).html('<input type="date" style="width: 80%" id="tashkeel_d_change'+id+'" onkeypress="tashkeel_d_e(event,'+id+')">');
    $('#tashkeel_d_change'+id).val(tashkeel_d);
  };
  function tashkeel_d_save(id){
    $('#tashkeel_d_save'+id).removeClass('checkmark');
    $('#tashkeel_d_save'+id).addClass('loading sync alternate');
    $('#tashkeel_d_save'+id).removeAttr('style');
    var tashkeel_d = $('#tashkeel_d_change'+id).val();
    var data = {
      action      : 'my_action4',
      security    : MyAjax.security,
      tashkeel_d  : tashkeel_d,
      id          : id
    };

    $.post(MyAjax.ajaxurl, data, function(response) {
      $('#tashkeel_d_save'+id).addClass('checkmark');
      $('#tashkeel_d_save'+id).removeClass('loading sync alternate');
      $('#tashkeel_d_save'+id).css('display','none');
      $('#tashkeel_d_edit'+id).css('display','inline');
      $('#tashkeel_d_name'+id).html(response);
    });
  };
  function tashkeel_d_e(e,id){
    if(e.keyCode === 13){
        $("#tashkeel_d_save"+id).trigger( "click" );
    }
  }
  function tashkeel_j_edit(id){
    $('#tashkeel_j_edit'+id).css('display','none');
    $('#tashkeel_j_save'+id).css('display','inline');
    var tashkeel_j = $('#tashkeel_j_name'+id).html();
    $('#tashkeel_j_name'+id).html('<select id="tashkeel_j_change'+id+'" style="width:80%" class="ui dropdown">'+
      '<option value="--">--</option>'+
      '<option value="3days">3days</option>'+
      '<option value="40days">40days</option>'+
      '<option value="4months">4months</option>'+
      '<option value="Berone">Berone</option>'+
      '<option value="Masturath 3days">Masturath 3days</option>'+
      '<option value="Masturath 10days">Masturath 10days</option>'+
      '<option value="Masturath 40days">Masturath 40days</option>'+
      '<option value="Masturath Berone">Masturath Berone</option>'+
      '</select>');
    $('#tashkeel_j_change'+id).val(tashkeel_j);
  };
  function tashkeel_j_save(id){
    $('#tashkeel_j_save'+id).removeClass('checkmark');
    $('#tashkeel_j_save'+id).addClass('loading sync alternate');
    $('#tashkeel_j_save'+id).removeAttr('style');
    var tashkeel_j = $('#tashkeel_j_change'+id).val();
    var data = {
      action      : 'my_action3',
      security    : MyAjax.security,
      tashkeel_j  : tashkeel_j,
      id          : id
    };

    $.post(MyAjax.ajaxurl, data, function(response) {
      $('#tashkeel_j_save'+id).addClass('checkmark');
      $('#tashkeel_j_save'+id).removeClass('loading sync alternate');
      $('#tashkeel_j_save'+id).css('display','none');
      $('#tashkeel_j_edit'+id).css('display','inline');
      $('#tashkeel_j_name'+id).html(response);
    });
  };
  function tashkeel_j_e(e,id){
    if(e.keyCode === 13){
        $("#tashkeel_j_save"+id).trigger( "click" );
    }
  }

  function identifier_edit(id){
    $('#identifier_edit'+id).css('display','none');
    $('#identifier_save'+id).css('display','inline');
    var identifier = $('#identifier_name'+id).html();
    $('#identifier_name'+id).html('<input id="identifier_change'+id+'" type="text" value="'+identifier+'" autofocus="" style="width:80%" onkeypress="identifier_e(event,'+id+')">');
  };
  function identifier_save(id){
    $('#identifier_save'+id).removeClass('checkmark');
    $('#identifier_save'+id).addClass('loading sync alternate');
    $('#identifier_save'+id).removeAttr('style');
    var identifier = $('#identifier_change'+id).val();
    var data = {
      action      : 'my_action2',
      security    : MyAjax.security,
      identifier  : identifier,
      id          : id
    };

    $.post(MyAjax.ajaxurl, data, function(response) {
      $('#identifier_save'+id).addClass('checkmark');
      $('#identifier_save'+id).removeClass('loading sync alternate');
      $('#identifier_save'+id).css('display','none');
      $('#identifier_edit'+id).css('display','inline');
      $('#identifier_name'+id).html(response);
    });
  };
  function identifier_e(e,id){
    if(e.keyCode === 13){
        $("#identifier_save"+id).trigger( "click" );
    }
  }
  function person_edit(id){
    $('#person_edit'+id).css('display','none');
    $('#person_save'+id).css('display','inline');
    var person = $('#person'+id).html();
    $('#person'+id).html('<input id="person_change'+id+'" type="text" value="'+person+'" autofocus="" style="width:80%" onkeypress="person_e(event,'+id+')">');
  };
  function person_save(id){
    $('#person_save'+id).removeClass('checkmark');
    $('#person_save'+id).addClass('loading sync alternate');
    $('#person_save'+id).removeAttr('style');
    var person = $('#person_change'+id).val();
    var data = {
      action      : 'my_action',
      security    : MyAjax.security,
      person : person,
      id          : id
    };

    $.post(MyAjax.ajaxurl, data, function(response) {
      $('#person_save'+id).addClass('checkmark');
      $('#person_save'+id).removeClass('loading sync alternate');
      $('#person_save'+id).css('display','none');
      $('#person_edit'+id).css('display','inline');
      $('#person'+id).html(response);
    });
  };
  function person_e(e,id){
        if(e.keyCode === 13){
            $("#person_save"+id).trigger( "click" );
        }
    }
  function juma_edit(id){
    $('#juma_edit'+id).css('display','none');
    $('#juma_save'+id).css('display','inline');
    var juma_name = $('#juma_name'+id).html();
    $('#juma_name'+id).html('<input id="juma_change'+id+'" type="text" value="'+juma_name+'" autofocus="" style="width:80%" onkeypress="juma_e(event,'+id+')">');
  };
  function juma_save(id){
    $('#juma_save'+id).removeClass('checkmark');
    $('#juma_save'+id).addClass('loading sync alternate');
    $('#juma_save'+id).removeAttr('style');
    var juma_name = $('#juma_change'+id).val();
    var data = {
      action      : 'my_action',
      security    : MyAjax.security,
      juma_name : juma_name,
      id          : id
    };

    $.post(MyAjax.ajaxurl, data, function(response) {
      $('#juma_save'+id).addClass('checkmark');
      $('#juma_save'+id).removeClass('loading sync alternate');
      $('#juma_save'+id).css('display','none');
      $('#juma_edit'+id).css('display','inline');
      $('#juma_name'+id).html(response);
    });
  };
    $('.links-btn').html('Menu');
  </script>
  <?php } ?>
  <script type="text/javascript">
    $('table').tablesort();
  </script>
  <?php
}
}