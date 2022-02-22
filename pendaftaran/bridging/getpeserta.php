<?php
require_once 'lib.php';

$signature = getSignature();
$key = $_GET['key'];
$id = $_GET['id'];

function getData($no, $signature)
{
    global $response;
    $id2 = strlen($no);
    if ($id2 == 13) {
    $request_url = "http://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nokartu/" . $no . "/tglSEP/" . date("Y-m-d");
    } else {
    $request_url = "http://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nik/" . $no . "/tglSEP/" . date("Y-m-d"); };
  

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
  // var_dump($response);
    curl_close($ch);
};

if (isset($key)) {
    getData($key, $signature);
};

if ($response->metaData->code == 200) {
    $kelas = $response->response->peserta->hakKelas->kode;
    $jnspeserta = $response->response->peserta->jenisPeserta->kode;
    $nama = $response->response->peserta->nama;
    $nik = $response->response->peserta->nik;
    $pisa = $response->response->peserta->pisa;
    $penyedia = $response->response->peserta->provUmum->nmProvider;
    $sex = $response->response->peserta->sex;
    $status = $response->response->peserta->statusPeserta->kode;
    $cetak = $response->response->peserta->tglCetakKartu;
    $lahir = $response->response->peserta->tglLahir;
    $tat = $response->response->peserta->tglTAT;
    $tmt = $response->response->peserta->tglTMT;
    $umur = $response->response->peserta->umur->umurSekarang;
    // var_dump($umur);

    $update = "UPDATE PASIEN 
    SET CLASS_ID = $kelas + 1 ,
    FAMILY_STATUS_ID = $jnspeserta,
    NAME_OF_PASIEN = '$nama',
    PASIEN_ID = $nik,
    COVERAGE_ID = $pisa,
    GENDER = IIF('$sex' = 'l', '1', '2'),
    AKTIF = $status,
    DATE_OF_BIRTH = '$lahir',
    TAT = '$tat',
    TMT = '$tmt',
    ORG_ID = '$umur',
    NATION_ID = 1
    WHERE ID = '$id'";

    //echo $update;

    // if ($conn->query($update) === TRUE) {
    //     echo "Record updated successfully";
    //   } else {
    //     echo "Error updating record: " . $conn->error;
    //   };
    $stmt = sqlsrv_query($conn, $update);
    // if( $stmt === false ) {
    //      die( print_r( sqlsrv_errors(), true));
    // };


    // else { 
    //     $msg = $response->metaData->message;

    // };
    sqlsrv_close($conn);
    echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id. "';</script>";

} else {
    sqlsrv_close($conn);
    echo "<script type='text/javascript'>alert('".$response->metaData->message."');</script>";
    echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id. "';</script>";

};

// $update =
// "UPDATE `data` 
// SET no_sep ='$nosep', kode_diag = '$diagnosa', tgl_sep = '$tglsep', faskesrujukan ='$asal', jnspeserta = '$peserta', jnspelayanan = '$pelayanan' WHERE idxdaftar = $id";



// sqlsrv_close($conn);

// header("location:http://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id);
