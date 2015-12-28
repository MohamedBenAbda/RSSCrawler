<?php
session_start();
//echo ''.$_SESSION['role'];
if ($_SESSION['role']=='admin') {
    
    header('Location:login.php');
}
$id_user = $_SESSION['id_user'];

?>

<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title> Historic </title>
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
                                </a>
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

                        <li class="active"><a href="User.php"><i class="fa fa-link"></i> <span>Home</span></a></li>
                        <li class="active"><a href="Historic.php"><i class="fa fa-link"></i> <span>Historic</span></a></li>
                    </ul>
                </section>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <p class="GrandTitre"> historic </p>                      
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Your historic</h3>

                                    <div class="box-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Link</th>
                                            <th>Date</th>
                                            <th>See Bar Chart</th>

                                        </tr>
                                        <?php
                                        $connect = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');
                                        $query = "Select * from user_link WHERE id_user = '$id_user'";
                                        $result = mysqli_query($connect, $query);

                                        while ($array[] = $result->fetch_object());
                                        array_pop($array);




                                        foreach ($array as $row) :
                                            echo '<tr>';

                                            //$mysqltime = date("Y-m-d H:i:s", $row->date);

                                            echo '<td>';

                                            $result1 = mysqli_query($connect, "SELECT * FROM links WHERE id_link = '$row->id_link' LIMIT 1");
                                            $link = mysqli_fetch_assoc($result1);

                                            if ($link) {
                                                echo '' . $link['name'];
                                            }
                                            echo '</td>';

                                            echo '<td>';
                                            echo '' . $row->date;
                                            echo '</td>';

                                            echo '<td>';
                                            echo '        <form method="post" action="Historic.php"> 
            <input type="submit" value="See" name="voir">
			<input type="hidden" name="name" value="' . $row->id . '" />

        </form>';
                                            echo '</td>';

                                            echo '</tr>';

                                        endforeach;
                                        ?>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>


                    <div id="chartdiv"></div></br>

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

        <?php
        if (isset($_POST['voir'])) {
            //echo ''.$nbr;
            //$_SESSION['nbr']=$nbr;
            $query1 = "Select * from mots Where id_user_link=" . $_POST['name'] . " ORDER BY occurence DESC";
            $result1 = mysqli_query($connect, $query1);

            while ($array1[] = $result1->fetch_object());
            array_pop($array1);

            $tab_mot = array();
            $tab_occurence = array();

            foreach ($array1 as $mot) :

                $tab_mot[] = $mot->mot;
                $tab_occurence[] = $mot->occurence;
                // echo '' . $mot->mot . '<br>';
                // echo '' . $mot->occurence . '<br>';
            endforeach;
            // echo 'aaaaaaaaaaaaaaaaaaaaaa';
            //print_r($tab_mot);

            echo' <script>
        var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
                "theme": "light",
                "dataProvider": [';
            for ($i = 0; $i < sizeof($tab_mot); $i++) {
                if ($i < sizeof($tab_mot)) {

                    echo'  {
                        "country": "' . $tab_mot[$i] . '",
                        "visits": ' . $tab_occurence[$i] . '}, ';
                }
            }
            echo '],
                        "valueAxes": [ {
                        "gridColor": "#FFFFFF",
                                "gridAlpha": 0.2,
                                "dashLength": 0
                        } ],
                        "gridAboveGraphs": true,
                        "startDuration": 1,
                        "graphs": [ {
                        "balloonText": "[[category]]: <b>[[value]]</b>",
                                "fillAlphas": 0.8,
                                "lineAlpha": 0.2,
                                "type": "column",
                                "valueField": "visits"
                        } ],
                        "chartCursor": {
                        "categoryBalloonEnabled": false,
                                "cursorAlpha": 0,
                                "zoomable": false
                        },
                        "categoryField": "country",
                        "categoryAxis": {
                        "gridPosition": "start",
                                "gridAlpha": 0,
                                "tickPosition": "start",
                                "tickLength": 20
                        },
                        "export": {
                        "enabled": true
                        }

                }); ';
            echo '</script>';
        }
        ?>

    </body>
</html>