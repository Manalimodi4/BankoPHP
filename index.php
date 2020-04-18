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
            <div class="navbar-brand " >
                <img src="images/Banko.svg" height="30" alt="">
            </div>
        </nav>
    </header>
    <main class="h-100 d-flex">
        <section class="flex-fill align-self-center">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                        <div class="card rounded-xl py-3 rounded-lg shadow-lg">
                            <div class="card-body ">
                                <div class="px-0 px-md-4">
                                <div class="text-center display-4 mb-4 fs-2">
                                    Sign In
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword" required>
                                    </div>
                                    <div class="form-group pt-2 py-0">
                                        <button type="submit" class="btn btn-primary btn-block">Log In</button>
                                    </div>
                                </form>
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