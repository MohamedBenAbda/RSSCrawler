<?php
session_start();
if (isset($_POST['submit'])) {

    $username = htmlentities(trim($_POST['username']));
    $password = htmlentities(trim($_POST['password']));

    if ($username && $password) {

        $password = (md5($password));
        $connect = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');

        $reg = "Select * from users where username='$username'and password='$password'";

        if ($result = mysqli_query($connect, $reg)) {

            if (mysqli_num_rows($result) == 1) {

                while ($row = mysqli_fetch_assoc($result)) {

                    $name = $row['username'];
                    $role = $row['role'];
                    $id_user = $row['id'];

                    //echo '' . $name . '<br>';
                    //echo '' . $role . '<br>';

                    if ($name && $role && $id_user) {
                        $_SESSION['name'] = $name;
                        $_SESSION['role'] = $role;
                        $_SESSION['id_user'] = $id_user;

                        if (strcmp($role, "admin") == 0) {
                            header("Location:Admin.php");
                        }

                        if (strcmp($role, "user") == 0) {
                            header("Location:User.php");
                        }
                    }
                }

                // header("Location:index.php");
            } else {
                echo '<script language="javascript">';
                echo 'alert("incorrect username or password")';
                echo '</script>';
            }
        }
    } else {
        echo '<script language="javascript">';
        echo 'Please complete all fields';
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Log in</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    </head>

    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="#"><b>ATS </b>Digital Dev</a>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="POST" action="Login.php">
                    <div class="form-group has-feedback">
                        <input type="text" name="username" placeholder="Name" required class="form-control" >
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div form-group has-feedback>
                        <div class="col-xs-4">
                            <button type="submit"  name="submit"class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    </div>
                </form>
                
                <a href="Register.php" class="text-center">Register a new membership</a>
            </div>            
        </div>
       
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>  
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>




