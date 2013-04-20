<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/fetch_functions.php"); ?>
<?php require_once("includes/class.phpmailer-lite.php"); ?>
<?php

     include("includes/LIB_http.php")  ;
     include("includes/LIB_parse.php")  ;
     include("includes/simple_html_dom.php") ;
    
    
    $target = "http://www.rimweb.in/forums/forum/50-buy-sell-bazaar/" ;
    $rimweb = rimweb($target) ;
     FetchAddPost($rimweb) ;
    
     $target = "http://www.erodov.com/forums/bazaar/classifieds-sale/" ;
    $ref = "http://www.thinkdigit.com" ;
    $erodov = erodov($target) ;
    FetchAddPost($erodov) ;
    
     $target = "http://www.erodov.com/forums/bazaar/classifieds-wanted/" ;
     $erodov = erodov($target) ;
     FetchAddPost($erodov) ;
    
    $target = "http://www.erodov.com/forums/bazaar/dealer-community-market/" ;
    $erodov = erodov($target) ;
    FetchAddPost($erodov) ;
   
    $target = "http://www.jjmehta.com/forum/index.php?board=8.0" ;
    $jjmehta =  jjmehta($target) ;
    FetchAddPost($jjmehta) ;
    
     $target = "http://forums.techarena.in/buy-sell-computer-hardware/" ;
     $techarena =   techarena($target) ;
     FetchAddPost($techarena) ;
     
    $target = "http://www.thinkdigit.com/forum/bazaar/" ;
    $think = thinkdigit($target) ;
    FetchAddPost($think) ;
    

   
   $target = "http://www.techenclave.com/members-market/" ;
    $techenclave = techenclave($target) ;
   FetchAddPost($techenclave) ;
    
    
   $target = "http://www.techenclave.com/phones-and-gadgets/" ;
    $techenclave = techenclave($target) ;
    FetchAddPost($techenclave) ;
    
    
   $target = "http://www.techenclave.com/cpu-mobo-and-ram/" ;
    $techenclave = techenclave($target) ;
    FetchAddPost($techenclave) ;
    
    
   $target = "http://www.techenclave.com/video-and-audio-hardware/" ;
    $techenclave = techenclave($target) ;
    FetchAddPost($techenclave) ;
    
      
    
   $target = "http://www.techenclave.com/storage/" ;
    $techenclave = techenclave($target) ;
    FetchAddPost($techenclave) ;
    
   $target = "http://www.techenclave.com/games-and-consoles/" ;
    $techenclave = techenclave($target) ;
    FetchAddPost($techenclave) ;
    
    
  
   $target = "http://www.hifivision.com/sale-owner/" ;
    $techenclave = hifivision($target) ;
    FetchAddPost($techenclave) ;
      
   $target = "http://www.hifivision.com/sale-dealer/" ;
    $techenclave = hifivision($target) ;
    FetchAddPost($techenclave) ;
      
   $target = "http://www.hifivision.com/wanted/" ;
    $techenclave = hifivision($target) ;
    FetchAddPost($techenclave) ;
    
  
  
    ?>

<?php
    
    
        $query = "SELECT * FROM emails" ;
        $email_resultset = mysql_query($query, $connection);
        confirm_query($email_resultset) ;
        $emails_row_array = array() ;
        while ( $emails_row = mysql_fetch_array($email_resultset) ) 
        {
        echo "</br>making array</br>" ;
        
        $emails_row_array[] = $emails_row ;
        }
        
        foreach ($emails_row_array as $email)
        // for ($email = 0 ; $email < 1 ; $email++ ) ;
        {
            // echo "email is- " . $email['email'] . $email['id'] . "</br>"   ;
            $sendmessage  = false ;
            $query = "SELECT * FROM keywords WHERE email_id={$email['id']} " ;
            unset($keywords_resultset) ;
            $keywords_resultset = mysql_query($query, $connection);
            confirm_query($keywords_resultset) ;
            
            while (  $key = mysql_fetch_array($keywords_resultset) ) 
            {
                $keywords_row_array[] = $key ;
            }
              
            $message = "<h1><center><a href='www.pc-tips.in'>Pc-tips.in</a> Notification </center></h1> <p> Found new thread containing your search terms</p>"  ;
            foreach ($keywords_row_array as $keyword )
            {  
                  global $sendmessage ;
                   
                   //search for search terms in search_data table
                  $wordtosearchfor  =  $keyword['keyword'] ;
                  $query = " SELECT * FROM search_data WHERE title like '%{$wordtosearchfor}%' " ;
                  $result = mysql_query($query, $connection);
                  confirm_query($result) ;
                 // echo "OUTPUTTING SEARCH RESUTLS-</br>" ;
                  // if found send mail
                  while ( $row = mysql_fetch_array($result) )
                  {
                    global $sendmessage ;
                    $sendmessage = true ;
                    $message .= "<p>" . $row['address'] . " </p></br>" ;
                    // echo "FOUND DATA- " . $row['address'] . "</br>"  ;
                  }
            }
            if ( $sendmessage == true )
            {
             $email_unsub = urlencode($email['email']) ;
              $message .= "</br></br><h3>To stop receiving notifications from pc-tips.in <a href='http://pc-tips.in/unsubscribe?email={$email_unsub}'>Click Here</a> </h3>" ;
              echo "sending mail " ;
              try 
              {
                $mail = new PHPMailerLite(); 
                 $mail->IsMail(); // telling the class to use native PHP mail()
                 $mail->SetFrom('admin@pc-tips.in', 'Nikhil jain');
                $mail->AddAddress($email['email']);
                $mail->Subject = 'New notification from Pc-tips.in';
                $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
                $mail->MsgHTML($message);
                $mail->Send();
                // echo $message ;
              } 
              catch (phpmailerException $e) 
              {
                echo $e->errorMessage(); //Pretty error messages from PHPMailer
              } catch (Exception $e) 
              {
                echo $e->getMessage(); //Boring error messages from anything else!
              }
              
              
            }
            if ( isset($keywords_row_array) )
                unset($keywords_row_array ) ;
        }
    
?>

<?php

    // transfer from search_data to all_addresses
    $query = "SELECT * FROM search_data " ;
    $searchdata_resultset = mysql_query($query,$connection) ;
    confirm_query($searchdata_resultset) ;
    while ($searchdata_row = mysql_fetch_array($searchdata_resultset))
    {
        $address = $searchdata_row['address'] ;
        $title = mysql_prep($searchdata_row['title']) ;
        $query = "INSERT INTO  all_addresses (address,title) VALUES ( '{$address}' , '{$title}' )" ;
        $result = mysql_query($query, $connection);
        confirm_query($result) ;
    }
    // empty fetch_data
    $query = "DELETE FROM search_data " ;
    $searchdata_resultset = mysql_query($query,$connection) ;
    confirm_query($searchdata_resultset) ;
    
?>