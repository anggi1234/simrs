<?php
include('../connect.php');

$idxdaftar = $_GET['idxdaftar'];


$sqlusername="select pd_nickname,signature_pad from master_login where username='$username'";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);
 

$sqlidmaster=mysql_query("SELECT 
    a.id_expertise_radiologi,
    c.nomr,
    d.NAMA,
    d.ALAMAT,
    DATE_FORMAT(d.TGLLAHIR, '%d-%m-%Y') AS TGLLAHIR,
    e.nama AS cara_bayar,
    DATE_FORMAT(b.tanggal, '%d-%m-%Y') AS tanggal,
    a.photo,
    f.namadokter AS pengirim,
    i.pd_nickname AS dokter_radiologi,
    i.signature_pad
FROM
    expertise_radiologi a
        LEFT JOIN
    bill_detail_tarif_detail b ON a.id_bill_detail_tarif_detail = b.id_bill_detail_tarif_detail
        LEFT JOIN
    bill_detail_tarif c ON b.id_bill_detail_tarif = c.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_pasien d ON c.nomr = d.NOMR
        LEFT JOIN
    simrs2012.m_carabayar e ON c.kdcarabayar = e.kode
        LEFT JOIN
    simrs2012.m_dokter f ON c.kddokter = f.kddokter
        LEFT JOIN
    simrs.m_dokter h ON a.userlevelid = h.userlevelid
        LEFT JOIN
    simrs.master_login i ON i.kddokter = h.kddokter
WHERE
    b.idxdaftar = $idxdaftar");

while($rows=mysql_fetch_array($sqlidmaster)){	

echo '
<style type="text/css">
	@page {
            margin-top: 1 cm;
            margin-left: 1 cm;
			margin-right: 1 cm;
			margin-bottom: 0.3 cm;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
	}
	
.tabel {
    border-collapse:collapse;
	font-size: 12px;
}

.pagebreak { 
		page-break-after: always;
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
  

    <div align="center"><strong>HASIL PEMERIKSAAN RADIOLOGI</strong></div>



<table width="100%" class="footer" border="0">
    <tr>
      <td width="18%">No. RM</td>
      <td width="27%">: '.$rows["nomr"].'</td>
      <td width="19%">Alamat</td>
      <td width="36%">: '.$rows["ALAMAT"].'</td>
    </tr>
    <tr>
      <td>Nama Pasien</td>
      <td>: '.$rows["NAMA"].'</td>
      <td>Cara Bayar</td>
      <td>: '.$rows["cara_bayar"].'</td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>: '.$rows["TGLLAHIR"].'</td>
      <td>Tanggal Periksa</td>
      <td>: '.$rows["tanggal"].'</td>
  </tr>
    <tr>
      <td valign="top">Jenis Pemeriksaan</td>
      <td valign="top">: '.$rows["photo"].'</td>
      <td valign="top">Pengirim</td>
      <td valign="top">: '.$rows["pengirim"].'</td>
    </tr>
</table>';

	
$sqlisi="SELECT * FROM simrs.expertise_detail_radiologi where id_expertise_radiologi=".$rows['id_expertise_radiologi']."";
$queryisi = mysql_query($sqlisi);
	
while($data=mysql_fetch_assoc($queryisi)){	
echo '<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="8%" style="vertical-align:top"><strong>KLINIS</strong></td>
      <td width="3%" style="vertical-align:top">: </td>
      <td width="89%" style="vertical-align:top">'.$data["klinis"].'</td>
    </tr>
    <tr>
      <td style="vertical-align:top"><strong>DESKRIPSI</strong></td>
      <td style="vertical-align:top">:</td>
      <td style="vertical-align:top">'.$data["bacaan"].'</td>
    </tr>
    <tr>
      <td style="vertical-align:top"><strong>KESAN</strong></td>
      <td style="vertical-align:top">:</td>
      <td style="vertical-align:top"><strong>'.$data["kesan"].'</strong></td>
    </tr>
  </tbody>
</table>

<div align="right" style="position: relative;">
  <div style="position: absolute; bottom: 5px;">
  <div align="right">
        Spesialis Radiodiagnostik,
      <br><img height="80px" src="'.$rows["signature_pad"].'"/><br>
	  		'.$rows["dokter_radiologi"].'
      </div>
  </div>
</div>	';
};

echo '</div><div class="pagebreak"></div>';
}

?>