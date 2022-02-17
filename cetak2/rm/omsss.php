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
      <td width="33%" style="font-size: 12px"><p align="center"><strong>ASSASEMEN MEDIS IGD</strong> <br><i>(Diisi oleh Dokter)</i><br>
      <strong></strong></p></td>
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

<table width="100%" class="tabel" border="1">
  <tr>
    <td>Parameter</td>
    <td>Skrining</td>
    <td>Jawaban</td>
    <td>Keterangan/Nilai</td>
    <td>Skor</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>tgl:</td>
  </tr>
  <tr>
    <td rowspan="2">Riwayat Jatuh</td>
    <td>Apakah pasien datang ke rmah skait karena jatuh?</td>
    <td><?= ""?></td>
    <td rowspan="2">Salah satu jawaban ya = 6</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan terkahir ini?</td>
    <td><?= ""?></td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td rowspan="3">Status Mental</td>
    <td>Apakah pasien delirium?(tidak dapat membuat keputusan, pola ppikir tidak terorganisir, gangguan daya ingat)</td>
    <td><?= ""?></td>
    <td rowspan="3">Salah satu jawabn ya = 14</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Apakah pasien disorientasi?(Salah menyebutkan waktu tempat atau orang)</td>
    <td><?= ""?></td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Apakah pasien mengalami agitasi?(ketakutan, gelisah, dan cemas)</td>
    <td><?= ""?></td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td rowspan="3">Penglihatan</td>
    <td>Apakah pasien memakai kacamata?</td>
    <td><?= ""?></td>
    <td rowspan="3">Salah satu jawaban ya = 1</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>apakah pasien mengeluh adanya penglihatan buram?</td>
    <td><?= ""?></td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Apakah pasien mempunyai glukoma, katarak, atau degenerasi macula?</td>
    <td><?= ""?></td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Kebiasaan berkemih</td>
    <td>Apakah terdapat perubahan prilaku berkemih?(frekuensi, urgensi, inkontinensia, nokturia)</td>
    <td><?= ""?></td>
    <td>Ya = 1</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td rowspan="4">Transfer (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
    <td>Mandiri(boleh menggunakan alat bantu jalan)</td>
    <td>0</td>
    <td rowspan="8">Jumlahkan nilai transfer dan mobilitas. Jika nilai total 0-3, maka skor = 0 Jika nilai total 4-6, maka skor = 7</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Memerlukan sedikit bantuan (1 orang)/dalam pengawasan</td>
    <td>1</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Memerlukan bantuan yang nyata (2orang)</td>
    <td>2</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Tidak dapat duduk dengan seimbang, perlu bantuan total</td>
    <td>3</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td rowspan="4">Mobilitas</td>
    <td>Mandiri (boleh menggunakan alat bantu jalan)</td>
    <td>0</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Berjalan dengan bantuan 1 orang (verbal/fisik)</td>
    <td>1</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>Menggunakan kursi bantu</td>
    <td>2</td>
    <td><?= ""?></td>
  </tr>
  <tr>
    <td>imobilisasi</td>
    <td>3</td>
    <td><?= ""?></td>
  </tr>
</table>

<br>
  
<div style="font-size: 9px; font-style: oblique">Terima kasih atas kerjasamanya telah mengisi formulir ini dengan jelas dan benar.</div> 
<div style="font-size: 9px; font-style: oblique">SIMRS VERSI 2.0 RSUD Ajibarang</div> 

</body>
</html>