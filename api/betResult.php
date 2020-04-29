<?php
require '../connection.php';
$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        response(doGet());
        break;
    default:
        break;
}

function doGet()
{
    $response = false;
    if (@$_GET['roomID']&& @$_GET['betResult']) {
        @$roomID = db_quote($_GET['roomID']);
        @$betResult = db_quote($_GET['betResult']);
        $query = "UPDATE `rooms` SET `betResult`=" . $betResult . " WHERE `roomID`=" . $roomID;
        $response = db_query($query);
    }
    return $response;
}

function response($x)
{
    header('Content-Type: application/json');
    echo json_encode($x);
}
