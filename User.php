<?php include_once 'simple_html_dom.php'; ?>

<!DOCTYPE html>

<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title> Rss-Crawler User</title>
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">    
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">     
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">


    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <?php
        session_start();
        
        $nbr = '';
        
        if ($_SESSION['role'] == 'admin') {

            header('Location:login.php');
        }

        if ($_SESSION['name']) {

            // echo 'Bienvenu :' . $_SESSION['name'];
        } else {
            header('Location:Login.php');
        }
       
        $id_user = $_SESSION['id_user'];

        $connect = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');
        $query = "Select * from links";
        $result = mysqli_query($connect, $query);

        while ($array[] = $result->fetch_object());
        array_pop($array);

        if (isset($_POST['submit'])) {

            $RSSLink = $_POST['RSSLink'];

            $res = mysqli_query($connect, "SELECT * FROM links WHERE link = '$RSSLink'");

            if (mysqli_num_rows($res) == 1) {

                while ($row1 = mysqli_fetch_assoc($res)) {

                    $id_link = $row1['id_link'];

                    $nbr = $row1['nbr_mots'];
                }
             
            } else {
                echo ' you chould select link';
            }

            $con = mysqli_connect('localhost', 'root', '', 'rss_crawler') or die('DB Connection error');
            $nowFormat = date('Y-m-d H:i:s');
            $query2 = "INSERT INTO user_link VALUES('','$id_link','$id_user','$nowFormat')";
            $result2 = mysqli_query($con, $query2);

            if ($result2) {
                // echo 'succee insertion user link';
                $user_link_id = mysqli_insert_id($con);
                // echo "New record has id: " . mysqli_insert_id($con);
            }
        }

        if (isset($_POST['historic'])) {

            session_start();
            header('Location:Historic.php');
        }
        if (isset($_POST['logout'])) {

            session_start();
            session_destroy();
            header('Location:login.php');
        }
        ?>

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

                        <li class="active"><a href="User.php"><i class="fa fa-link"></i> <span>Home</span></a></li>
                        <li class="active"><a href="Historic.php"><i class="fa fa-link"></i> <span>Historic</span></a></li>

                    </ul>

                </section>

            </aside>

            <div class="content-wrapper">

                <section class="content-header">


                    <p class="GrandTitre"> RSS Crawler  </p>                      


                </section>

                <section class="content">


                    <fieldset id="fieldsetLink">
                        <legend> RSS Link </legend> 

                        <div class="div-1">
                            <div class="left-1">
                                <label style="color:#046380;">Please enter the RSS link  :</label> 
                            </div>
                            <div class="right-1">

                                <form method="post" action="User.php"> 

                                    <select name='RSSLink'>
                                        <?php foreach ($array as $option) : ?>    
                                            <option value="<?php echo $option->link; ?>"><?php echo $option->link; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <input type="submit" value="treat" name="submit">


                                </form>

                            </div>
                        </div>
                    </fieldset >

                    <fieldset id="fieldsetCenter">
                        <legend>  Bar Chart  </legend> 
                        <div id="chartdiv"></div></br>
                        <p style=" font-size: large;color:#046380;text-align : center ;"> <?php
                            echo 'This graph shows the frequency of the ' . $nbr . ' most used words occurrence in the link articles';
                            ?>
                        </p> 
                    </fieldset >

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

        function multiexplode($delimiters, $string) {
            $ready = str_replace($delimiters, $delimiters[0], $string);
            $launch = explode($delimiters[0], $ready);
            return $launch;
        }

        function occurence($mot, &$tab_mot, &$tab_occurence) {
            $i = 0;
            foreach ($tab_mot as $value) {
                if ($mot == $value) {
                    $tab_occurence[$i] = $tab_occurence[$i] + 1;
                    return;
                }
                $i++;
            }
            $tab_mot[] = $mot;
            $tab_occurence[] = 1;
        }

//$RSSLink="http://feeds.gawker.com/deadspin/full";
        //  echo '' . $RSSLink;
        $content = file_get_contents($RSSLink);


        $x = new SimpleXmlElement($content);


        $tab_mot = array();
        $tab_occurence = array();


        foreach ($x->channel->item as $entry) {
            $html = str_get_html($entry->description . "");
            foreach ($html->find('p[class=first-text]') as $p) {
                $p_without_tags = strip_tags($p);
                $words = multiexplode(array('"', ' ', '.', '|', ',', '?', '!', '—', '“'), $p_without_tags);
                foreach ($words as $mot) {
                    if (strlen($mot) >= 5) {

                        occurence($mot, $tab_mot, $tab_occurence);
                    }
                }
            }
        }

        function permute(&$val1, &$val2) {
            $inter = $val1;
            $val1 = $val2;
            $val2 = $inter;
        }

        function sort_array(&$array1, &$array2) {
            for ($i = 0; $i < sizeof($array1); $i++) {
                for ($j = 0; $j < sizeof($array1); $j++) {
                    if ($array1[$i] > $array1[$j]) {
                        permute($array1[$i], $array1[$j]);
                        permute($array2[$i], $array2[$j]);
                    }
                }
            }
        }

        sort_array($tab_occurence, $tab_mot);
        $table_final = array("mots" => $tab_mot, "occurence" => $tab_occurence);
        echo' <script>
          var chart = AmCharts.makeChart( "chartdiv", {
            "type": "serial",
            "theme": "light",
            "dataProvider": [';
        for ($i = 0; $i < sizeof($tab_mot); $i++) {
            if ($i < $nbr) {

                $query3 = "INSERT INTO mots VALUES('','$tab_mot[$i]','$tab_occurence[$i]','$user_link_id')";
                $result3 = mysqli_query($connect, $query3);

                ///////////////////////////////////////////////////////////////////////
                echo'  {
        "country": "' . $tab_mot[$i] . '",
        "visits": ' . $tab_occurence[$i] . '},';
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

        } );';
        echo '</script>';

        ?>

    </body>
</html>
