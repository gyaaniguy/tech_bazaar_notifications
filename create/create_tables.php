<?php require_once("../includes/connection.php"); ?>
<?php
    $query = "CREATE TABLE all_addresses (
            id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            address VARCHAR( 250 ) NOT NULL ,
            title VARCHAR( 250 ) NOT NULL  ,
            time_stamp TIMESTAMP NOT NULL
            ) "; 
	mysql_query($query);
	echo mysql_error() ;
			
			    $query = "CREATE TABLE search_data (
            id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            address VARCHAR( 250 ) NOT NULL ,
            title VARCHAR( 250 ) NOT NULL  ,
            time_stamp TIMESTAMP NOT NULL,
            fulltext(title) 
            ) ENGINE = MYISAM "; 
	mysql_query($query);
	echo mysql_error() ;
	
			    $query = "CREATE TABLE emails (
            id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            email VARCHAR( 250 ) NOT NULL 
            ) "; 
	mysql_query($query);
	echo mysql_error() ;
	
	    $query = "CREATE TABLE keywords (
            id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            keyword VARCHAR( 250 ) NOT NULL ,
            email_id INT( 11 ) NOT NULL  
            ) "; 
	mysql_query($query);
	echo mysql_error() ;
	
	$query = "CREATE TABLE downloadnumber (
            id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            application_name VARCHAR( 40 ) NOT NULL ,
            downloads INT(11) NOT NULL ,
            ip_address VARCHAR( 40 )  NULL
            ) "; 
	mysql_query($query);
	echo mysql_error() ;
	
	echo "Done!" ;
	
?>

<?php mysql_close($connection); ?>