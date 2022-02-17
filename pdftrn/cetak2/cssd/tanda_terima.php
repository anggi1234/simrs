<?php
ob_start();
// session_start();
include('../connect2.php');
$id = $_GET['id'];
// print_r($id);
// die();

$sqlidentitas="SELECT c.jenis_alat, b.nama_alat, a.jumlah, f.userlevelname as ruang, SUBSTRING(a.created_pengambilan_at,1,10) as tanggal_ambil, d.pd_nickname as ptgs_cssd , e.pd_nickname as ptgs_ambil from t_cssd a
left join m_alat_cssd b on b.alat_id = a.instrumen
left join l_jenisalat c on c.jenis_id = a.jenis
left join simrs.master_login d on d.uid = a.petugas_yg_menyerahkan
left join simrs.master_login e on e.uid = a.petugas_pengambil
left join simrs.userlevels f on f.userlevelid = a.ruang
where a.id = '".$id."'";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tanda Terima Barang</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
	border-collapse: collapse;
	font-size: 12px;
	text-align: right;
}  
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 12px;
}

.pagebreak { 
		page-break-before: always;
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
<div align="center"><strong>Tanda Terima</strong></div>
<table width="100%" border="0" cellspacing="10">
  <tbody>
    <!-- <tr>
      <td width="4%">&nbsp;</td>
      <td width="25%">No</td>
      <td width="1%">:</td>
      <td width="70%"></td>
    </tr> -->
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="25%">Telah Diterima Dari</td>
      <td width="1%">:</td>
      <td width="70%">CSSD</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Jenis</td>
      <td>:</td>
      <td><?php echo $DATA_IDENTITAS['jenis_alat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Instrumen</td>
      <td valign="top">:</td>
      <td valign="top"><?php echo $DATA_IDENTITAS['nama_alat']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Ruang</td>
      <td valign="top">:</td>
      <td valign="top"><?php echo $DATA_IDENTITAS['ruang']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td valign="top">Jumlah</td>
      <td valign="top">:</td>
      <td valign="top"><?php echo $DATA_IDENTITAS['jumlah']; ?></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0">
        <tbody>
         <tr>
           <td align="center">&nbsp;</td>
           <td colspan="6" align="right">&nbsp;</td>
           <td align="center">&nbsp;</td>
         </tr>
         <tr>
           <td width="29%" align="center">&nbsp;</td>
          <td colspan="6" align="right">&nbsp;</td>
          <td width="32%" align="center">Ajibarang, <?php echo $DATA_IDENTITAS['tanggal_ambil']; ?></td>
        </tr>
         <tr>
           <td align="center">Petugas Pengambil</td>
           <td colspan="6" align="right">&nbsp;</td>
           <td align="center" class="total">Petugas CSSD</td>
         </tr>
         <tr>
          <td align="right">&nbsp;</td>
          <td colspan="6" align="right">&nbsp;</td>
          <td align="center" class="total">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td colspan="6" align="right">&nbsp;</td>
          <td align="center" class="total">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td colspan="6" align="right">&nbsp;</td>
          <td align="center" class="total">&nbsp;</td>
        </tr>
         <tr>
           <td align="center"><?php echo $DATA_IDENTITAS['ptgs_ambil']; ?></td>
           <td colspan="6" align="right">&nbsp;</td>
           <td align="center"><?php echo $DATA_IDENTITAS['ptgs_cssd']; ?></td>
         </tr>
         <tr>
          <td align="center"></td>
          <td colspan="6" style="font-size: 20px" align="left"></td>
          <td align="center" class="footer"><u></u></td>
         </tr>
        </tbody>
  </table>

</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('tandaterima.pdf',array('Attachment' => 0));
?>