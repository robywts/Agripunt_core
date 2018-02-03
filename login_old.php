<?php
include("config.php");
session_start();
$username = $_POST['email'];
$password = trim($_POST['password']);
$_SESSION['login_user'] = $username;
$sql = "SELECT * FROM users WHERE email='$username'";
$query = mysqli_query($con, $sql);
if (mysqli_num_rows($query) != 0) {
    $rs = mysqli_fetch_assoc($query);

    if (password_verify($_POST['password'], $rs['password'])) {
        echo "<script language='javascript' type='text/javascript'> location.href='dashboard.html' </script>";
    } else {
        echo "<script type='text/javascript'>alert('User Name Or Password Invalid!'); location.href='login.html'</script>";
    }
}

?>