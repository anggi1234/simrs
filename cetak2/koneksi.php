 <?php
$serverName = "192.168.1.192,51295"; //serverName\instanceName
$connectionInfo = array( "Database"=>"lis", "UID"=>"admin", "PWD"=>"oratidokan");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}?> 