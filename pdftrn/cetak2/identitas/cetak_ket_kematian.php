<?php
ob_start();
session_start();
include('../connect.php');

$id_bill_detail_tarif = $_GET['id_bill_detail_tarif'];
$sqlidentitas="SELECT 
    DATE_FORMAT(a.tglreg, '%d %M %Y') AS tglreg,
    DATE_FORMAT(a.tglreg, '%d-%m-%Y') AS sejak,
    DATE_FORMAT(a.tglout, '%d-%m-%Y') AS sampai,
    a.tglout,
    a.nomr,
    b.nama,
    a.usia,
    b.tgllahir,
    b.alamat,
    b.pekerjaan,
    d.userlevelname,
    TIME(a.tglout) AS jam,
    f.pd_nickname AS dokter,
    f.signature,
    f.no_surat_izin_praktek
FROM
    simrs.bill_detail_tarif a
        LEFT JOIN
    simrs2012.m_pasien b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.bill_detail_transfer_pasien c ON a.id_bill_detail_tarif = c.id_bill_detail_tarif
        AND c.id_status_keluar = 8
        LEFT JOIN
    simrs.userlevels d ON a.userlevelid = d.userlevelid
        LEFT JOIN
    simrs.m_dokter e ON a.kddokter = e.kddokter
        AND a.userlevelid = e.userlevelid
        LEFT JOIN
    simrs.master_login f ON e.kddokter = f.kddokter
WHERE
    a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);




	function tgl_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $tgl_indo;
		}
		return $tgl_indo;
	}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Surat Keterangan Kematian</title>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 12px;
	}
	
#box {
    box-sizing: content-box;    
    width: 100%;
    height: 48%;
    padding: 0px;    
    border: 2px solid #000000;
}

	
</style>


</head>
<body>
<div id="box">
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
  <span style="font-size: 14px"><strong>SURAT KETERANGAN KEMATIAN</strong></span><br>
  <span style="font-size: 14px"><strong>NO. </strong></span>
</center>
<table width="100%" border="0">
  <tbody>
    <tr>
      <td colspan="7"><p style="text-align: justify; text-indent: 30px;">Yang bertanda tangan dibawah ini, Dokter Rumah Sakit Umum Daerah Ajibarang, menerangkan bahwa : </p></td>
      </tr>
    <tr>
      <td width="13%">Nama</td>
      <td width="2%">:</td>
      <td colspan="5"><?php echo $DATA_IDENTITAS['nama']; ?></td>
      </tr>
    <tr>
      <td>Umur/tgl lahir</td>
      <td>:</td>
      <td colspan="5"><?php echo $DATA_IDENTITAS['usia']; ?> / <?php echo $DATA_IDENTITAS['tgllahir']; ?></td>
      </tr>
    <tr>
      <td>Pendidikan</td>
      <td>:</td>
      <td colspan="5"><?php echo $DATA_IDENTITAS['pendidikan']; ?></td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td>:</td>
      <td colspan="5"><?php echo $DATA_IDENTITAS['pekerjaan']; ?></td>
      </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td colspan="5"><?php echo $DATA_IDENTITAS['alamat']; ?></td>
    </tr>
    
    <tr>
      <td colspan="7"><p style="text-align: justify; text-indent: 30px;">Penderita tersebut dirawat di Rumah Sakit Umum Ajibarang, sejak : <?php echo $DATA_IDENTITAS['sejak']; ?> s/d <?php echo $DATA_IDENTITAS['sampai']; ?> di Ruang <?php echo $DATA_IDENTITAS['userlevelname']; ?> No.RM <?php echo $DATA_IDENTITAS['nomr']; ?> penderita tersebut telah meninggal dunia di Rumah Sakit Umum Ajibarang pada tanggal <?php echo $DATA_IDENTITAS['sampai']; ?> jam <?php echo $DATA_IDENTITAS['jam']; ?> WIB.</p></td>
    </tr>
    
<tr>
      <td colspan="3">&nbsp;</td>
      <td width="40%" align="center">&nbsp;</td>
      <td width="32%" align="center">Ajibarang, <?php echo tgl_indo(date('Y-m-d'),true); ?></td>
      </tr>
<tr>
  <td colspan="3">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">Dokter yang memeriksa</td>
</tr>
<tr>
  <td colspan="3">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center"><img height="100px" src="../../uploads/<?php echo $DATA_IDENTITAS['signature']; ?>"></td>
</tr>
<tr>
  <td colspan="3">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center"><?php echo $DATA_IDENTITAS['pd_nickname']; ?><br>
    <?php echo $DATA_IDENTITAS['no_surat_izin_praktek']; ?></td>
</tr>
    </tbody>
</table>
	</div>
<hr style="border:none;
  border-top:1px dotted #00000;
  color:#fff;
  background-color:#fff;
  height:1px;
  width:100%;" />
	
	
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
$dompdf->stream('SURATKEMATIAN.pdf',array('Attachment' => 0));
?>