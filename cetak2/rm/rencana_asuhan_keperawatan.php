<html>
<head>
<meta charset="utf-8">
<title>FORM ASSESEMENT IGD</title>
<style type="text/css">
  @page {
            margin-top: 1 cm;
            margin-left: 1 cm;
      margin-right: 1 cm;
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
.isi {
  font-size: 10px;
}
.pagebreak { 
    page-break-before: always;
  }
    .vertical-line{

        display: inline-block;
        border-left: 1px solid #000000; 
        height: 40px;

    }
  

</style>
</head>

<body>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="33%"><table width="100%" border="0">
        <tbody>
          <tr>
            <td width="23%" align="center"><img src="../gambar/logobms.png" height="40px" /></td>
            <td width="77%" align="center" style="font-size: 7px; font-weight: bold" valign="middle">PEMERINTAH KABUPATEN BANYUMAS<br>RUMAH SAKIT UMUM DAERAH AJIBARANG<br>Jl. Raya Pancasan – Ajibarang<br>(0281) 6570004   Fax. (0281) 6570005<br>Email:rsudajibarang@banyumaskab.go.id</td>
          </tr>
        </tbody>
      </table></td>
      <td width="33%" style="font-size: 12px"><p align="center"><strong>ASSASEMEN KEPERATAN RAWAT INAP ANAK </strong> </p></td>
      <td width="33%" valign="middle" style="font-weight: bold"><table width="100%" style="font-size: 11px" border="0">
        <tbody>
          <tr>
            <td width="27%">NO RM</td>
            <td width="4%">:</td>
            <td width="69%"><?php echo $DATAISI['nomr']; ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $DATAISI['nama']; ?></td>
          </tr>
          <tr>
            <td>Tgl Lahir</td>
            <td>:</td>
            <td><?php echo $DATAISI['tgllahir']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>

<br>

<table width="100%" class="tabel" border="0">
  <tr>
    <td width="25%">Tanggal Masuk Ruang Rawat</td>
    <td width="5%">:</td>
    <td width="20%"><?= "" ?></td>
    <td width="25%">Jam Masuk Ruang Rawat</td>
    <td width="5%">:</td>
    <td width="20%"><?= "" ?>WIB</td>
  </tr>
  <tr>
    <td>Anamnesa</td>
    <td>:</td>
    <td><?= ""?></td>
  </tr>  
</table>

<table width="100%" class="tabel" border="1">
  <tr>
    <td><strong>TGL/JAM</strong></td>
    <td><strong>DIAGNOSA KEPERAWATAN</strong></td>
    <td><strong>TUJUAN DAN KRITERIA HASIL</strong></td>
    <td><strong>INTERVENSI KEPERAWATAN</strong></td>
    <td><strong>PARAF & NAMA</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
</table>



  
<div style="font-size: 9px; font-style: oblique">Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.</div> 
<div style="font-size: 9px; font-style: oblique">SIMRS VERSI 2.0 RSUD Ajibarang</div> 

</body>
</html>