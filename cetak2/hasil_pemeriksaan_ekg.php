<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];

$sqlidentitas="SELECT 
    d.nama AS Nama,
    b.nomr AS 'No. RM',
    b.usia AS Umur,
    d.JENISKELAMIN AS 'Jenis Kelamin',
    d.ALAMAT AS Alamat,
    c.nama_dokter AS 'Permintaan dr.',
    DATE_FORMAT(b.tglreg,'%d-%m-%Y') AS Tanggal,
    a.tensi AS Tensi,
    a.laju_jantung AS 'Laju Jantung',
    a.irama AS Irama,
    a.sumbu AS 'Sumbu & Posisi',
    a.transisi AS 'Zone Transisi',
    a.rotasi AS 'Rotasi',
    a.gel_p AS 'Gelombang P',
    a.gel_q AS 'Gelombang Q',
    a.kel_qrs AS 'Komplek QRS',
    a.gel_t AS 'Gelombang T',
    a.lain_lain AS 'Lain-lain',
    a.kesimpulan AS 'Kesimpulan',
    a.saran AS 'Saran',
    a.interval_pr AS 'Interval P-R',
    a.interval_qt AS 'Interval QT',
    a.segmen_st AS 'Segmen S-T',
    a.gel_u AS 'Gelombang U',
    a.userlevelid,
    e.signature AS 'Ttd',
    e.no_surat_izin_praktek AS 'Izin praktek'
FROM
    simrs.bill_detail_keterangan_ekg a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs.m_dokter c ON b.kddokter = c.kddokter
        AND b.userlevelid = c.userlevelid
        LEFT JOIN
    simrs2012.m_pasien d ON b.nomr = d.NOMR
        LEFT JOIN
    simrs.master_login e ON a.username = e.username
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

function Terbilang($nilai) {
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if($nilai==0){
    return "";
  }elseif ($nilai < 12&$nilai!=0) {
    return "" . $huruf[$nilai];
  } elseif ($nilai < 20) {
    return Terbilang($nilai - 10) . " Belas ";
  } elseif ($nilai < 100) {
    return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
  } elseif ($nilai < 200) {
    return " Seratus " . Terbilang($nilai - 100);
  } elseif ($nilai < 1000) {
    return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
  } elseif ($nilai < 2000) {
    return " Seribu " . Terbilang($nilai - 1000);
  } elseif ($nilai < 1000000) {
    return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
  } elseif ($nilai < 1000000000) {
    return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
  }elseif ($nilai < 1000000000000) {
    return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
  }elseif ($nilai < 100000000000000) {
    return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
  }elseif ($nilai <= 100000000000000) {
    return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
  }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kwitansi Pembayaran Umum</title>
  <style type="text/css">
    @page {
      margin-top: 0.5 cm;
      margin-left: 0.5 cm;
      margin-right: 0.5 cm;
      margin-bottom: 0.5 cm;
      font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
    }

    .tabel {
      border-collapse: collapse;
      font-size: 9px;
      text-align: right;
    }  

    .header {
      font-size: 12px;
    } 
    .footer {
      font-size: 12px;
    }

    .pagebreak { 
      page-break-before: always;
    }

  </style>
</head>

<body>
  <table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="gambar/logobms.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 16px">PEMERINTAH KABUPATEN BANYUMAS</td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 21px">RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 <br> 
        Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      E-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
  </table>
  <hr>
  <div align="center"><strong>HASIL PEMERIKSAAN EKG</strong></div>
  <br>
  <table width="100%" border="0" cellspacing="2">
    <tbody style="font-size: 12px">
      <tr>
        <td width="4%">&nbsp;</td>
        <td width="30%">Nama</td>
        <td width="1%">:</td>
        <td width="70%"><?php echo $DATA_IDENTITAS['Nama']; ?></td>
        <td width="4%">&nbsp;</td>
        <td width="25%">NO RM</td>
        <td width="1%">:</td>
        <td width="70%"><?php echo $DATA_IDENTITAS['No. RM'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Umur']; ?></td>
        <td width="4%">&nbsp;</td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Jenis Kelamin']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Alamat'];?> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="top">Permintaan dr.</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $DATA_IDENTITAS['Permintaan dr.']; ?></td>
        <td>&nbsp;</td>
        <td valign="top">Tanggal</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $DATA_IDENTITAS['Tanggal']; ?></td>
      </tr>
    </tbody>
  </table>

  <br>

  <table width="100%" border="0" cellspacing="2" style="font-size: 12px">
    <tbody>
      
      <tr>
        <td>&nbsp;</td>
        <td>Tensi</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Tensi']; ?>mmHg</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Laju Jantung</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Laju Jantung']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Irama</td>
        <td>:</td>
        <td><?php echo Terbilang($DATA_IDENTITAS['Irama']) ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Sumbu & Posisi</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Sumbu & Posisi']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Zone Transisi</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Zone Transisi']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Rotasi</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Rotasi']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Gelombang P</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Gelombang P']; ?></td>
        <td>&nbsp;</td>
        <td>Gelombang PR</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Interval P-R']; ?> / detik</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>Gelombang Q</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Gelombang Q']; ?></td>
        <td>&nbsp;</td>
        <td>Interval QT</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Interval QT']; ?> / detik</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>Komplek QRS</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Komplek QRS']; ?></td>
        <td>&nbsp;</td>
        <td>Segmen S-T</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Segmen S-T']; ?></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>Gelombang T</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Gelombang T']; ?></td>
        <td>&nbsp;</td>
        <td>Gelombang U</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Gelombang U']; ?></td>
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>Lain-lain</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Lain-lain']; ?></td>
      </tr>
        <tr>
        <td>&nbsp;</td>
        <td>Kesimpulan</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Kesimpulan']; ?></td>
      </tr>
      </tr>
        <tr>
        <td>&nbsp;</td>
        <td>Saran</td>
        <td>:</td>
        <td><?php echo $DATA_IDENTITAS['Saran']; ?></td>
      </tr>

    </tbody>
  </table>
  <br>
  <table width="100%" border="0" style="font-size: 12px">
    <tbody>
      <tr>
        <td width="29%" align="center">&nbsp;</td>
        <td colspan="6" align="right">&nbsp;</td>
        <td width="32%" align="center">Ajibarang, <?php echo $DATA_IDENTITAS['Tanggal']; ?></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td colspan="6" align="right">&nbsp;</td>
        <td align="center" class="total">Pembaca</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td colspan="6" align="right">&nbsp;</td>
        <td align="center"><img  height="100px" src="../uploads/<?php echo $DATA_IDENTITAS['Ttd'];?>"></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td colspan="6" align="right">&nbsp;</td>
        <td align="center"><?php echo $DATA_IDENTITAS['username'];?></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td colspan="6" align="right">&nbsp;</td>
        <td align="center"><?php echo $DATA_IDENTITAS['Izin praktek'];?></td>
      </tr>
    </tbody>
  </table>

</body>
</html>
<?php
$html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 7.66 * 72, 8 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('44_ekg.pdf',array('Attachment' => 0));
?>