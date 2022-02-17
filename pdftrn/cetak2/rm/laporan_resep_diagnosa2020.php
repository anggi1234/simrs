<?php
ob_start();
include('../connect.php');
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
$icd = $_GET['icd'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_resep_diagnosa2020.xls");

$sqlitemobat="SELECT 
    CONCAT(h.nomr, ',', h.nama, ',', h.alamat) AS identitas,
    c.nama_obat,
    a.qty,
    g.nama_resep,
    f.tglreg
FROM
    simrs.bill_detail_permintaan_obat a
        LEFT JOIN
    simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
        LEFT JOIN
    simrs.master_obat c ON b.id_obat = c.id_obat
        LEFT JOIN
    simrs.bill_detail_permintaan_obat_master d ON a.id_bill_detail_permintaan_obat_master = d.id_bill_detail_permintaan_obat_master
        LEFT JOIN
    (SELECT 
        icd10, id_bill_detail_tarif
    FROM
        simrs.bill_detail_penyakit
    WHERE
        icd10 LIKE '%$icd%'
    GROUP BY id_bill_detail_tarif) e ON e.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    simrs.bill_detail_tarif f ON e.id_bill_detail_tarif = f.id_bill_detail_tarif
        LEFT JOIN
    simrs.master_resep g ON a.id_master_resep = g.id_master_resep
        LEFT JOIN
    simrs2012.m_pasien h ON f.nomr = h.nomr
WHERE
    YEAR(f.tglreg) = $tahun and MONTH(f.tglreg) = $bulan
        AND c.nama_obat NOT LIKE '%jasa%'
        AND g.nama_resep IS NOT NULL
ORDER BY f.tglreg ASC , f.nomr ASC";
$queryitemobat = mysql_query($sqlitemobat);

$sqlitemicd="SELECT 
    CONCAT(code, ', ', str) AS diagnosa
FROM
    simrs2012.vw_diagnosa_eklaim
WHERE
    code = '$icd'";
$queryitemicd = mysql_query($sqlitemicd);
$DATA_ICD = mysql_fetch_array($queryitemicd);


function bulan($bulan)
{
Switch ($bulan){
    case 1 : $bulan="Januari";
        Break;
    case 2 : $bulan="Februari";
        Break;
    case 3 : $bulan="Maret";
        Break;
    case 4 : $bulan="April";
        Break;
    case 5 : $bulan="Mei";
        Break;
    case 6 : $bulan="Juni";
        Break;
    case 7 : $bulan="Juli";
        Break;
    case 8 : $bulan="Agustus";
        Break;
    case 9 : $bulan="September";
        Break;
    case 10 : $bulan="Oktober";
        Break;
    case 11 : $bulan="November";
        Break;
    case 12 : $bulan="Desember";
        Break;
    }
return $bulan;
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Resep Berdasarkan Diagnosa Tahun 2020</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.8 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 11px;
}
	
.kosong {
    border:none;
}
	
.header {
	font-size: 12px;
}	
.footer {
	font-size: 14px;
}
	
body {
	margin-top: 0px;
	margin-bottom: 0px;
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
<center>
  <span style="font-size: 14px">LAPORAN OBAT BERDASARKAN DIAGNOSA</span>
</center>


<table width="100%" border="0" cellpadding="1" cellspacing="0" class="header">
    <tr>
      <td width="14%" align="left">Tahun</td>
      <td width="39%">: <?php echo $tahun ?></td>
      <td width="15%" align="left">Bulan</td>
      <td width="32%">: <?php echo bulan($bulan) ?></td>
    </tr>
    <tr>
      <td align="left">Diagnosa</td>
      <td>: <?php echo $DATA_ICD['diagnosa']; ?></td>
      <td align="left">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>


<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="12%">No.RM &amp; Nama</td>
      <td width="12%">Jenis Obat</td>
      <td width="15%">Dosis &amp; Frekuensi</td>
      <td width="11%">Efek Samping</td>
      <td width="6%">Tgl Berobat</td>
      <td width="7%">Lama Pengobatan</td>
      <td width="7%">Rute Pemberian</td>
      <td width="14%">Golongan Antibiotik</td>
    </tr>
    <?php
      		while($data=mysql_fetch_assoc($queryitemobat)){
				echo '<tr>';
				echo '<td>'.$data['identitas'].'</td>';
				echo '<td>'.$data['nama_obat'].'</td>';
				echo '<td align="right">'.$data['nama_resep'].'</td>';
				echo '<td></td>';
				echo '<td>'.$data['tglreg'].'</td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '</tr>';
		}
		?>
  </tbody>
</table>

</body>
</html>


<?php
/*$html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('resep berdasarkan diagnosa.pdf',array('Attachment' => 0));*/
?>