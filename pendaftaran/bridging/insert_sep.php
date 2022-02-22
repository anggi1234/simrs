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
    $jnspeserta = $response->response->rujukan->peserta->jenisPeserta->kode;
    //$nama = $response->response->rujukan->peserta->nama;
    $nokartu = $response->response->rujukan->peserta->noKartu;
    //$kls = $response->response->rujukan->peserta->hakKelas->kode;
    //$nik = $response->response->rujukan->peserta->nik;
    //$pisa = $response->response->rujukan->peserta->pisa;
    //$penyedia = $response->response->rujukan->peserta->provUmum->kdProvider;
    //$sex = $response->response->rujukan->peserta->sex;
    //$status = $response->response->rujukan->peserta->statusPeserta->kode;
    //$cetak = $response->response->rujukan->peserta->tglCetakKartu;
    //$lahir = $response->response->rujukan->peserta->tglLahir;
    //$tat = $response->response->rujukan->peserta->tglTAT;
    //$tmt = $response->response->rujukan->peserta->tglTMT;
    //$umur = $response->response->rujukan->peserta->umur->umurSekarang;
    $diag = $response->response->rujukan->diagnosa->kode;
    $rujukan = $response->response->rujukan->noKunjungan;
    $tglrujukan = $response->response->rujukan->tglKunjungan;
    $pelayanan = $response->response->rujukan->pelayanan->kode;
    $penyedia = $response->response->rujukan->provPerujuk->kode;
    $notelp = $response->response->rujukan->peserta->mr->noTelepon;
    $poli = $response->response->rujukan->poliRujukan->kode;

    // $str = explode(",", $umur);
    // $year = preg_replace('/[^0-9]/', '', $str[0]);
    // $month = preg_replace('/[^0-9]/', '', $str[1]);
    // $day = preg_replace('/[^0-9]/', '', $str[2]);

    $jnspelayanan = htmlspecialchars($_GET['pelayanan']);
    //$kodepoli = htmlspecialchars($_GET['poli']);
    $eksekutif = htmlspecialchars($_GET['eksekutif']);
    $nosurat = htmlspecialchars($_GET['nosurat']);
    $dpjp = htmlspecialchars($_GET['dpjp']);
    //$id = htmlspecialchars($_GET['id']);
    $catatan = htmlspecialchars($_GET['catatan']);
    //echo $input;

    $url = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/SEP/1.1/insert";
    $data = array(
        'request' => array(
            't_sep' => array(
                'noKartu' => $nokartu,
                'tglSep' => date("Y-m-d"),
                'ppkPelayanan' => '0613R001',
                'jnsPelayanan' => $jnspelayanan,  // *
                'klsRawat' => $kelas,
                'noMR' => $no,
                'rujukan' => array(
                    'asalRujukan' => $asalfaskes,
                    'tglRujukan' => $tglrujukan,
                    'noRujukan' => $rujukan,
                    'ppkRujukan' => $penyedia // PUSKESMAS PEMBUAT RUJUKAN
                ),
                'catatan' => $catatan,      // *
                'diagAwal' => $diag, // icd-10
                'poli' => array(
                    'tujuan' => $poli,
                    'eksekutif' => $eksekutif   // *
                ),
                'cob' => array(
                    'cob' => '0' // asuransi
                ),
                'katarak' => array(
                    'katarak' => '0'
                ),
                'jaminan' => array(
                    'lakaLantas' => '0',
                    'penjamin' => array(
                        'penjamin' => '1',
                        'tglKejadian' => '',
                        'keterangan' => '',
                        'suplesi' => array(
                            'suplesi' => '0',
                            'noSepSuplesi' => '',
                            'lokasiLaka' => array(
                                'kdPropinsi' => '',
                                'kdKabupaten' => '',
                                'kdKecamatan' => ''
                            )
                        )
                    )
                ),
                'skdp' => array(
                    'noSurat' => $nosurat,      // *
                    'kodeDPJP' => $dpjp         // *
                ),
                'noTelp' => $notelp,
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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
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
    $nosep = $sep->response->sep->noSep;
    $tglsep = $sep->response->sep->tglSep;

    if ($jnspelayanan == 1) {
        $kolom = "NO_SKPINAP";
    } else {
        $kolom = "NO_SKP";
    };

    $update = "UPDATE PASIEN_VISITATION SET SEP_PRINTDATE = '$tglsep', $kolom = '$nosep' WHERE IDXDAFTAR = '$id'";
    // echo "<script type='text/javascript'>alert('$update');</script>";
    $stmt = sqlsrv_query($conn, $update);
    sqlsrv_close($conn);
    echo "<script type='text/javascript'>alert('Insert SEP Berhasil');</script>";
    echo "<script type='text/javascript'>window.location.href = 'https://192.168.1.234/simrs/pendaftaran/PasienVisitationEdit/" . $id . "?showmaster=cv_pasien&fk_NO_REGISTRATION=" . $no . "';</script>";
};




//print_r("https://192.168.1.234/simrs/pendaftaran/PasienEdit/".$id."?showmaster=cv_pasien&fk_NO_REGISTRATION=".$no)
?>