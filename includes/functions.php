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


function curl_fetch($url, $save_cookies = true, $load_cookies = true, $post_data = false, $https = false, $proxy = false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // Target site
    if ($load_cookies) curl_setopt($ch, CURLOPT_COOKIEFILE, CKFILE);
    if ($save_cookies) curl_setopt($ch, CURLOPT_COOKIEJAR, CKFILE);
    if ($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    if ($post_data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
    curl_setopt($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // Follow redirects
    curl_setopt($ch, CURLOPT_MAXREDIRS, 4); // Limit redirections to four
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Return in string
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}


function clean_string($strin) {
    $strin = trim(utf8_decode(html_entity_decode($strin)));
    return preg_replace('#\r|\n|\s+#', ' ', $strin);
}
