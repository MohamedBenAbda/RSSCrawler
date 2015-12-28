<?php
session_start();
$nn = '';

if ($_SESSION['role']=='user') {
    
    header('Location:login.php');
}
if ($_SESSION['name']  ) {

    //echo 'Bienvenu :' . $_SESSION['name'];
} else {
    header('Location:Login.php');
}
if (isset($_POST['submit'])) {


    $name = $_POST['name'];
    $link = $_POST['link'];
    //$link = "http://feeds.gawker.com/lifehacker/full";
    $nbrMots = $_POST['nbrMots'];



    if (isset($_POST['link'])) {
        $connect = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $result = mysqli_query($connect, "SELECT * FROM links WHERE link = '$link'");
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $nn = $row['name'];

            $id = $row['id_link'];
            $nbr = $row['nbr_mots'];
            $n = $row['name'];
            echo ' name ' . $n . '<br>';
            echo ' id' . $id . '<br>';
            echo ' nbr  db' . $nbr . '<br>';
            echo ' nbr set ' . $nbrMots . '<br>';

            if ($nbr != $nbrMots) {

                $sql = "UPDATE links SET nbr_mots='$nbrMots' WHERE id_link='$id'";

                if (mysqli_query($connect, $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            } else {
                echo 'no thing to do ';
            }
        } else {

            if ($nbrMots && $link && $name) {


                $query = "INSERT INTO links VALUES('','$link','$nbrMots','$name')";
                $result1 = mysqli_query($connect, $query);

                if ($result1) {
                    echo 'succee insertion';
                }
            } else {
                echo 'veilez saisir tous les champs ';
            }
        }
    }
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

        <title> Rss-Crawler Admin </title>

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

                    <p class="GrandTitre"> Add Links  </p>                      

                </section>

               
                <section class="content">


                    <div class="row">

                        <div class="box box-primary">

                            <form method="POST" action="Admin.php">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Links</label>
                                        <input type="text" name="link"class="form-control"  placeholder="Enter link">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Name</label>
                                        <input type="text"  name="name"class="form-control"  placeholder="<?php echo $nn; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Number of Words</label>
                                        <input type="number" name="nbrMots" min="5" max="15">
                                    </div>

                                </div>
                               

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary"  name="submit">Submit</button>
                                </div>
                            </form>
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





























