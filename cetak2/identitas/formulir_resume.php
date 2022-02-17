<?php
ob_start();
session_start();
include('../connect.php');
$nomr = $_GET['nomr'];
// echo $nomr;

$sqlitemanamnesa="SELECT 
    a.tglreg,
    i.userlevelname,
    (SELECT 
            GROUP_CONCAT(z.anamnesa
                    SEPARATOR ', ') AS anamnesa
        FROM
            bill_detail_keterangan z
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY id_bill_detail_keterangan) AS anamnesa,
    (SELECT 
            GROUP_CONCAT(CASE
                        WHEN z.icd10 = '' THEN IFNULL(z.keterangan, '')
                        WHEN z.icd10 <> '' THEN IFNULL(CONCAT(z.icd10, ', ', x.str), '')
                    END
                    SEPARATOR ', ') AS diagnosa
        FROM
            simrs.bill_detail_penyakit z
                LEFT JOIN
            simrs.master_penyakit y ON z.id_penyakit = y.id_master_penyakit
                LEFT JOIN
            simrs2012.vw_diagnosa_eklaim x ON z.icd10 = x.code
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif
        ORDER BY z.id_bill_detail_tarif DESC) AS diagnosa,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS tindakan
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            y.userlevelid IS NULL
                AND z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS tindakan,
    (SELECT 
            GROUP_CONCAT(CONCAT(x.nama_obat, '(', z.qty, ')')
                    SEPARATOR ', ') AS obat
        FROM
            simrs.bill_detail_permintaan_obat z
                LEFT JOIN
            simrs.master_obat_detail y ON z.id_master_obat_detail = y.id_master_obat_detail
                LEFT JOIN
            simrs.master_obat x ON y.id_obat = x.id_obat
        WHERE
            z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS obat,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS radiologi
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            y.userlevelid = 17
                AND z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS radiologi,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS laboratorium
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            y.userlevelid = 16
                AND z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS laboratorium,
    (SELECT 
            GROUP_CONCAT(y.nama_tindakan
                    SEPARATOR ', ') AS fisioterapi
        FROM
            simrs.bill_detail_tindakan z
                LEFT JOIN
            simrs.master_tindakan y ON z.id_tindakan = y.id_tindakan
        WHERE
            y.userlevelid = 31
                AND z.id_bill_detail_tarif = a.id_bill_detail_tarif
        GROUP BY z.id_bill_detail_tarif) AS fisioterapi
FROM
    bill_detail_tarif a
        LEFT JOIN
    userlevels i ON a.userlevelid = i.userlevelid
WHERE
    a.nomr = $nomr
GROUP BY a.id_bill_detail_tarif";
$queryitemanamnesa = mysql_query($sqlitemanamnesa);
$queryitemanamnesa1 = mysql_query($sqlitemanamnesa);
$DATAISI = mysql_fetch_array($queryitemanamnesa1);

$sqlumur="";
$queryumur = mysql_query($sqlumur);
$DATAUMUR = mysql_fetch_array($queryumur);

$sqlidentitas="SELECT 
    b.nomr,
    b.nama,
    b.alamat,
    b.jeniskelamin,
    date_format(b.tgllahir, '%d-%m-%Y') as tgllahir,
    CONCAT(TIMESTAMPDIFF(YEAR, b.tgllahir, NOW()),
            ' tahun') AS usia
FROM
    simrs2012.m_pasien b
WHERE
    b.nomr = $nomr";
	$queryidentitas = mysql_query($sqlidentitas);
 	$DATA_IDENTITAS = mysql_fetch_array($queryidentitas);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>FORM RESUME RAWAT JALAN</title>
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 1 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
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
	
.kosong {
    border:none;
}
	
body {
margin: 0;
padding: 0;
border: 2px solid #000000;
}

</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%">
      	<table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="60px" /></td>
            <td width="77%" align="center" style="font-size: 10px; font-weight: bold" valign="top">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>FORMULIR <br/> RESUME RAWAT JALAN</strong><br>
      </p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATA_IDENTITAS['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATA_IDENTITAS['nama']; ?></td>
          </tr>
          <tr>
            <td valign="top">Tgl Lahir</td>
            <td valign="top">:</td>
            <td><?php echo $DATA_IDENTITAS['tgllahir']; ?>  <br>/ <?php echo $DATA_IDENTITAS['usia']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
<br>
<table width="100%" class="tabel" border="1">
	<tr>
		<td colspan="20" align="left"><font style="font-size:12px;"><i>Diisi Oleh Perawat Penanggungjawab Pasien</i></td>
	</tr>
	<tr>
		<td colspan="8"><center><font style="font-size:12px;">ALERGI</center></td>
		<td colspan="12"><center><font style="font-size:12px;">RAWAT INAP-OPERASI</center></td>
	</tr>
	<tr>
			<td colspan="8" height="6%"><center><font style="font-size:12px;"></center></td>
			<td colspan="12"><center><font style="font-size:12px;"></center></td>
	</tr>

	<tr>
		<td colspan="3"><center><font style="font-size:12px;">TANGGAL</center></td>
		<td colspan="5"><center><font style="font-size:12px;">KLINIK / NAMA DOKTER</center></td>
		<td colspan="4"><center><font style="font-size:12px;">DIAGNOSE</center></td>
		<td colspan="6"><center><font style="font-size:12px;">TERAPI</center></td>
		<td colspan="2"><center><font style="font-size:12px;">KET</center></td>
	</tr>
	<?php
	while ($p = mysql_fetch_array($queryitemanamnesa1)){
		$tglreg = $p['tglreg'];
		$userlevelname = $p['userlevelname'];
		$anamnesa = $p['anamnesa'];
		$diagnosa = $p['diagnosa'];
		$tindakan = $p['tindakan'];
	?>
	<body>
	<tr>
		<td colspan="3"><center><font style="font-size:12px;"><?php echo $tglreg; ?></center></td>
		<td colspan="5"><center><font style="font-size:12px;"><?php echo $userlevelname; ?></center></td>
		<td colspan="4"><center><font style="font-size:12px;"><?php echo $diagnosa; ?></center></td>
		<td colspan="6"><center><font style="font-size:12px;"><?php echo $tindakan; ?></center></td>
		<td colspan="2"><center><font style="font-size:12px;"></center></td>
		<?php } ?>
	</tr>
	</body>
</table>

  </tbody>
</table>
		  
	

	
	<div align="right" style="position: relative;">
	<div style="position: absolute; bottom: 9px;">
		<div align="left" style="font-size: 9px; font-style: oblique">
      		Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.
    	</div>
	</div>
	</div>	

</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.27 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('nota.pdf',array('Attachment' => 0));
?>