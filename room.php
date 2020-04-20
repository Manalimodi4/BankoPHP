<?php
session_start();
if (!isset($_SESSION['player']['roomID']))
    header("Location: game.php");
require_once 'components/header.php';
?>

<main class="h-100 d-flex">
    <section class="flex-fill align-self-center">
        <div class="container-fluid ">
            <div class="row">
                <div class=" col-lg-4 offset-lg-1 col-md-6 offset-md-1 col-sm-5">
                    <div class="card rounded-xl py-3rounded-lg shadow-lg mb-2">
                        <div class="card-body ">
                            <div class="display-4 fs-2 px-2">
                                Hey,<span id="username"><?php echo $_SESSION['player']['username'] ?></span>
                                <br>
                                Your room ID is <span id="roomID"><?php print_r($_SESSION['player']['roomID']) ?></span>
                            </div>
                            <div class="card-body my-2 ">
                                <div class="row px-0 mx-0 mt-2">
                                    <div class="col-md-6">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <input type="submit" name="inviteFriends" value="Invite Friends" class="btn btn-secondary mb-2 btn-block">
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <input type="submit" name="startGame" value="Start Game" class="btn btn-primary mb-2 btn-block">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-7">
                    <div class="card rounded-xl py-3rounded-lg shadow-lg">
                        <div class="card-body">
                            This Room:
                            <div id="playerList" class="mt-2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
<script>
    window.addEventListener('load', function() {
        var el = document.querySelector("#roomID");
        roomID = el.textContent;
        var el = document.querySelector("#username");
        username = el.textContent;
        getJoinedPlayers(roomID);
        // This refreshes players in room 2 seconds
        window.setInterval(function() {
            getJoinedPlayers(roomID);
        }, 2000);
        // This kicks user out of the room automatically
        setTimeout(function() {
            forceKick(username);
        }, 300000);
    });
</script>
</body>

</html>