<?php require_once("../includes/connection.php"); ?>

<?php 

	$daystokeep =  24*3600*90 ;
	$result = mysql_query("DELETE FROM all_addresses WHERE Unix_Timestamp(time_stamp)+{$daystokeep} < Unix_Timestamp(now())" , $connection);
	
	mysql_close($connection) ;
   
        
	
?>