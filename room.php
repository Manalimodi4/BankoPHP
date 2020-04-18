<?php
session_start();
// if(!isset($_SESSION['player']))
// header("Location: index.php");
?>
<?php
if(!isset($_SESSION['roomID'])){
    header("Location: game.php");
}
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
<body><body class="h-100">
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
                                 <?php echo $_SESSION['player']['username'] ?><br />
                                 Your room ID is <?php print_r($_SESSION['roomID'])?>
                                </div>
                                    <div class="card-body my-2 ">
                                        <form>
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                                <input type="submit" name="Invite Friends" value="Invite Friends" class="btn btn-info btn-block">
                                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

</body>