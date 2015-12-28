<?php
if (isset($_POST['submit'])) {

    $username = htmlentities(trim($_POST['username']));
    $password = htmlentities(trim($_POST['password']));
    $repeatPassword = htmlentities(trim($_POST['repeatPassword']));
    $role = htmlentities(trim($_POST['role']));

    if ($username && $password && $repeatPassword && $role) {

        if ($password == $repeatPassword) {

            $password = (md5($password));
            $connect = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');

            $reg = "Select * from users where username='$username'";
            $row = mysqli_query($connect, $reg);

            if (mysqli_num_rows($row) == 0) {

                $query = "INSERT INTO users VALUES('','$username','$password','$role')";
                $result = mysqli_query($connect, $query);

                if ($result) {
                    echo '<script language="javascript">';
                    echo 'alert("Registration successfully completed")';
                    echo '</script>';
                    
                    header('Location:Login.php');
                }

               // die("Registration successfully completed <a href='Login.php'>Sign In</a>");
            } else {
                echo '<script language="javascript">';
                echo 'alert("This username is not available")';
                echo '</script>';
            }
        } else {
            echo '<script language="javascript">';
            echo 'both password must be identical';
            echo '</script>';
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
        <title>Registration Page</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    </head>

    <body  background="IMG/book-and-pen.jpg" class="hold-transition register-page">
        <div class="register-box">

            <div class="register-logo">
                <a href="#"><b>ATS </b>Digital Dev</a>
            </div>

            <div class="register-box-body">

                <p class="login-box-msg">Register a new membership</p>

                <form method="POST" action="Register.php">

                    <div class="form-group has-feedback">
                        <input type="text" name="username" placeholder="Name" required class="form-control" >
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="repeatPassword" class="form-control" placeholder="Retype password">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>

                    <div form-group has-feedback>

                        <div class="form-group">

                            <div class="radio">
                                <label for="radioOne" class="radio" chec>
                                    <input type="radio" value="admin" id="radioOne" name="role" checked/>
                                    Administrator 
                                </label>
                            </div>

                            <div class="radio">
                                <label for="radioTwo" class="radio">
                                    <input type="radio" value="user" id="radioTwo" name="role" />
                                    User
                                </label>
                            </div>

                        </div>

                        <div class="col-xs-4">
                            <button type="submit"  name="submit"class="btn btn-primary btn-block btn-flat">Register</button>
                        </div>

                    </div>
                </form>

                <a href="Login.php" class="text-center">I already have a membership</a>
            </div>

        </div>

        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>




