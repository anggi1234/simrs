<?php
ob_start();
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Buku Kas</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
  
  @page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
      margin-right: 0.5 cm;
      margin-bottom: 0.5 cm;
    font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
    font-size: 11px;
  }
  
.tabelfix {
    border-collapse:collapse;
  font-size: 11px;
}
.footer {
  font-size: 12px;
}
.header {
  font-size: 15px;
}
  
</style>
</head>

<body>
  <table width="100%" border="0">
    <tr>
      <td width="10%" rowspan="4" align="right"><img src="../gambar/logobms.png" height="70px" /></td>
      <td width="90%" align="center" style="font-size: 14px"><strong>PEMERINTAH KABUPATEN BANYUMAS</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 14px"><strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    </tr>
    <tr>
      <td align="center"><strong style="font-size: 18px">BUKU TUNAI BENDAHARA PENGELUARAN</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-size: 12px"><strong>TAHUN ANGGARAN ...</strong></td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="text-align:right"> Periode s/d: <?php ?></td>
    </tr>
  </table>

  <hr>

  <table width="100%" class="tabelfix" border="1">
      <tr style="text-align:center">
        <td width="3%">No</td>
        <td width="10%">Tanggal</td>
        <td width="13%">Nomor Bukti</td>
        <td width="39%">Keterangan</td>
        <td width="14%">Penerimaan</td>
        <td width="11%">Pengeluaran</td>
        <td width="10%">Saldo</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr style="text-align:center">
        <td colspan="4">JUMLAH</td>
        <td><?php ?></td>
        <td><?php ?></td>
        <td><?php ?></td>
      </tr>
  </tbody>
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
$dompdf->stream('Laporan_SPM.pdf',array('Attachment' => 0));
?>