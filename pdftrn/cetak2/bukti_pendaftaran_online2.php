<?php
ob_start();
session_start();
include('connect.php');
include('barcode128.php');
$id_pendaftaran_online =$_GET['id_pendaftaran_online'];


$sqlidentitas="SELECT a.id_pendaftaran_online,
    a.NOMR,
    b.NAMA,
    b.ALAMAT,
    c.userlevelname,
    date_format(a.TGLREG,'%d-%m-%Y') as TGLREG,
    d.NAMA_DOKTER,
    e.NAMA AS carabayar,
    date_format(b.TGLLAHIR,'%d-%m-%Y') as TGLLAHIR,
    f.no_antrian,
	f.no_antrian as barcode,
    h.pd_nickname,time(f.jam_pemeriksaan) as jam_pemeriksaan
FROM
    simrs.pendaftaran_online a
        LEFT JOIN
    simrs2012.m_pasien b ON a.NOMR = b.NOMR
        LEFT JOIN
    simrs.userlevels c ON a.KDPOLY = c.userlevelid
        LEFT JOIN
    simrs.m_dokter d ON a.KDDOKTER = d.KDDOKTER
        LEFT JOIN
    simrs2012.m_carabayar e ON a.KDCARABAYAR = e.kode
        LEFT JOIN
    simrs.no_antrian f ON a.nomr = f.nomr and a.TGLREG=f.tglreg
        LEFT JOIN
    simrs.registrasi_akun_detail g ON a.nomr = g.nomr
        LEFT JOIN
    simrs.registrasi_akun h ON g.uid = h.username
WHERE
    a.id_pendaftaran_online = $id_pendaftaran_online";

 $queryidentitas = mysql_query($sqlidentitas);
 $DATA_IDENTITAS = mysql_fetch_array($queryidentitas);
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BUKTI PENDAFTARAN ONLINE</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
	@page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
			margin-right: 0.5 cm;
			margin-bottom: 0.5 cm;
			font-family: Consolas, Andale Mono, Lucida Console, Lucida Sans Typewriter, Monaco, Courier New, monospace;
		font-size: 12px;
	}
	
.tabel {
    border-collapse:collapse;
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
.NomorAntrian {
	font-size: 36px;
	font-weight: bold;
}
.JamDaftar {
	font-size: 36px;
	font-weight: bold;
}
</style>

</head>

<body>


<table width="100%" border="0" cellpadding="-3px" cellspacing="0px">
    <tr>
      <td width="10%" rowspan="3" align="right"><img src="gambar/logobms.png" height="70px" /></td>
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


<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. Rekam Medis</td>
      <td width="34%">: <?php echo $DATA_IDENTITAS['NOMR']; ?></td>
      <td width="15%">Unit</td>
      <td width="33%">: <?php echo $DATA_IDENTITAS['userlevelname']; ?></td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: <?php echo $DATA_IDENTITAS['NAMA']; ?></td>
      <td>Cara Bayar</td>
      <td>: <?php echo $DATA_IDENTITAS['carabayar']; ?></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: <?php echo $DATA_IDENTITAS['TGLLAHIR']; ?></td>
      <td>Tanggal Periksa</td>
      <td>: <strong><?php echo $DATA_IDENTITAS['TGLREG']; ?></strong></td>
  </tr>
    <tr>
      <td valign="top">Alamat</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['ALAMAT']; ?></td>
      <td valign="top">Dokter</td>
      <td valign="top">: <?php echo $DATA_IDENTITAS['NAMA_DOKTER']; ?></td>
    </tr>
</table>

<hr />
<center>KARTU BUKTI PENDAFTAR ONLINE</center>

<table width="100%" border="0">
   <tr>
    <td>&nbsp;</td>
    <td></td>
    <td><span style="text-align: center">Jam Dilayani di Loket adalah</span></td>
  </tr>
  <tr>
    <td width="37%" align="center" class="NomorAntrian"><?php echo $DATA_IDENTITAS['no_antrian']; ?></td>
    <td align="right">&nbsp;</td>
    <td align="right" style="text-align: center" class="JamDaftar"><strong><?php echo $DATA_IDENTITAS['jam_pemeriksaan']; ?></strong></td>
  </tr>
  <tr>
    <td align="center">Nomor Antrian Pendaftaran Online</td>
    <td align="right"></td>
    <td align="right" style="text-align: left">Datanglah 10 menit sebelum jam dilayani</td>
  </tr>
</table>
 <table width="100%" border="0">
  <tr>
    <td width="37%" align="center"></td>
    <td colspan="2" rowspan="2" align="right"><?php echo  bar128($DATA_IDENTITAS['barcode']); ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td align="center"><strong style="font-style: oblique">Pasien yang datang pada hari jum'at dimohon untuk hadir lebih awal dikarenakan layanan loket pendaftaran online selesai jam 10.00</strong></td>
  </tr>
  <tr>
    <td align="center"><strong style="font-style: oblique">Pasien dengan cara pembayaran Asuransi seperti BPJS/Jamkesda/KBS harus melalui proses verifikasi dokumen di Loket Khusus Pendaftaran Online</strong></td>
  </tr>
</table>

<table width="100%">
	<tr>
    <td width="29%">&nbsp;</td>
    <td width="39%">&nbsp;</td>
    <td width="32%" align="center">Ajibarang, <?php echo date("d-m-Y") ?></td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">Pemilik Akun</td>
  </tr>
	<tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
  </tr>
	<tr>
	  <td align="center"></td>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center">&nbsp;</td>
	  <td align="center">( <?php echo $DATA_IDENTITAS['pd_nickname']; ?> )</td>
  </tr>
</table>


<div align="right" style="position: relative;">
<div style="position: absolute; bottom: 5px;">
<div align="right">

    </div>
</div>
	</div>


</body>
</html>
<?php
 $html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('BUKTI-PENDAFTARAN-ONLINE.pdf',array('Attachment' => 0));
?>