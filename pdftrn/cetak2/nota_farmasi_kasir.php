<?php
ob_start();
session_start();
include('connect.php');
$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$username = $_GET['username'];
$idxdaftar = $_GET['idxdaftar'];

$sqlitem="SELECT 
    b.nama_obat,
    a.qty,
    IFNULL(c.qty, 0) AS qty_retur,
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
    a.id_bill_detail_tarif=$id_bill_detail_tarif";
$queryitem = mysql_query($sqlitem);


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
    DATE_FORMAT(d.tglkeluar, '%d-%m-%Y %H:%m:%s') AS tglkeluar,
	IFNULL(a.biaya_obat, 0) as biaya_obat,
	IFNULL(a.biaya_obat_retur, 0) as biaya_obat_retur,
    IFNULL(a.biaya_obat, 0) - IFNULL(a.biaya_obat_retur, 0) AS total_obat,
	CONCAT(e.keterangan, ' (', ifnull(f.userlevelname,''), ')') AS status_keluar,
	g.userlevelname
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
    a.id_bill_detail_tarif = $id_bill_detail_tarif and a.idxdaftar = $idxdaftar";


 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlusername="select pd_nickname from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BIAYA OBAT</title>
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
<div align="center"><strong>RINCIAN BIAYA OBAT</strong></div>



<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">No. Rekam Medis</td>
      <td width="41%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="13%" align="left">No. Pelayanan</td>
      <td width="32%">: <?php echo $DATA_IDENTITAS['idxdaftar']; ?></td>
    </tr>
    <tr>
      <td align="left">Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td align="left">Pembayaran </td>
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
      <td align="left" valign="top">Unit</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
</table>



<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="10" align="left" class="a"><strong>No</strong></td>
      <td width="189" align="left" class="a"><strong>Nama Produk</strong></td>
      <td width="50" align="center" class="a"><strong>Satuan</strong></td>
      <td width="50" align="center" class="a"><strong>Kuantitas</strong></td>
	  <td width="72" align="center" class="a"><strong>Kuantitas Retur</strong></td>
      <td width="64" align="center" class="a"><strong>Harga </strong></td>
      <td width="92" align="center" class="a"><strong>Total</strong></td>
  </tr>
	<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td class="a kosong">'.$no.'</td>';
      echo '<td class="a kosong">'.$data['nama_obat'].'</td>';
	  echo '<td class="a kosong">'.$data['satuan'].'</td>';
      echo '<td class="a kosong"><div align="center">'.$data['qty']. '</div></td>';
	  echo '<td class="a kosong"><div align="center">'.$data['qty_retur']. '</div></td>';
      echo '<td class="a kosong"><div align="right">'.number_format($data['tarif_obat'], 2,",","."). '</div></td>';
	  echo '<td class="a kosong"><div align="right">'.number_format($data['total'], 2,",","."). '</div></td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
	<tr>
      <td colspan="7" align="right"><table width="100%" border="0">
        <tbody>
     <tr>
       <td width="17%" align="center">Petugas Farmasi</td>
      <td colspan="6" align="right">Sub Total</td>
      <td width="15%" align="right" class="total">Rp.<?php echo number_format($DATA_IDENTITAS['biaya_obat'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td colspan="6" align="right">Sub Total  Retur</td>
      <td align="right" class="total">Rp.<?php echo number_format($DATA_IDENTITAS['biaya_obat_retur'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_USERNAME['pd_nickname']; ?></td>
      <td colspan="6" align="right">Total Keseluruhan</td>
      <td align="right" class="total"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['total_obat'], 0,",","."); ?></strong></td>
    </tr>
        </tbody>
      </table></td>
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
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>