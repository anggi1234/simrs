<?php
require_once 'lib.php';

$signature = getSignature();
$key = $_GET['key'];
$id = $_GET['id'];
$no = $_GET['no'];


function getData($no, $signature)
{
    global $response;

    if (strlen($no) == 19) {
        $request_url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/" . $no;
    } else {
        $request_url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/Peserta/" . $no;
    };
    //echo $request_url;
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
    curl_close($ch);
};
if (isset($key)) {
    getData($key, $signature);
};
//print_r($response);

if ($response->metaData->code == 200) {
    $asalfaskes = $response->response->asalFaskes;
    $kelas = $response->response->rujukan->peserta->hakKelas->kode;
    //$jnspeserta = $response->response->rujukan->peserta->jenisPeserta->kode;
    //$nama = $response->response->rujukan->peserta->nama;
    //$nik = $response->response->rujukan->peserta->nik;
    //$pisa = $response->response->rujukan->peserta->pisa;
    //$penyedia = $response->response->rujukan->peserta->provUmum->kdProvider;
    //$sex = $response->response->rujukan->peserta->sex;
    //$status = $response->response->rujukan->peserta->statusPeserta->kode;
    //$cetak = $response->response->rujukan->peserta->tglCetakKartu;
    //$lahir = $response->response->rujukan->peserta->tglLahir;
    //$tat = $response->response->rujukan->peserta->tglTAT;
    //$tmt = $response->response->rujukan->peserta->tglTMT;
    $umur = $response->response->rujukan->peserta->umur->umurSekarang;
    $diag = $response->response->rujukan->diagnosa->kode;
    $rujukan = $response->response->rujukan->noKunjungan;
    $pelayanan = $response->response->rujukan->pelayanan->kode;
    $penyedia = $response->response->rujukan->provPerujuk->kode;
    $str = explode(",",$umur);
    $year = preg_replace('/[^0-9]/', '', $str[0]);
    $month = preg_replace('/[^0-9]/', '', $str[1]);
    $day = preg_replace('/[^0-9]/', '', $str[2]);

    $input = "UPDATE PASIEN_VISITATION SET 
    ASALRUJUKAN = $asalfaskes,
        CLASS_ID = $kelas + 1,
        DIAG_AWAL = '$diag',
        NORUJUKAN = '$rujukan',
        RESPONTGLPLG_DESC = '$pelayanan',
        PPKRUJUKAN = '$penyedia',
        AGEYEAR = $year,
        AGEMONTH = $month,
        AGEDAY = $day
        WHERE IDXDAFTAR = '$id'";
//echo $input;
$stmt = sqlsrv_query($conn, $input);

sqlsrv_close($conn);
echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienVisitationEdit/".$id."?showmaster=cv_pasien&fk_NO_REGISTRATION=".$no."';</script>";

} else {
sqlsrv_close($conn);
echo "<script type='text/javascript'>alert('".$response->metaData->message."');</script>";
echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienVisitationEdit/".$id."?showmaster=cv_pasien&fk_NO_REGISTRATION=".$no."';</script>";

};




//sqlsrv_close($conn);

//print_r("https://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id."?showmaster=cv_pasien&fk_NO_REGISTRATION=".$no)

//header("location:https://192.168.1.234/simrs/pendaftaran/PasienVisitationEdit/".$id."?showmaster=cv_pasien&fk_NO_REGISTRATION=".$no);


?>