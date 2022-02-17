<?php
$serverName = "192.168.1.234, 50201"; //serverName\instanceName
$connectionInfo = array( "Database"=>"RSUD_BESEMAH_VCLAIM_V11", "UID"=>"sa", "PWD"=>"Agussalim7"); //RSUD_BESEMAH_VCLAIM_V11
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$path = "https://api.telegram.org/bot1937412324:AAH3UK2ZQQFUdkxPxLMwOYYoDV7yLJev1_c";

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>
