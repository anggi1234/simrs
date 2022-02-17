<?php
ob_start();
session_start();
include('connect.php');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>surat_pesanan</title>

<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 3 cm;
			margin-right: 2 cm;
			margin-bottom: 3 cm;
		font-family: Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
	font-family: Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 14px;
	font-family: Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana
}	
.footer {
	font-size: 12px;
	font-family: Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana
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
  
  
<u><strong><center> SURAT PESANAN BARANG </center></strong></u>
      <center>Nomor : (.........)</center>
   

  
<table width="100%" border="0">
  <tbody>
    <tr>
      <td>Kepada Yth.</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>(............................)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>di-</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;(...............)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">Dengan ini mohon agar dapat dipenuhi kebutuhan barang - barang sebagaimana tercantum dibawah ini :</td>
    </tr>
  </tbody>
</table>

<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="6%" rowspan="2" align="center" >No</td>
    <td width="33%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2" align="center" >Banyaknya</td>
    <td width="14%" rowspan="2" align="center" >Harga Satuan</td>
    <td width="17%" rowspan="2" align="center" >Jumlah (Rp)</td>
    <td width="12%" rowspan="2" align="center" >Ket.</td>
  </tr>
  
  <tr>
    <td width="8%" align="center" >Vol</td>
    <td width="10%" align="center" >Sat</td>
  </tr>
   <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="left"  > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td colspan="5" align="center" > TOTAL</td>
        <td align="right" >(.........)</td>
    <td align="left" > </td>
    
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
      <td width="40%" align="center" >Ajibarang,</td>
     </tr>
     <tr>
       <td width="25%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" >Pejabat Pengadaan</td>
     </tr>
     <tr>
       <td width="25%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" >Kegiatan (.........)</td>
     </tr>
     <tr>
       <td height="50" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="25%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" > <u>(.........)</u></td>
     </tr>
     <tr>
      <td width="25%" align="center" >&nbsp;</td>
      <td width="33%" align="center" >&nbsp;</td>
      <td width="42%" align="center" >NIP. (.........)</td>
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