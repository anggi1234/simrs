<?php
ob_start();
session_start();
include('connect.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>nota_terima_barang_pesanan</title>

<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
	font-family: Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana	
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 10px;
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

<div align="center" class="header" ><u><strong>NOTA TERIMA BARANG PESANAN</strong></u></div>
     <div class="footer" align="center">Nomor : (.........)</div>
<p></p>
<table class="tabel" width="100%" cellpadding="2" border="0">
    
      <tr>
        <td width="10%" >Terima dari </td>
        <td width="1%" >:</td>
        <td width="33%" >(.........)</td>
        <td width="21%" >&nbsp;</td>
        <td width="11%" >&nbsp;</td>
        <td width="1%" >&nbsp;</td>
        <td width="23%" >&nbsp;</td>
      </tr>
      <tr>
		  <td height="33" colspan="3" > Faktur/Surat Jalan/Bukti Kirim ;</td>
		  <td height="33" >&nbsp;</td>
		  <td height="33" colspan="3" > Surat Pesanan ;</td>
	  </tr>
      <tr>
        <td> Nomor </td>
        <td> :</td>
        <td> (.........)</td>
        <td>&nbsp; </td>
        <td> Nomor</td>
        <td> :</td>
        <td> (.........)</td>
      </tr>
      <tr>
        <td> Tanggal</td>
        <td> :</td>
        <td> (.........)</td>
        <td>&nbsp;</td>
        <td> Tanggal</td>
        <td> :</td>
        <td> (.........)</td>
      </tr>
    
</table>

<p></p>
<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" > No</td>
    <td width="33%" rowspan="2" align="center" > Nama Barang</td>
    <td colspan="2" align="center" > Pesanan</td>
    <td colspan="3" align="center" > Terima</td>
    <td width="9%" rowspan="2" align="center" > Volume Kurang/Lebih</td>
    <td width="12%" rowspan="2" align="center" > Ket.</td>
  </tr>
  <tr>
    <td width="5%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
    <td width="5%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
    <td width="16%" align="center" >Harga</td>
  </tr>
   <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
  <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
  <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
  <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
  <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
  <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
  <tr>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
    <td align="right" > (.........) </td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........) </td>
  </tr>
	</table>
  
  	    	    
   <P></P>
   <table class="footer" width="100%" border="0">
        
     <tr>
       <td width="40%" align="center" ></td>
       <td width="33%" align="center" ></td>
       <td width="42%" align="center" >Ajibarang,</td>
     </tr>
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><p>Yang menerima,</p></td>
     </tr>
     <tr>
       <td height="50" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" > <u>(.........)</u></td>
     </tr>
     <tr>
      <td width="40%" align="center" >&nbsp;</td>
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