<?php
require_once 'lib2.php';

$signature = getSignature();
$key = $_GET['key'];
//$id = $_GET['id'];

function getData($no, $signature)
{
    global $response;
    $id2 = strlen($no);
   
    //$request_url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/ListSpesialistik/PPKRujukan/0601R001/TglRujukan/2021-12-30";
    $request_url = "https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/Rujukan/ListSpesialistik/PPKRujukan/0601R001/TglRujukan/2021-12-31";

  

    $ch = curl_init($request_url);
    //curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $signature);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
    //curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


    $response = curl_exec($ch);
    $error = curl_error($ch);
    //echo $response['response']['peserta']['jenisPeserta']['keterangan'];
    $response = json_decode($response);
    var_dump($response);
    curl_close($ch);
};

if (isset($key)) {
    getData($key, $signature);
};

// $update =
// "UPDATE `data` 
// SET no_sep ='$nosep', kode_diag = '$diagnosa', tgl_sep = '$tglsep', faskesrujukan ='$asal', jnspeserta = '$peserta', jnspelayanan = '$pelayanan' WHERE idxdaftar = $id";



// sqlsrv_close($conn);

// header("location:https://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id);
