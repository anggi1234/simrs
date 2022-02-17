<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_permintaan_obat = $_GET['id_pengadaan_permintaan_obat'];
$sqlidentitas="SELECT 
    a.id_pengadaan_permintaan_obat, b.nama, c.nip,a.no_pengadaan,a.nama_kegiatan
FROM
    simrs.pengadaan_permintaan_obat a
        LEFT JOIN
    simrs.master_login_detail b ON a.username_ppkom = b.username
        LEFT JOIN
    simrs.master_login c ON b.uid = c.uid
WHERE
    a.id_pengadaan_permintaan_obat = $id_pengadaan_permintaan_obat";
$queryidentitas = mysql_query($sqlidentitas);
$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


$sqlitem="SELECT 
    a.id_master_obat_detail AS kode_barang,
    c.nama_obat,
    a.qty,
    c.satuan_pembelian,
    a.harga
FROM
    simrs.pengadaan_permintaan_obat_detail a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat c ON b.id_obat = c.id_obat
WHERE
    a.id_pengadaan_permintaan_obat =$id_pengadaan_permintaan_obat";
$queryitem = mysql_query($sqlitem);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>surat_perintah_pengadaan</title>

<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
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
     
 <table width="100%" border="0">
  <tbody>
    <tr>
      <td>Kepada Yth.</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Pejabat Pengadaan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;di-</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<u>TEMPAT</u></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
       
         
    <div class="header" align="center" ><u><strong>SURAT PERINTAH PENGADAAN BARANG</strong></u></div>
    <div align="center"> Nomor : <?php echo $DATA_IDENTITAS['no_pengadaan']; ?></div>
      
    <p style="text-align: justify">Agar dapat dilaksanakan pengadaan  pada kegiatan <?php echo $DATA_IDENTITAS['nama_kegiatan']; ?>, barang - barang sebagai berikut :</p>
    

    
<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" >No</td>
    <td width="13%" rowspan="2" align="center" >Kode Barang</td>
    <td width="28%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2" align="center" >Banyaknya</td>
    <td width="10%" rowspan="2" align="center" >HPS (Rp)</td>
    <td width="18%" rowspan="2" align="center" >Keterangan</td>
  </tr>
  <tr>
    <td width="11%" align="center" >Vol</td>
    <td width="16%" align="center" >Sat</td>
  </tr>
  <?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="7">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td align="center">'.$no.'</td>';
      echo '<td align="left">'.$data['kode_barang'].'</td>';
	  echo '<td align="left">'.$data['nama_obat'].'</td>';
      echo '<td align="center">'.$data['qty']. '</td>';
	  echo '<td align="center">'.$data['satuan_pembelian']. '</div></td>';
      echo '<td align="right">'.number_format($data['harga'], 2,",","."). '</td>';
	  echo '<td align="left"></td>';
			echo '</tr>';
			$no++;
		}
	}
	?>
 </table>	
 <br>
  <table class="footer" width="100%" border="0"> 
     <tr>
      <td width="40%" align="center"  ></td>
      <td width="33%" align="center"  ></td>
      <td width="42%" align="center" >Ajibarang, <?php echo date("d-m-Y") ?></td>
     </tr>
   
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><p>Pejabat Pembuat Komitmen</p></td>
     </tr>
     <tr>
       <td height="30" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center">&nbsp;</td>
       <td width="33%" align="center">&nbsp;</td>
       <td width="42%" align="center"><u><?php echo $DATA_IDENTITAS['nama']; ?></u></td>
     </tr>
     <tr>
      <td width="40%" align="center" >&nbsp;</td>
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