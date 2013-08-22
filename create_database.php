<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/fetch_functions.php"); ?>
<?php
include_once('includes/QueryPath/QueryPath.php');

set_time_limit(1000);
$links_array = array();

/*
 * TODO
 * use variable variables to shorten this up.
 */

$erodovArr = array("http://www.erodov.com/forums/bazaar/classifieds-sale/", 'http://www.erodov.com/forums/bazaar/classifieds-wanted/');
foreach ($erodovArr as $erodov) {
    addToDatabaseMethod(erodov($erodov));
}

$jjmehtaArr = array("http://www.jjmehta.com/forum/index.php/board,11.0.html", 'http://www.jjmehta.com/forum/index.php/board,8.0.html');
foreach ($jjmehtaArr as $jjmehta) {
    addToDatabaseMethod(jjmehta($jjmehta));
}
$thinkArr = array("http://www.thinkdigit.com/forum/bazaar/", 'http://www.thinkdigit.com/forum/want-buy/');
foreach ($thinkArr as $think) {
    addToDatabaseMethod(thinkdigit($think));
}

$target = "http://www.rimweb.in/forums/forum/92-sell-bazaar-forum/";
$rimweb = rimweb($target);
addToDatabaseMethod($rimweb);

$techArr = array("http://www.techenclave.com/community/forums/sell-or-trade-products.33/", "http://www.techenclave.com/community/forums/want-to-buy-products.106/");

foreach ($techArr as $tech) {
    addToDatabaseMethod(techenclave($tech));
}

$hifiArr = array("http://www.hifivision.com/sale-owner/", "http://www.hifivision.com/wanted/", "http://www.hifivision.com/group-buys-deals/");

foreach ($hifiArr as $hifi) {
    addToDatabaseMethod(hifivision($hifi));
}


?>