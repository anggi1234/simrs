<?php
$serverName = "serverbesemah\sql2016"; //serverName\instanceName
$connectionInfo = array( "Database"=>"RSUD_BESEMAH_VCLAIM_V11", "UID"=>"sa", "PWD"=>"Agussalim7");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $conn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// };

function getSignature()
{
  $dataid = "29446";
  $secretKey = "2yM44573CA";


  date_default_timezone_set('UTC');
  $tStamp              = strval(time() - strtotime('1970-01-01 00:00:00'));
  $signature           = hash_hmac('sha256', $dataid . "&" . $tStamp, $secretKey, true);
  $encodedSignature    = base64_encode($signature);
  $urlencodedSignature = urlencode($encodedSignature);

  $header = array(
    "x-cons-id: " . $dataid . "",
    "x-timestamp:" . $tStamp . "",
    "x-signature:" . $encodedSignature . "",
    "Content-Type: application/x-www-form-urlencoded"
  );
  return $header;
};
?>

