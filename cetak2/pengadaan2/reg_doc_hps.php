<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];

$sqlitem="SELECT 
    f.nama_obat,
    a.qty * a.volume AS jumlah,
    f.satuan,
    a.harga_beli_satuan,
    a.harga_beli_satuan * (a.qty * a.volume) AS total
FROM
    farmasi_pembelian_obat_detail a
        LEFT JOIN
    farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
        LEFT JOIN
    pengadaan_pesanan_masuk_faktur c ON b.id_pembelian_obat = c.id_pembelian_obat
        LEFT JOIN
    pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
        LEFT JOIN
    master_obat_detail e ON a.id_master_obat_detail = e.id_master_obat_detail
        LEFT JOIN
    master_obat f ON e.id_obat = f.id_obat
WHERE
    d.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
 $queryitem = mysql_query($sqlitem);

$sqlidentitas="SELECT
	b.nama_rekening AS pekerjaan,
	a.tahun_anggaran,
	a.jumlah_netto,
	a.jumlah_bruto,
	a.jumlah_ppn
FROM
	pengadaan_pesanan_masuk a
	LEFT JOIN master_rekening b ON a.id_rekening = b.id_rekening 
WHERE
	a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlppk="select nama_pejabat,nip,nama_jabatan,id_jabatan from master_jabatan where id_jabatan=3";
$queryppk = mysql_query($sqlppk);
$DATA_PPK = mysql_fetch_array($queryppk);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Harga Perkiraan Sendiri</title>
	<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 12px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    	border-collapse:collapse;
	}
	
	.pagebreak { 
	page-break-before: always; 
	}
	.normal { 
	font-size: 12px; 
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
	<center>
	  <strong>HARGA PERKIRAAN SENDIRI</strong>
	</center>
	<br>
	<br>
	
	<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" >No</td>
    <td width="35%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2" align="center" >Banyaknya</td>
    <td width="14%" rowspan="2" align="center" >Harga Satuan</td>
    <td width="17%" rowspan="2" align="center" >Jumlah Harga (Rp)</td>
  </tr>
  
  <tr>
    <td width="8%" align="center" >Vol</td>
    <td width="10%" align="center" >Sat</td>
  </tr>
   <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="6">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td align="center">'.$no.'</td>';
	  echo '<td align="left">'.$data['nama_obat'].'</td>';
      echo '<td align="center">'.$data['jumlah']. '</td>';
	  echo '<td align="center">'.$data['satuan']. '</div></td>';
      echo '<td align="right">'.number_format($data['harga_beli_satuan'], 2,",","."). '</td>';
	  echo '<td align="right">'.number_format($data['total'], 2,",","."). '</td>';
			echo '</tr>';
			$no++;
		}
	}
	?>
   <tr>
     <td colspan="5" align="right" ><strong>Jumlah</strong></td>
     <td align="right" style="font-size: 14px"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_bruto'], 0,",","."); ?></strong></td>
   </tr>
   <tr>
     <td colspan="5" align="right" ><strong>PPN</strong></td>
     <td align="right" style="font-size: 14px"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_ppn'], 0,",","."); ?></strong></td>
   </tr>
   <tr>
    <td colspan="5" align="right" ><strong>Total</strong></td>
        <td align="right" style="font-size: 14px"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['jumlah_netto'], 0,",","."); ?></strong></td>
  </tr>
</table>
	<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="50%">&nbsp;</td>
      <td width="50%" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">Pejabat Pembuat Komitmen</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center"><u><?php echo $DATA_PPK['nama_pejabat']; ?></u></td>
    </tr>
    <tr>
      <td style="text-align: center">&nbsp;</td>
      <td style="text-align: center">NIP.<?php echo $DATA_PPK['nip']; ?></td>
    </tr>
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
$dompdf->stream('doc_hps.pdf',array('Attachment' => 0));
?>