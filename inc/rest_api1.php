<?php
function rest_api_select_person( WP_REST_Request $request ) {
    global $wpdb;
    $fields = "*";
    if($request["fields"]){
        $fields = $request["fields"];
    }
    $sql = "SELECT $fields FROM person";
    if($request["where"]){
        $where = explode(',',$request["where"]);
        $sql = $sql." WHERE ".$where[0]." = '".$request[$where[0]]."'";
        for ($j=1; $j < count($where); $j++) { 
            $sql = $sql." AND ".$where[$j]." = '".$request[$where[$j]]."'";
        }
        $connect = "AND";
    } else {
        $connect = "WHERE";
    }
    $result = $wpdb->get_results($sql.' LIMIT 50');
    echo(json_encode($result,JSON_PRETTY_PRINT));;
}
function rest_api_insert_person( WP_REST_Request $request ) {
    global $wpdb;
    $params = $request->get_params();
    foreach ($params as $key => $value) {
        if ($key!="where" && $key!="WHERE") {
            $data[$key] = $value;
        }
    }
    $result = $wpdb->insert('person', $data );
    echo(json_encode($result,JSON_PRETTY_PRINT));;
}
function rest_api_update_person( WP_REST_Request $request ) {
    global $wpdb;
    if($request["where"]){
        $where = explode(',',$request["where"]);
        for ($j=0; $j < count($where); $j++) { 
            $w_array[$where[$j]] = $request[$where[$j]];
        }
    } else {
        $w_array = array('id' => $request["id"]);
    }
    $params = $request->get_params();
    foreach ($params as $key => $value) {
        if ($key!="where" && $key!="WHERE") {
            $data[$key] = $params->$value;
        }
    }
    $result = $wpdb->update('person',$data, $w_array);
    echo(json_encode($result,JSON_PRETTY_PRINT));;
}
function rest_api_delete_person( WP_REST_Request $request ) {
    global $wpdb;
    if($request["where"]){
        $where = explode(',',$request["where"]);
        for ($j=0; $j < count($where); $j++) { 
            $w_array[$where[$j]] = $request[$where[$j]];
        }
    } else {
        $w_array = $request->get_params();
    }
    $result = $wpdb->delete('person',$w_array );
    echo(json_encode($result,JSON_PRETTY_PRINT));;
}
add_action( 'rest_api_init', function () {
    register_rest_route( 'person/v1', '/person/select', array(
        'methods' => 'GET',
        'callback' => 'rest_api_select_person'));
    register_rest_route( 'person/v1', '/person/insert', array(
        'methods' => 'GET',
        'callback' => 'rest_api_insert_person'));
    register_rest_route( 'person/v1', '/person/update', array(
        'methods' => 'GET',
        'callback' => 'rest_api_update_person'));
    register_rest_route( 'person/v1', '/person/delete', array(
        'methods' => 'GET',
        'callback' => 'rest_api_delete_person'));
} );