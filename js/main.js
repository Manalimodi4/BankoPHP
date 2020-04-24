function startObservingRoom() {

    roomID = document.querySelector("#roomID");
    roomID = roomID.textContent;

    observeAdmin(roomID);

    renderCards(roomID);

    window.setInterval(function() {
        observeRoom(roomID)
    }, 1000);

}

function addScore(el) {
    var pott = parseInt(bet.innerText);
    if (isNaN(pott)) {
        pott = 0;
    }
    bet.innerText = pott + 10;
    updateBetAmount(bet.innerText);
}

function subScore(el) {
    var pott = parseInt(bet.innerText);
    if (isNaN(pott)) {
        pott = 0;
    }
    if (this.bet.innerText >= 0) {
        bet.innerText = parseInt(pott) - 10;
        updateBetAmount(pott);
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
            // console.log(data);
            console.log("Bet Amount Updated.");

        },
        error: function(textStatus, errorMessage) { // error callback 
            console.log(textStatus);
            console.log(errorMessage);
        }
    });

}

function observeAdmin(roomID) {
    console.log("ObserveAdmin Called");
    username2 = document.querySelector("#username");
    username2 = username2.innerText;
    $.ajax('../api/observeRoom.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            if (data.isAdmin == username2) {
                initialisePotEvent();
                console.log("Yeh user admin hai");

            } else {
                console.log("Yeh user admin nahi hai");
            }
        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });

}


function observeRoom(roomID) {
    $.ajax('../api/observeRoom.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            players = JSON.parse(data.players);
            potBalance = document.querySelector("#pot");
            potBalance.innerText = data.potBalance;
            if (data.action >= 0)
                bet.innerText = data.action;
            else
                bet.innerText = 0;
            buttonHolder = document.querySelector("#buttonHolder");
            buttonHolder = buttonHolder.innerHTML;
            buttonHolder.innerHTML = "";
            username2 = document.querySelector("#username");
            username2 = username2.innerText;
            if (data.isPlaying != username2) {
                buttonHolder.innerHTML = "";

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
    $.ajax('../api/initialisePot.php', {
        data: { roomID: roomID },
        contentType: 'application/json',
        dataType: 'json', // type of response data
        //timeout: 500,     // timeout milliseconds
        success: function(data, status, xhr) { // success callback function
            //players = JSON.parse(data.players);
            console.log("Pot Initialised.");
        },
        error: function(textStatus, errorMessage) { // error callback 
            console.log("Pot Initialise Failed: " + errorMessage);
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
            console.log("Bet Action Completed: " + data);
        },
        error: function(textStatus, errorMessage) { // error callback 
            console.log("Bet Action Failed: " + errorMessage);
        }
    });
}