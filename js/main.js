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


                // var ele = document.querySelector("#leftCard");

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

function addScore(el) {
    bet.innerText = parseInt(bet.innerText) + 10;
    updateBetAmount(bet.innerText);
}

function subScore(el) {
    if (this.bet.innerText >= 0) {
        bet.innerText = parseInt(bet.innerText) - 10;
        updateBetAmount(bet.innerText);
    }
}

function updateBetAmount(betAmount) {

    roomID = document.querySelector("#roomID");
    roomID = roomID.textContent;
    $.ajax('../api/updateBetAmount.php', {
        data: {
            roomID: roomID,
            betAmount: betAmount
        },
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


function startObservingRoom() {

    roomID = document.querySelector("#roomID");
    roomID = roomID.textContent;
    window.setInterval(function() {
        observeRoom(roomID)
    }, 1000);
    renderCards(roomID);
    // window.alert("hii");

}

function observeRoom(roomID) {
    $.ajax('../api/observeRoom.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            players = JSON.parse(data.players);
            console.log(data.potBalance);
            potBalance = document.querySelector("#pot");
            potBalance.innerText = data.potBalance;
            if (data.action >= 0)
                bet.innerText = data.action;
            else
                bet.innerText = 0;
            buttonHolder = document.querySelector("#buttonHolder");
            buttonHolder = buttonHolder.innerHTML;
            username2 = document.querySelector("#username");
            username2 = username2.innerText;
            console.log(data.isPlaying);
            console.log(username2);
            if (data.isPlaying != username2) {

                username2.innerHTML = '<button type="button" class="btn btn-warning px-3" onclick="actionBet()">Pass</button><button type="button" class="btn btn-dark px-3">Bet</button><button type="button" class="btn btn-danger px-3">Banco</button>';

            } else {
                buttonHolder.innerHTML = ' <div class="d-flex flex-column align-items-center">' + data.isPlaying + '</div>'
            }
        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}

function observeRoomStart(roomID, username) {
    $.ajax('api/observeRoom.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            if (data) {
                if (data.isAdmin == username) {
                    console.log("Player is admin, shouldn't see this msg");
                } else {
                    window.location.href = "app/";
                }
            }

        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}


function roomStartEventListener(roomID, username) {
    window.setInterval(function() {
        observeRoomStart(roomID, username);
    }, 1000);
}

function renderCards(roomID, username) {
    $.ajax('../api/observeRoom.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            myDeckJSON = JSON.parse(data.deck);
            document.getElementById('stage').innerHTML = '';
            for (var i = 0; i < 2; i++) {
                var card = document.createElement("div");
                var value = document.createElement("div");
                var suit = document.createElement("div");
                card.className = "card1 shadow-lg";
                value.className = "value";
                console.log(myDeckJSON[deckIndex + i]);

                suit.className = "suit " + myDeckJSON[i].substr(2);

                value.innerHTML = myDeckJSON[i].substr(0, 2);
                card.appendChild(value);
                card.appendChild(suit);

                document.getElementById("stage").appendChild(card);

            }

        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
            window.alert("not working");
        }
    });
}

function initialisePotEvent() {
    roomID = document.querySelector('#roomID');
    roomID = roomID.innerText;
    console.log(roomID);
    $.ajax('../api/initialisePot.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            //players = JSON.parse(data.players);
            console.log(data);

        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
    renderCards(roomID);
}

function actionBet() {

    roomID = document.querySelector("#roomID");
    roomID = roomID.textContent;
    $.ajax('../api/actionBet.php', {
        data: {
            roomID: roomID,
            action: "doBet"
        },
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