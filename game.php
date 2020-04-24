<?php
session_start();
require 'connection.php';
$query = "UPDATE `accounts` SET `roomID` = NULL WHERE `username` =".db_quote($_SESSION['player']['username']);
$response = db_query($query);

if (!isset($_SESSION['player']['username'])) {
    header("Location: index.php");
}

if (isset($_POST['createRoom'])) {
    // $_SESSION['roomID'] = $_POST['roomID'];
    $roomID = db_quote($_POST['roomID']);
    $username = db_quote($_SESSION['player']['username']);
    $query = "UPDATE `accounts` SET `roomID` =" . $roomID . " WHERE `username` =" . $username;
    $result = db_query($query);
    if ($result) {
        // $query = "SELECT * FROM `accounts` WHERE `username` = " . $username;
        // $result = db_select($query);
        // $_SESSION['player'] = $result[0];
        $_SESSION['player']['roomID'] = $_POST['roomID'];
        $_SESSION['player']['isAdmin'] = $_SESSION['player']['username'];
        header("Location: room.php");
    }
}

if (isset($_POST['joinRoom'])) {
    $roomID = db_quote($_POST['roomID']);
    $username = db_quote($_SESSION['player']['username']);
    $query = "SELECT * FROM `accounts` WHERE `roomID` = " . $roomID;
    $result = db_select($query);
    if ($result) {
        // roomID is valid, thus update the same in Enterer's DB
        $query = "UPDATE `accounts` SET `roomID` =" . $roomID . " WHERE `username` =" . $username;
        $result = db_query($query);
        if ($result) {
            $_SESSION['player']['roomID'] = $_POST['roomID'];
            $_SESSION['player']['isAdmin'] = "Room Owner";
            header("Location: room.php");
        }
    } else {
        // roomID is invalid, deal with this later
    }
}
require_once 'components/header.php';
?>
<main class="h-100 d-flex">
    <section class="flex-fill align-self-center">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-sm-8 offset-sm-2">
                    <div class="card rounded-xl py-3rounded-lg shadow-lg">
                        <div class="card-body ">
                            <div class="display-4 fs-2 px-2">
                                Hey, <span id="username">
                                    <?php echo $_SESSION['player']['username'] ?>
                                </span>
                            </div>
                            <div class="display-4  fs-15 mt-4 mb-4 px-2">
                                Amount:
                                <?php echo $_SESSION['player']['amount'] ?>
                            </div>
                            <div class="card-body my-2 ">
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <input type="hidden" name="roomID" value="<?php echo rand(100000, 999999); ?>" required>
                                    <input type="submit" name="createRoom" value="Create Room" class="btn btn-info btn-block">
                                </form>
                            </div>
                            <div class="card rounded-xl py-3 rounded-lg shadow-lg">
                                <div class="card-body">
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <div class="form-group">
                                            <label for="roomID">Invite ID</label>
                                            <input type="number" name="roomID" class="form-control" id="roomID" aria-describedby="inviteHelp" required>
                                        </div>
                                        <input type="submit" name="joinRoom" value="Join Room" class="btn btn-primary btn-block">
                                    </form>
                                </div>
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
<script src="js/room.js"></script>
<script>
    window.addEventListener('load', function() {
        var el = document.querySelector("#username");
        username = el.textContent;
        forceKick(username);
    });
</script>
</body>

</html>