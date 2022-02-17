<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_permintaan_barang = $_GET['id_pengadaan_permintaan_barang'];

$sqlidentitas="SELECT
	b.nama_supplier,
	b.alamat,
	c.ppk_uid,
	a.kode_permintaan,
	c.nama_rekening,
	c.perihal,
	c.sub_kegiatan,a.total_permintaan,
    d.pd_nickname as pp,
	d.nip
FROM
	simrs.pengadaan_permintaan_barang a
	LEFT JOIN simrs.master_supplier b ON a.id_supplier = b.id_master_supplier
	LEFT JOIN simrs.master_rekening c ON a.id_rekening = c.id_rekening 
    left join simrs.master_login d on c.pp_uid=d.uid 
WHERE
	a.id_pengadaan_permintaan_barang = $id_pengadaan_permintaan_barang";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

$sqlusername="SELECT
	pd_nickname,
	nip 
FROM
	master_login a
WHERE
a.username = '$username'";
$queryusername = mysql_query($sqlusername);
$DATA_USERNAME = mysql_fetch_array($queryusername);


$sqlitem="SELECT
	b.nama_barang,
	a.jumlah_barang,
	b.satuan,
	a.harga,
	a.total 
FROM
	simrs.pengadaan_permintaan_barang_detail a
	LEFT JOIN simrs.v_pengadaan_barang_permintaan b ON a.id_master_barang_detail = b.id_barang_detail
	LEFT JOIN simrs.pengadaan_permintaan_barang c ON a.id_pengadaan_permintaan_barang = c.id_pengadaan_permintaan_barang 
WHERE
	c.id_pengadaan_permintaan_barang = $id_pengadaan_permintaan_barang";
$queryitem = mysql_query($sqlitem);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>surat_pesanan</title>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-size: 12px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 14px;
}	
.footer {
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
      <td align="center" style="font-size: 14px">Jl. Raya Pancasan - Ajibarang, Ajibarang Kode Pos 53163 <br> 
      Telp. (0281) 6570004 Fax. (0281) 6570005 <br> 
      e-mail : rsudajibarang@banyumaskab.go.id</td>
    </tr>
</table>
  <hr>
  
  
<u><strong><center> SURAT PESANAN </center></strong></u>
   

  
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="9%">Nomor</td>
      <td width="3%">:</td>
      <td width="54%"><?php echo $DATA_IDENTITAS['kode_permintaan']; ?></td>
      <td width="34%">Kepada:</td>
    </tr>
    <tr>
      <td>Lamp</td>
      <td>:</td>
      <td>-</td>
      <td>Yth. <?php echo $DATA_IDENTITAS['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>Perihal</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['perihal']; ?></td>
      <td>di <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Dengan ini kami mohon kesediaan perusahaan saudara untuk dapat memenuhi kebutuhan <?php echo $DATA_IDENTITAS['perihal']; ?> RSUD Ajibarang yang kami minta sebagai berikut:</td>
    </tr>
  </tbody>
</table>

<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" >No</td>
    <td width="35%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2" align="center" >Banyaknya</td>
    <td width="14%" rowspan="2" align="center" >Harga Satuan</td>
    <td width="17%" rowspan="2" align="center" >Jumlah (Rp)</td>
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
	  echo '<td align="left">'.$data['nama_barang'].'</td>';
      echo '<td align="center">'.$data['jumlah_barang']. '</td>';
	  echo '<td align="center">'.$data['satuan']. '</div></td>';
      echo '<td align="right">'.number_format($data['harga'], 2,",","."). '</td>';
	  echo '<td align="right">'.number_format($data['total'], 2,",","."). '</td>';
			echo '</tr>';
			$no++;
		}
	}
	?>
  <tr>
    <td colspan="5" align="center" >Jumlah</td>
        <td align="right" style="font-size: 14px"><strong>Rp.<?php echo number_format($DATA_IDENTITAS['total_permintaan'], 0,",","."); ?></strong></td>
  </tr>
</table>
  	   
   
 <table class="footer" width="100%" border="0">
     <tr>
       <td align="center" ></td>
       <td align="center" ></td>
       <td align="center" >&nbsp;</td>
     </tr>
     <tr>
      <td width="40%" align="center"  ></td>
      <td width="20%" align="center"  ></td>
      <td width="40%" align="center" >Ajibarang, <?php echo date("d-m-Y") ?></td>
     </tr>
     <tr>
       <td width="25%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" >Pejabat Pengadaan</td>
     </tr>
     <tr>
       <td width="25%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><?php echo $DATA_IDENTITAS['sub_kegiatan']; ?></td>
     </tr>
     <tr>
       <td height="50" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="25%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" > <u><?php echo $DATA_IDENTITAS['pp']; ?></u></td>
     </tr>
     <tr>
      <td width="25%" align="center" >&nbsp;</td>
      <td width="33%" align="center" >&nbsp;</td>
      <td width="42%" align="center" >NIP. <?php echo $DATA_IDENTITAS['nip']; ?></td>
    </tr>
    
      
</table>
    	
</body>
</html>
<?php
$html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>