<?php
//code disini
ob_start();
session_start();
include('../connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sql="SELECT 
    date(a.tanggal) AS tanggal,
    time(a.tanggal) AS waktu,
    a.hd_etiologi,
    a.hd_penyulit,
    a.hd_penunjang,
    a.hd_target_pengobatan,
    a.hd_jenis_dialisat,
    a.hd_akses_sirkulasi,
    a.hd_durasi,
    a.hd_uf_goal,
    a.hd_bb_kering,
    a.hd_kecepatan_aliran_darah,
    a.hd_kecepatan_aliran_dialisat,
    a.hd_hiparinisasi,
    a.hd_program_profilling,
    a.hd_suhu,
    a.hd_terapi
FROM
    simrs.v_hd_asesmen_medis a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
    where a.id_bill_detail_tarif= 347034";

 $query = mysql_query($sql);
 $DATA = mysql_fetch_array($query);

 $sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
  date_format(b.tgllahir, '%d-%m-%Y') as tgllahir
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels f ON a.userlevelid = f.userlevelid
WHERE
    a.id_bill_detail_tarif = 347034";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>ASESMEN MEDIS UNIT HEMODIALISA</title>
  <style type="text/css">

    @page {
      margin-top: 0.5 cm;
      margin-left: 0.5 cm;
      margin-right: 0.5 cm;
      margin-bottom: 0.5 cm;
      font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
    }
    .tabel {
      border-collapse:collapse;
      /*border: 1px solid #999;*/
      font-size: 12px;

    }
    .spasi {
      padding-top: 15px;
      padding-bottom: 15px;
    }
    .spasi2 {
      padding-top: 10px;
      padding-bottom: 10px;
    }

    .label2 {
      font-size:10px;
      padding-top: 0px;
      padding-bottom: 0px;
    }

    .label3 {
      font-size:9px;
      padding-top: 0px;
      padding-bottom: 0px;
    }

    .label4 {
      font-size:7px;
      padding-top: 0px;
      padding-bottom: 0px;
    }

    .labelneo {
      font-size:16px;
      padding-top: 0px;
      padding-bottom: 0px;
    }
  </style>
</head>

<body>
  <table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%">
        <table width="100%" border="0">
          <tbody>
            <tr>
              <td width="23%" align="center"><img src="../gambar/logobms.png" height="40px" /></td>
              <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
            </tr>
          </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>LAPORAN<br> TINDAKAN<br> HEMODIALISA</strong></p></td>
      <td width="33%" valign="middle" style="font-weight: bold">
        <table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
    <br>
    <table class="tabel" border="1" width="100%">
      <tbody>
        <tr>
          <td>
            <table class="tabel" border="0" width="100%">
              <tbody>
                <tr>
                  <td>
                    <table width="100%">
                      <body>
                        <tr>
                          <!-- <td colspan="1"><center><font style="font-size:12px;">A.</center></td> -->
                          <td colspan="5" style="text-align: left;"><font style="font-size:12px;">Tanggal</td>
                          <td colspan="6" style="text-align: left;"><font style="font-size:12px;">: <?php echo $DATA['tanggal']; ?></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Jam</td>
                          <td colspan="7" style="text-align: left;"><font style="font-size:12px;">: <?php echo $DATA['waktu']; ?> WIB</td>
                        </tr>
                      </body>
                    </table>
                    <table width="100%">
                      <body>
                        <tr>
                          <td colspan="3" style="text-align: left;"><font style="font-size:12px;">Asal Pasien :</td>
                          <td colspan="17" style="text-align: left;"><font style="font-size:12px;">: ...........</td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">I.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Penanggung</td>
                          <td colspan="17" style="text-align: left;"><font style="font-size:12px;">: ...........</td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">II.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Diagnosa Penyakit Ginjal</td>
                          <td colspan="17" style="text-align: left;"><font style="font-size:12px;">: ...........</td>
                        </tr>
                        <tr>
                          <td colspan="3" style="text-align: left;"><font style="font-size:12px;">Etiologi</td>
                          <td colspan="17" style="text-align: left;"><font style="font-size:12px;">: <?php echo $DATA['hd_etiologi']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="3" style="text-align: left;"><font style="font-size:12px;">Penyulit</td>
                          <td colspan="17" style="text-align: left;"><font style="font-size:12px;">: <?php echo $DATA['hd_penyulit']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="3" style="text-align: left;"><font style="font-size:12px;">Penyakit Penyerta</td>
                          <td colspan="17" style="text-align: left;"><font style="font-size:12px;">: .....................................................</td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">III.</center></td>
                          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Anamnesis</td>
                        </tr>
                        <tr>
                          <td colspan="20" style="text-align: left;"><font style="font-size:12px;">...........</td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">IV.</center></td>
                          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Pemeriksaan Fisik</td>
                        </tr>
                        <tr>
                          <td colspan="20" style="text-align: left;"><font style="font-size:12px;">...........</td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">V.</center></td>
                          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Data Penunjang</td>
                        </tr>
                        <tr>
                          <td colspan="20" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_penunjang']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">VI.</center></td>
                          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Target Pengobatan</td>
                        </tr>
                        <tr>
                          <td colspan="20" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_target_pengobatan']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">VII.</center></td>
                          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Resep Dialisis</td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">1.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Jenis Dialisat</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_jenis_dialisat']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">2.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Akses Sirkulasi</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_akses_sirkulasi']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">3.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Durasi HD (Td)</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_durasi']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">4.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">UF Goal</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_uf_goal']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">5.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">BB Kering</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_bb_kering']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">6.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Kecepatan aliran darah (Qb)</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_kecepatan_aliran_darah']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">7.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Kecepatan aliran dialisat (Qd)</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_kecepatan_aliran_dialisat']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">8.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Heparinisasi</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_hiparinisasi']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">9.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Program profiling</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_program_profilling']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">10.</center></td>
                          <td colspan="2" style="text-align: left;"><font style="font-size:12px;">Suhu</td>
                          <td colspan="1" style="text-align: left;"><font style="font-size:12px;">:</td>
                          <td colspan="16" style="text-align: left;"><font style="font-size:12px;"><?php echo $DATA['hd_suhu']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;">VII.</center></td>
                          <td colspan="19
                          " style="text-align: left;"><font style="font-size:12px;">Terapi : <?php echo $DATA['hd_terapi']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="1"><center><font style="font-size:12px;"></center></td>
                          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">............................................................................................................................................................................</td>
                        </tr>
                      </body>
                    </table>
                  </td>
                </tr>
                
              </tbody>
            </table>

            <br>
            <table width="100%">
              <body style="text-align: center">
                <tr>
                  <td width="50%"><center><font style="font-size:12px;"></font></center></td>
                  <td width="50%"><center><font style="font-size:12px;">Dokter</font></center></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="50%"><center><font style="font-size:12px;"></font></center></td>
                  <td width="50%"><center><font style="font-size:12px;">(................................)</font></center></td>
                </tr>
                <tr>
                  <td width="50%"><center><font style="font-size:12px;"></font></center></td>
                  <td width="50%"><center><font style="font-size:12px;">Tanda tangan dan nama jelas</font></center></td>
                </tr>
              </body>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <table width="100%" class="tabel" border="0">
      <tbody>
        <tr>
          <td colspan="20" style="text-align: left;"><font style="font-size:12px;"><b>Petunjuk Pengisian :</b></td>
        </tr>
        <tr>
          <td colspan="1"><right><font style="font-size:12px;">1.</right></td>
          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Catatan medis bisa dijadikan AOP medis (sesuaikan dengan kebijakan dan kebutuhan instansi)</td>
        </tr>
        <tr>
          <td colspan="1"><right><font style="font-size:12px;">2.</right></td>
          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Diisi oleh nefrologist atau Sp.PD terlatih/tersertifikasi HD</td>
        </tr>
        <tr>
          <td colspan="1"><right><font style="font-size:12px;">3.</right></td>
          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Pada kondisi HD cito/akut jika tidak ada nefrologist atau Sp.PD terlatih/tersertifikasi HD boleh diisi oleh dokter jaga</td>
        </tr>
        <tr>
          <td colspan="1"><right><font style="font-size:12px;">4.</right></td>
          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Dibuat sesuai dengan kebijakan masing-masing instansi (tuangkan dalam kebijakan/pedoman)</td>
        </tr>
        <tr>
          <td colspan="1"><right><font style="font-size:12px;">5.</right></td>
          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Pada bagian laboratorium  : diisi dengan hasil terakhir pemeriksaan</td>
        </tr>
        <tr>
          <td colspan="1"><right><font style="font-size:12px;">6.</right></td>
          <td colspan="19" style="text-align: left;"><font style="font-size:12px;">Pada bagian terapi rutin yang diberikan termasuk terapi EPO.Zat besi dll, jika terjadi perubahan terapi maka catatan medic harus diulang atau di perbaharui (cantumkan dalam kebijakan)</td>
        </tr>

      </tbody>
    </table>
    <br>
  </body>
  </html>

  <?php
  $html = ob_get_clean();
  require_once("../dompdf_baru/dompdf_config.inc.php");
  $dompdf = new DOMPDF();
  $paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
  $dompdf->set_paper($paper_size, 'portrait');
  $dompdf->load_html($html);
  $dompdf->render();
  $dompdf->stream('laporanoperasi.pdf',array('Attachment' => 0));
  ?>