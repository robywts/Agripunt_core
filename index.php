<?php
session_start();
if (isset($_POST) && isset($_POST['email']) && isset($_POST['password'])) {
    include("config.php");

    $username = $_POST['email'];
    $password = trim($_POST['password']);
    if (($username == '') || ($password = '')) {
        echo "<script type='text/javascript'>alert('Please Enter Email and Password!'); </script>";
        return;
    }
    $sql = "SELECT * FROM users WHERE email='$username'";
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) != 0) {
        $rs = mysqli_fetch_assoc($query);

        if (password_verify($_POST['password'], $rs['password'])) {

            $_SESSION['login_user'] = $username;
            $_SESSION['login_user_id'] = $rs['id'];
            $_SESSION['login_user_type'] = $rs['type'];
            if ($rs['type'] == 1)
                echo "<script language='javascript' type='text/javascript'> location.href='dashboard.php' </script>";
            else
                echo "<script language='javascript' type='text/javascript'> location.href='articles/index.php' </script>";
        } else {
            echo "<script type='text/javascript'>alert('Email Or Password Invalid!'); </script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Email Or Password Invalid!'); </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Agripunt Login</title>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
    </head>

    <body class="bg-dark">
        <div class="container login">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header"><img src="images/logo.png"></div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input class="form-control" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input class="form-control" id="exampleInputPassword1" name="password" type="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"> Remember Password</label>
                            </div>
                        </div>
                        <a class="btn btn-primary btn-block" id="login" name="submit" href="javascript:;" onclick="$(this).closest('form').submit()">Login</a>
                    </form>
                    <div class="text-center mt10">

                        <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    </body>
</html>
