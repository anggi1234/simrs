<?php
ob_start();
session_start();
include('../connect.php');
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];


$sqlitemmutasimasuk="SELECT 
 	DATE_FORMAT(a.masukrs, '%d-%m-%Y') AS masukrs,
    a.nomr,
    b.nama,
    b.alamat,
    DATE_FORMAT(b.tgllahir, '%d-%m-%Y') AS tgllahir,
    c.nama AS namaruang,
    d.nama AS carabayar,
    a.icd_masuk
FROM
    simrs2012.t_admission a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs2012.m_ruang c ON a.noruang = c.no
        LEFT JOIN
    simrs2012.m_carabayar d ON a.statusbayar = d.KODE
WHERE
 		(date(masukrs) >= '$dari_tanggal'
        AND date(masukrs) <= '$sampai_tanggal')";
$queryitemmutasimasuk = mysql_query($sqlitemmutasimasuk);


?>



<html>
<head>
<meta charset="utf-8">
<title>Laporan Sensus Rawat Inap</title>
<style type="text/css">
	@page {
            margin-top: 0.1 cm;
            margin-left: 0.1 cm;
			margin-right: 0.1 cm;
			margin-bottom: 0.1 cm;
			font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}
	
.header {
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
}	
.footer {
	font-size: 12px;
	font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
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
  

    <div align="center" class="header"><strong>LAPORAN SENSUS RAWAT INAP</strong></div>
<table width="100%" class="tabel" border="0">
  <tbody>
    <tr>
      <td width="12%">Dari Tanggal</td>
      <td width="17%">: <?php echo date("d-m-Y",strtotime($dari_tanggal)) ?></td>
      <td width="33%" align="right">Sampai Tanggal</td>
      <td width="38%">: <?php echo date("d-m-Y",strtotime($sampai_tanggal)) ?></td>
    </tr>
  </tbody>
</table>


<hr>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="2%">No.</td>
      <td width="9%">Tgl Masuk</td>
      <td width="5%">No.RM</td>
      <td width="20%">Nama</td>
      <td width="30%">Alamat</td>
      <td width="10%">Tgl Lahir</td>
      <td width="10%">Nama Ruang</td>
      <td width="10%">Cara Bayar</td>
      <td width="10%">ICD x</td>
    </tr>
    <?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemmutasimasuk)){
	  echo '<tr>';
	  echo '<td>'.$no.'</td>';
      echo '<td>'.$data['masukrs'].'</td>';
	  echo '<td>'.$data['nomr'].'</td>';
			 echo '<td>'.$data['nama'].'</td>';
			 echo '<td>'.$data['alamat'].'</td>';
			 echo '<td>'.$data['tgllahir'].'</td>';
			 echo '<td>'.$data['namaruang'].'</td>';
			 echo '<td>'.$data['carabayar'].'</td>';
			 echo '<td>'.$data['icd_masuk'].'</td>';
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
$paper_size = array(0,0, 8.26 * 72, 12.69 * 72);
$dompdf->set_paper($paper_size, 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('mutasimasuk.pdf',array('Attachment' => 0));
?>