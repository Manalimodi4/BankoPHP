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
            case 'doBanko':
                $response2 = doBanko($roomID);
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
    $response = updateDeckIndex($roomID, 2);
    return $response;
}
function doBet($roomID)
{
    $response = moveToNextPlayer($roomID);
    $response = updateDeckIndex($roomID, 3);
    return $response;
}
function doBanko($roomID)
{
    $response = moveToNextPlayer($roomID);
    $response = updateDeckIndex($roomID, 51);
    return $response;
}

function updateDeckIndex($roomID, $updateDeckIndexBy)
{
    $query = "SELECT `deckIndex` FROM `rooms` WHERE `roomID` = " . $roomID;
    $resultSet = db_select($query);
    $indexFromDB = $resultSet[0]["deckIndex"];
    $deckIndex = intval($indexFromDB) + $updateDeckIndexBy;
    if ($deckIndex > 50) {
        $deck = shuffleDeck();
        $query = "UPDATE `rooms` SET `deck`= " . $deck . " , `deckIndex` = 0 WHERE `roomID` = " . $roomID;
        $response = db_query($query);
    } else {
        $query = "UPDATE `rooms` SET `deckIndex` = " . $deckIndex . " WHERE `roomID` = " . $roomID;
        $response = db_query($query);
    }
    return $response;
}
function shuffleDeck()
{
    $cards=array("A","2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"); 
    $suits=array("diamonds", "hearts", "spades", "clubs");
    $i=0;
    foreach ($cards as $key => $value) {
        foreach ($suits as $key2 => $value2) {
            $deck[$i]=$value." ".$value2;
            $i=$i+1;
        }
        # code...
    }
    shuffle($deck);
    
    $deck=json_encode($deck); #encode in json
    $deck = db_quote($deck);
    return $deck;
}
function  moveToNextPlayer($roomID)
{
    // $query = "SELECT `players` FROM `rooms` WHERE `roomID` =" . $roomID;
    $query = "SELECT `username` FROM `accounts` WHERE `roomID` =" . $roomID;
    $getNames = db_select($query);
    $query2 = "SELECT `isPlaying` FROM `rooms` WHERE `roomID` =" . $roomID;
    $roomInfo = db_select($query2);
    $isPlaying = $roomInfo[0]["isPlaying"];
    $count = count($getNames);
    $answer = false;

    for ($i = 0; $i < $count; $i++) {
        $getName = $getNames[$i]["username"];
        if ($getName == $isPlaying) {
            $answer = $i;
        }
    }
    $nextPlayerIndex = intval($answer) + 1;
    if ($nextPlayerIndex >= $count) {
        $nextPlayerIndex = 0;
    }
    $nextPlayer = $getNames[$nextPlayerIndex]["username"];
    $query = "UPDATE `rooms` SET `isPlaying` = " . db_quote($nextPlayer) . ", `action` = 0 WHERE `roomID` =" . $roomID;
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
function compareCards($roomID){
    $query = "SELECT isPlaying, deck, deckIndex FROM `rooms` WHERE `roomID` = " .db_quote($roomID);
    
}