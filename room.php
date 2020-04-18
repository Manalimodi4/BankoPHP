<?php
session_start();
if (!isset($_SESSION['player']['roomID']))
    header("Location: game.php");
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

<body>

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
                        <div class="col-md-4 offset-md-1 col-sm-4 offset-sm-1">
                            <div class="card rounded-xl py-3rounded-lg shadow-lg">
                                <div class="card-body ">
                                    <div class="display-4 fs-2 px-2">
                                        Hey,
                                        <?php echo $_SESSION['player']['username'] ?>
                                        <br>
                                        Your room ID is <span id="roomID"><?php print_r($_SESSION['player']['roomID']) ?></span>
                                    </div>
                                    <div class="card-body my-2 ">
                                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <input type="submit" name="Invite Friends" value="Invite Friends" class="btn btn-info btn-block">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
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
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="js/main.js"></script>
        <script>
            var el = document.querySelector("#roomID");
            roomID = el.textContent;
            getJoinedPlayers(roomID);
            window.setInterval(function() {
                getJoinedPlayers(roomID);
            }, 1000);
        </script>
    </body>

</html>