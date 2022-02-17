<?php
$serverName = "localhost, 50201"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array("Database" => "RSUD_BESEMAH_VCLAIM_V11", "UID" => "sa", "PWD" => "Agussalim7");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn) {
    echo "Connection established.<br />";
} else {
    echo "Connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
}
