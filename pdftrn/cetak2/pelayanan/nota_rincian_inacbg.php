<?php
ob_start();
session_start();
include('connect.php');
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,a.nomr,b.nama,b.alamat,b.jeniskelamin,date_format(b.tgllahir, '%d-%m-%Y') as tgllahir,c.nama as carabayar,date_format(a.tanggal, '%d-%m-%Y') as tglmasuk,a.biaya_obat,biaya_obat_retur,a.biaya_obat-IFNULL(biaya_obat_retur,0) AS total_keseluruhan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
    left join simrs2012.m_carabayar c on a.kdcarabayar=c.kode

WHERE
    a.idxdaftar=$idxdaftar";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqliteminacbg="SELECT a.*,b.userlevelname FROM simrs.v_bill_inacbg a left join simrs.userlevels b on a.userlevelid=b.userlevelid where a.idxdaftar=$idxdaftar";
$queryiteminacbg = mysql_query($sqliteminacbg);

$sqltotal="SELECT sum(total_keseluruhan) as grandtotal from v_bill_inacbg where idxdaftar=$idxdaftar group by idxdaftar";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);


$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rincian Obat</title>
<link rel="shortcut icon" href="../favicon.ico"/>
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
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}
</style>

</head>

<body>


<table width="100%" class="tabel" border="1">
    <tr>
      <td width="10%" style="vertical-align:top" class="header"><img src="gambar/logobms.png" height="60px" /></td>
      <td width="90%" style="vertical-align:top" height="60px" class="header"><strong>RSUD AJIBARANG - RIIL COST INACBGs</strong><br />
          <strong>Jl. Raya Pancasan - Ajibarang, Banyumas<br />
      TELP: (0281) 557 0004 FAX: - (0281)5670005<br />
      Kode Pos : 53163 -</strong></td>
      <td width="20%" style="vertical-align:top" class="header">No. Ref: <?php echo $DATA_IDENTITAS['id_bill_detail_tarif']; ?> <br> Tanggal Cetak: <?php echo date("d-m-Y") ?></td>
    </tr>
</table>
  

    <div align="center"><strong>RINCIAN RIIL COST (TARIF RS) INA-CBGs</strong></div>



<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%">Alamat</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>Status Pembayaran </td>
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
      <td>Tanggal Keluar</td>
      <td>: </td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
  <tr>
    <td width="1%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Unit</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Non Bedah</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>TnG Ahli</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Radiologi</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Rehabilitas</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Obat</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Sewa Alat</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Bedah</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Keperawatan</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Laboratorium</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Akomodasi</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Alkes/Kamar</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Konsultasi</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Penunjang</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Pel Darah</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Intensive</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>BMHP</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>Total</strong></td>
  </tr>
  
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryiteminacbg)){
				echo '<tr>';
				echo '<td align="center">'.$no.'</td>';
				echo '<td align="left">'.$data['userlevelname'].'</td>';
				echo '<td align="right">'.number_format($data['inacbg_non_bedah'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_tenaga_ahli'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_radiologi'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_fisioterapi'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_obat'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_sewa_alat'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_bedah'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_keperawatan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_laboratorium'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_akomodasi'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_alkes'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_konsultasi'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_penunjang'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_pelayanan_darah'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_intensive'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['inacbg_bhp'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total_keseluruhan'], 0,",",".").'</td>';
				
				echo '</tr>';
				
			$no++;
		}
		?>
  
  <tr>
    <td colspan="26" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right">Rp.<?php echo number_format($DATA_TOTAL['grandtotal'], 0,",","."); ?></td>
    </tr>
     <tr>
       <td align="right">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" class="footer"><strong>Rp.<?php echo number_format($DATA_TOTAL['grandtotal'], 0,",","."); ?></strong></td>
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
$paper_size = array(0,0, 8.46 * 72, 12.99 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('biaya_inacbg.pdf',array('Attachment' => 0));
?>