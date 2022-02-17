<?php
ob_start();
session_start();
include('../connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];
$userlevelid= $_GET['userlevelid'];
$id_master_obat_detail= $_GET['id_master_obat_detail'];


$sqlitemstok="SELECT 
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tanggal,
    a.id_master_obat_detail,
    c.nama_obat,
    SUM(a.qty) AS qty,
    a.tarif_obat,
    a.total,
    a.userlevelid,
    d.nomr,
    CONCAT(e.nama, ', ', e.alamat) AS nama,
    g.nama_dokter,
    (SELECT 
            GROUP_CONCAT(CONCAT(z.icd10, ', ', y.str)
                    SEPARATOR ', ') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
        WHERE
            z.id_bill_detail_tarif = f.id_bill_detail_tarif
        GROUP BY a.id_bill_detail_tarif) AS diagnosa,h.call_unit
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master d ON a.id_bill_detail_permintaan_obat_master = d.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    simrs2012.m_pasien e ON d.nomr = e.nomr
        LEFT JOIN
    simrs.bill_detail_tarif f ON d.id_bill_detail_tarif = f.id_bill_detail_tarif
        LEFT JOIN
    simrs.m_dokter g ON f.kddokter = g.kddokter
        AND f.userlevelid = g.userlevelid
		left join
	simrs.userlevels h on f.userlevelid=h.userlevelid
WHERE
    a.userlevelid = $userlevelid
        AND a.id_master_obat_detail = $id_master_obat_detail
        AND DATE(a.tanggal) >= '$dari_tanggal'
        AND DATE(a.tanggal) <= '$sampai_tanggal'
        group by d.nomr,date(a.tanggal)";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

?>



<html>
<head>
<meta charset="utf-8">
<title>Obat Keluar</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 9px;
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

    <div align="center" class="header"><strong>LAPORAN OBAT KELUAR</strong></div>

<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Nama Obat</td>
      <td colspan="3">: <?php echo $DATA_OBAT['nama_obat']; ?></td>
    </tr>
    <tr>
      <td>Dari Tanggal</td>
      <td width="27%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="15%" align="right">Sampai Tanggal</td>
      <td width="46%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>

<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%" >No.</td>
      <td width="8%" align="center">Tanggal</td>
      <td width="5%" align="center">NORM</td>
      <td width="24%" >Nama Pasien</td>
      <td width="25%" align="center" >Diagnosa</td>
      <td width="14%" align="center" >Dokter</td>
      <td width="3%" align="center" >Jumlah</td>
      <td width="9%" align="right" >Ruang</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemstok)){
			echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td align="center">'.$data['tanggal'].'</td>';
			echo '<td align="center">'.$data['nomr'].'</td>';
			echo '<td>'.$data['nama'].'</td>';
			echo '<td>'.$data['diagnosa'].'</td>';
			echo '<td>'.$data['nama_dokter'].'</td>';
	  echo '<td align="right">'.$data['qty'].'</td>';
	  echo '<td align="right">'.$data['call_unit'].'</td>';
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
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>