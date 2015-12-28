
<?php
session_start();
$nn = '';
if ($_SESSION['role']=='user') {
    
    header('Location:login.php');
}

if ($_SESSION['name']) {

    //echo 'Bienvenu :' . $_SESSION['name'];
} else {
    header('Location:Login.php');
}

if (isset($_POST['logout'])) {

    session_start();
    session_destroy();
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title> List of Links </title>
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">    
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">     
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">

                <a href="#" class="logo">
                    <span class="logo-mini"><b>A</b>TS</span>
                    <span class="logo-lg"><b>ATS </b>Digital Dev</span>
                </a>

                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <li class="dropdown user user-menu">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/avatar5.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs">
                                        <?php
                                        if ($_SESSION['name']) {

                                            echo 'Welcom : ' . $_SESSION['name'];
                                        }
                                        ?> 
                                    </span>
                                </a>

                            </li>

                            <li>
                                <a href="Login.php" class="dropdown-toggle">
                                    <form method="post" action="User.php"> 
                                        <input type="submit" value="Sign out"  name="logout">
                                    </form>
                                    <?php
                                    //session_destroy();
                                    ?></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">

                <section class="sidebar">

                    <ul class="sidebar-menu">
                        <li class="header">

                            <?php
                            echo '' . $_SESSION['role'];
                            ?> 
                        </li>
                        <li class="active"><a href="Admin.php"><i class="fa fa-link"></i> <span>Add Links</span></a></li>
                        <li class="active"><a href="LinksList.php"><i class="fa fa-link"></i> <span>List of links</span></a></li>

                    </ul>

                </section>

            </aside>

            <div class="content-wrapper">

                <section class="content-header">
                    <p class="GrandTitre"> List of Links  </p>                      
                </section>

                <section class="content">

                    <div class="row">

                        <div class="box box-primary">
                            
                                <table class="table table-hover">
                                    <tr>
                                        <th>Name</th>
                                        <th>Link</th>
                                        <th>Number of words</th>

                                    </tr>
                                    <?php
                                    $connect = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');
                                    $query = "Select * from links";
                                    $result = mysqli_query($connect, $query);

                                    while ($array[] = $result->fetch_object());
                                    array_pop($array);




                                    foreach ($array as $row) :
                                        echo '<tr>';

                                        //$mysqltime = date("Y-m-d H:i:s", $row->date);

                                        echo '<td>';
                                        echo '' . $row->name;
                                        echo '</td>';

                                        echo '<td>';
                                        echo '' . $row->link;
                                        echo '</td>';

                                        echo '<td>';
                                        echo '' . $row->nbr_mots;
                                        echo '</td>';

                                        echo '</tr>';

                                    endforeach;
                                    //echo '' . $nbr;
                                    ?>

                                </table>
                            </div>
                      
                    </div>

                </section>

            </div>         

            <footer class="main-footer">
                <p class="copyright">  Copyright©MohamedBenAbda </p>
            </footer>

        </div>

        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="http://www.amcharts.com/lib/3/serial.js"></script>
        <script src="http://www.amcharts.com/lib/3/themes/light.js"></script>

    </body>
</html>





























