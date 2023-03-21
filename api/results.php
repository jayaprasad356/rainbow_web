<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');

$db = new Database();
$db->connect();


$sql = "SELECT * FROM results,colors WHERE results.color_id = colors.id ORDER BY results.id DESC";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1){
    foreach($res as $row){
        $temp['name']= $row['name'];
        $temp['code']= $row['code'];
        $temp['datetime']= $row['datetime'];
        $rows[]=$temp;
    }
    $response['success'] = true;
    $response['message'] = "Results Listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Results Not Found";
    print_r(json_encode($response));

}
