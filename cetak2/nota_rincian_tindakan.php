<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];
$idxdaftar = $_GET['idxdaftar'];

$sqltotal="SELECT 
    IFNULL(biaya_tind_tmno, 0) + IFNULL(biaya_tind_tmo, 0) + IFNULL(biaya_tind_keperawatan, 0) + IFNULL(biaya_tind_persalinan, 0) + IFNULL(biaya_bhp_tmno, 0) + IFNULL(biaya_bhp_tmo, 0) + IFNULL(biaya_bhp_keperawatan, 0) + IFNULL(biaya_bhp_persalinan, 0) + IFNULL(biaya_bhp_icu_mandiri, 0) + IFNULL(biaya_bhp_icu_delegasi, 0) + IFNULL(biaya_icu_mandiri, 0) + IFNULL(biaya_icu_delegasi, 0) + IFNULL(biaya_sarana_tmo, 0) + IFNULL(biaya_sarana_tmno, 0) + IFNULL(biaya_sarana_keperawatan, 0) + IFNULL(biaya_sarana_persalinan, 0) + IFNULL(biaya_sarana_icu_mandiri, 0) + IFNULL(biaya_sarana_icu_delegasi, 0) + IFNULL(biaya_sewa_alat, 0) + IFNULL(biaya_bhp_sewa_alat, 0) + IFNULL(biaya_sarana_sewa_alat, 0) AS total_tindakan
FROM
    simrs.bill_detail_tarif
WHERE
    id_bill_detail_tarif = $id_bill_detail_tarif";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);


$sqlitemtmno="select b.nama_tindakan,concat(e.nama_emergency,'  +',a.tarif_emergency,'%') as JENIS,d.type_tindakan,date_format(a.tanggal_tindakan, '%d-%m-%Y') as tanggal,a.qty,a.tarif_pelayanan,a.tarif_bhp,a.tarif_jasa_sarana,a.total,a.userlevelid from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
left join l_type_tindakan d on a.id_type_tindakan=d.id_type_tindakan
left join l_emergency e on a.id_emergency=e.id_emergency
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=1";
$queryitemtmno = mysql_query($sqlitemtmno);

$sqlitemtmo="select b.nama_tindakan,concat(e.nama_emergency,'  +',a.tarif_emergency,'%') as JENIS,d.type_tindakan,date_format(a.tanggal_tindakan, '%d-%m-%Y') as tanggal,a.qty,a.tarif_pelayanan,a.tarif_bhp,a.tarif_jasa_sarana,a.total,a.userlevelid from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
left join l_type_tindakan d on a.id_type_tindakan=d.id_type_tindakan
left join l_emergency e on a.id_emergency=e.id_emergency
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=2";
$queryitemtmo = mysql_query($sqlitemtmo);

$sqlitemkeperawatan="select b.nama_tindakan,concat(e.nama_emergency,'  +',a.tarif_emergency,'%') as JENIS,d.type_tindakan,date_format(a.tanggal_tindakan, '%d-%m-%Y') as tanggal,a.qty,a.tarif_pelayanan,a.tarif_bhp,a.tarif_jasa_sarana,a.total,a.userlevelid from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
left join l_type_tindakan d on a.id_type_tindakan=d.id_type_tindakan
left join l_emergency e on a.id_emergency=e.id_emergency
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=3";
$queryitemkeperawatan = mysql_query($sqlitemkeperawatan);

$sqlitempersalinan="select b.nama_tindakan,concat(e.nama_emergency,'  +',a.tarif_emergency,'%') as JENIS,d.type_tindakan,date_format(a.tanggal_tindakan, '%d-%m-%Y') as tanggal,a.qty,a.tarif_pelayanan,a.tarif_bhp,a.tarif_jasa_sarana,a.total,a.userlevelid from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
left join l_type_tindakan d on a.id_type_tindakan=d.id_type_tindakan
left join l_emergency e on a.id_emergency=e.id_emergency
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=8";
$queryitempersalinan = mysql_query($sqlitempersalinan);


$sqlitemicumandiri="select b.nama_tindakan,concat(e.nama_emergency,'  +',a.tarif_emergency,'%') as JENIS,d.type_tindakan,date_format(a.tanggal_tindakan, '%d-%m-%Y') as tanggal,a.qty,a.tarif_pelayanan,a.tarif_bhp,a.tarif_jasa_sarana,a.total,a.userlevelid from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
left join l_type_tindakan d on a.id_type_tindakan=d.id_type_tindakan
left join l_emergency e on a.id_emergency=e.id_emergency
where a.id_bill_detail_tarif =$id_bill_detail_tarif and a.id_jenis_tindakan=22";
$queryitemicumandiri = mysql_query($sqlitemicumandiri);

$sqlitemicudelegasi="select b.nama_tindakan,concat(e.nama_emergency,'  +',a.tarif_emergency,'%') as JENIS,d.type_tindakan,date_format(a.tanggal_tindakan, '%d-%m-%Y') as tanggal,a.qty,a.tarif_pelayanan,a.tarif_bhp,a.tarif_jasa_sarana,a.total,a.userlevelid from bill_detail_tindakan a 
left join master_tindakan b on a.id_tindakan=b.id_tindakan
left join bill_detail_tarif_detail c on a.id_bill_detail_tarif_detail=c.id_bill_detail_tarif_detail
left join l_type_tindakan d on a.id_type_tindakan=d.id_type_tindakan
left join l_emergency e on a.id_emergency=e.id_emergency
where a.id_bill_detail_tarif =$id_bill_detail_tarif and (a.id_jenis_tindakan=23 or a.id_jenis_tindakan=24)";
$queryitemicudelegasi = mysql_query($sqlitemicudelegasi);


$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    simrs.master_login a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username ='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 


$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
	a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(a.tglout, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    a.total_keseluruhan,
	CONCAT(e.keterangan, ' (', ifnull(f.userlevelname,''), ')') AS status_keluar,
	g.userlevelname as unit
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
		LEFT JOIN
    simrs.userlevels g ON a.userlevelid = g.userlevelid
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif  and a.idxdaftar = $idxdaftar";
	


 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rincian Obat</title>
<link rel="shortcut icon" href="../favicon.ico"/>
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
	font-size: 10px;
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
  <span style="font-size: 14px">RINCIAN TINDAKAN PELAYANAN</span>
</center>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. RM</td>
      <td width="38%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="20%" align="left">Unit</td>
      <td width="28%">: <?php echo $DATA_IDENTITAS['unit']; ?></td>
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
      <td valign="top">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
      <td align="left" valign="top">Status Pasien</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['status_keluar']; ?></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
  <tr>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="30%" align="center" bgcolor="#FFFFFF"><strong>JENIS TINDAKAN</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>JENIS</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>TIPE</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>TANGGAL</strong></td>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>JASPEL</strong></td>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>JASAR</strong></td>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>BHP</strong></td>
    <td width="4%" align="center" bgcolor="#FFFFFF"><strong>JUMLAH</strong></td>
    <td width="10%" align="center" bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">1.</td>
    <td colspan="9" bgcolor="#FFFFFF">TINDAKAN MEDIS NON OPERATIK (TMNO)</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemtmno)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['JENIS'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['tanggal'].'</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">2.</td>
    <td colspan="9" bgcolor="#FFFFFF">TINDAKAN MEDIS OPERATIK (TMO)</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemtmo)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['JENIS'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['tanggal'].'</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">3.</td>
    <td colspan="9" bgcolor="#FFFFFF">TINDAKAN KEPERAWATAN</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemkeperawatan)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['JENIS'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['tanggal'].'</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">4.</td>
    <td colspan="9" bgcolor="#FFFFFF">TINDAKAN PERSALINAN</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitempersalinan)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['JENIS'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['tanggal'].'</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">5.</td>
    <td colspan="9" bgcolor="#FFFFFF">TINDAKAN ICU MANDIRI</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemicumandiri)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['JENIS'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['tanggal'].'</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF">6.</td>
    <td colspan="9" bgcolor="#FFFFFF">TINDAKAN ICU DELEGASI</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemicudelegasi)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['JENIS'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['tanggal'].'</td>';
				echo '<td align="right">'.number_format($data['tarif_pelayanan'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_jasa_sarana'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['tarif_bhp'], 0,",",".").'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
			$no++;
		}
		?>
  <tr>
    <td colspan="10" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="33%" align="center">Petugas Administrasi</td>
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
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right"><strong>TOTAL KESELURUHAN</strong></td>
      <td align="right" class="footer" style="font-size: 14px"><strong>Rp <?php echo number_format($DATA_TOTAL['total_tindakan'], 0,",","."); ?></strong></td>
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('40_rincian_tindakan.pdf',array('Attachment' => 0));
?>