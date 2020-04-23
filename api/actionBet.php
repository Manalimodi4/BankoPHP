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
    if (@$_GET['roomID'] && @$_GET['action']) {

        @$roomID = db_quote($_GET['roomID']);
        @$action = db_quote($_GET['action']);
        switch ($_GET['action']) {
            case 'doPass':
                $response2 = doPass($roomID);
                break;
            case 'doBet':
                $response2 = doBet($roomID);
                break;
            case 'doBanco':
                $response2 = doBanco($roomID);
                break;
            default:
                $response2 = "Invalid Action";
                break;
        }
    }
    return $response2;
}

function doPass($roomID)
{

    $response = moveToNextPlayer($roomID);
    return $response;
}
function doBet($roomID)
{
    $response = moveToNextPlayer($roomID);
    return $response;
}
function doBanco($roomID)
{
}
function  moveToNextPlayer($roomID)
{
    // $query = "SELECT `players` FROM `rooms` WHERE `roomID` =" . $roomID;
    $query = "SELECT `username` FROM `accounts` WHERE `roomID` =" . $roomID;
    $getNames = db_select($query);
    $query2 = "SELECT `isPlaying` FROM `rooms` WHERE `roomID` =" . $roomID;
    $isPlaying =db_select($query2);
    $isPlaying = $isPlaying[0]["isPlaying"];
    $count = count($getNames);
    $answer = false;

    for ($i = 0; $i < $count; $i++) {
        $getName = $getNames[$i]["username"];
        if ($getName==$isPlaying) {
            $answer = $i;
        }
        
    }
    $nextPlayerIndex = intval($answer)+ 1;
    if ($nextPlayerIndex >= $count) {
        $nextPlayerIndex=0;
    }
    $nextPlayer = $getNames[$nextPlayerIndex]["username"];
    $query = "UPDATE `rooms` SET `isPlaying` = ".db_quote($nextPlayer)." WHERE `roomID` =".$roomID;
    $updatePlayer = db_query($query);

    
    return $nextPlayer;
    
}
function endGame()
{
}
function response($x)
{
    header('Content-Type: application/json');
    echo json_encode($x);
}
