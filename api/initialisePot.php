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
        $query = "SELECT id, username, amount FROM `accounts` WHERE `roomID` =".$roomID;
        $response = db_select($query);
        if($response == array()) {
            $response = false;
        }
    } else {
        $response = false;
    }
    return $response;
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


