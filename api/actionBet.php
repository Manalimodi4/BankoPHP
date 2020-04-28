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
            case 'compareCards':
                $response2 = compareCards($roomID);
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
    // find result of bet
    $betResult = compareCards($roomID);
    if ($betResult["betCompareResult"]) {
        // amount deduct from pot & add to Player amount
        $isTransferred = transferAmount($roomID, "POT_TO_PLAYER");
    } else {
        // amount deduct from player & add to pot
        $isTransferred = transferAmount($roomID, "PLAYER_TO_POT");
    }
    // move to next player
    $movedToNextPlayer = moveToNextPlayer($roomID);

    // update deck index
    $deckIndexUpdated = updateDeckIndex($roomID, 3);
    return compact("betResult", "isTransferred", "movedToNextPlayer", "deckIndexUpdated");
}
function doBanko($roomID)
{
    $betResult = compareCards($roomID);
    if ($betResult["betCompareResult"]) {
        // amount deduct from pot & add to Player amount
        $isTransferred = transferAmount($roomID, "FLUSH_PLAYER");
    } else {
        // amount deduct from player & add to pot
        $isTransferred = transferAmount($roomID, "FLUSH_POT");
    }

    $movedToNextPlayer = moveToNextPlayer($roomID);
    $deckIndexUpdated = updateDeckIndex($roomID, 51);
    return compact("betResult", "isTransferred", "movedToNextPlayer", "deckIndexUpdated");
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
    $cards = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");
    $suits = array("diamonds", "hearts", "spades", "clubs");
    $i = 0;
    foreach ($cards as $key => $value) {
        foreach ($suits as $key2 => $value2) {
            $deck[$i] = $value . " " . $value2;
            $i = $i + 1;
        }
        # code...
    }
    shuffle($deck);

    $deck = json_encode($deck); #encode in json
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
function compareCards($roomID)
{
    $query = "SELECT  deck, deckIndex FROM `rooms` WHERE `roomID` = " . $roomID;
    $resultSet = db_select($query);
    $compareCardDeck = $resultSet[0]["deck"];
    $compareCardDeck = json_decode($compareCardDeck);
    $compareCardDeckIndex = $resultSet[0]["deckIndex"];
    if ($compareCardDeckIndex > 49) {
        shuffleDeck();
        $query = "SELECT  deck, deckIndex FROM `rooms` WHERE `roomID` = " . $roomID;
        $resultSet = db_select($query);
        $compareCardDeck = $resultSet[0]["deck"];
        $compareCardDeck = json_decode($compareCardDeck);
        $compareCardDeckIndex = $resultSet[0]["deckIndex"];
    }
    $firstCardName = $compareCardDeck[$compareCardDeckIndex];
    $secondCardName = $compareCardDeck[$compareCardDeckIndex + 1];
    $betCardName = $compareCardDeck[$compareCardDeckIndex + 2];
    $firstCard = getFaceValue(substr($compareCardDeck[$compareCardDeckIndex], 0, 2));
    $secondCard = getFaceValue(substr($compareCardDeck[$compareCardDeckIndex + 1], 0, 2));
    $betCard = getFaceValue(substr($compareCardDeck[$compareCardDeckIndex + 2], 0, 2));

    if (($betCard == $firstCard) or ($betCard == $secondCard)) {
        $betCompareResult = false;
    } else {
        if ($firstCard < $secondCard) {
            //bet Won
            if (($betCard > $firstCard) and ($betCard < $secondCard)) {
                $betCompareResult = true;
            }
            // bet Lost
            else {
                $betCompareResult = false;
            }
        }

        if ($firstCard > $secondCard) {
            //bet Won
            if (($betCard < $firstCard) and ($betCard > $secondCard)) {
                $betCompareResult = true;
            }
            // bet Lost
            else {
                $betCompareResult = false;
            }
        }
        //bet Lost
        if ($firstCard == $secondCard) {
            $betCompareResult = false;
        }
    }
    return compact("betCompareResult", "firstCardName", "secondCardName", "betCardName");
}

function getFaceValue($cardName)
{
    if ($cardName == "A ")
        return 1;
    if ($cardName == "2 ")
        return 2;
    if ($cardName == "3 ")
        return 3;
    if ($cardName == "4 ")
        return 4;
    if ($cardName == "5 ")
        return 5;
    if ($cardName == "6 ")
        return 6;
    if ($cardName == "7 ")
        return 7;
    if ($cardName == "8 ")
        return 8;
    if ($cardName == "9 ")
        return 9;
    if ($cardName == "10")
        return 10;
    if ($cardName == "J ")
        return 11;
    if ($cardName == "Q ")
        return 12;
    if ($cardName == "K ")
        return 13;
    else
        return $cardName;
}
function transferAmount($roomID, $mode)
{
    if ($mode == "POT_TO_PLAYER") {
        // Deduct from Pot
        $query = "SELECT isPlaying, action , potBalance FROM `rooms` WHERE `roomID` = " . $roomID;
        $resultSett = db_select($query);
        $betAmount = $resultSett[0]["action"];
        $potBalance = $resultSett[0]["potBalance"];
        $player =  $resultSett[0]["isPlaying"];
        $potBalance = $potBalance - $betAmount;
        $query = "UPDATE `rooms` SET `action`= 0, `potBalance` = " . db_quote($potBalance) . " WHERE `roomID` = " . $roomID;
        $deductedFromPot = db_query($query);
        // add to player 
        $query = "SELECT amount FROM `accounts` WHERE `username` = " . db_quote($player);
        $resulttt = db_select($query);
        $playerBalance = $resulttt[0]["amount"];
        $playerBalance = $playerBalance + $betAmount;
        $query = "UPDATE `accounts` SET `amount` = " . db_quote($playerBalance) . " WHERE `username` = " . db_quote($player);
        $addedToPlayer = db_query($query);

        return compact("deductedFromPot", "addedToPlayer", "betAmount", "playerBalance", "potBalance", "player");
    }
    if ($mode == "PLAYER_TO_POT") {
        // add to Pot
        $query = "SELECT isPlaying, action , potBalance FROM `rooms` WHERE `roomID` = " . $roomID;
        $resultSett = db_select($query);
        $betAmount = $resultSett[0]["action"];
        $potBalance = $resultSett[0]["potBalance"];
        $player =  $resultSett[0]["isPlaying"];
        $potBalance = $potBalance + $betAmount;
        $query = "UPDATE `rooms` SET `action`= 0, `potBalance` = " . db_quote($potBalance) . " WHERE `roomID` = " . $roomID;
        $addedToPot = db_query($query);
        // deduct from player 
        $query = "SELECT amount FROM `accounts` WHERE `username` = " . db_quote($player);
        $resulttt = db_select($query);
        $playerBalance = $resulttt[0]["amount"];
        $playerBalance = $playerBalance - $betAmount;
        $query = "UPDATE `accounts` SET `amount` = " . db_quote($playerBalance) . " WHERE `username` = " . db_quote($player);
        $deductedFromPlayer = db_query($query);

        return compact("addedToPot", "deductedFromPlayer", "betAmount", "playerBalance", "potBalance", "player");
    }
    if ($mode == "FLUSH_PLAYER") {
        //If player wins Banko
        $query2 = "SELECT potBalance,isPlaying FROM `rooms` WHERE `roomID` = " . $roomID;
        $resultSet = db_select($query2);
        $potBalance = $resultSet[0]["potBalance"];
        $player =  $resultSet[0]["isPlaying"];
        //select amount
        $query = "SELECT amount FROM `accounts` WHERE `username` = " . db_quote($player);
        $resulttt = db_select($query);
        $playerBalance = $resulttt[0]["amount"];
        //add potbalance to playerbalance
        $playerBalance = $playerBalance + $potBalance;
        $query = "UPDATE `accounts` SET `amount` = " . db_quote($playerBalance) . " WHERE `username` = " . db_quote($player);
        $flushPlayer = db_query($query);
        //set potbalance zero
        $clearPotQuery = "UPDATE `rooms` SET `potBalance` = 0 WHERE `roomID`= " . $roomID;
        $clearPot = db_query($clearPotQuery);

        return compact("clearPot", "flushPlayer", "playerBalance", "potBalance", "player");
    }
    if ($mode == "FLUSH_POT") {
        //If player loses Banko
        $query2 = "SELECT potBalance,isPlaying FROM `rooms` WHERE `roomID` = " . $roomID;
        $resultSet = db_select($query2);
        $potBalance = $resultSet[0]["potBalance"];
        $player = $resultSet[0]["isPlaying"];
        //select player's amount
        $query = "SELECT amount FROM `accounts` WHERE `username` = " . db_quote($player);
        $resulttt = db_select($query);
        $playerBalance = $resulttt[0]["amount"];
        //deduct player's balance
        $playerBalance = $playerBalance - $potBalance;
        $potBalance = $potBalance * 2;
        $query = "UPDATE `accounts` SET `amount` = " . db_quote($playerBalance) . " WHERE `username` = " . db_quote($player);
        $deductFromPlayer = db_query($query);
        //update  pot
        $flushPotQuery = "UPDATE `rooms` SET `potBalance` =" . db_quote($potBalance) . " WHERE `roomID`= " . $roomID;
        $flushPot = db_query($flushPotQuery);

        return compact("flushPot", "deductFromPlayer",  "playerBalance", "potBalance", "player");
    }
}
