<?php
require_once 'connection.php';

if(isset($_POST['signin'])) {
    $response = db_signin($_POST['username'], $_POST['password']);
}

require_once 'components/header.php';
?>
    <main class="h-100 d-flex">
        <section class="flex-fill align-self-center">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2">
                        <div class="card rounded-xl py-3 rounded-lg shadow-lg">
                            <div class="card-body ">
                                <div class="px-0 px-md-4">
                                <div class="text-center display-4 mb-4 fs-2">
                                    Sign In
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword" required>
                                        <small id="passwordHelp" class="form-text text-muted text-danger" style="display: none">Incorrect Password</small>
                                    </div>
                                    <script>
                                        var e  = document.querySelector("#passwordHelp");
                                        if(typeof(invalidPassword) != "undefined") {
                                            e.style.display = "block";
                                        }
                                        </script>
                                    <div class="form-group pt-2 py-0">
                                        <input type="submit" name="signin" class="btn btn-primary btn-block" value="Log In">
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>

</body>

</html>