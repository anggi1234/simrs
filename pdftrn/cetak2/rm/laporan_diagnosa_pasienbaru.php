<?php
ob_start();
include('../connect.php');
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
$icd = $_GET['icd'];
$diagnosa = $_GET['diagnosa'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_diagnosa.xls");
$whrcondnicd.=($icd)?" and e.diagnosa like '%$icd%'":"";
$whrcondndiagnosa.=($diagnosa)?" AND e.keterangan like '%$diagnosa%'":"";
if($icd == "" && $diagnosa <> ""){
	$sqlitemobat="SELECT 
    a.nomr,
    c.nama,
    c.tgllahir,
    c.alamat,
    c.noktp,
    d.nama_dokter,
    e.diagnosa,
    e.nama_kasus,
    e.keterangan,
    f.pasienbaru,
    a.tglreg,
    b.userlevelname AS unit,
    g.nama AS carabayar,
    h.keterangan as carakeluar,
    c.jeniskelamin
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs2012.m_pasien c ON a.nomr = c.nomr
        LEFT JOIN
    simrs.m_dokter d ON a.kddokter = d.kddokter
        AND a.userlevelid = d.userlevelid
        LEFT JOIN
    (SELECT 
        z.id_bill_detail_tarif,
            GROUP_CONCAT(CONCAT(z.icd10)
                SEPARATOR ' | ') AS diagnosa,
            z.keterangan,
            x.nama_kasus
    FROM
        simrs.bill_detail_penyakit z
    LEFT JOIN simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
    LEFT JOIN simrs.l_jenis_kasus x ON z.id_kasus = x.id_jenis_kasus
    GROUP BY z.id_bill_detail_tarif) e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.l_pasienbaru f ON a.id_pasienbaru = f.id
        LEFT JOIN
    simrs2012.m_carabayar g ON g.kode = a.kdcarabayar
        LEFT JOIN
    simrs.m_statuskeluar h ON a.id_status_pasien = h.status
WHERE
    b.id_pelayanan = 1
        AND (MONTH(tglreg) = $bulan
        AND YEAR(tglreg) = $tahun)
		$whrcondndiagnosa";
$queryitemobat = mysql_query($sqlitemobat);
}elseif($icd <> "" && $diagnosa == ""){
	$sqlitemobat="SELECT 
    a.nomr,
    c.nama,
    c.tgllahir,
    c.alamat,
    c.noktp,
    d.nama_dokter,
    e.diagnosa,
    e.nama_kasus,
    e.keterangan,
    f.pasienbaru,
    a.tglreg,
    b.userlevelname AS unit,
    g.nama AS carabayar,
    h.keterangan as carakeluar,
    c.jeniskelamin
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs.userlevels b ON a.userlevelid = b.userlevelid
        LEFT JOIN
    simrs2012.m_pasien c ON a.nomr = c.nomr
        LEFT JOIN
    simrs.m_dokter d ON a.kddokter = d.kddokter
        AND a.userlevelid = d.userlevelid
        LEFT JOIN
    (SELECT 
        z.id_bill_detail_tarif,
            GROUP_CONCAT(CONCAT(z.icd10)
                SEPARATOR ' | ') AS diagnosa,
            z.keterangan,
            x.nama_kasus
    FROM
        simrs.bill_detail_penyakit z
    LEFT JOIN simrs2012.vw_diagnosa_eklaim y ON z.icd10 = y.code
    LEFT JOIN simrs.l_jenis_kasus x ON z.id_kasus = x.id_jenis_kasus
    GROUP BY z.id_bill_detail_tarif) e ON a.id_bill_detail_tarif = e.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.l_pasienbaru f ON a.id_pasienbaru = f.id
        LEFT JOIN
    simrs2012.m_carabayar g ON g.kode = a.kdcarabayar
        LEFT JOIN
    simrs.m_statuskeluar h ON a.id_status_pasien = h.status
WHERE
    b.id_pelayanan = 1
        AND (MONTH(tglreg) = $bulan
        AND YEAR(tglreg) = $tahun)
		$whrcondnicd";
$queryitemobat = mysql_query($sqlitemobat);
}


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
  <span style="font-size: 14px">LAPORAN  DIAGNOSA</span> PASIEN
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
      <td>: <?php 
	if($icd <> ""){
		echo $DATA_ICD['diagnosa'];
	}
		  else{
			  echo $diagnosa;
		  }
	 ?></td>
      <td align="left">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>


<table width="100%" border="1" class="tabel">
  <tbody>
    <tr>
      <td width="4%" height="18">No.RM</td>
      <td width="18%">Nama</td>
      <td width="4%">TglReg</td>
      <td width="4%">Pasien</td>
      <td width="5%">Tgl Lahir</td>
      <td width="3%">NIK</td>
      <td width="9%">Alamat</td>
      <td width="7%">Unit</td>
      <td width="12%">Dokter</td>
      <td width="6%">Cara Bayar</td>
      <td width="6%">Jenis Kasus</td>
      <td width="5%">ICD</td>
      <td width="10%">Diagnosa</td>
      <td width="7%">Cara Keluar</td>
    </tr>
    <?php
      		while($data=mysql_fetch_assoc($queryitemobat)){
				echo '<tr>';
				echo '<td>'.$data['nomr'].'</td>';
				echo '<td>'.$data['nama'].'</td>';
				echo '<td>'.$data['tglreg'].'</td>';
				echo '<td>'.$data['pasienbaru'].'</td>';
				echo '<td>'.$data['tgllahir'].'</td>';
				echo '<td>'.$data['noktp'].'</td>';
				echo '<td>'.$data['alamat'].'</td>';
				echo '<td>'.$data['unit'].'</td>';
				echo '<td>'.$data['nama_dokter'].'</td>';
				echo '<td>'.$data['carabayar'].'</td>';
				echo '<td>'.$data['nama_kasus'].'</td>';
				echo '<td>'.$data['diagnosa'].'</td>';
				echo '<td>'.$data['keterangan'].'</td>';
				echo '<td>'.$data['carakeluar'].'</td>';
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