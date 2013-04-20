<?php
set_time_limit(1000);
  
  /////////////////////////////////////////
  //EDIT HERE
  /////////////////////////////////////////
    $techenclave_user = "YOUR TECENCLAVE USERNAME" ;
    $techenclave_pass = "YOUR TECHENCLAVE PASSWORD" ;
    
  /////////////////////////////////////////
  //FUNCTIONS START
  /////////////////////////////////////////  
    function FetchAddPost($array)
    {
        global $connection ;
        $address_row_array = array() ;
        $query = "SELECT address FROM all_addresses" ;
        $addresses_resultset = mysql_query($query,$connection) ;
        confirm_query($addresses_resultset) ;
        
        while ( $address_row_array[] = mysql_fetch_array($addresses_resultset) ) 
        {}
        
        foreach ($array as $new_address)
        {
            $addToDatabase = true ;
            // echo "count- " . $new_address[0] . "</br>" ;
            foreach ( $address_row_array as $address_row )
            {
              //   echo $new_address[0]   . " - " .$address_row['address'] . "<br/>";
                
                if ( strcasecmp ($address_row['address'], $new_address[0]) == 0 ) 
                {
                   // echo "found<br/>" ;
                    $addToDatabase = false ;
                    break ;
                }
                else
                {
                    $addToDatabase = true ;
                }
            }
            
            if ($addToDatabase == true )
            {
               echo "adding to database". "<br/>" ;
               
               $title = mysql_prep($new_address[1]) ;
               
              // echo $title ;
               
               $query = "INSERT INTO search_data (address,title) VALUES ( '{$new_address[0]}' , '{$title}' )" ;
               $result = mysql_query($query, $connection);
               confirm_query($result) ;
               
            }
        }
    }
    

    function addToDatabaseMethod($array)
    {
        global $connection ;
        $address_row_array = array() ;  
        $query = "SELECT address FROM all_addresses" ;
        $addresses_resultset = mysql_query($query,$connection) ;
        confirm_query($addresses_resultset) ;

        while ( $address_row_array[] = mysql_fetch_array($addresses_resultset) ) 
        {}
        
        foreach ($array as $new_address)
        {
            $addToDatabase = true ;

            foreach ( $address_row_array as $address_row )
            {

               //  echo $new_address[0]    . "<br/>";
                if ( strcasecmp ($address_row['address'], $new_address[0]) == 0 ) 
                {
                  echo "found - ". $address_row['address'] . " - " .  $new_address[0] . "</br>";
                    $addToDatabase = false ;
                    break ;
                }
                else
                {
                    $addToDatabase = true ;  
                    
                }
               
            }
            
            if ($addToDatabase == true )
            {
               echo "adding to database- {$new_address[0]}". "<br/>" ;
               $title = mysql_prep($new_address[1]) ;
               $query = "INSERT INTO all_addresses (address,title) VALUES ( '{$new_address[0]}' , '{$title}' )" ;
               $result = mysql_query($query, $connection);
               confirm_query($result) ;
              
               
            }
        }
       
    }
    
    
    function erodov($target)
    {
        $ref = "http://www.erodov.com/" ;   
        $webpage = http_get($target,$ref) ;
        
        
        $table_array =  parse_array($webpage['FILE'],"<table", "</table>") ;
        
        for($i=0;$i < count($table_array);$i++)
        {
            // if found correct table
            if ( get_attribute($table_array[$i],$attribute="id") == "threadslist")
           // if ( stristr($table_array[$i],"forum_table" ))
            {
               // echo "found table\n" ;
                
                //get all rows in an array
                $rows_array = parse_array($table_array[$i],"<tr", "</tr>") ;
                
              //  echo "number of rows- " . count($rows_array) ;
                   
                   
                for($ii=0;$ii< count($rows_array);$ii++)    //for every row
                {
                    // echo "\n for every row \n" ;
                    //get all td in an array
                    $cells_array = parse_array($rows_array[$ii],"<td","</td>") ;
                     // echo $cells_array[2] ;
                    if (!empty($cells_array)) 
                    {
       
                        //since the second colun contains our link we have cells_array[1] 
                        if ($target == "http://www.erodov.com/forums/bazaar/classifieds-wanted/" )
                            $final_link_array = parse_array($cells_array[2],"<a","</a>") ;
                        else
                            $final_link_array = parse_array($cells_array[1],"<a","</a>") ;
                          
                          $index = 0;
                          if (stristr($final_link_array[$index],"attachments"))
                          {
                              $index++ ;
                          }
                          if ( stristr($final_link_array[$index] , "Go to first" ) )
                          {
                             $index++ ;
                          }
                             $links_array[] = array(get_attribute($final_link_array[$index], $attribute="href"), 
                                                    return_between($final_link_array[$index],">","</a>", EXCL) ) ;    
                          
                   }
                    
                }
            }
            
        }
        
       // echo  "</br>" ;
        return $links_array ;
        
    }
    
    function jjmehta($target)
    {
        $ref = "http://www.jjmehta.com/" ;   
        $webpage = http_get($target,$ref) ;
       
        $table_array =  parse_array($webpage['FILE'],"<table", "</table>") ;
        
        for($i=0;$i < count($table_array);$i++)
        {
            // if found correct table
            if ( get_attribute($table_array[$i],$attribute="class") == "table_grid")
           // if ( stristr($table_array[$i],"forum_table" ))
            {
                echo "found table</br>" ;
                
                //get all rows in an array
                $rows_array = parse_array($table_array[$i],"<tr", "</tr>") ;
                
              //  echo "number of rows- " . count($rows_array) ;
                   
                   
                for($ii=0;$ii< count($rows_array);$ii++)    //for every row
                {
                    // echo "\n for every row \n" ;
                    //get all td in an array
                    $cells_array = parse_array($rows_array[$ii],"<td","</td>") ;
                     // echo $cells_array[2] ;
                    if (!empty($cells_array)) 
                    {
                        //since the second colun contains our link we have cells_array[1] 
                        $final_link_array = parse_array($cells_array[2],"<a","</a>") ;
                           $links_array[] = array(get_attribute($final_link_array[0], $attribute="href"), 
                                                    return_between($final_link_array[0],">","</a>", EXCL) ) ; 
                    }
                    
                }
            }
            
        }
       
         return $links_array ;
        
    }
    
    function techarena($target)
    {
        $ref = "http://www.techarena.in/" ;   
        $webpage = http_get($target,$ref) ;
       
        $table_array =  parse_array($webpage['FILE'],"<table", "</table>") ;
        
        for($i=0;$i < count($table_array);$i++)
        {
            // if found correct table
            if ( get_attribute($table_array[$i],$attribute="id") == "threadslist")
           // if ( stristr($table_array[$i],"forum_table" ))
            {
                echo "found table</br>" ;
                
                //get all rows in an array
                $rows_array = parse_array($table_array[$i],"<tr", "</tr>") ;
                
              //  echo "number of rows- " . count($rows_array) ;
                   
                   
                for($ii=0;$ii< count($rows_array);$ii++)    //for every row
                {
                    // echo "\n for every row \n" ;
                    //get all td in an array
                    $cells_array = parse_array($rows_array[$ii],"<td","</td>") ;
                     // echo $cells_array[2] ;
                    if (!empty($cells_array)) 
                    {
                        $final_link_array = parse_array($cells_array[2],"<a","</a>") ;
                        
                         if (stristr($final_link_array[0],"attachments"))
                          {
                                 $links_array[] = array(get_attribute($final_link_array[1], $attribute="href"), 
                                                    return_between($final_link_array[1],">","</a>", EXCL) ) ; 
                                 
                          }
                          else
                          {
                                 $links_array[] = array(get_attribute($final_link_array[0], $attribute="href"), 
                                                    return_between($final_link_array[0],">","</a>", EXCL) ) ; 
                             
                          }
                    }
                    
                }
            }
            
        }
        
        return $links_array ;
        
    }
    
    function thinkdigit($target)
    {
        $ref = "http://www.thinkdigit.com/" ;   
        $webpage = http_get($target,$ref) ;
       
        $table_array =  parse_array($webpage['FILE'],"<table", "</table>") ;
        
        for($i=0;$i < count($table_array);$i++)
        {
            // if found correct table
            if ( get_attribute($table_array[$i],$attribute="id") == "threadslist")
           // if ( stristr($table_array[$i],"forum_table" ))
            {
                echo "found table</br>" ;
                
                //get all rows in an array
                $rows_array = parse_array($table_array[$i],"<tr", "</tr>") ;
                
              //  echo "number of rows- " . count($rows_array) ;
                   
                   
                for($ii=0;$ii< count($rows_array);$ii++)    //for every row
                {
                    // echo "\n for every row \n" ;
                    //get all td in an array
                    $cells_array = parse_array($rows_array[$ii],"<td","</td>") ;
                     // echo $cells_array[2] ;
                    if (!empty($cells_array)) 
                    {
                        $final_link_array = parse_array($cells_array[2],"<a","</a>") ;
                        
                         
                          $index = 0;
                          if (stristr($final_link_array[$index],"attachments"))
                          {
                              $index++ ;
                          }
                          if ( stristr($final_link_array[$index], "Go to first" ))
                          {
                             $index++ ;
                          }
                             $links_array[] = array(get_attribute($final_link_array[$index], $attribute="href"), 
                                                    return_between($final_link_array[$index],">","</a>", EXCL) ) ;    
                          
                    }
                    
                }
            }
            
        }
       
         return $links_array ;
        
    }
    
    function rimweb($target)
    {
        $ref = "rimweb.com" ;
        $webpage = http_get($target,$ref) ;
        $table_array =  parse_array($webpage['FILE'],"<table", "</table>") ;
        
        for($i=0;$i < count($table_array);$i++)
        {
            // if found correct table
            if ( stristr($table_array[$i],"forum_table" ))
            {
                echo "found table</br>" ;
                
                //get all rows in an array
                $rows_array = parse_array($table_array[$i],"<tr", "</tr>") ;
                
              //  echo "number of rows- " . count($rows_array) ;
                   
                for($ii=0;$ii< count($rows_array);$ii++)
                {
                    // echo "\n for every row \n" ;
                    $cells_array = parse_array($rows_array[$ii],"<td","</td>") ;
                    // echo $cells_array[1] ;
                    if (!empty($cells_array))
                    {
                        // echo "not empty" ;
                        // $all_links = parse_array($cells_array[1],"<a",">") ;
                       // echo $cells_array[1] ;
                       $final_link_array = parse_array($cells_array[1],"<a","</a>") ;
                        
                         
                          $index = 0;
                           if ( stristr($final_link_array[$index],"View topic preview" ))
                          {
                             $index++ ;
                          }
                          if ( stristr($final_link_array[$index],"Go to first" ))
                          {
                             $index++ ;
                          }
                          if (stristr($final_link_array[$index],"attachments"))
                          {
                              $index++ ;
                          }
                             $links_array[] = array(get_attribute($final_link_array[$index], $attribute="href"), 
                                                    return_between($final_link_array[$index],">","</a>", EXCL) ) ;    

                    }
                    
                }
            }
            
        }
       // for($k=0;$k<count($links_array);$k++)
        {
           // echo $links_array[$k] ;
            return $links_array ;
        }
         
    }
    
    // TODO!!
    function techenclave($target)
    {
        
        $webpage['FILE'] = techenclave_fetch($target) ;
        
        $html = str_get_html($webpage['FILE'] ) ;
       
        $innerdiv = $html->find('div[id=threadlist]') ;
       // $innerdiv = str_get_html($innerdiv) ;
       
       // echo $innerdiv[0]->innertext ;  
       $innerdivobject=str_get_html( $innerdiv[0]->innertext) ;
       $div_inner_array = $innerdivobject->find('div[class=inner]') ;
       // echo $li_array[0]->innertext ; 
       
       $html->__destruct();
       
        foreach ($div_inner_array as $div)
        {
            $divinner =str_get_html( $div->innertext ) ;
            $a_array = $divinner->find('a') ;
            
            $index = 0 ;
            if ( stristr($a_array[$index]->innertext , "Go to first" ) ) 
                $index++ ;
                
            $links_array[] = array($a_array[$index]->href, $a_array[$index]->innertext ) ; 
            echo "inner text- " . $a_array[$index]->innertext    . "</br>" ;
             $divinner->__destruct();
            unset($divinner) ;
           // echo $a_array[$index]->href;
            
            //$a =str_get_html($a_array[0]->innertext) ;
            // echo $a->src ;
          //  echo "</br> " ;
        }
        
      unset($html) ;
       $innerdivobject->__destruct();
       unset($innerdivobject) ;
       
       return $links_array ;
         
         
    }
    
    function techenclave_fetch($target)
    {
        global $techenclave_user ;
        global $techenclave_pass ;
        
        $ref = "http://www.techenclave.com" ;
        
             
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.techenclave.com/login.php?do=login") ;       // Target site
        curl_setopt ($ch, CURLOPT_COOKIEFILE, "cookie-techenclave.txt");             
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie-techenclave.txt");
        curl_setopt($ch, CURLOPT_REFERER, $ref);  
        curl_setopt($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT);    // Timeout
        curl_setopt($ch, CURLOPT_USERAGENT, WEBBOT_NAME); 
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, "vb_login_username={$techenclave_user}&vb_login_password=".$techenclave_pass
                      ."&securitytoken=guest&cookieuser=1&do=login&vb_login_md5password=&vb_login_md5password_utf=");
        
      //  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);     // Follow redirects
        curl_setopt($ch, CURLOPT_MAXREDIRS, 4);             // Limit redirections to four
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);     // Return in string  
        
        
        $webpage['FILE'] = curl_exec($ch);
        curl_close($ch);
        ///////////////////////////////////////////////////
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$target}") ;       // Target site
        curl_setopt ($ch, CURLOPT_COOKIEFILE, "cookie-techenclave.txt");             
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie-techenclave.txt");
        curl_setopt($ch, CURLOPT_REFERER, $ref);  
        curl_setopt($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT);    // Timeout
        curl_setopt($ch, CURLOPT_USERAGENT, WEBBOT_NAME); 
       
      //  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);     // Follow redirects
        curl_setopt($ch, CURLOPT_MAXREDIRS, 4);             // Limit redirections to four
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);     // Return in string  
        
        $webpage['FILE'] = curl_exec($ch);
        curl_close($ch);
        return $webpage['FILE'] ;
    }
    
    
     function hifivision($target)
    {
        $ref = "http://www.hifivision.com/" ;
        $webpage = http_get($target,$ref) ;
        $table_array =  parse_array($webpage['FILE'],"<table", "</table>") ;
        
        for($i=0;$i < count($table_array);$i++)
        {
            // if found correct table
            if (get_attribute($table_array[$i],$attribute="id") == "threadslist" )
            {
                echo "found table</br>" ;
                
                //get all rows in an array
                $rows_array = parse_array($table_array[$i],"<tr", "</tr>") ;
                
              //  echo "number of rows- " . count($rows_array) ;
                   
                for($ii=0;$ii< count($rows_array);$ii++)
                {
                    // echo "\n for every row \n" ;
                    $cells_array = parse_array($rows_array[$ii],"<td","</td>") ;
                    // echo $cells_array[1] ;
                    if (!empty($cells_array))
                    {
                        // echo "not empty" ;
                        // $all_links = parse_array($cells_array[1],"<a",">") ;
                       // echo $cells_array[1] ;
                       $final_link_array = parse_array($cells_array[2],"<a","</a>") ;
                        
                         
                          $index = 0;
                           if ( stristr($final_link_array[$index],"View topic preview" ))
                          {
                             $index++ ;
                          }
                          if (stristr($final_link_array[$index],"attachments"))
                          {
                              $index++ ;
                          }
                          if ( stristr($final_link_array[$index],"Go to first" ))
                          {
                             $index++ ;
                          }
                        
                             $links_array[] = array(get_attribute($final_link_array[$index], $attribute="href"), 
                                                    return_between($final_link_array[$index],">","</a>", EXCL) ) ;    

                    }
                    
                }
            }
            
        }
        for($k=0;$k<count($links_array);$k++)
        {
            echo $links_array[$k] ;
            return $links_array ;
        }
         
    }
    
?>