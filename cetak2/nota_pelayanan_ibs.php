<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];

$sqlidentitas="SELECT 
    a.id_bill_detail_tarif,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y %H:%i:%s') AS tglmasuk,
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%i:%s') AS tglkeluar,
    a.total_keseluruhan
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    simrs.bill_detail_transfer_pasien d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid where a.username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
 $sqltotal="select total_keseluruhan-biaya_obat as total from bill_detail_tarif where id_bill_detail_tarif=$id_bill_detail_tarif";
 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);


$sqlitemdokter="SELECT 
    c.pd_nickname,d.nama_profesi,a.qty,a.tarif_dokter,a.total
FROM
    bill_detail_visit_dokter a
        LEFT JOIN
    l_dokter_standby b ON a.id_dokter_standby = b.id_dokter_standby
    left join master_login c on c.uid=b.uid
    left join master_profesi d on b.id_profesi=d.id_profesi where a.id_bill_detail_tarif=$id_bill_detail_tarif and c.id_profesi=13 order by a.id_profesi asc";
$queryitemdokter = mysql_query($sqlitemdokter);

$sqlitemtmo="SELECT 
    d.nama_tindakan,
    CONCAT(b.jenis_tindakan,
            ' (',
            CONCAT(e.nama_emergency,
                    ' +',
                    a.tarif_emergency,
                    '%)')) AS keterangan,
    a.qty AS qty,
    IFNULL(a.tarif_pelayanan, 0) + IFNULL(a.tarif_jasa_sarana, 0) + IFNULL(a.tarif_bhp, 0) AS tarif,
    a.total
FROM
    simrs.bill_detail_tindakan a
        LEFT JOIN
    simrs.l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    simrs.l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    simrs.master_tindakan d ON a.id_tindakan = d.id_tindakan
        LEFT JOIN
    simrs.l_emergency e ON a.id_emergency = e.id_emergency
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND (a.id_jenis_tindakan = 1
        OR a.id_jenis_tindakan = 2
        OR a.id_jenis_tindakan = 3
        OR a.id_jenis_tindakan = 8)
ORDER BY a.id_jenis_tindakan ASC , a.id_type_tindakan ASC";
$queryitemtmo = mysql_query($sqlitemtmo);

$sqlitemobat="SELECT 
    c.nama_obat, a.qty, a.tarif_obat, a.total
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat c ON b.id_obat = c.id_obat where a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitemobat = mysql_query($sqlitemobat);

$sqlitemlab="SELECT 
    d.nama_tindakan,
    b.jenis_tindakan,
    c.type_tindakan,
    SUM(a.qty) AS qty,
     SUM(IFNULL(a.tarif_pelayanan, 0) + IFNULL(a.tarif_jasa_sarana, 0) + IFNULL(a.tarif_bhp, 0)) AS tarif,
    a.total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND a.id_jenis_tindakan=5
group by a.id_tindakan
ORDER BY a.id_jenis_tindakan ASC , a.id_type_tindakan ASC";
$queryitemlab = mysql_query($sqlitemlab);


$sqlitemrad="SELECT 
    d.nama_tindakan,
    b.jenis_tindakan,
    c.type_tindakan,
    SUM(a.qty) AS qty,
     SUM(IFNULL(a.tarif_pelayanan, 0) + IFNULL(a.tarif_jasa_sarana, 0) + IFNULL(a.tarif_bhp, 0)) AS tarif,
    a.total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND a.id_jenis_tindakan=4
group by a.id_tindakan
ORDER BY a.id_jenis_tindakan ASC , a.id_type_tindakan ASC";
$queryitemrad = mysql_query($sqlitemrad);


$sqlitempelda="SELECT 
    d.nama_tindakan,
    b.jenis_tindakan,
    c.type_tindakan,
    SUM(a.qty) AS qty,
     SUM(IFNULL(a.tarif_pelayanan, 0) + IFNULL(a.tarif_jasa_sarana, 0) + IFNULL(a.tarif_bhp, 0)) AS tarif,
    a.total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND a.id_jenis_tindakan=7
group by a.id_tindakan
ORDER BY a.id_jenis_tindakan ASC , a.id_type_tindakan ASC";
$queryitempelda = mysql_query($sqlitempelda);


$sqlitemfisio="SELECT 
    d.nama_tindakan,
    b.jenis_tindakan,
    c.type_tindakan,
    SUM(a.qty) AS qty,
     SUM(IFNULL(a.tarif_pelayanan, 0) + IFNULL(a.tarif_jasa_sarana, 0) + IFNULL(a.tarif_bhp, 0)) AS tarif,
    a.total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    l_jenis_tindakan b ON a.id_jenis_tindakan = b.id_jenis_tindakan
        LEFT JOIN
    l_type_tindakan c ON c.id_type_tindakan = a.id_type_tindakan
        LEFT JOIN
    master_tindakan d ON a.id_tindakan = d.id_tindakan
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif
        AND a.id_jenis_tindakan=20 group by a.id_tindakan";
$queryitemfisio = mysql_query($sqlitemfisio);


$sqlrincian="select
    a.biaya_asuhan_keperawatan,
	(SELECT 
            qty
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=16 group by id_bill_detail_tarif) AS qty_askep,
	(SELECT 
            tarif_pelayanan
        FROM
            bill_detail_tindakan_lain
        WHERE
            id_bill_detail_tarif =$id_bill_detail_tarif and id_jenis_tindakan=16 group by id_bill_detail_tarif) AS tarif_askep
FROM
    bill_detail_tarif a
        LEFT JOIN
    bill_detail_keterangan b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
	 left join master_admisi c on b.id_pasienbaru=c.id_pasienbaru and b.userlevelid=c.userlevelid
WHERE
    a.id_bill_detail_tarif=$id_bill_detail_tarif
	GROUP BY a.id_bill_detail_tarif";

 $queryrincian = mysql_query($sqlrincian);
 $DATA_RINCIAN = mysql_fetch_array($queryrincian);



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA PELAYANAN IBS</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 11px;
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
  

    <div align="center"><strong>RINCIAN BIAYA PELAYANAN IBS</strong></div>



<table width="100%" class="header" border="0">
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
      <td>: <?php echo $DATA_IDENTITAS['tglkeluar']; ?></td>
    </tr>
</table>




<table width="100%" border="1" class="tabel">
  <tr>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="40%" align="center" bgcolor="#FFFFFF"><strong>JENIS PELAYANAN</strong></td>
    <td width="20%" align="center" bgcolor="#FFFFFF"><strong>KETERANGAN</strong></td>
    <td width="6%" align="center" bgcolor="#FFFFFF"><strong>JUMLAH</strong></td>
    <td width="3%" align="center" bgcolor="#FFFFFF"><strong>X</strong></td>
    <td width="9%" align="center" bgcolor="#FFFFFF"><strong>TARIF</strong></td>
    <td width="19%" align="center" bgcolor="#FFFFFF"><strong>TOTAL</strong></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>1.</strong></td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>DAFTAR TENAGA AHLI</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemdokter)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['pd_nickname'].'</td>';
				echo '<td align="left">'.$data['nama_profesi'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif_dokter'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
		?>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>2.</strong></td>
    <td bgcolor="#FFFFFF"><strong>ASUHAN KEPERAWATAN ANESTHESI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['qty_askep'], 0,",","."); ?></td>
    <td align="center" bgcolor="#FFFFFF">x</td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['tarif_askep'], 0,",","."); ?></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo number_format($DATA_RINCIAN['biaya_asuhan_keperawatan'], 0,",","."); ?></td>
  </tr>
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>3.</strong></td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>PENUNJANG</strong></td>
  </tr>
  
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- LABORATORIUM</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
   <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemlab)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- RADIOLOGI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemrad)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- PELAYANAN DARAH</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitempelda)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF"><strong>- FISIOTERAPI</strong></td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  
  
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemfisio)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['type_tindakan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  
  
  <tr bgcolor="#ABABAB">
    <td align="center" bgcolor="#FFFFFF"><strong>4.</strong></td>
    <td colspan="6" bgcolor="#FFFFFF"><strong>TINDAKAN MEDIS</strong></td>
  </tr>
  <?php
	  $no=a;
      		while($data=mysql_fetch_assoc($queryitemtmo)){
				echo '<tr>';
				echo '<td></td>';
			  	echo '<td>'.$no.'). '.$data['nama_tindakan'].'</td>';
				echo '<td align="left">'.$data['keterangan'].'</td>';
				echo '<td align="center">'.$data['qty'].'</td>';
				echo '<td align="center">x</td>';
				echo '<td align="right">'.number_format($data['tarif'], 0,",",".").'</td>';
				echo '<td align="right">'.number_format($data['total'], 0,",",".").'</td>';
				echo '</tr>';
				
			$no++;
		}
	?>
  <tr>
    <td colspan="7" align="center" bgcolor="#FFFFFF">
    	
    	<table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right">Rp<?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></td>
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
      <td align="right" class="footer"><strong>Rp<?php echo number_format($DATA_TOTAL['total'], 0,",","."); ?></strong></td>
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
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>