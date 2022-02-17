<?php
ob_start();
session_start();
include('connect.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>nota_permintaan_stok</title>


<style type="text/css">
	@page {
		    margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-size: 12px;
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
<div class="header" align="center" ><u><strong>NOTA PERMINTAAN STOK BARANG</strong></u></div>
<div class="footer" align="center" > Nomor : (.........)</div>


<table class="tabel" width="100%" cellpadding="2" border="0">
      <tr>
        <td width="10%" >Dari </td>
        <td width="1%" >:</td>
        <td width="33%" >(.........)</td>
        <td width="21%" >&nbsp;</td>
        <td width="11%" >&nbsp;</td>
        <td width="1%" >&nbsp;</td>
        <td width="23%" >&nbsp;</td>
      </tr>
      <tr>
        <td style="font-size: 12">Kepada </td>
        <td style="font-size: 12">:</td>
        <td style="font-size: 12">(.........)</td>
        <td style="font-size: 12">&nbsp;</td>
        <td style="font-size: 12"></td>
        <td style="font-size: 12"></td>
        <td style="font-size: 12"></td>
      </tr>
    </table>
    
<p class="footer" >Permintaan stok barang tersebut dibawah ini : </p>

<table class="tabel" width="100%" border="1" cellpadding="4">
  <tr>
    <td width="3%" rowspan="2" align="center" >No</td>
    <td width="11%" rowspan="2" align="center" >Kode Barang</td>
    <td width="29%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2" align="center" >Banyaknya</td>
    <td colspan="3" align="center" >Stok Tersedia</td>
    <td width="15%" rowspan="2" align="center" >Ket.</td>
  </tr>
  <tr>
    <td width="6%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
    <td width="6%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
    <td width="14%" align="center" >Harga Satuan</td>
  </tr>
   <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  <tr>
    <td align="center" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left"  > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="center" >(.........)</td>
    <td align="left" >(.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
	</table>
 	   <p></p> 	   
   
   <table class="footer" width="100%" border="0">
       
     
     <tr>
       <td width="40%" align="center"  >&nbsp;</td>
       <td width="33%" align="center"  >&nbsp;</td>
       <td width="42%" align="center" >Ajibarang,</td>
     </tr>
     <tr>
       <td width="40%" align="center" >&nbsp;</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><p>(.........)</p></td>
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