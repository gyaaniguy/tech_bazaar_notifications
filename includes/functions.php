
<?php

    function mysql_prep( $value )
    {
        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
        if( $new_enough_php ) { // PHP v4.3.0 or higher
            // undo any magic quote effects so mysql_real_escape_string can do the work
            if( $magic_quotes_active ) { $value = stripslashes( $value ); }
            $value = mysql_real_escape_string( $value );
        } else { // before PHP v4.3.0
            // if magic quotes aren't already on then add slashes manually
            if( !$magic_quotes_active ) { $value = addslashes( $value ); }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }

    function redirect_to( $location = NULL ) {
        if ($location != NULL) {
            header("Location: {$location}");
            exit;
        }
    }

    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed: " . mysql_error());
        }
    }

    function logged_in() 
    {
        if (isset($_SESSION["email"])) 
        {
            return true ;
        }
        else 
        { return false ;
        }
    }
    
		// email validation function 
	function email_valid($email) 
	{  
	  if (preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) 
	  		return true;
	  else 	return false;
	  
	}
	
	function login($email,$hashed_password)
	{
        global $connection ;
		global $message ;
        $email = mysql_prep($email) ;
        $hashed_password = mysql_prep($hashed_password) ;
		$query = " SELECT * FROM users 
                        WHERE email = '{$email}'
                         AND hashed_password = '{$hashed_password}' " ;
            
            $result_set = mysql_query($query, $connection) ;
            confirm_query($result_set) ; 
            
             if(mysql_num_rows($result_set) == 1 )  
            {
                $found_user = mysql_fetch_array($result_set) ;
                $_SESSION['user_id'] = $found_user["id"] ;
                $_SESSION['email'] = $found_user["email"] ;
                if ( $found_user["colony_id"] != null )
                    $_SESSION['colony_id'] = $found_user["colony_id"] ;
               //login over
                return true ;
            }
            else 
            {
                  if(isset($_POST['email']))      $_SESSION['post_email'] = $_POST['email'] ;
                $message = " -email/password wrong. Problem? " . mysql_error() ;
            }
	}
	
	function drawPagination($pagination)
	{
		$navigation = $pagination->create_links();
        echo $navigation; 
	}
	
	function get_delhiitemrow_from_id()
	{
        
		global $connection ;
        if ( isset($_GET['id']) )
        {
            $id = mysql_prep($_GET['id'])          ;
            $query = "SELECT * FROM delhi_items WHERE id={$id}" ;
        }
		else 
        {
            $id = mysql_prep($_POST['id']) ;
            $query = "SELECT * FROM delhi_items WHERE id={$id}" ;
		}
        $result_set = mysql_query($query, $connection) ;
		confirm_query($result_set) ;
		return mysql_fetch_array($result_set) ;
	}
    
    function get_delhiservicesrow_from_id()
    {
        global $connection ;
        if ( isset($_GET['id']) )
         {
            $id = mysql_prep($_GET['id'])          ;
            $query = "SELECT * FROM delhi_services WHERE  id={$id}" ;
         }
        else 
        {
            $id = mysql_prep($_POST['id']) ;
            $query = "SELECT * FROM delhi_services WHERE  id={$id}" ;
        }
        $result_set = mysql_query($query, $connection) ;
        confirm_query($result_set) ;
        return mysql_fetch_array($result_set) ;
    }
    function get_colonyname_from_id($colony_id)
    {
         global $connection ; 
         $colony_id = mysql_prep($colony_id) ;
         $query = "SELECT * FROM colonies WHERE id={$colony_id}" ;
         $result_set = mysql_query($query, $connection) ;
         confirm_query($result_set) ; 
         $result_row = mysql_fetch_array($result_set) ;
         return $result_row['colony_name'] ;
    }
    function register_and_login()
    {
        global $connection ;
         $message = "username/password entered " ;    
            $email = mysql_prep( $_POST["email"] )  ;
            $hashed_password = mysql_prep( sha1($_POST["password"]) ) ;
           $ip_address = mysql_prep($_SERVER['REMOTE_ADDR']) ;
            
            $query = "INSERT INTO users ( email, hashed_password, ip_address) 
                    VALUES ('{$email}', '{$hashed_password}', '{$ip_address}' ) ";
           
            $result_set = mysql_query($query, $connection) ;
            confirm_query($result_set) ; 
 
                       
             if($result_set)  //first method
            {
                $message = "success!" ;
                // login
                login($email,$hashed_password) ;
             }
            else 
            {
                $message = "Something went horribly wrong! Problem? " . mysql_error() ; 
                //SEND ERROR MAIL
            }
    }
    
    function PIPHP_ImageResize($image, $w, $h) 
    { 
       $oldw = imagesx($image); 
       $oldh = imagesy($image); 
       $temp = imagecreatetruecolor($w, $h); 
       imagecopyresampled($temp, $image, 0, 0, 0, 0, 
          $w, $h, $oldw, $oldh); 
       return $temp; 
   }
   
   function resize_image($add, $fileType)
   {
       
       
        if ($fileType == "image/jpeg")
        {
            $image = imagecreatefromjpeg($add); 
        }
        if ($fileType == "image/png")
        {
            $image = imagecreatefrompng($add); 
        }
        if ($fileType == "image/gif")
        {
            $image = imagecreatefromgif($add); 
        }
        
        
        $finalwidth = 675 ;
        list($width, $height, $type, $attr) = getimagesize($add);
        if ($width > $finalwidth )
        {
            $height = $height * $finalwidth /$width  ;
            $width = $finalwidth  ;    
        }
        $newim = PIPHP_ImageResize($image, $width, $height); 
        if ($fileType == "image/jpeg")
        {
        imagejpeg($newim, $add);
        }
        if ($fileType == "image/png")
        {
        imagepng($newim, $add);
        }
        if ($fileType == "image/gif")
        {
        imagegif($newim, $add);
        }
   }
   
   function errorIfEmpty($variable , $errormessage = null )
   {
       global $errors ;       
        if ( empty($variable)) 
        {
            $errors[] = $errormessage ;
        }  
   }
   
   function tooLong($var)
   {
        if ( strlen($var) > 30 )         // is 30 ok ?
        {
            $errors[] = $var ;
        }
   }
   
   function uploadimage()
   {
        global $image1_path ;
        global $message ;
       if($_FILES['image1']['size'] > 0) // if image entered
        {
            if ( getimagesize($_FILES['image1']['tmp_name']) )
            {
          //  $message .= " - image entered    " ;
            // print_r($_FILES) ;
        
                $fileName = $_FILES['image1']['name'];
                $tmpName  = $_FILES['image1']['tmp_name'];
                $fileSize = $_FILES['image1']['size'];
                $fileType = $_FILES['image1']['type'];
                
                
                $image1_path =rand(100,10000).$fileName  ;
                $add="site_data/delhi_images/{$image1_path}";
                echo $add ;
                
                if(move_uploaded_file ($tmpName, $add))
                {
                    resize_image($add, $fileType) ;
                   // $message .= "uploaded" ;
                    // do your coding here to give a thanks message or any other thing.
                }
                else
                {
                    echo "Failed to upload file. Contact Site admin to fix the problem";
                }
                echo "<br>File $fileName uploaded<br>";
            }
            else
            {
               // echo "wrong image type" ;
                $message = "wrong image type. try uploading some other image "    ;
                $error = 1 ;
            }
        } 
   }
   
   function PIPHP_TextTruncate($text, $max, $symbol) 
   { 
       $temp = substr($text, 0, $max); 
       $last = strrpos($temp, " "); 
       $temp = substr($temp, 0, $last); 
       $temp = preg_replace("/([^\w])$/", "", $temp); 
       return "$temp$symbol"; 
   }
   
   function curPageName() 
   {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
   }

	function contains_bad_str($str_to_test)
	 {
  $bad_strings = array(
                "content-type:"
                ,"mime-version:"
                ,"multipart/mixed"
		,"Content-Transfer-Encoding:"
                ,"bcc:"
		,"cc:"
		,"to:"
  );
  
  foreach($bad_strings as $bad_string)
  {
    if(eregi($bad_string, strtolower($str_to_test))) 
    {
      echo "$bad_string found. Suspected injection attempt - mail not being sent.";
      exit;
    }
  }
}

function contains_newlines($str_to_test) 
{
   if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) != 0) 
   {
     echo "newline found in $str_to_test. Suspected injection attempt - mail not being sent.";
     exit;
   }
} 
?>

