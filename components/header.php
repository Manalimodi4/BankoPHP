<?php
$config2 = parse_ini_file('db/config.ini');
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>Banko Game</title>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $config2['sitekey'] ?>"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute(<?php echo $config2['sitekey'] ?>, {
                action: 'homepage'
            }).then(function(token) {
                console.log(token);
                document.getElementById("token").value = token;
            });
        });
    </script>
</head>

<body class="h-100">
    <header role="navbar">
        <nav class="navbar bg-white fixed-top">
            <div class="navbar-brand ">
                <img src="images/Banko.svg" height="30" alt="">
            </div>
            <?php
            if ($_SERVER['PHP_SELF'] != "/bankoPHP/index.php")
                echo '<div class="ok"><a class="btn px-3 btn-outline-danger" href="signout.php">Sign Out</a></div>';
            ?>
            <input type="hidden" name="token" value="" id="token">
        </nav>
    </header>