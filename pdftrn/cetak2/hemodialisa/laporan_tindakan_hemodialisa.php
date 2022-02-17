<?php
//code disini
ob_start();
session_start();
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlhd = "SELECT
    date_format(a.tanggal, '%d-%m-%Y') as tanggal,
    date_format(a.dari_jam, '%H:%i') as dari_jam,
    date_format(a.sampai_jam, '%H:%i') as sampai_jam,
    a.time_dialisis,
    a.pre_suhu,
    a.uf_goal,
    a.quick_blood,
    a.quick_dialysat,
    a.uf,
    a.na,
    a.akses_sirkulasi,
    a.pre_keluhan,
    a.pre_keadaan_umum,
    a.pre_kesadaran,
    a.pre_tensi,
    a.pre_nadi,
    a.pre_suhu,
    a.pre_respirasi,
    a.on_hd,
    a.post_hd,
    a.ha_time_dialysis,
    a.ha_tranfusi,
    a.ha_terapi,
    a.ha_asupan,
    a.ha_jumlah,
    a.ha_uf_goal,
    a.ha_uf_total,
    a.keterangan_lain,
    a.tanggal,
    a.jenis_program,
    c.signature
FROM
    simrs.hd_laporan_tindakan a
    LEFT JOIN simrs.bill_detail_tarif b on a.id_bill_detail_tarif = b.id_bill_detail_tarif
    LEFT JOIN simrs.master_login c on b.kddokter=c.kddokter
WHERE
    b.idxdaftar = $idxdaftar AND a.id_bill_detail_tarif = $id_bill_detail_tarif";

$queryhd = mysql_query($sqlhd);
$DATAHD = mysql_fetch_array($queryhd);

$sqlidentitas = "SELECT 
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
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

?>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Tindakan Hemodialisa</title>
  <style type="text/css">
    @page {
      margin-top: 1 cm;
      margin-left: 1 cm;
      margin-right: 1 cm;
      margin-bottom: 1 cm;
      font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
      font-size: 12px;
    }

    .tabel {
      border-collapse: collapse;
    }

    .header {
      font-size: 12px;
    }

    .footer {
      font-size: 12px;
    }

    .isi {
      font-size: 10px;
    }

    .pagebreak {
      page-break-before: always;
    }

    .vertical-line {
      display: inline-block;
      border-left: 1px solid #000000;
      height: 40px;
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
                <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004 Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
              </tr>
            </tbody>
          </table>
        </td>
        <td width="33%" style="font-size: 12px">
          <p align="center"><strong>LAPORAN<br> TINDAKAN<br> HEMODIALISA</strong></p>
        </td>
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
          </table>
        </td>
      </tr>
    </tbody>
  </table>

  <div>
    <strong>Laporan Tindakan</strong>
  </div>

  <table width="100%" class="tabel" border="0">
    <tr>
      <td width="22%">Hari/tanggal</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['tanggal']; ?></td>
      <td width="15%">Waktu HD</td>
      <td width="2%">:</td>
      <td width="27%">Pkl <?= $DATAHD['dari_jam']; ?> s/d pkl <?= $DATAHD['sampai_jam']; ?> WIB </td>
    </tr>
    <tr>
      <td width="22%">Ruang rawat</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['userlevelname']; ?></td>
      <td width="15%">Status</td>
      <td width="2%">:</td>
      <td width="27%"><?= $DATAHD['status']; ?></td>
    </tr>
    <tr>
      <td width="22%">Dilakukan program</td>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="22%">Tim Dialisis</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['time_dialisis']; ?> Jam</td>
      <td width="15%">Suhu</td>
      <td width="2%">:</td>
      <td width="27%"><?= $DATAHD['pre_suhu']; ?></td>
    </tr>
    <tr>
      <td width="22%">UF GOAL</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['uf_goal']; ?> ml</td>
    </tr>
    <tr>
      <td width="22%">Quick Blood</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['quick_blood']; ?> ml/mnt</td>
    </tr>
    <tr>
      <td width="22%">Quick Dialysat</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['quick_dialysat']; ?> ml/mnt</td>
    </tr>
    <tr>
      <td rowspan="2">Profiling</td>
      <td>UF</td>
      <td width="31%">:
        <?= $DATAHD['uf']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="27%">Lainnya
        <?= $DATAHD['']; ?></td>
    </tr>
    <tr>
      <td width="3%">Na</td>
      <td width="31%">:
        <?= $DATAHD['na']; ?></td>
      <td width="15%">&nbsp;</td>
    </tr>
    <tr>
      <td width="22%">Akses Sirkulasi</td>
      <td width="3%">:</td>
      <td width="31%"><?= $DATAHD['akses_sirkulasi']; ?></td>
    </tr>
  </table>

  <table width="100%" class="tabel" border="0">
    <tr>
      <td><strong>Pre HD</strong></td>
    </tr>
    <tr>
      <td width="20%">Keluhan utama</td>
      <td width="2%">:</td>
      <td width="28%"><?= $DATAHD['pre_keluhan']; ?></td>
    </tr>
    <tr>
      <td width="20%">Keadaan umum</td>
      <td width="2%">:</td>
      <td width="28%"><?= $DATAHD['pre_keadaan_umum']; ?></td>
      <td width="20%">Kesadaran</td>
      <td width="5%">:</td>
      <td width="25%"><?= $DATAHD['pre_kesadaran']; ?></td>
    </tr>
    <tr>
      <td width="20%">Tensi</td>
      <td width="2%">:</td>
      <td width="28%"><?= $DATAHD['pre_tensi']; ?> mmHg</td>
      <td width="20%">Nadi</td>
      <td width="5%">:</td>
      <td width="25%"><?= $DATAHD['pre_nadi']; ?> x/mnt</td>
    </tr>
    <tr>
      <td width="20%">Suhu</td>
      <td width="2%">:</td>
      <td width="28%"><?= $DATAHD['pre_suhu']; ?> C</td>
      <td width="20%">Respirasi</td>
      <td width="5%">:</td>
      <td width="25%"><?= $DATAHD['pre_respirasi']; ?> x/mnt On Ventilator</td>
    </tr>
  </table>

  <table width="100%" class="tabel" border="0">
    <tr>
      <td width="10%"><strong>On HD</strong></td>
      <td width="5%">:</td>
      <td width="85%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;<?= $DATAHD['on_hd']; ?></td>
    </tr>
  </table>

  <table width="100%" class="tabel" border="0">
    <tr>
      <td width="10%"><strong>Post HD</strong></td>
      <td width="5%">:</td>
      <td width="85%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;<?= $DATAHD['post_hd']; ?></td>
    </tr>
  </table>

  <table width="699">
    <tr>
      <td colspan="6"><strong>Hasil Akhir HD</strong></td>
    </tr>
    <tr>
      <td width="20%">Tim Dialysis</td>
      <td width="3%">:</td>
      <td width="30%">&nbsp;<?= $DATAHD['ha_time_dialysis']; ?> jam</td>
      <td width="8%">Transfusi</td>
      <td width="2%">:</td>
      <td width="37%">&nbsp;<?= $DATAHD['ha_tranfusi']; ?> ml</td>
    </tr>
    <tr>
      <td width="20%">Terapi Cairan</td>
      <td width="3%">:</td>
      <td width="30%">&nbsp;<?= $DATAHD['ha_terapi']; ?> ml</td>
    </tr>
    <tr>
      <td width="20%">Asupan Cairan(Oral/NGT)</td>
      <td width="3%">:</td>
      <td width="30%">&nbsp;<?= $DATAHD['ha_asupan']; ?> ml</td>
    </tr>
    <tr>
      <td width="20%">Jumlah</td>
      <td width="3%">:</td>
      <td width="30%">&nbsp;<?= $DATAHD['ha_jumlah']; ?> ml</td>
      <td width="8%">Uf Total</td>
      <td width="2%">:</td>
      <td width="37%">&nbsp;<?= $DATAHD['ha_uf_total']; ?> ml</td>
    </tr>
    <tr>
      <td width="20%">Keterangan lain</td>
      <td width="3%">:</td>
      <td width="30%">&nbsp;<?= $DATAHD['keterangan_lain']; ?></td>
    </tr>
  </table>

  <table width="100%">

    <body>
      <tr>
        <td width="50%">
          <center>
            <font style="font-size:12px;">Darah untuk pemeriksaan laboratorium <?= "" ?></font>
          </center>
        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%">
          <center>
            <font style="font-size:12px;">Dokter jaga</font>
          </center>
          <center><img height="100px" src="../../uploads/<?php echo $DATAHD['signature']; ?>" /></center>
        </td>
        <td width="50%">
          <center>
            <font style="font-size:12px;">Perawat</font>
          </center>
          <center><img height="100px" src="../../uploads/<?php echo $DATAHD['signature']; ?>" /></center>
        </td>
      </tr>
      <!-- <tr>
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
      </tr> -->
      <tr>
        <td width="50%">
          <center>
            <font style="font-size:12px;">(..........)</font>
          </center>
        </td>
        <td width="50%">
          <center>
            <font style="font-size:12px;">(...........)</font>
          </center>
        </td>
      </tr>
      <tr>
        <td width="50%">
          <center>
            <font style="font-size:10px;">Tanda tangan dan nama jelas</font>
          </center>
        </td>
        <td width="50%">
          <center>
            <font style="font-size:10px;">Tanda tangan dan nama jelas</font>
          </center>
        </td>
      </tr>
    </body>
  </table>

  <div><em>*)coret yang tidak perlu</em></div>
  <div><strong>PETUNJUK PENGISIAN LAPORAN TINDAKAN HEMODIALISA</strong></div>
  <div>1.Dibuat sebagai laporan untuk ruang lain ( EMG,Rawat Inap, atau ntensive/high care</div>
  <div>2.Dibuat sebagai gambaran tindakan HD yang dilakkan</div>
  <div>3.Ditandatangani dokter DPJP atau dokter jaga ruangan dan perawat pelaksanan tindakan HD</div>
  <div>4.Merupakan rangkuman dari AOP perawat dan AOP Medis</div>
  <div>5.Hasil akhir HD merupakan hasil HD yang dilaksanakan tekait kemungkinan perubahan antara program HD dngan hasil akhir karena kendala intra dialisis</div>

  <br>

  <div style="font-size: 9px; font-style: oblique">Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.</div>
  <div style="font-size: 9px; font-style: oblique">SIMRS VERSI 2.0 RSUD Ajibarang</div>

</body>

</html>

<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0, 0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanoperasi.pdf', array('Attachment' => 0));
?>