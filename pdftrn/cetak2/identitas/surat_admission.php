<?php
ob_start();
session_start();
include('../connect.php');

$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$idxdaftar = $_GET['idxdaftar'];

$sqlidentitas="SELECT 
    a.no_admission,
    c.nama,
    CASE
        WHEN c.jeniskelamin = 'L' THEN 'LAKI-LAKI'
        WHEN c.jeniskelamin = 'P' THEN 'PEREMPUAN'
    END AS JK,
    c.alamat,
    b.nomr,
    DATE_FORMAT(a.tglkeluar, '%d-%m-%Y') AS tglkeluar,
    b.usia,
    g.namadokter,
    j.no_surat_izin_praktek,j.signature,
    h.call_unit,
    CONCAT(d.icd10, ', ', i.str) AS icd,
    DATE_FORMAT(a.tglkeluar, '%d-%m-%Y') AS tanggal,
    date_format(a.tglkeluar, '%H:%i:%s') as jamkeluar,
    a.tingkat_prioritas,
    d.kategori_diagnosa,
    b.kelas
FROM
    simrs.bill_detail_transfer_pasien a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien c ON b.nomr = c.nomr
        LEFT JOIN
    simrs.bill_detail_penyakit d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    simrs.master_penyakit e ON d.id_penyakit = e.id_master_penyakit
        LEFT JOIN
    simrs2012.m_dokter g ON b.kddokter = g.kddokter
        LEFT JOIN
    simrs.userlevels h ON b.userlevelid = h.userlevelid
        LEFT JOIN
    simrs2012.vw_diagnosa_eklaim i ON d.icd10 = i.code
        LEFT JOIN
    simrs.master_login j ON g.kddokter = j.kddokter
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif and a.id_status_keluar=2";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
 $sqlruang="SELECT 
    b.userlevelname,c.nama_dokter
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.m_dokter c ON a.kddokter = c.kddokter
        AND a.userlevelid = c.userlevelid
WHERE
    a.idxdaftar = $idxdaftar
        AND a.id_bill_detail_tarif IN (SELECT 
            MIN(id_bill_detail_tarif)
        FROM
            simrs.bill_detail_tarif a
                LEFT JOIN
            simrs.userlevels b ON a.userlevelid = b.userlevelid
        WHERE
            b.id_pelayanan = 2
        GROUP BY a.idxdaftar)";
 $queryruang = mysql_query($sqlruang);
 $DATA_RUANGAN = mysql_fetch_array($queryruang);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SURAT ADMISSION</title>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 11px;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
.tabel {
    border-collapse:collapse;
}
</style>


</head>

<body>
  
	
	<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="60px" /></td>
            <td width="77%" align="center" style="font-size: 10px; font-weight: bold" valign="top">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
            </tr>
          </tbody>
      </table></td>
      <td width="33%" align="center" valign="middle" style="font-weight: bold">FORMULIR <br> PENGANTAR RAWAT INAP (ADMISSION NOTE)</td>
    </tr>
  </tbody>
</table>
	
	
	
	
<center>
</center>
<br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="30%">No. RM</td>
      <td width="40%">: <?php echo $DATA_IDENTITAS['nomr']; ?> </td>
      <td width="11%">&nbsp;</td>
      <td width="19%">&nbsp;</td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['JK']; ?></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Umur</td>
      <td>: <?php echo $DATA_IDENTITAS['usia']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Dengan Diagnosa tetap/sementara</td>
      <td>: <?php echo $DATA_IDENTITAS['icd']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>DPJP : <?php echo $DATA_RUANGAN['nama_dokter']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<br>
<u>Masih membutuhkan perawatan lebih lanjut di Rawat Inap RSUD Ajibarang:</u>
<br><br>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="39%">Dimasukan ke ruangan/bangsal</td>
      <td width="61%">: <?php echo $DATA_RUANGAN['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Kategori</td>
      <td>: <?php echo $DATA_IDENTITAS['kategori_diagnosa']; ?></td>
    </tr>
    <tr>
      <td>Kelas Perawatan</td>
      <td>: <?php echo $DATA_IDENTITAS['kelas']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Dikirim dari</td>
      <td>: <?php echo $DATA_IDENTITAS['call_unit']; ?></td>
    </tr>
    <tr>
      <td>Tingkat prioritas</td>
      <td>: <?php echo $DATA_IDENTITAS['tingkat_prioritas']; ?></td>
    </tr>
    <tr>
      <td>Sudah diberikan informasi dan Edukasi</td>
      <td>: Sudah</td>
    </tr>
  </tbody>
</table><br>
<table width="100%" class="tabel">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="27%">&nbsp;</td>
    <td width="44%" align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tanggal']; ?> Jam: <?php echo $DATA_IDENTITAS['jamkeluar']; ?> WIB</td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Nama dan tanda tangan <br> Dokter yang memasukkan</td>
  </tr>
	<tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><img height="60px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature']; ?>"/></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center"><?php echo $DATA_IDENTITAS['namadokter']; ?></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">SIP : <?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></td>
  </tr>
</table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 6.5 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('39_admission_note.pdf',array('Attachment' => 0));
?>