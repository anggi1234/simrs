<?php
ob_start();
session_start();
include('../connect.php');
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Asesmen Keperawatan IGD</title>

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
      <td width="33%" style="font-size: 12px"><p align="center"><strong>ASESMEN PERAWAT<br> <?php echo $DATAISI['userlevelname']; ?></strong><br>
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


<table width="100%" class="isi" border="0">
  <tbody>
    <tr>
      <td colspan="3"><strong>Tanggal Masuk</strong>:</td>
      <td width="19%">&nbsp;</td>
      <td width="21%">&nbsp;</td>
      <td><strong>Jam Masuk</strong>:</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="2%"><strong>I.</strong></td>
      <td colspan="2"><strong>PENGKAJIAN KEPERAWATAN</strong>:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="31%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="2%">A.</td>
      <td width="15%"><strong>DATA SUBYEKTIF:</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Riwayat Penyakit Sekarang</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Riwayat Alergi</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Riwayat Penyakit Dahulu</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Riwayat Pengobatan Sebelumnya</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Riwayat Psikologis</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Riwayat Sosial Ekonomi</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Pekerjaan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Hubungan Pasien dengan keluarga</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>B</td>
      <td><strong>DATA OBYEKTIF</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>Tanda-tanda Vital:</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Keadaan Umum</td>
      <td>:</td>
      <td>&nbsp;</td>
      <td>Nadi</td>
      <td>:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Tensi:</td>
      <td>:</td>
      <td>&nbsp;</td>
      <td>Berat Badan</td>
      <td>:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Suhu:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Pernapasan</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7"><table width="100%" class="tabel" border="1">
        <tbody>
          <tr>
            <td width="21%" align="center">GCS:</td>
            <td width="29%" align="center">Mata</td>
            <td width="31%" align="center">Motorik</td>
            <td width="19%" align="center">Verbal</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6"><strong>Pengkajian Nyeri</strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="6" align="center">Skala FLACC (Untuk Anak &lt; 3 tahun, anak dengan Gangguan Kognitif)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5"><table width="100%" border="1" class="tabel">
        <tbody>
          <tr>
            <td width="12%" align="center"><strong>Pengkajian</strong></td>
            <td width="23%" align="center">0</td>
            <td width="29%" align="center">1</td>
            <td width="30%" align="center">2</td>
            <td width="6%" align="center">Nilai</td>
          </tr>
          <tr>
            <td align="left">Wajah</td>
            <td>Tersenyum / Tidak ada ekspresi khusus</td>
            <td>Terkadang eringis/Menarik diri</td>
            <td>Sering Menggetarkn Dagu Dan Mengatupkan Rahang</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Kaki</td>
            <td>Gerakan Normal/Relaksasi</td>
            <td>Tidak Tenang/Tegang</td>
            <td>Kaki Dibuat Menendang/Menarik Diri</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Aktifitas</td>
            <td>Tidur, Posisi Normal, Mudah Bergerak</td>
            <td>Gerakan Menggeliat, Berguling, Kaku</td>
            <td>Menangis Terus Menerus, Terhisak, Menjerit</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Menangis</td>
            <td>Tidak Menangis (Bangun/Tidur)</td>
            <td>Mengerang, Merengek-Rengek</td>
            <td>Menangis Terus Menerus, Terhisak dan Menjerit</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Bersuara</td>
            <td>Bersuara Normal, Tenang</td>
            <td>Tenang Bila Dipeluk, Digendong Atau Diajak Bicara</td>
            <td>Sulit Untuk Menenangkan</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="left">TOTAL Skor</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left">Skala</td>
            <td>0 = Nyaman</td>
            <td>4 - 6 = Nyeri Sedang</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td>1 - 3 = Kurang Nyaman</td>
            <td>7 - 10 = Nyeri Berat</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">1) P (Provokatif) / Penyebab Nyeri</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">2) Q Quality / Kualitas Nyeri</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">3) R Regio / Radiasi / Daerah Nyeri</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">4) S Severty / Skala, Skala Nyeri</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">5) T Time berapa lama Nyeri ini?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Seberapa lama sering mengalamai nyeri ini ? Berapa Jam</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Apakah yang membuat nyeri</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><strong>Pengkajian Fungsional: </strong>Aktivitas Sehari-hari</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5"><strong>Bila terdapat gangguan fungsional. pasien dikonsul ke rehabilitasi medis melalui DPJP </strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>Kebutuhan Edukasi</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Keyakinan/agama:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Nilai-nilai kepercayaan yang di anut</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Hambaran dalam pembelajaran</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Tingkat pendidikan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Bahasa yang digunakan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Butuh penerjemah</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Kebutuhan pembelajaran pasien (pilih topik pembelajaran pada kotak yang tersedia)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Ketersediaan Pasien/Keluarga untuk menerima informasi yang diberikan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><strong>Pengkajian Resiko Jatuh</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah pernah jatuh daam 3 bulan terakhir ?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah menggunakan alat bantu ?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah ada kesulitan berjalan</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">Apabila salah satu jawaban adalah Ya, maka lakukan intervensi Pasien Resiko Jatuh dibawah ini:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><strong>Pengkajian Resiko Decubitus</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah pasien menggunakan kursi roda atau membutuhkan bantuan?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah ada inkontinensia uri atau alvi?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah ada riwayat dekubitus atau luka dekubitus?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah pasien diatas 65 tahun?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah pasien tirah baring lama?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>Khusus Anak</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apakah ekstremitas dan badan tidak sesuai dengan usia perkembangan?</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">Apabila salah satu jawaban adalah Ya, maka lakukan edukasi pencegahan dekubitus.</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Status Obstretrik</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5"><table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="4%" rowspan="2" align="center">No.</td>
      <td width="27%" rowspan="2">Variabel</td>
      <td width="56%" rowspan="2">Pertanyaan</td>
      <td width="13%" align="center">Skor</td>
    </tr>
    <tr>
      <td align="center">YA=1, TIDAK=0</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>Kondisi Pasien Sekarang apakah pasien</td>
      <td>Apakah pasien terlihat kurus</td>
      <td align="center"><?php echo $DATAISI['gizi_terlihat_kurus']; ?></td>
    </tr>
    <tr>
      <td rowspan="2" align="center">2.</td>
      <td rowspan="2">Penurunan Berat Badan</td>
      <td>Apakah pakaian anda terasa lebih longgar</td>
      <td align="center"><?php echo $DATAISI['gizi_pakaian_terlihat_longgar']; ?></td>
    </tr>
    <tr>
      <td>Apakah akhir-akhir ini kehilangan berat badan yang tidak sengaja (3-6 bln terakhir)</td>
      <td align="center"><?php echo $DATAISI['gizi_kehilangan_bb']; ?></td>
    </tr>
    <tr>
      <td align="center">3.</td>
      <td>Penurunan Asupan Makanan</td>
      <td>Apakah anda mengalami penurunan asupan makanan selama satu minggu terakhir</td>
      <td align="center"><?php echo $DATAISI['gizi_penurunan_asupan']; ?></td>
    </tr>
    <tr>
      <td rowspan="2" align="center">4.</td>
      <td rowspan="2">Riwayat Penyakit</td>
      <td>Apakah anda merasa lemah loyo dan tidak bertenaga</td>
      <td align="center"><?php echo $DATAISI['gizi_merasa_loyo']; ?></td>
    </tr>
    <tr>
      <td>Apakah anda menderita suatu penyakit yang mengakitbatkan adanya perubahan jumlah atau jenis makanan yang anda makan</td>
      <td align="center"><?php echo $DATAISI['gizi_menderita_penyakit']; ?></td>
    </tr>
    <tr>
      <td colspan="3" align="center">TOTAL SKOR</td>
      <td align="center"><?php echo $hasilskrining = $DATAISI['gizi_menderita_penyakit']+$DATAISI['gizi_merasa_loyo']+$DATAISI['gizi_penurunan_asupan']+$DATAISI['gizi_kehilangan_bb']+$DATAISI['gizi_terlihat_kurus']+$DATAISI['gizi_pakaian_terlihat_longgar']; ?></td>
    </tr>
  </tbody>
</table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Interpretasi skor hasil</td>
      <td>0-2 Tidak beresiko malnutrisi</td>
      <td>3-6 Resiko malnutrisi</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><strong>Skrining Gizi (strong kids) Untuk Pasien ANAK-ANAK</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5"><table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%" rowspan="2" align="center">No.</td>
      <td width="75%" rowspan="2" align="center">Parameter</td>
      <td width="22%" align="center">Skor</td>
    </tr>
    <tr>
      <td align="center">YA=1, TIDAK=0</td>
    </tr>
    <tr>
      <td align="center">1.</td>
      <td>Apakah pasien tampak kurus ? (ya=1, tidak=0)</td>
      <td align="center"><?php echo $DATAISI['gizi_terlihat_kurus']; ?></td>
    </tr>
    <tr>
      <td align="center">2.</td>
      <td>Apakah terdapat penurunan BB selama 1 bulan terakhir? (Berdasarkan penilaian objektif data BB bila ada / penilaian subjektif dari orang tua pasien atau untuk bayi &lt; 1 tahun : BB Naik selama 3 bulan terakhir) (ya=1, tidak=0)</td>
      <td align="center"><?php echo $DATAISI['gizi_pakaian_terlihat_longgar']; ?></td>
    </tr>
    <tr>
      <td align="center">3.</td>
      <td>Apakah terdapat salah satu dari kondisi berikut? Diare &gt;= 5 kali/hari dan atau muntah &gt; 3 kali/hari dalam seminggu terakhir. Asupan makan berkurang selama 1 minggu terakhir (Ya=1, Tidak=0)</td>
      <td align="center"><?php echo $DATAISI['gizi_kehilangan_bb']; ?></td>
    </tr>
    <tr>
      <td align="center">4.</td>
      <td>Apakah terdapat penyakit atau keadaan yang mengakibatkan beresiko mengalami mal nutrisi? (Ya=2, Tidak=0)</td>
      <td align="center"><?php echo $DATAISI['gizi_penurunan_asupan']; ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center">TOTAL SKOR</td>
      <td align="center"><?php echo $hasilskrining = $DATAISI['gizi_menderita_penyakit']+$DATAISI['gizi_merasa_loyo']+$DATAISI['gizi_penurunan_asupan']+$DATAISI['gizi_kehilangan_bb']+$DATAISI['gizi_terlihat_kurus']+$DATAISI['gizi_pakaian_terlihat_longgar']; ?></td>
    </tr>
  </tbody>
</table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5">Hasil beresiko malnutrisi:</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"><strong>PEMBERIAN OBAT / INFUS</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="5"><table width="100%" class="tabel" border="1">
        <tbody>
          <tr>
            <td width="2%">NO</td>
            <td width="9%">Jam</td>
            <td width="37%">Nama Obat/Infus</td>
            <td width="21%">Dosis</td>
            <td width="14%">Rute</td>
            <td width="17%">Diberikan oleh</td>
            </tr>
			<?php
				$no=1;
				while($data=mysql_fetch_assoc($queryitemobatdikonsumsi)){
				echo '<tr>';
				echo '<td>'.$no.'</td>';
				echo '<td>'.$data['nama_obat'].'</td>';
				echo '<td>'.$data['nama_resep'].'</td>';
				echo '<td></td>';
				echo '</tr>';
				$no++;
				}
			?>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">KONDISI PASIEN SAAT PULANG / RUJUK DARI IGD</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Jam: .....</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Keadaan Umum</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Nadi</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Tanda Vital: Tensi </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Suhu</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Pernapasan</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Status Keluar</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">Nama dan Perawat Pengkaji IGD</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">(......................)</td>
    </tr>
  </tbody>
</table>

</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.46 * 72, 12.99 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('ASSASEMENT PERAWAT IGD.pdf',array('Attachment' => 0));
?>