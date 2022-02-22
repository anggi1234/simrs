<?php
require_once 'lib.php';

$signature = getSignature();
//$key = $_GET['key'];
$id = $_GET['id'];
$no = $_GET['no'];
$key = htmlspecialchars($_GET['key']);

if (isset($key)) {  

    $url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/SEP/Delete";
    $data = array(
        'request' => array(
            't_sep' => array(
                'noSep' => $key,
                'user' => 'RSUD BESEMAH'
            )
        )
    );
    // print_r($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $signature);
    //curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //print_r($data);
    $sep = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    $sep = json_decode($sep);
    //print_r($sep);
};



if ($sep->metaData->code != 200) {
    sqlsrv_close($conn);
    echo "<script type='text/javascript'>alert('" . $sep->metaData->message . "');</script>";
    echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienVisitationEdit/" . $id . "?showmaster=cv_pasien&fk_NO_REGISTRATION=" . $no . "';</script>";
} else {
    
    $update = "UPDATE PASIEN_VISITATION SET NO_SKP=null, RESPONDEL_VKLAIM=$sep WHERE IDXDAFTAR = '$id'";
    // // echo "<script type='text/javascript'>alert('$update');</script>";
    $stmt = sqlsrv_query($conn, $update);
    sqlsrv_close($conn);
    echo "<script type='text/javascript'>alert('Insert SEP Berhasil');</script>";
    echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienVisitationEdit/" . $id . "?showmaster=cv_pasien&fk_NO_REGISTRATION=" . $no . "';</script>";
};




//print_r("https://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id."?showmaster=cv_pasien&fk_NO_REGISTRATION=".$no)
?>