<?php
ob_start();
session_start();
include('connect.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>nota_pengeluaran_stok</title>

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
	font-size: 11px;
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

     <div class="header" align="center" ><u><strong>NOTA PENGELUARAN STOK BARANG</strong></u></div>
     
     <div class="footer" align="center" >Nomor : (.........)</div>

     <p class="footer" style="text-align: justify" > Telah dikeluarkan dan disalurkan barang tersebut dibawah ini berdasarkan nota permintaan stok nomor : (.........)dari (.........)</p>

<table width="100%" class="tabel" border="1" cellpadding="4">
  <tr>
    <td width="4%" rowspan="2" align="center" >No</td>
    <td width="12%" rowspan="2" align="center" >Kode Barang</td>
    <td width="30%" rowspan="2" align="center" >Nama Barang</td>
    <td colspan="2" align="center" >Banyaknya</td>
    <td width="13%" rowspan="2" align="center" >Harga Satuan</td>
    <td width="14%" rowspan="2" align="center" >Jumlah  Harga</td>
    <td width="13%" rowspan="2" align="center" >Ket.</td>
  </tr>
  <tr>
    <td width="6%" align="center" >Vol</td>
    <td width="8%" align="center" >Sat</td>
  </tr>
   <tr>
    <td align="center" > (.........)</td>
    <td align="center" > (.........) </td>
    <td align="left" > (.........)</td>
    <td align="center" > (.........)</td>
    <td align="left" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="right" > (.........)</td>
    <td align="left" > (.........)</td>
  </tr>
  
</table>
  
 <table width="100%" border="0" class="footer" >
       
     <tr>
       <td align="center" ></td>
       <td align="center" ></td>
       <td align="center" ></td>
     </tr>
     
      <tr>
       <td width="40%" align="center" ></td>
       <td width="33%" align="center" ></td>
       <td width="42%" align="center" >Ajibarang,</td>
     </tr>
     <tr>
       <td width="40%" align="center" >Yang menerima,</td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" >Yang menyerahkan,</td>
     </tr>
     <tr>
       <td height="50" >&nbsp;</td>
       <td >&nbsp;</td>
       <td >&nbsp;</td>
     </tr>
     
     <tr>
       <td width="40%" align="center" ><u>(.........)</u></td>
       <td width="33%" align="center" >&nbsp;</td>
       <td width="42%" align="center" ><u>(.........)</u></td>
     </tr>
     <tr>
      <td width="40%" align="center" >NIP. (.........)</td>
      <td width="33%" align="center" >&nbsp;</td>
      <td width="42%" align="center" >NIP. (.........)</td>
    </tr>
    
</table>
	
</style>    	
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