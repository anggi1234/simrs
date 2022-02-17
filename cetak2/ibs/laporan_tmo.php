<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];

$sqlitem="SELECT 
    a.tanggal,
    b.tglreg,
    c.nama AS namapasien,
    b.nomr,
    c.alamat,
    c.tgllahir,
    d.nama AS carabayar,
    e.singkatan as unit,
    b.kelas,
    (SELECT 
            y.nama_tindakan
        FROM
            bill_detail_tindakan z
                LEFT JOIN
            master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            z.userlevelid = 40
                AND z.id_bill_detail_tarif_detail = a.id_bill_detail_tarif_ibs
        GROUP BY z.id_bill_detail_tarif_detail) AS tindakan,
    f.singkatan,
    g.ok,
    g.lensa,
    g.jenis_anastesi,
	g.rencana_tindakan,
	ROUND(b.biaya_tind_tmo) AS  biaya_tind_tmo,
    b.biaya_tind_tmno,
    round(b.biaya_obat + IFNULL(b.biaya_obat_retur, 0)) AS obat
FROM
    simrs.bill_detail_tarif_ibs a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien c ON b.nomr = c.nomr
        LEFT JOIN
    simrs2012.m_carabayar d ON b.kdcarabayar = d.kode
        LEFT JOIN
    simrs.userlevels e ON b.userlevelid_from = e.userlevelid
        LEFT JOIN
    simrs.m_dokter f ON b.kddokter = f.kddokter
        AND b.userlevelid = f.userlevelid
        LEFT JOIN
    (SELECT 
        z.rencana_tindakan,z.lensa, z.jenis_anastesi, z.ok, z.id_bill_detail_tarif_op
    FROM
        bill_order_ibs z
    GROUP BY id_bill_detail_tarif_op) g ON a.id_bill_detail_tarif = g.id_bill_detail_tarif_op
WHERE
    a.userlevelid = 40
        AND b.tglreg >= '$dari_tanggal' AND b.tglreg <= '$sampai_tanggal'";
$queryitem = mysql_query($sqlitem);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN TMO</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.1 cm;
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
  

<div align="center"><strong>LAPORAN TMO</strong></div>

<table width="100%" class="tabel" border="1">
    <tr>
	  <td width="4%" align="left" ><strong>TGL</strong></td>
      <td width="5%" align="center" ><strong>TGL OP</strong></td>
      <td width="12%" align="center" ><strong>NAMA PASIEN</strong></td>
	  <td width="3%" align="center" ><strong>NO</strong></td>
      <td width="4%" align="center" ><strong>UMUR</strong></td>
      <td width="7%" align="center" ><strong>CARABAYAR</strong></td>
      <td width="6%" align="center" ><strong>BANGSAL</strong></td>
      <td width="9%" align="center" ><strong>PRE OP</strong></td>
      <td width="8%" align="center" ><strong>PASCA OP</strong></td>
      <td width="10%" align="center" ><strong>TINDAKAN</strong></td>
      <td width="3%" align="center" ><strong>AN</strong></td>
      <td width="4%" align="center" ><strong>DPJP</strong></td>
      <td width="6%" align="center" ><strong>PENATA</strong></td>
      <td width="7%" align="center" ><strong>JEN.TMO</strong></td>
      <td width="5%" align="center" ><strong> OP</strong></td>
      <td width="7%" align="center" ><strong>OBAT</strong></td>
  </tr>
	<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
			echo '<td>'.$data['tanggal'].'</td>';
			echo '<td>'.$data['tglreg'].'</td>';
			echo '<td>'.$data['namapasien'].'</td>';
			echo '<td>'.$data['nomr'].'</td>';
			echo '<td>'.$data['tgllahir'].'</td>';
			echo '<td>'.$data['carabayar'].'</td>';
			echo '<td>'.$data['unit'].'</td>';
			echo '<td>'.$data[''].'</td>';
			echo '<td>'.$data[''].'</td>';
			echo '<td>'.$data['rencana_tindakan'].'</td>';
			echo '<td>'.$data['jenis_anastesi'].'</td>';
			echo '<td>'.$data['singkatan'].'</td>';
			echo '<td>'.$data[''].'</td>';
			echo '<td>'.$data[''].'</td>';
			echo '<td>'.$data['biaya_tind_tmo'].'</td>';
			echo '<td>'.$data['obat'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
	<tr>
      <td colspan="19" align="right">&nbsp;</td>
    </tr>
	
  </table>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 17 * 72, 8.26 * 72); // 12" x 12"
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN_TMO.pdf',array('Attachment' => 0));
?>