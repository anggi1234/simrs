<?php
$serverName = "192.168.1.234, 50201"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array("Database" => "RSUD_BESEMAH_VCLAIM_V11", "UID" => "sa", "PWD" => "Agussalim7");
$conn = sqlsrv_connect($serverName, $connectionInfo);
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

function getSignature2()
{
    $data = "29446";
    $secretKey = "2yM44573CA";
        // Computes the timestamp
        date_default_timezone_set('UTC');
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        // Computes the signature by hashing the salt with the secret key as the key
    $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
     
    // base64 encode
    $encodedSignature = base64_encode($signature);
     
    // urlencode
    // $encodedSignature = urlencode($encodedSignature);
     
    echo "X-cons-id: " .$data ." ";
    echo "X-timestamp:" .$tStamp ." ";
    echo "X-signature: " .$encodedSignature;
}
require_once 'vendor/autoload.php';
 // function decrypt
 function stringDecrypt($key, $string){
            
      
    $encrypt_method = 'AES-256-CBC';

    // hash
    $key_hash = hex2bin(hash('sha256', $key));

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

    return $output;
}

// function lzstring decompress 
// download libraries lzstring : https://github.com/nullpunkt/lz-string-php
function decompress($string){

    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

}
?>