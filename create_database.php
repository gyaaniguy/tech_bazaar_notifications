
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/fetch_functions.php"); ?>
<?php
    include("includes/LIB_http.php")  ;
    include("includes/LIB_parse.php")  ;
    include("includes/simple_html_dom.php") ;
 //   $ourFileName = "/home/appspcom/public_html/pc-tips.in/notification/testFile.txt";
 //   $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
 // fclose($ourFileHandle);
    
    set_time_limit(1000);
    $links_array = array() ;
    
    $target = "http://www.erodov.com/forums/bazaar/classifieds-sale/" ;
    $ref = "http://www.erodov.com" ;
      $erodov = erodov($target) ;
    addToDatabaseMethod($erodov) ;
  
    $target = "http://www.erodov.com/forums/bazaar/classifieds-wanted/" ;
    $erodov = erodov($target) ;
    addToDatabaseMethod($erodov) ;
    
    $target = "http://www.erodov.com/forums/bazaar/dealer-community-market/" ;
    $erodov = erodov($target) ;
    addToDatabaseMethod($erodov) ;
   
    $target = "http://www.jjmehta.com/forum/index.php?board=8.0" ;
     $jjmehta =  jjmehta($target) ;
    addToDatabaseMethod($jjmehta) ;
    
     $target = "http://forums.techarena.in/buy-sell-computer-hardware/" ;
     $techarena =   techarena($target) ;
     addToDatabaseMethod($techarena) ;
     
    $target = "http://www.thinkdigit.com/forum/bazaar/" ;
    $think = thinkdigit($target) ;
    addToDatabaseMethod($think) ;
    
    $target = "http://www.rimweb.in/forums/forum/50-buy-sell-bazaar/" ;
        $rimweb = rimweb($target) ;
    addToDatabaseMethod($rimweb) ;

  $target = "http://www.techenclave.com/members-market/" ;
    $techenclave = techenclave($target) ;
    addToDatabaseMethod($techenclave) ;
    
    
   $target = "http://www.techenclave.com/phones-and-gadgets/" ;
    $techenclave = techenclave($target) ;
    addToDatabaseMethod($techenclave) ;
    
    
   $target = "http://www.techenclave.com/cpu-mobo-and-ram/" ;
    $techenclave = techenclave($target) ;
    addToDatabaseMethod($techenclave) ;
    
       $target = "http://www.techenclave.com/video-and-audio-hardware/" ;
    $techenclave = techenclave($target) ;
    addToDatabaseMethod($techenclave) ;
    
    
   $target = "http://www.techenclave.com/storage/" ;
    $techenclave = techenclave($target) ;
    addToDatabaseMethod($techenclave) ;
    
    
   $target = "http://www.techenclave.com/games-and-consoles/" ;
    $techenclave = techenclave($target) ;
    addToDatabaseMethod($techenclave) ;
    
      $target = "http://www.hifivision.com/sale-owner/" ;
    $hifivision = hifivision($target) ;
    addToDatabaseMethod($hifivision) ;
    
      $target = "http://www.hifivision.com/wanted/" ;
    $hifivision = hifivision($target) ;
    addToDatabaseMethod($hifivision) ;
    
      $target = "http://www.hifivision.com/sale-dealer/" ;
    $hifivision = hifivision($target) ;
    addToDatabaseMethod($hifivision) ;
    
    
?>