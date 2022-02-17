<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];

$sqlrincian="SELECT 
    a.temp_biaya_pendaftaran AS biaya_pendaftaran,
    a.temp_biaya_jasar AS biaya_jasar,
    a.temp_biaya_pemeriksaan AS biaya_pemeriksaan,
    a.temp_biaya_askep AS biaya_askep,
    a.temp_biaya_penj_non_medis AS biaya_penj_non_medis,
    a.biaya_usg,
    (SELECT 
            GROUP_CONCAT(b.nama_tindakan
                    SEPARATOR ', ')
        FROM
            bill_detail_tindakan a
                LEFT JOIN
            master_tindakan b ON a.id_tindakan = b.id_tindakan
        WHERE
            a.id_bill_detail_tarif = $id_bill_detail_tarif
        GROUP BY a.id_tindakan) as tindakan,
    IFNULL(a.temp_biaya_pendaftaran, 0) + IFNULL(a.temp_biaya_jasar, 0) + IFNULL(a.temp_biaya_pemeriksaan, 0) + IFNULL(a.temp_biaya_askep, 0) + IFNULL(a.temp_biaya_penj_non_medis, 0) + IFNULL(a.biaya_usg, 0) AS total
FROM
    bill_detail_tarif a
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryrincian = mysql_query($sqlrincian);
 $DATA_RINCIAN = mysql_fetch_array($queryrincian);


$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tglmasuk
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA PENUNJANG</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
		font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 14px;
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

    <div align="center"><strong>RINCIAN LAYANAN RAWAT JALAN</strong></div>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. Rekam Medis</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%">No. Pelayanan</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Status Pembayaran</td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td>Tanggal Masuk</td>
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td>Alamat</td>
      <td>: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>
<table width="100%" class="tabel" border="1">
  <tr>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="40%" align="center" bgcolor="#FFFFFF"><strong>JENIS PELAYANAN</strong></td>
    <td width="19%" align="center" bgcolor="#FFFFFF"><strong>TARIF</strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">1.</td>
    <td bgcolor="#FFFFFF">PENDAFTARAN</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_pendaftaran'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">2.</td>
    <td bgcolor="#FFFFFF">JASA SARANA</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_jasar'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">3.</td>
    <td bgcolor="#FFFFFF">PEMERIKSAAN DOKTER</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_pemeriksaan'], 0,",","."); ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">4.</td>
    <td bgcolor="#FFFFFF">PENUNJANG NON MEDIS</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_penj_non_medis'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">5.</td>
    <td bgcolor="#FFFFFF">ASUHAN KEPERAWATAN</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_askep'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">6.</td>
    <td bgcolor="#FFFFFF">(<?php echo $DATA_RINCIAN['tindakan']; ?>)</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_usg'], 0,",","."); ?></td>
  </tr>
  <tr>
  	    <td colspan="3" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Petugas Kasir</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="15%" align="right">&nbsp;</td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total"></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" class="footer"><strong>Rp<?php echo number_format($DATA_RINCIAN['total'], 0,",","."); ?></strong><hr></td>
    </tr>
        </tbody>
      </table>
    	
    	
    </td>
  </tr>
  </table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notapenunjang.pdf',array('Attachment' => 0));
?>