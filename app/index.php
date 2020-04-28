<?php
session_start();
require_once '../connection.php';
if (!isset($_SESSION['player']['roomID']))
    header("Location: ../");
$roomID = db_quote($_SESSION['player']['roomID']);
$query = "SELECT * FROM `rooms` WHERE `roomID` =" . $roomID;
$result = db_select($query);
$_SESSION['rooms'] = $result[0];
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <title>Banko Game</title>
</head>

<body>
    <header role="navbar">
        <nav class="navbar bg-white fixed-top">
            <div class="navbar-brand ">
                <img src="../images/Banko.svg" height="30" alt="">
            </div>

            <div class="ok">
                <!-- <button class="btn btn-dark" onclick="shuffle()">Shuffle</button> -->
                <a class="btn px-3 btn-outline-danger" href="../signout.php">Sign Out</a></div>
        </nav>
    </header>
    <main class="d-flex" style="padding-top: 80px;">
        <section class="flex-fill align-self-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6  col-md-7  col-sm-12 mb-3">
                        <div class="card py-4 rounded-xl">
                            <div class="container-fluid">
                                <div class="row ">
                                    <div class="cardRevealOverlay flex-column">
                                        <div class="d-flex my-2">
                                            <span id="isPlaying22"></span>&nbsp;<span id="betResult"></span>&nbsp;<span id="amountr"></span>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <div class="card2 shadow-lg" id="firstCard">
                                                <div class="value" id="firstCardValue"></div>
                                                <div class="" id="firstCardSuit"></div>
                                            </div>

                                            <div class="card2 shadow-lg" id="revealedCard" style="">
                                                <div class="value" id="betCardValue"></div>
                                                <div class="" id="betCardSuit"></div>
                                            </div>

                                            <div class="card2 shadow-lg" id="secondCard">
                                                <div class="value" id="secondCardValue"></div>
                                                <div class="" id="secondCardSuit"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 px-4">

                                        <div class="deck my-3 mt-4 d-flex justify-content-center" id="stage">

                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-sm-6 d-flex flex-column justify-content-center">
                                        <div class="text-center text-muted mb-1">
                                            BET AMOUNT
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <div class="d-flex flex-row justify-content-center">
                                                <button type="button" class="btn btn-outline-primary rounded-circle" onclick="subScore(this)" id="sub">
                                                    <i class="fa fa-caret-down fa-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-info rounded-pill px-4 py-2 mx-3" value="0" id="bet">0</button>
                                                <button type="button" class="btn btn-outline-primary rounded-circle" onclick="addScore(this)" id="add">
                                                    <i class="fa fa-caret-up fa-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 d-flex flex-column mt-3 mt-md-0">
                                        <div class="text-center text-muted mb-1">
                                            POT AMOUNT
                                        </div>
                                        <div class="d-flex flex-row justify-content-center">
                                            <button type="button" class="btn btn-success rounded-pill px-4 py-2 mx-3" id="pot">0</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 my-3 mt-4 d-flex justify-content-around" id="buttonHolder">
                                        <button type="button" class="btn btn-warning px-3" onclick="actionPass()">Pass</button>
                                        <button type="button" class="btn btn-dark px-3" onclick="actionBet()">Bet</button>
                                        <button type="button" class="btn btn-danger px-3" onclick="actionBanko()">Banco</button>
                                    </div>
                                    <div class="col-sm-12 my-3 mt-4 d-flex justify-content-around" id="playerHolder">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    Playing: <span id="isPlaying">isPlaying</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5  col-sm-12 mb-3">
                        <div class="card rounded-xl p-1 bg-dark text-white">
                            <div class="card-header">
                                You: <?php echo $_SESSION['player']['username'] ?>
                                <?php $query1 = "SELECT username,amount FROM `accounts` WHERE `roomID`=" . db_quote($_SESSION['player']['roomID']);
                                $tableResult = db_query($query1);  ?>
                            </div>
                            <!-- <div class="card-body">
                                <div class="table-responsive">
                                    <table id="players_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>username</td>
                                                <td>amount</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        while ($row = mysqli_fetch_array($tableResult)) {
                                            echo '  
                               <tr>  
                                    <td>' . $row["username"] . '</td>  
                                    <td>' . $row["amount"] . '</td>  
                               </tr>  
                               ';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div> -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table id="players_data" class="table table-hover table-dark">
                                        <thead>
                                            <tr>
                                                <td>Player</td>
                                                <td>Amount</td>
                                            </tr>
                                        </thead>
                                        <tbody id="leaderboard">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="d-none" id="roomID"><?php echo $_SESSION['rooms']['roomID'] ?></div>
        <div class="d-none" id="username"><?php echo $_SESSION['player']['username'] ?></div>
        <div class="d-none" id="isPlaying"></div>
        <div class="d-none" id="isInitialised"></div>
        <div class="d-none">
            <div id="rightCard"></div>
            <div id="currentCard"></div>
            <div id="leftCard"></div>
        </div>

    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="../js/main.js"></script>
    <script>
        bet = document.querySelector("#bet");
        window.onload = startObservingRoom;
    </script>
    <script>
        // $(document).ready(function(){  
        //   $('#players_data').DataTable();  
        //  });  
    </script>
</body>

</html>