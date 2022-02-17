<?php
ob_start();
session_start();
include('../connect.php');

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>laporan_pengadaan</title>

<style type="text/css">
	@page {
            margin-top: 2 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 2 cm;
		font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif"
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 10px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 10px;
}
</style>

</head>

<body>

<div align="center"  class="header"><u><strong>LAPORAN PENGADAAN BARANG</strong></u></div>
     <div align="center" class="header" >Periode : </div>
<p></p>

<table width="100%" class="tabel" border="1" cellpadding="4" style="font-size-adjust: auto">
  <tr>
    <td width="3%" rowspan="2" align="center"  >No</td>
    <td width="7%" rowspan="2" align="center"  >Kode Rekening</td>
    <td width="13%" rowspan="2" align="center"  >Nama Rekening</td>
    <td colspan="3" align="center"  >SPK/Kontrak/SP</td>
    <td colspan="2" align="center"  >BAST</td>
    <td colspan="3" align="center"  >SPM</td>
    <td width="9%" rowspan="2" align="center" >Ket.</td>
  </tr>
  <tr>
    <td width="5%" align="center" >Tgl</td>
    <td width="10%" align="center" >Nomor</td>
    <td width="11%" align="center" >Nilai</td>
    <td width="5%" align="center" >Tgl</td>
    <td width="11%" align="center" >Nomor</td>
    <td width="5%" align="center" >Tgl</td>
    <td width="11%" align="center" >Nomor</td>
    <td width="10%" align="center" >Nilai</td>
  </tr>
   <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  <tr>
    <td align="center" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left"  > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="center" > (........)</td>
    <td align="left" > (........)</td>
    <td align="right" > (........)</td>
    <td align="left" > (........)</td>
  </tr>
  	    
  
  </table>
  
        <table width="100%" border="0">
        <tbody>
     <tr>
       <td align="center" class="footer" ></td>
       <td align="center" class="footer" ></td>
       <td align="center" class="footer" style="font-size: 12">(....)</td>
     </tr>
     <tr>
       <td width="40%" align="center" class="footer" ></td>
       <td width="33%" align="center" class="footer" ></td>
       <td width="42%" align="center" class="footer" >Ajibarang,<?php echo tanggal_indo(date("Y-m-d")); ?></td>
     </tr>
     <tr>
       <td width="40%" align="center" class="footer">Mengetahui,</td>
       <td width="33%" align="center" class="footer">(....)</td>
       <td width="42%" align="center" class="footer">Pejabat Pengadaan</td>
     </tr>
     <tr>
       <td width="40%" align="center" class="footer">Pejabat Pelaksana Teknis Kegiatan,</td>
       <td width="33%" align="center" class="footer">(....)</td>
       <td width="42%" align="center" class="footer">Kegiatan (........)</td>
     </tr>
     <tr>
       <td height="50" ></td>
       <td ></td>
       <td ></td>
     </tr>
     
     <tr>
       <td width="40%" align="center" class="footer"><u>(........)</u></td>
       <td width="33%" align="center" class="footer">(....)</td>
       <td width="42%" align="center" class="footer"> <u>(........)</u></td>
     </tr>
     <tr>
      <td width="40%" align="center" class="footer" >NIP. (........)</td>
      <td width="33%" align="center" class="footer" >(....)</td>
      <td width="42%" align="center" class="footer" >NIP. (........)</td>
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
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporan_pengadaan.pdf',array('Attachment' => 0));
?>