<?php
require '../connection.php';
$request_method = $_SERVER['REQUEST_METHOD'];
$response = array();
switch ($request_method) {
    case 'GET':
        response(doGet());
        break;
    case 'POST':
        doPost();
        break;
    case 'DELETE':
        doDelete();
        break;
    case 'PUT':
        doPut();
        break;

    default:
        # code...
        break;
}

function doGet() {
    if(@$_GET['roomID']) {
        @$roomID = db_quote($_GET['roomID']);
        $query = "SELECT username,amount FROM `accounts` WHERE `roomID` =".$roomID;
        $response = db_select($query);
        $response2=false;
    
        for ($i=0; $i < count($response) ; $i++) { 
        //print_r($response[$i]["username"]);
        $username=db_quote($response[$i]["username"]);
        $amount=db_quote(intval($response[$i]["amount"])-10);
        $query = "UPDATE `accounts` SET `amount` = ".$amount." WHERE `username`=".$username;
        $response2 = db_query($query);
        }

        if($response == array()) {
            $response = false;

        }
    } else {
        $response = false;
    }
    return $response2;
}
function doPost() {
    
}
function doDelete() {
    
}
function doPut() {
    
}

function response($x) {
    header('Content-Type: application/json');
    echo json_encode($x);
}


