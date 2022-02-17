<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];


$sqlusername="SELECT 
    a.pd_nickname, b.userlevelname
FROM
    master_login a
        LEFT JOIN
    userlevels b ON a.userlevelid = b.userlevelid
WHERE
    a.username ='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 

$sqlidentitas="SELECT 
    d.id_bill_detail_tarif,
	d.id_bill_detail_tarif_detail
FROM
    simrs.bill_detail_tarif_detail d
WHERE
    d.id_bill_detail_tarif =$id_bill_detail_tarif and d.userlevelid=31";

 $queryidentitas = mysql_query($sqlidentitas);
 
 
 
 if(mysql_num_rows($queryidentitas)==0){
		echo '<center>Tidak ada Pelayanan Fisioterapi</center>';
	}
	else{
		$no=1;
while($rows=mysql_fetch_array($queryidentitas)){	



$sqlitemid="SELECT 
    a.id_bill_detail_tarif,
    a.idxdaftar,
    a.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS carabayar,
    DATE_FORMAT(a.tanggal, '%d-%m-%Y') AS tglmasuk,
    DATE_FORMAT(d.tanggal, '%d-%m-%Y') AS tglorder,
	DATE_FORMAT(d.tanggal, '%d-%m-%Y') AS tglcetak,
    e.userlevelname,
	d.id_bill_detail_tarif_detail
FROM
    simrs.bill_detail_tarif_detail d
        LEFT JOIN
    simrs.bill_detail_tarif a ON d.id_bill_detail_tarif = a.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_carabayar c ON a.kdcarabayar = c.kode
        LEFT JOIN
    userlevels e ON a.userlevelid = e.userlevelid
WHERE
    d.id_bill_detail_tarif_detail = ".$rows["id_bill_detail_tarif_detail"]."
	and d.userlevelid=31";
$queryitemid = mysql_query($sqlitemid);
$DATA_ID = mysql_fetch_array($queryitemid);


echo '
<div class="pagebreak">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA LABORATORIUM</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 1 cm;
			margin-right: 1cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 11px;
}

.pagebreak { 
		page-break-after: always;
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
  <span style="font-size: 14px">RINCIAN BIAYA PEMERIKSAAN FISIOTERAPI</span>
</center>

<table width="100%" border="0" cellpadding="1" cellspacing="1" class="footer">
    <tr>
      <td width="13%">No. RM</td>
      <td width="43%">: '.$DATA_ID['nomr'].'</td>
      <td width="19%">Dari Unit</td>
      <td width="25%">: '.$DATA_ID['userlevelname'].'</td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: '.$DATA_ID['nama'].'</td>
      <td>Status Pembayaran </td>
      <td>: '.$DATA_ID['carabayar'].'</td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: '.$DATA_ID['tgllahir'].'</td>
      <td>Tanggal Masuk</td>
      <td>: '.$DATA_ID['tglmasuk'].'</td>
  </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>: '.$DATA_ID['jeniskelamin'].'</td>
      <td>Tanggal Order</td>
      <td>: '.$DATA_ID['tglorder'].'</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>: '.$DATA_ID['alamat'].'</td>
      <td></td>
      <td></td>
    </tr>
</table>


<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="10" align="left" class="a"><strong>No</strong></td>
      <td width="189" align="left" class="a"><strong>Nama Produk</strong></td>
      <td width="50" align="center" class="a"><strong>Kuantitas</strong></td>
      <td width="92" align="center" class="a"><strong>Total</strong></td>
  </tr>';

$sqlitem="SELECT 
    b.nama_tindakan, a.qty, a.total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    bill_detail_tarif c ON a.id_bill_detail_tarif= c.id_bill_detail_tarif
WHERE
    a.id_bill_detail_tarif_detail = ".$rows["id_bill_detail_tarif_detail"]." and b.userlevelid=31";
$queryitem = mysql_query($sqlitem);

$sqltotal="SELECT 
    sum(a.total) as total
FROM
    bill_detail_tindakan a
        LEFT JOIN
    master_tindakan b ON a.id_tindakan = b.id_tindakan
        LEFT JOIN
    bill_detail_tarif c ON a.id_bill_detail_tarif= c.id_bill_detail_tarif
WHERE
    a.id_bill_detail_tarif_detail = ".$rows["id_bill_detail_tarif_detail"]." and b.userlevelid=31";

 $querytotal = mysql_query($sqltotal);
 $DATA_TOTAL = mysql_fetch_array($querytotal);


	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="4">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td class="a kosong">'.$no.'</td>';
      echo '<td class="a kosong">'.$data['nama_tindakan'].'</td>';
      echo '<td class="a kosong"><div align="center">'.$data['qty']. '</div></td>';
	  echo '<td class="a kosong"><div align="right">'.number_format($data['total'], 0,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    

	echo '<tr>
      <td colspan="4" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center">Ajibarang, '.$DATA_ID['tglcetak'].'</td>
       <td colspan="6" align="right">&nbsp;</td>
       <td align="right" class="total">&nbsp;</td>
     </tr>
     <tr>
       <td width="26%" align="center">Petugas Administrasi</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td width="15%" align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">&nbsp;</td>
      <td align="right" class="total">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">'.$DATA_USERNAME['pd_nickname'].'</td>
      <td colspan="6" align="right">Total Keseluruhan</td>
      <td align="right" style="font-size: 16px" class="total"><strong>Rp'.number_format($DATA_TOTAL['total'], 0,",",".").'</strong></td>
    </tr>
        </tbody>
      </table></td>
    </tr>
	
  </table>


</body>
</html></div>';
}
	};

 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota_fisioterapi.pdf',array('Attachment' => 0));
?>



