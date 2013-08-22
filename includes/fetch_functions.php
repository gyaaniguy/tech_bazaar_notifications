<?php
set_time_limit(1000);
/**
 * Checks if a particular links existsw in the database and then adds it if it doesn't
 * @param $array of links and their titles
 */
function addToDatabaseMethod($array) {
    global $connection;
    $address_row_array = array();
    $query = "SELECT address FROM all_addresses";
    $addresses_resultset = mysql_query($query, $connection);
    confirm_query($addresses_resultset);

    while ($address_row_array[] = mysql_fetch_array($addresses_resultset)) {
    }

    foreach ($array as $new_address) {
        $addToDatabase = true;

        foreach ($address_row_array as $address_row) {

            //  echo $new_address[0]    . "<br/>";
            if (strcasecmp($address_row['address'], $new_address[0]) == 0) {
                echo "found - " . $address_row['address'] . " - " . $new_address[0] . "</br>";
                $addToDatabase = false;
                break;
            } else {
                $addToDatabase = true;

            }

        }

        if ($addToDatabase == true) {
            echo "adding to database- {$new_address[0]}" . "<br/>";
            $title = mysql_prep($new_address[1]);
            $query = "INSERT INTO all_addresses (address,title) VALUES ( '{$new_address[0]}' , '{$title}' )";
            $result = mysql_query($query, $connection);
            confirm_query($result);


        }
    }

}

/**
 * Helper Function to start fetching pages.
 * @param $target
 * @return QueryPath
 */
function init($target){

    $page = curl_fetch($target) ;
    $qp = htmlqp($page);
    return $qp ;
}

/*
 * VARIOUS FUNCTIONS TO FETCH LISTINGS FROM DIFFERENT FORUMS.
 */

function erodov($target) {
    $links_array = array() ;
    $qp = init($target) ;
    $threadslist = $qp->find('#threadslist tbody') ;

    $trs = $threadslist->eq(1)->find('tr') ;

    foreach ($trs as $tr) {
        $a = $tr->find('a') ;
        $linkNum = 0 ;
        if (count($a) > 0 ){
            do {
                $link = $a->branch()->eq($linkNum) ;
                $linkText = $link->text() ;

                if ( preg_match('/^\s*$/',$linkText) == 1 ) {
                    $continue = true ;
                    $linkNum++ ;
                }
                else {
                    $continue = false ;
                }

            }
            while ($continue ) ;

            $links_array[] = array($link->attr('href'), $link->text() ) ;
        }
    }


    return $links_array;

}

function jjmehta($target) {
    $links_array = array() ;
    $qp = init($target) ;
    $threadslist = $qp->find('.table_grid tbody') ;

    $trs = $threadslist->eq(0)->find('tr') ;

    foreach ($trs as $tr) {
        $link = $tr->find('a')->eq(0) ;
        $links_array[] = array($link->attr('href'), $link->text() ) ;
    }
    return $links_array;

}

function thinkdigit($target) {


    $links_array = array() ;
    $qp = init($target) ;
    $threadtitles = $qp->find('.threadtitle');
    foreach ($threadtitles as $threadtitle) {
        $link = $threadtitle->find('a')->eq(0) ;
        $links_array[] = array($link->attr('href'), clean_string($link->text()) ) ;
    }


    return $links_array;

}

function rimweb($target) {
    $links_array = array() ;
    $qp = init($target) ;
    $threadtitles = $qp->find('.__topic');
    foreach ($threadtitles as $threadtitle) {
        $link = $threadtitle->find('a')->eq(0) ;
        $links_array[] = array($link->attr('href'), clean_string($link->text()) ) ;
    }
    // echo $links_array[$k] ;
    return $links_array;

}

function techenclave($target) {

    $links_array = array() ;
    $qp = init($target) ;
    $threadtitles = $qp->find('.title');
    foreach ($threadtitles as $threadtitle) {
        $link = $threadtitle->find('a')->eq(1) ;
        $links_array[] = array( 'http://www.techenclave.com/community/'.$link->attr('href'), clean_string($link->text()) ) ;
    }
    return $links_array;
}

function hifivision($target) {
    $links_array = array() ;
    $qp = init($target) ;
    $threadslist = $qp->find('#threadslist tbody') ;

    $trs = $threadslist->eq(1)->find('tr') ;

    foreach ($trs as $tr) {
        $a = $tr->find('a') ;
        if (count($a) > 0 ){
            $link = $a->branch()->eq(0) ;
            $linkText = $link->text() ;
            if ( preg_match('/^\s*$/',$linkText) == 1 ) {
                $link = $a->eq(1) ;
            }
            $links_array[] = array($link->attr('href'), $link->text() ) ;
        }
    }


    return $links_array;

}

?>