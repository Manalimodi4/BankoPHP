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
                setTimeout(() => node.classList.add("animate"), 500);
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
            console.log(data);
        },
        error: function(textStatus, errorMessage) { // error callback 
            // console.log(jqxhr);
            console.log(textStatus);
            console.log(errorMessage);
        }
    });
}