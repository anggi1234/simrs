<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%m:%s') AS tglmasuk,
    DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%m:%s') AS tglkeluar,
	DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS tglcetak,
    a.total_keseluruhan,
	CONCAT(e.keterangan, ' (', ifnull(f.userlevelname,''), ')') AS status_keluar,	ifnull(biaya_penj_gizi,0)+ifnull(biaya_penj_laboratorium,0)+ifnull(biaya_penj_radiologi,0)+ifnull(a.biaya_pel_darah,0)+ifnull(biaya_penj_fisioterapi,0)+(IFNULL(a.biaya_obat, 0) - IFNULL(a.biaya_obat_retur, 0)) as total_biaya_penunjang
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
	        LEFT JOIN
    simrs2012.m_statuskeluar e ON e.status = d.id_status_keluar
        LEFT JOIN
    simrs.userlevels f ON d.userlevelid_transfer = f.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);




$sqlitemradiologi="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=4";
$queryitemradiologi = mysql_query($sqlitemradiologi);

$sqlitemlaboratorium="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=5";
$queryitemlaboratorium = mysql_query($sqlitemlaboratorium);

$sqlitemgizi="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=25";
$queryitemgizi = mysql_query($sqlitemgizi);

$sqlitemfisioterapi="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=20";
$queryitemfisioterapi = mysql_query($sqlitemfisioterapi);


$sqlitempelayanandarah="select b.nama_tindakan,a.qty,a.total_pelayanan+a.total_bhp+a.total_jasa_sarana as harga,a.total from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=7";
$queryitempelayanandarah = mysql_query($sqlitempelayanandarah);


$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);


$sqlitem="SELECT 
    b.nama_obat,
    a.qty-IFNULL(c.qty, 0) AS qty,
    a.tarif_obat,
    a.total
FROM
    bill_detail_permintaan_obat a
        LEFT JOIN
    master_obat_detail d ON a.id_master_obat_detail = d.id_master_obat_detail
        LEFT JOIN
    master_obat b ON d.id_obat = b.id_obat
        LEFT JOIN
    bill_detail_permintaan_retur_obat c ON a.id_bill_detail_permintaan_obat = c.id_bill_detail_permintaan_obat
WHERE
    a.id_bill_detail_tarif=$id_bill_detail_tarif and a.id_status_konfirmasi=2";
$queryitem = mysql_query($sqlitem);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA PENUNJANG</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.7 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
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
<center>
  <span style="font-size: 14px">RINCIAN BIAYA PENUNJANG</span>
</center>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. RM</td>
      <td width="44%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="19%" align="left">No. Pelayanan</td>
      <td width="23%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
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
      <td>: <?php echo $DATA_IDENTITAS['tglmasuk']; ?></td>
  </tr>
    <tr>
      <td align="left">Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
      <td align="left">Tanggal Keluar</td>
      <td>: <?php echo $DATA_IDENTITAS['tglkeluar']; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top">Alamat</td>
      <td colspan="3" valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
  <tr>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="40%" align="center" bgcolor="#FFFFFF"><strong>JENIS PELAYANAN</strong></td>
    <td width="20%" align="center" bgcolor="#FFFFFF"><strong>HARGA</strong></td>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>JUMLAH</strong></td>
    <td width="19%" align="center" bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>1.</strong></td>
    <td colspan="4" bgcolor="#FFFFFF"><strong>RADIOLOGI</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemradiologi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>2.</strong></td>
    <td colspan="4" bgcolor="#FFFFFF"><strong>LABORATORIUM</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemlaboratorium)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>3.</strong></td>
    <td colspan="4" bgcolor="#FFFFFF"><strong>FISIOTERAPI</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemfisioterapi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>4.</strong></td>
    <td colspan="4" bgcolor="#FFFFFF"><strong>PELAYANAN DARAH</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitempelayanandarah)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>5.</strong></td>
    <td colspan="4" bgcolor="#FFFFFF"><strong>FARMASI</strong></td>
  </tr>
  
  <?php
  		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
	  echo '<tr>';
	  echo '<td></td>';
      echo '<td>'.$no.').'.$data['nama_obat'].'</td>';
	  echo '<td align="right">'.number_format($data['tarif_obat'], 2,",",".").'</td>';
      echo '<td align="center">'.$data['qty'].'</td>';
	  echo '<td align="right"><strong>'.number_format($data['total'], 2,",",".").'</strong></td>';
	  echo '</tr>';
			
			$no++;
		}
	?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>6.</strong></td>
    <td colspan="4" bgcolor="#FFFFFF"><strong>GIZI</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemgizi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="right">'.$data['harga'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right"><strong>'.number_format($data['total'], 0,",",".").'</strong></td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  
  <tr>
    <td colspan="5" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="45%" align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tglcetak']; ?></td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="15%" align="right">&nbsp;</td>
    </tr>
     <tr>
       <td align="center">Petugas Administrasi</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
     <tr>
       <td align="center">&nbsp;</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="footer">&nbsp;</td>
     </tr>
     <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" class="footer"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['total_biaya_penunjang'], 0,",","."); ?></strong></td>
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
$paper_size = array(0,0, 8.66 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notarincianpenunjang.pdf',array('Attachment' => 0));
?>