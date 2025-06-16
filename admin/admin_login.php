<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>AgroLink - Admin Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/fa/css/all.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark text-white">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Admin Login</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Display error or feedback messages
                                    if (isset($_SESSION["errormsg"])) {
                                        echo "<p class='alert alert-danger'>" . $_SESSION["errormsg"] . "</p>";
                                        unset($_SESSION['errormsg']);
                                    }
                                    if (isset($_SESSION["feedback"])) {
                                        echo "<div class='alert alert-danger'><p>" . $_SESSION["feedback"] . "</p></div>";
                                        unset($_SESSION['feedback']);
                                    }
                                    // echo "<pre>";
                                    // print_r($_SESSION);
                                    // echo "</pre>";
                                    // exit;
                                    ?>
                                    <form action="process/process_adminlogin.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control text-white bg-dark" id="username" type="text" placeholder="Username" name="admin_username" required />
                                            <label for="admin_username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control bg-dark text-white" id="inputPassword" type="password" placeholder="Password" name="admin_password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-success col-12" name="btnlogin">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-success  mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-white">Copyright &copy; AgroLink 2023</div>
                        <div class="text-white">
                            <a href="#" class="text-white text-decoration-none">Privacy Policy</a>
                            &middot;
                            <a href="#" class="text-white text-decoration-none">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>