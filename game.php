<?php
session_start();
// if(!isset($_SESSION['player']))
// header("Location: index.php");
?>



<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>Banko Game</title>
</head>

<body class="h-100">
    <header role="navbar">
        <nav class="navbar  bg-white fixed-top">
            <div class="navbar-brand ">
                <img src="images/Banko.svg" height="30" alt="">
            </div>
        </nav>
    </header>
    <main class="h-100 d-flex">
        <section class="flex-fill align-self-center">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-sm-6 offset-sm-3">
                        <div class="card rounded-xl py-3rounded-lg shadow-lg">
                            <div class="card-body ">
                                <div class="display-4 fs-2 px-2">
                                    Hey,
                                    <?php echo $_SESSION['player']['username'] ?>
                                </div>
                                <div class="display-4  fs-15 mt-4 mb-4 px-2">
                                    Amount:
                                    <?php echo $_SESSION['player']['amount'] ?>
                                </div>
                                    <div class="card-body my-2 ">
                                        <form>
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                                <input type="submit" name="createRoom" value="Create Room" class="btn btn-info btn-block">
                                            </form>
                                </div>
                                <div class="card rounded-xl py-3 rounded-lg shadow-lg">
                                    <div class="card-body ">
                                        <form>
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                                <div class="form-group">
                                                    <label for="roomId">Invite ID</label>
                                                    <input type="text" name="invite" class="form-control" id="invite" aria-describedby="inviteHelp" required>
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>