<?php include_once 'simple_html_dom.php'; ?>


<!DOCTYPE html>

<html>
    <head>

        <meta charset="UTF-8">
        <title> Proof-of-concept - Ben Abda Mohamed </title>
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="http://www.amcharts.com/lib/3/serial.js"></script>
        <script src="http://www.amcharts.com/lib/3/themes/light.js"></script>
    </head>
    <body style="background-color: #AFAFAF">

        <?php
        // $RSSLinkErr = "";
        $RSSLink = "";

        if (empty($_POST["RSSLink"])) {
            $RSSLink = "";
        } else {
            $RSSLink = test_input($_POST["RSSLink"]);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>



        <div id="divGlobale">

            <div class="div_Haut">

                <div class="left-2"><p class="GrandTitre"> RSS Crawler  </p></div>

                <div >
                    <img src="IMG/ATS.png" style="border-radius:5px 5px 5px 5px;box-shadow:10px 10px 10px #888888; width: 100px;height: 100px;"  />
                </div>

            </div>
            <div id="div_Link">

                <fieldset id="fieldsetLink">
                    <legend> RSS Link </legend> 

                    <div class="div-1">
                        <div class="left-1">
                            <label >Please enter the RSS link  :</label> 
                        </div>
                        <div class="right-1">

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 

                                <input type="text" name="RSSLink" size='50' placeholder=" Copier le lien ici " value="<?php echo $RSSLink; ?>">
                                <span class="error"></span>                            

                            </form>

                        </div>
                    </div>
                </fieldset >
            </div>


            <div id="div-center">
                <fieldset id="fieldsetCenter">
                    <legend>  Bar Chart  </legend> 
                    <div id="chartdiv"></div></br>
                    <p style=" font-size: large;color:#046380;text-align : center ;"> This graph shows the frequency of the 10 most used words occurrence in the link articles </p> 
                </fieldset >
            </div>

            <div class="divCopyright"><p class="copyright">  Copyright©MohamedBenAbda </p></div>

        </div>



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

        // $RSSLink="http://feeds.gawker.com/deadspin/full";
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
            if ($i < 10) {
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
        //  print_r($table_final);
        ?>


    </body>
</html>
