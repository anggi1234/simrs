<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_tindakan= $_GET['id_tindakan'];


$sqlitemtindakan="SELECT 
    a.uid,
    c.pd_nickname,
    b.nama_profesi,
    a.userlevelid,
    IFNULL(d.nama_tindakan, '-') AS nama_tindakan,
    IFNULL(d.jumlah_tindakan, 0) AS jumlah_tindakan,
    IFNULL(d.tarif, 0) AS tarif,
    IFNULL(d.total, 0) AS total,e.userlevelname
FROM
    simrs.l_dokter_standby a
        LEFT JOIN
    simrs.master_profesi b ON a.id_profesi = b.id_profesi
        LEFT JOIN
    simrs.master_login c ON a.uid = c.uid
        LEFT JOIN
    (SELECT 
        a.l_standby_dokter,
            b.nama_tindakan,
            SUM(qty) AS jumlah_tindakan,
            a.tarif_pelayanan + a.tarif_jasa_sarana AS tarif,
            SUM(qty) * (a.tarif_pelayanan + a.tarif_jasa_sarana) AS total
    FROM
        bill_detail_tindakan a
    LEFT JOIN master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        a.id_tindakan = $id_tindakan
            AND (a.tanggal_tindakan >= '$dari_tanggal'
            AND a.tanggal_tindakan <= '$sampai_tanggal')
            AND a.userlevelid = $userlevelid
    GROUP BY a.l_standby_dokter) d ON a.id_dokter_standby = d.l_standby_dokter
	LEFT JOIN
    userlevels e ON a.userlevelid = e.userlevelid
WHERE
    a.userlevelid = $userlevelid
        AND (a.id_profesi = 1 OR a.id_profesi = 3
        OR a.id_profesi = 4
        OR a.id_profesi = 6
        OR a.id_profesi = 12
        OR a.id_profesi = 13
        OR a.id_profesi = 16)";
$queryitemtindakan = mysql_query($sqlitemtindakan);
$queryitemtindakan1 = mysql_query($sqlitemtindakan);
$DATA_TINDAKAN = mysql_fetch_array($queryitemtindakan1);

$sqlusername="select * from master_tindakan where id_tindakan=$id_tindakan";
 $queryusername = mysql_query($sqlusername);
 $DATA_IDENTITAS = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Stok Pengeluaran</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
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
      <td width="10%" rowspan="3" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
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
  

    <div align="center" class="header"><strong>LAPORAN TINDAKAN</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Tindakan</td>
      <td width="35%">: <?php echo $DATA_IDENTITAS['nama_tindakan']; ?></td>
      <td width="15%" align="right">Unit</td>
      <td width="38%">: <?php echo $DATA_TINDAKAN['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td align="right">Sampai Tanggal</td>
      <td>: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="50%">Dokter</td>
      <td width="20%" align="center">Tindakan</td>
      <td width="10%" align="center">Jumlah</td>
      <td width="10%" align="center">Biaya Tindakan</td>
      <td width="10%" align="center">Total</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemtindakan)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['pd_nickname'].'</td>';
	  echo '<td>'.$data['nama_tindakan'].'</td>';
	  echo '<td align="center">'.$data['jumlah_tindakan'].'</td>';
      echo '<td><div align="right">'.number_format($data['tarif'], 2,",",".").'</div></td>';
			echo '<td><div align="right">'.number_format($data['total'], 2,",",".").'</div></td>';
			$no++;
		}
	?>
    
  </tbody>
</table>

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
$dompdf->stream('laporantindakan.pdf',array('Attachment' => 0));
?>