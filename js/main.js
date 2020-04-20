players = 0;

function getJoinedPlayers(roomID) {
    $.ajax('api/getJoinedPlayers.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            var playerList = document.querySelector("#playerList");
            playerList.innerHTML = '';
            players = data.length;
            if (players === undefined) {
                window.location.href = "game.php";
            }
            for (i = 0; i < data.length; i++) { // for each player
                var node = document.createElement("div");
                node.className = "playerCard";

                var node2 = document.createElement("div");
                node2.className = "playerName";

                var node3 = document.createElement("div");
                node3.className = "playerAmount"

                var textnode = document.createTextNode(data[i].username);
                node2.appendChild(textnode);

                var textnode = document.createTextNode(data[i].amount);
                node3.appendChild(textnode);
                node.appendChild(node2);
                node.appendChild(node3);
                playerList.appendChild(node);

                var ele = document.querySelector("#currentPlayerList");
                ele.value = JSON.stringify(data);
            }
        },
        error: function(jqXhr, textStatus, errorMessage) { // error callback 
            console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}

function forceKick(username) {
    $.ajax('api/forceKick.php', {
        data: { username: username },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            // console.log();
        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}

var cards = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
var suits = ["diamonds", "hearts", "spades", "clubs"];
var deck = new Array();

function getDeck() {
    var deck = new Array();

    for (var i = 0; i < suits.length; i++) {
        for (var x = 0; x < cards.length; x++) {
            var card = { Value: cards[x], Suit: suits[i] };
            deck.push(card);
        }
    }

    return deck;
}

function shuffle() {
    // for 1000 turns
    // switch the values of two random cards
    for (var i = 0; i < 1000; i++) {
        var location1 = Math.floor((Math.random() * deck.length));
        var location2 = Math.floor((Math.random() * deck.length));
        var tmp = deck[location1];

        deck[location1] = deck[location2];
        deck[location2] = tmp;
    }

    renderDeck();
}

function renderDeck() {
    document.getElementById('stage').innerHTML = '';
    for (var i = 0; i < 2; i++) {
        var card = document.createElement("div");
        var value = document.createElement("div");
        var suit = document.createElement("div");
        card.className = "card1 shadow-lg";
        value.className = "value";
        suit.className = "suit " + deck[i].Suit;

        value.innerHTML = deck[i].Value;
        card.appendChild(value);
        card.appendChild(suit);

        document.getElementById("stage").appendChild(card);
    }
}

function load() {
    deck = getDeck();
    shuffle();
    renderDeck();
}


function addScore(el) {
    pot.innerText = parseInt(pot.innerText) + 10;
}

function subScore(el) {
    if (this.pot.innerText > 0)
        pot.innerText = parseInt(pot.innerText) - 10;
}

function startObservingRoom() {
    roomID = document.querySelector("#roomID");
    roomID = roomID.textContent;
    window.setInterval(function() {
        observeRoom(roomID);
    }, 1000);
}

function observeRoom(roomID) {
    $.ajax('../api/observeRoom.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            console.log(data);
        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}