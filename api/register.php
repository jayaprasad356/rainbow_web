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


if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['device_id'])) {
    $response['success'] = false;
    $response['message'] = "Device Id is Empty";
    print_r(json_encode($response));
    return false;
}
$email = $db->escapeString($_POST['email']);
$name = $db->escapeString($_POST['name']);
$datetime = date('Y-m-d H:i:s');
$referred_by = (isset($_POST['referred_by']) && !empty($_POST['referred_by'])) ? $db->escapeString($_POST['referred_by']) : "";
$device_id = $db->escapeString($_POST['device_id']);

$sql = "SELECT * FROM users WHERE email = '$email'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1){
    $response['success'] = false;
    $response['message'] = "You are Already Registered";
    print_r(json_encode($response));
}
else{
    do {
        $random_number = mt_rand(10000,99999);
        $sql = "SELECT * FROM users WHERE refer_code = $random_number";
        $db->sql($sql);
        $res = $db->getResult();
        if(!$res) {
            break;
        }
    } while(1);

    $refer_code = $random_number;
    $sql = "SELECT * FROM settings WHERE id =1";
    $db->sql($sql);
    $result = $db->getResult();
    $coins=$result[0]['register_coins'];
    $refer_coins=$result[0]['refer_coins'];
    if(empty($referred_by)){
        

    }
    else{
        $sql = "UPDATE users SET coins = coins + $refer_coins WHERE refer_code = '$referred_by' AND device_id !='$device_id'";
        $db->sql($sql);
        
    }

    $currentdate = date('Y-m-d');
    $sql = "INSERT INTO users (`email`,`name`,`referred_by`,`upi`,`device_id`,`refer_code`,`coins`,`joined_date`,`datetime`) VALUES ('$email','$name','$referred_by','','$device_id','$refer_code','$coins','$currentdate','$datetime')";
    $db->sql($sql);
   
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "User Registered Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));


}



?>