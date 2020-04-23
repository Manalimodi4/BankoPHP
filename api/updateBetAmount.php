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

function doGet()
{
    $response2 = false;
    if (@$_GET['roomID']&& @$_GET['betAmount']) {

        @$roomID = db_quote($_GET['roomID']);
        @$betAmount = db_quote($_GET['betAmount']);
        $query = "UPDATE `rooms` SET `action`=" . $betAmount . " WHERE `roomID`=" . $roomID;
        $response2 = db_query($query);
    }
    return $response2;
}

function doPost()
{
}
function doDelete()
{
}
function doPut()
{
}

function response($x)
{
    header('Content-Type: application/json');
    echo json_encode($x);
}
