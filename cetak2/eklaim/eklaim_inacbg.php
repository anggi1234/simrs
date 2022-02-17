<?php
$idxdaftar = $_GET['idxdaftar'];
$username = $_GET['username'];
include_once('identitas.php');


$sqliteminacbg="SELECT 
    a.*, b.userlevelname, c.keterangan
FROM
    simrs.v_bill_inacbg a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs.m_statuskeluar c ON a.id_status_pasien = c.status
WHERE
    a.idxdaftar = $idxdaftar";
$queryiteminacbg = mysql_query($sqliteminacbg);
$queryiteminacbg2 = mysql_query($sqliteminacbg);
$queryiteminacbg3 = mysql_query($sqliteminacbg);
$queryiteminacbg4 = mysql_query($sqliteminacbg);
$queryiteminacbg5 = mysql_query($sqliteminacbg);
$queryiteminacbg6 = mysql_query($sqliteminacbg);
$queryiteminacbg7 = mysql_query($sqliteminacbg);
$queryiteminacbg8 = mysql_query($sqliteminacbg);
$queryiteminacbg9 = mysql_query($sqliteminacbg);
$queryiteminacbg10 = mysql_query($sqliteminacbg);
$queryiteminacbg11 = mysql_query($sqliteminacbg);
$queryiteminacbg12 = mysql_query($sqliteminacbg);
$queryiteminacbg13 = mysql_query($sqliteminacbg);
$queryiteminacbg14 = mysql_query($sqliteminacbg);
$queryiteminacbg15 = mysql_query($sqliteminacbg);
$queryiteminacbg16 = mysql_query($sqliteminacbg);
$queryiteminacbg17 = mysql_query($sqliteminacbg);
$queryiteminacbg18 = mysql_query($sqliteminacbg);
$queryiteminacbg19 = mysql_query($sqliteminacbg);

$sqlitemtotal="SELECT 
    SUM(inacbg_non_bedah) AS total_bedah,
    SUM(inacbg_tenaga_ahli) AS total_tenaga_ahli,
    SUM(inacbg_radiologi) AS total_radiologi,
    SUM(inacbg_fisioterapi) AS total_fisioterapi,
    SUM(inacbg_obat) AS total_obat,
    SUM(inacbg_tmo) AS total_tmo,
    SUM(inacbg_keperawatan) AS total_keperawatan,
    SUM(inacbg_laboratorium) AS total_laboratorium,
    SUM(inacbg_akomodasi) AS total_akomodasi,
    SUM(inacbg_konsultasi) AS total_konsultasi,
    SUM(inacbg_penunjang) AS total_penunjang,
    SUM(inacbg_pelayanan_darah) AS total_pelayanan_darah,
    SUM(inacbg_bhp) AS total_bhp,
	SUM(inacbg_rawat_intensive) AS total_rawat_intensive,
	SUM(inacbg_sewa_alat) AS total_sewa_alat,
    SUM(total_keseluruhan) AS grand_total_keseluruhan
    
FROM
    simrs.v_bill_inacbg
WHERE
    idxdaftar=$idxdaftar";
$queryitemtotal = mysql_query($sqlitemtotal);
$DATA_TOTAL = mysql_fetch_array($queryitemtotal);



?>
<style type="text/css">
@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 11px;
}	
.tabel {
    border-collapse:collapse;
	font-size: 11px;
}
.footer {
	font-size: 12px;
}
.header {
	font-size: 11px;
}
	
</style>  
     
<?php include "header.php" ?>

<center>
  <span style="font-size: 14px;">RINCIAN BIAYA INACBGs</span>
</center>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="17%" align="left">No. Rekam Medis</td>
      <td width="32%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="15%" align="left">No. Pelayanan</td>
      <td width="36%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td align="left">Status Pembayaran </td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td align="left">Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td align="left">Tanggal Masuk</td>
      <td>: <?php echo $DATA_ADMISI['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="left">Tanggal Keluar</td>
      <td>: <?php echo $DATA_ADMISI['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td colspan="3" valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="15%">Nama Pelayanan</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg)){
				echo '<td align="center">'.$data['userlevelname'].'</td>';
		}
		
		?>
   		<td width="20%" rowspan="2" align="center">Sub Total Tarif</td>
    </tr>
    <tr>
       <td colspan="2">Keterangan Keluar</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg19)){
				echo '<td align="center"><strong>'.$data['keterangan'].'</strong></td>';
		}
		
		?>
	</tr>
    <tr>
      <td>1.</td>
      <td>Non Bedah</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg2)){
				echo '<td align="right">'.number_format($data['inacbg_non_bedah'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_bedah'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>2.</td>
      <td>Tenaga Ahli</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg3)){
				echo '<td align="right">'.number_format($data['inacbg_tenaga_ahli'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_tenaga_ahli'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Radiologi</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg4)){
				echo '<td align="right">'.number_format($data['inacbg_radiologi'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_radiologi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>3.</td>
      <td>Rehabilitas</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg5)){
				echo '<td align="right">'.number_format($data['inacbg_fisioterapi'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_fisioterapi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>5.</td>
      <td>Obat</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg6)){
				echo '<td align="right">'.number_format($data['inacbg_obat'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_obat'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>6.</td>
      <td>Sewa Alat</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg7)){
				echo '<td align="right">'.number_format($data['inacbg_sewa_alat'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_sewa_alat'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>7.</td>
      <td>Prosedur Bedah</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg8)){
				echo '<td align="right">'.number_format($data['inacbg_tmo'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_tmo'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>8.</td>
      <td>Keperawatan</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg9)){
				echo '<td align="right">'.number_format($data['inacbg_keperawatan'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_keperawatan'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>9.</td>
      <td>Laboratorium</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg10)){
				echo '<td align="right">'.number_format($data['inacbg_laboratorium'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_laboratorium'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>10.</td>
      <td>Akomodasi/Kamar</td>
      <?php
		while($data=mysql_fetch_assoc($queryiteminacbg11)){
				echo '<td align="right">'.number_format($data['inacbg_akomodasi'], 0,",",".").'</td>';
		}
		?>
   	 <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_akomodasi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>11.</td>
      <td>Alkes</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg12)){
				echo '<td align="right">0</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_alkes'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>12.</td>
      <td>Konsultasi</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg13)){
				echo '<td align="right">'.number_format($data['inacbg_konsultasi'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_konsultasi'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>13.</td>
      <td>Penunjang</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg14)){
				echo '<td align="right">'.number_format($data['inacbg_penunjang'], 0,",",".").'</td>';
		}
		
		?>
   <td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_penunjang'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>14.</td>
      <td>Pelayanan Darah</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg15)){
				echo '<td align="right">'.number_format($data['inacbg_pelayanan_darah'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_pelayanan_darah'], 0,",","."); ?></td>
    </tr>
	<tr>
      <td>15.</td>
      <td>Rawat Intensive</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg16)){
				echo '<td align="right">'.number_format($data['inacbg_rawat_intensive'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_rawat_intensive'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td>16.</td>
      <td>BMHP</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg17)){
				echo '<td align="right">'.number_format($data['inacbg_bhp'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" align="right"><?php echo number_format($DATA_TOTAL['total_bhp'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td></td>
      <td>TOTAL TARIF RS</td>
      <?php
		
		while($data=mysql_fetch_assoc($queryiteminacbg18)){
				echo '<td align="right">'.number_format($data['total_keseluruhan'], 0,",",".").'</td>';
		}
		
		?>
   		<td width="15%" style="font-size: 15px" align="right"><strong>Rp. <?php echo number_format($DATA_TOTAL['grand_total_keseluruhan'], 0,",","."); ?></strong></td>
    </tr>
    
  </tbody>
</table>


<table width="100%" class="tabel">
	<tr>
	  <td>Petugas Administrasi wajib melakukan verifikasi data billing dengan cara klik <strong>SELESAI</strong> pada menu Administrasi Pelayanan</td>
	  <td align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
  </tr>
	<tr>
    <td><strong>Penanggung Jawab Administrasi:</strong></td>
    <td width="41%" align="center">Petugas Administrasi</td>
  </tr>
	<tr>
	  <td rowspan="3" valign="top">
	    
	    
  <?php  
$sqlitempj="SELECT 
    b.pd_nickname, c.userlevelname
FROM
    bill_detail_tarif a
        LEFT JOIN
    master_login b ON a.uidadm = b.username
        LEFT JOIN
    userlevels c ON a.userlevelid = c.userlevelid
WHERE
    a.idxdaftar = $idxdaftar
ORDER BY a.tanggal ASC";
$queryitempj = mysql_query($sqlitempj);
		  
		  
	  		$no=1;
      		while($data=mysql_fetch_assoc($queryitempj)){
				echo ''.$no.'. '.$data['userlevelname'].' (Adm: '.$data['pd_nickname'].') <br>';
			$no++;
		}
?>
	    
	    
      </td>
	  <td align="center">
      <center><img height="40px" src="../../uploads/<?php echo $DATA_USERNAME['signature']; ?>"/><br>
      <?php echo $DATA_USERNAME['pd_nickname']; ?></center>
    </td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
  </tr>
</table>
 <div class="pagebreak"> </div>
