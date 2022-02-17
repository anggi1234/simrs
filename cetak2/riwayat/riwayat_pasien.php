<?php
ob_start();
include('../connect.php');
$nomr = $_GET['nomr'];

 $sqlitem="SELECT 
    a.tglreg,
    i.userlevelname,
    b.anamnesa,
    c.diagnosa,
    d.tindakan,
    e.obat,
    f.radiologi,
    g.laboratorium,
    h.fisioterapi
FROM
    bill_detail_tarif a
        LEFT JOIN
    (SELECT 
        id_bill_detail_tarif,
            GROUP_CONCAT(anamnesa
                SEPARATOR ', ') AS anamnesa
    FROM
        bill_detail_keterangan
    GROUP BY id_bill_detail_keterangan) b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_penyakit
                SEPARATOR ', ') AS diagnosa
    FROM
        simrs.bill_detail_penyakit a
    LEFT JOIN simrs.master_penyakit b ON a.id_penyakit = b.id_master_penyakit
    GROUP BY a.id_bill_detail_tarif) c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ') AS tindakan
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        b.userlevelid IS NULL
    GROUP BY a.id_bill_detail_tarif) d ON a.id_bill_detail_tarif = d.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(CONCAT(c.nama_obat, '(', a.qty, ')')
                SEPARATOR ', ') AS obat
    FROM
        simrs.bill_detail_permintaan_obat a
    LEFT JOIN simrs.master_obat_detail b ON a.id_master_obat_detail = b.id_master_obat_detail
    LEFT JOIN simrs.master_obat c ON b.id_obat = c.id_obat
    GROUP BY a.id_bill_detail_tarif) e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ') AS radiologi
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        b.userlevelid = 17
    GROUP BY a.id_bill_detail_tarif) f ON a.id_bill_detail_tarif = f.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ') AS laboratorium
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        b.userlevelid = 16
    GROUP BY a.id_bill_detail_tarif) g ON a.id_bill_detail_tarif = g.id_bill_detail_tarif
        LEFT JOIN
    (SELECT 
        a.id_bill_detail_tarif,
            GROUP_CONCAT(b.nama_tindakan
                SEPARATOR ', ') AS fisioterapi
    FROM
        simrs.bill_detail_tindakan a
    LEFT JOIN simrs.master_tindakan b ON a.id_tindakan = b.id_tindakan
    WHERE
        b.userlevelid = 31
    GROUP BY a.id_bill_detail_tarif) h ON a.id_bill_detail_tarif = h.id_bill_detail_tarif
        LEFT JOIN
    userlevels i ON a.userlevelid = i.userlevelid
WHERE
    a.nomr = $nomr
GROUP BY a.id_bill_detail_tarif";
 $queryitem = mysql_query($sqlitem);


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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Riwayat Pasien</title>
<link rel="shortcut icon" href="../favicon.ico"/>

<style type="text/css">
.tabel {
    border-collapse:collapse;
}
	
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.2 cm;
	}
	
</style>
</head>

<body>

 <table width="100%" border="0">
  <tr>
    <td class="header" width="3%"><img src="../gambar/logobms.png" width="76" height="70" /></td>
    <td class="header" width="97%">
      <div align="center">
        <strong>PEMERINTAH KABUPATEN BANYUMAS</strong><br />
        <strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong><br />
        Jl. Raya Pancasan - Ajibarang, Kode Pos 53163 Telp. (0281)6570004, Fax (0281)5670005<br />      
        Email: rsudajibarang@banyumaskab.go.id
      </div>
    </td>
  </tr>
</table>
<hr>
<table width="100%" height="52" border="0">
  <tr>
    <td width="100%" class="header"><div align="center"><strong>RIWAYAT PASIEN RSUD AJIBARANG</strong></div></td>
  </tr>
</table>
<table width="100%" class="footer" border="0">
    <tr>
      <td width="16%">No. Rekam Medis</td>
      <td width="19%">: <?php echo $DATA_IDENTITAS['nomr']; ?></td>
      <td width="4%">&nbsp;</td>
      <td width="11%">Alamat</td>
      <td width="50%">: <?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['nama']; ?></td>
      <td>&nbsp;</td>
      <td>Jenis Kelamin</td>
      <td>: <?php echo $DATA_IDENTITAS['jeniskelamin']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      <td></td>
      <td>Usia</td>
      <td>: <?php echo $DATA_IDENTITAS['usia']; ?></td>
  </tr>
</table>
<hr>

<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%" align="center"><strong>No</strong></td>
      <td width="5%" align="center"><strong>TGL</strong></td>
      <td width="9%" align="center"><strong>UNIT</strong></td>
      <td width="9%" align="center"><strong>ANAMNESA</strong></td>
      <td width="9%" align="center"><strong>DIAGNOSA</strong></td>
      <td width="14%" align="center"><strong>TINDAKAN</strong></td>
      <td width="17%" align="center"><strong>OBAT</strong></td>
      <td width="12%" align="center"><strong>RAD</strong></td>
      <td width="10%" align="center"><strong>LAB</strong></td>
      <td width="13%" align="center"><strong>FISIOTERAPI</strong></td>
    </tr>
    
    
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
			echo '<td valign="top" align="center">'.$no.'</td>';
			echo '<td valign="top">'.$data['tglreg'].'</td>';
			echo '<td valign="top">'.$data['userlevelname'].'</td>';
			echo '<td valign="top">'.$data['anamnesa'].'</td>';
			echo '<td valign="top">'.$data['diagnosa'].'</td>';
			echo '<td valign="top">'.$data['tindakan'].'</td>';
			echo '<td valign="top">'.$data['obat'].'</td>';
			echo '<td valign="top">'.$data['radiologi'].'</td>';
			echo '<td valign="top">'.$data['laboratorium'].'</td>';
			echo '<td valign="top">'.$data['fisioterapi'].'</td>';
			echo '</tr>';
			$no++;
		}
	?>
    
    
  </tbody>
</table>



</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 1300.134, 612);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanoperasi.pdf',array('Attachment' => 0));
?>