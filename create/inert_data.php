<?php require_once("../includes/connection.php"); ?>
<?php

    // into worker_name
    $query = "INSERT INTO downloadnumber (application_name, downloads) 
        VALUES ( 'bazaarsearchcounter',0 )";
        mysql_query($query);
        echo mysql_error() ;
    
        $query = "INSERT INTO downloadnumber (application_name, downloads) 
        VALUES ( 'bazaarcounter',0 )";
        mysql_query($query);
        echo mysql_error() ;
    
    
    
?>

<?php mysql_close($connection); ?>

       

