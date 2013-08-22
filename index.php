<html>
<head><title>Search indian tech bazaar forums in one place</title>
    <style>
        body {
            background-color: grey;
            color: rgb(219, 224, 219);
            font-size: 1.2em;
        }

        #container {
            -moz-box-shadow: 0px 3px 10px #000;
            -webkit-box-shadow: 0px 3px 10px #000;
            box-shadow: 0px 3px 10px #000;
            margin: 0 auto;
            width: 900px;
            background-color: rgb(46, 77, 50);
            padding: 10px;

        }

        h1 {
            color: rgb(65, 180, 79);
        }

        a {
            color: lightblue;
        }

        .right {
            float: right;
        }

        table {
            margin: 0 auto;
            background-color: rgb(51, 102, 71);
            width: 850px
        }

        table td {
            padding: 6px;
        }

        h6 {
            font-family: "Book Antiqua";
        }
    </style>
</head>
<body>

<div id="container">
    <h1>Indian Tech Bazaar forums combined page.</h1>

    <p>There are various indian forums on which people exchange various tech products (computer parts, audio, cameras
        etc). This page attempts to combine them into
        one page, so that instead of having to visit each forum, you can just visit this one page and get to know about
        all the latest tech stuff that people are selling / wanting to buy. </p>

    <div class="right">- Coded by Nikhil Jain</div>
    <?php

    require_once("includes/connection.php");
    require_once("includes/functions.php");
    require_once("includes/ps_pagination.php");

    date_default_timezone_set('Asia/Calcutta');


    echo "<h3>Search:</h3>";
    echo "<form method='get' class='searchform1'  action=''> ";
    echo "<input type='text' size='40' name='search_query' class='textbox'> ";
    echo "<input type='submit' name='search' value=' Search '> </form>";
    echo 'Another of my site:  <a href="http://www.discountghar.in">Discountghar.in- The place for all flipkart discounts.</a> ';

    echo "</br>";

    if (isset($_GET['search'])) {
        $query = "UPDATE  downloadnumber SET downloads = downloads+1 WHERE application_name='bazaarsearchcounter' ";
        mysql_query($query, $connection);
        echo "<br/>";
        echo "<a href='index.php'>Back to listings</a>";
        $searchterm = $_GET['search_query'];
        $query = "select * FROM  all_addresses WHERE title like '%{$searchterm}%' ORDER BY time_stamp DESC ";
        $pager = new PS_Pagination($connection, $query, 100, 5, "gonotify=1");
        $pager->setDebug(true);
        $resultset = $pager->paginate();

        if (!$resultset) die(mysql_error());

        echo "<table>";
        echo "<tr> <th>Forum</th><th>Thread Title</th><th>Fetched On</th></tr>";

        while ($result_row = mysql_fetch_array($resultset)) {
            $address = $result_row['address'];
            $title = $result_row['title'];
            $time_stamp = $result_row['time_stamp'];
            $time = date("F j, Y ", strtotime($time_stamp));
            echo "<tr>";
            if (stristr($address, "techenclave")) {
                echo "<td>Techenclave</td>";
            }
            if (stristr($address, "erodov")) {
                echo "<td>erodov</td>";
            }
            if (stristr($address, "thinkdigit")) {
                echo "<td>thinkdigit</td>";
            }
            if (stristr($address, "jjmehta")) {
                echo "<td>jjmehta</td>";
            }
            if (stristr($address, "rimweb")) {
                echo "<td>rimweb</td>";
            }
            if (stristr($address, "techarena")) {
                echo "<td>techarena</td>";
            }
            if (stristr($address, "hifivision")) {
                echo "<td>hifivision</td>";
            }
            echo " <td><a href={$address}>$title</a></td><td>{$time}</td></tr>";
        }
        echo "</table></br> ";
        echo $pager->renderFullNav();
    } else {
        $query = "UPDATE  downloadnumber SET downloads = downloads+1 WHERE application_name='bazaarcounter' ";
        mysql_query($query, $connection);

        echo "<h3 style='float:left ; ' >Listing all threads by time</h3>";


        $query = "select * FROM  all_addresses ORDER BY time_stamp DESC ";
        $pager = new PS_Pagination($connection, $query, 50, 5, "gonotify=1");
        $pager->setDebug(true);
        $resultset = $pager->paginate();

        if (!$resultset) die(mysql_error());
        //$resultset = mysql_query($query,$connection) ;
        //confirm_query(resultset) ;
        echo "<table style='clear:both'>";
        echo "<tr> <th>Forum</th><th>Thread Title</th><th>Fetched On</th></tr>";

        while ($result_row = mysql_fetch_array($resultset)) {

            $address = $result_row['address'];
            $title = $result_row['title'];
            $time_stamp = $result_row['time_stamp'];
            $time = date("F j, Y ", strtotime($time_stamp));
            echo "<tr>";
            if (stristr($address, "techenclave")) {
                echo "<td>Techenclave</td>";
            }
            if (stristr($address, "erodov")) {
                echo "<td>erodov</td>";
            }
            if (stristr($address, "thinkdigit")) {
                echo "<td>thinkdigit</td>";
            }
            if (stristr($address, "jjmehta")) {
                echo "<td>jjmehta</td>";
            }
            if (stristr($address, "rimweb")) {
                echo "<td>rimweb</td>";
            }
            if (stristr($address, "techarena")) {
                echo "<td>techarena</td>";
            }
            if (stristr($address, "hifivision")) {
                echo "<td>hifivision</td>";
            }

            echo " <td><a href={$address}>$title</a></td><td>{$time}</td></tr>";
        }
        echo "</table></br> ";
        echo $pager->renderFullNav();

    }
    ?>
</div>
</body>
</html>
