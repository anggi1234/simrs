<?php
ob_start();
session_start();
include('connect.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>nota_perintah_penyaluran</title>

<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 1 cm;
		font-family: Constantia, Lucida Bright, Georgia, san-serif 
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

<div align="center" style="font-size: 16" ><u><strong>NOTA PERINTAH PENYALURAN BARANG</strong></u></div>
     <div align="center" style="font-size: 14" >Nomor : (.........)</div>
<p></p>
<table width="100%" cellpadding="2" border="0">
    <tbody>
      <tr>
        <td width="10%" style="font-size: 12">Dari </td>
        <td width="1%" style="font-size: 12">:</td>
        <td width="33%" style="font-size: 12">(.........)</td>
        <td width="21%" style="font-size: 12">&nbsp;</td>
        <td width="11%" style="font-size: 12">&nbsp;</td>
        <td width="1%" style="font-size: 12">&nbsp;</td>
        <td width="23%" style="font-size: 12">&nbsp;</td>
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
    </tbody>
</table>

<p style="text-align: justify">Harap dikeluarkan dan disalurkan barang tersebut dalam dafatar berdasar surat permintaan stok barang nomor :  (.........)dari (.........)</p>
<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">No</td>
    <td width="12%" rowspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">Kode Barang</td>
    <td width="30%" rowspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">Nama Barang</td>
    <td colspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">Banyaknya</td>
    <td width="12%" rowspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">Harga Satuan</td>
    <td width="13%" rowspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">Jumlah  Harga</td>
    <td width="15%" rowspan="2" align="center" bgcolor="#FFFFFF" style="font-size: 12">Ket.</td>
  </tr>
  <tr>
    <td width="6%" align="center" bgcolor="#FFFFFF" style="font-size: 12">Vol</td>
    <td width="8%" align="center" bgcolor="#FFFFFF" style="font-size: 12">Sat</td>
  </tr>
   <tr>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
      <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
      <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
     <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
     <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
     <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
     <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
     <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
   <td align="center" bgcolor="#FFFFFF" style="font-size: 12" >(.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12" > (.........)</td>
    <td align="center" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12">(.........)</td>
    <td align="right" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
    <td align="left" bgcolor="#FFFFFF" style="font-size: 12"> (.........)</td>
  </tr>
  <tr>
  	    <td colspan="8" align="center" bgcolor="#FFFFFF">
   
   <table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center" class="footer" ></td>
       <td align="center" class="footer" ></td>
       <td align="center" class="footer" style="font-size: 12">&nbsp;</td>
     </tr>
     <tr>
       <td width="40%" align="center" class="footer" ></td>
       <td width="33%" align="center" class="footer" ></td>
       <td width="42%" align="center" class="footer" style="font-size: 12">Ajibarang,</td>
     </tr>
     <tr>
       <td width="40%" align="center" class="footer">&nbsp;</td>
       <td width="33%" align="center" class="footer">&nbsp;</td>
       <td width="42%" align="center" class="footer"><p>(.........)</p></td>
     </tr>
     <tr>
       <td height="81" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center" class="footer">&nbsp;</td>
       <td width="33%" align="center" class="footer">&nbsp;</td>
       <td width="42%" align="center" class="footer"> <u>(.........)</u></td>
     </tr>
     <tr>
      <td width="40%" align="center" class="footer" >&nbsp;</td>
      <td width="33%" align="center" class="footer" >&nbsp;</td>
      <td width="42%" align="center" class="footer" >NIP. (.........)</td>
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
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('notafarmasi.pdf',array('Attachment' => 0));
?>