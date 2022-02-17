<?php
ob_start();
session_start();
include('../connect.php');
$id_pengadaan_pesanan_barang_masuk = $_GET['id_pengadaan_pesanan_barang_masuk'];


$sqlitemstok="SELECT
    a.bapem_no,
    c.nama_rekening, 
    a.tahun_anggaran,
    b.nama_supplier,
    b.alamat,
    a.jumlah_bruto,
    b.nama_pj,
    b.posisi,
    e.pd_nickname AS 'pphp',
    e.nip AS 'nip_pphp',
    f.pd_nickname AS 'pptk',
    f.nip AS 'nip_pptk',
    a.no_pesanan,
    a.tgl_pesanan,
    a.spk_no,
    a.spk_tgl,
    a.pl_undangan_no,
    a.pl_undangan_tgl,
    a.ba_hpl_no,
    a.ba_hpl_tgl,
    a.kontrak_jangka_waktu,
    a.jumlah_bruto,
    a.jumlah_netto,
    a.jumlah_pph+a.jumlah_ppn AS 'jumlah_ppn'

FROM
    simrs.pengadaan_pesanan_masuk a
        LEFT JOIN
    master_supplier b ON a.id_supplier = b.id_master_supplier
        LEFT JOIN
    master_rekening c ON a.id_rekening = c.id_rekening
        LEFT JOIN
    master_rekening3 d ON a.id_master_rekening3 = d.id_master_rekening3
    LEFT JOIN
    master_login e ON c.pphp_uid = e.uid
    LEFT JOIN
    master_login f ON d.pptk_uid = f.uid
WHERE
    a.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
$queryitemstok = mysql_query($sqlitemstok);
$queryitemobat = mysql_query($sqlitemstok);
$DATA_OBAT = mysql_fetch_array($queryitemobat);

$sqlusername="select a.pd_nickname,b.userlevelname from master_login a left join userlevels b on a.userlevelid=b.userlevelid where a.username=$username";
 $queryusername = mysql_query($sqlusername);
 $DATA_USERNAME = mysql_fetch_array($queryusername);

$sqlitem="SELECT
	f.nama_obat,a.qty*a.volume as jumlah,f.satuan,a.harga_beli_satuan,a.harga_beli_setelah_pajak
FROM
	farmasi_pembelian_obat_detail a
	LEFT JOIN farmasi_pembelian_obat b ON a.id_pembelian_obat = b.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk_faktur c ON b.id_pembelian_obat = c.id_pembelian_obat
	LEFT JOIN pengadaan_pesanan_masuk d ON c.id_pengadaan_pesanan_masuk = d.id_pengadaan_pesanan_barang_masuk
	left join master_obat_detail e on a.id_master_obat_detail=e.id_master_obat_detail
	left join master_obat f on e.id_obat=f.id_obat 
WHERE
	d.id_pengadaan_pesanan_barang_masuk = '$id_pengadaan_pesanan_barang_masuk'";
 $queryitem = mysql_query($sqlitem);




function Terbilang($nilai) {
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        if($nilai==0){
            return "";
        }elseif ($nilai < 12&$nilai!=0) {
            return "" . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return Terbilang($nilai - 10) . " Belas ";
        } elseif ($nilai < 100) {
            return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
        } elseif ($nilai < 200) {
            return " Seratus " . Terbilang($nilai - 100);
        } elseif ($nilai < 1000) {
            return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
        } elseif ($nilai < 2000) {
            return " Seribu " . Terbilang($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
        }elseif ($nilai < 1000000000000) {
            return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
        }elseif ($nilai < 100000000000000) {
            return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
        }elseif ($nilai <= 100000000000000) {
            return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
        }
    }



function tanggal_indo($tanggal, $cetak_hari = false)
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
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Surat Perintah Kerja</title>
<style type="text/css">
	@page {
            margin-top: 2 cm;
            margin-left: 2 cm;
			margin-right: 2 cm;
			margin-bottom: 3 cm;
		font-size: 11px;
		font-family: Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black," sans-serif";
	}
	
	.tabel {
    	border-collapse:collapse;
	}
	.judul {
    	font-size: 13px;
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
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="21%" rowspan="4" align="center"><strong>SURAT PERINTAH KERJA (SPK)</strong></td>
      <td colspan="4" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="font-size: 13px">SATUAN KERJA : RSUD AJIBARANG</strong></td>
    </tr>
    <tr>
      <td width="13%">Nomor SPK</td>
      <td colspan="3">: <?php echo $DATA_OBAT['spk_no']; ?></td>
    </tr>
    <tr>
      <td>Tanggal SPK</td>
      <td colspan="3">: <?php echo tanggal_indo($DATA_OBAT['spk_tgl'],true); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="28%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td rowspan="6" align="center"><strong><?php echo $DATA_OBAT['nama_rekening']; ?> Rumah Sakit</strong></td>
      <td colspan="4">Nomor dan Tanggal Surat Undangan Pengadaan Langsung</td>
    </tr>
    <tr>
      <td>Nomor</td>
      <td colspan="3">: <?php echo $DATA_OBAT['pl_undangan_no']; ?></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td colspan="3">: <?php echo tanggal_indo($DATA_OBAT['pl_undangan_tgl'],true); ?></td>
    </tr>
    <tr>
      <td colspan="4">Nomor dan Tanggal Berita Acara Hasil Pengadaan Langsung</td>
    </tr>
    <tr>
      <td>Nomor</td>
      <td colspan="3">: <?php echo $DATA_OBAT['ba_hpl_no']; ?></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td colspan="3">: <?php echo tanggal_indo($DATA_OBAT['ba_hpl_tgl'],true); ?></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td colspan="4">SPK ini mulai berlaku efektif terhitung sejak tanggal diterbitkannya SP dan penyelesaian keseluruhan pekerjaan sebagaimana diatur dalam SPK ini.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Sumber Dana</td>
      <td colspan="4">Anggaran BLUD RSUD Ajibarang Kab. Banyumas T.A. <?php echo $DATA_OBAT['tahun_anggaran']; ?></td>
    </tr>
    <tr>
      <td>Waktu Pelaksanaan</td>
      <td colspan="4"><?php echo $DATA_OBAT['kontrak_jangka_waktu']; ?> (<?php echo Terbilang($DATA_OBAT['kontrak_jangka_waktu']) ?>) hari kalender</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">Pembayaran dilakukan melalui transfer rekening ke Bank JATENG Cab. Purwokerto dengan nomor rekening <?php echo $DATA_OBAT['no_rekening']; ?> atas nama <?php echo $DATA_OBAT['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td colspan="5" style="text-align: center">Pekerjaan Pengadaan Barang</td>
    </tr>
  </tbody>
</table>
<table width="100%" class="tabel" border="1">
  <tbody>
    <tr>
      <td width="3%"  style="text-align: center">No.</td>
      <td width="37%"  style="text-align: center">Jenis Barang</td>
      <td width="10%"  style="text-align: center">Volume</td>
      <td width="10%"  style="text-align: center">Satuan</td>
      <td width="19%"  style="text-align: center">Harga Satuan</td>
      <td width="21%"  style="text-align: center">Jumlah Harga</td>
    </tr>
<?php
	if(mysql_num_rows($queryitem)==0){
		echo '<tr><td colspan="6">Tidak ada data</td></tr>';
	}
	else{
		$no=1;
		while($data=mysql_fetch_assoc($queryitem)){
			echo '<tr>';
	  echo '<td>'.$no.'.</td>';
      echo '<td>'.$data['nama_obat'].'</td>';
	  echo '<td>'.$data['jumlah'].'</td>';
	  echo '<td>'.$data['satuan'].'</td>';
      echo '<td align="right">'.number_format($data['harga_beli_satuan'], 2,",","."). '</td>';
	  echo '<td align="right">'.number_format($data['harga_beli_setelah_pajak'], 2,",","."). '</td>';
			echo '</tr>';
			
			$no++;
		}
	}
    
	?>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td>Jumlah</td>
      <td align="right"><?php echo number_format($DATA_OBAT['jumlah_bruto'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td>PPN</td>
      <td align="right"><?php echo number_format($DATA_OBAT['jumlah_ppn'], 0,",","."); ?></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td>TOTAL</td>
      <td align="right">Rp.<?php echo number_format($DATA_OBAT['jumlah_netto'], 2,",","."); ?></td>
    </tr>
  </tbody>
</table>
<br>
Terbilang : <?php echo Terbilang($DATA_OBAT['jumlah_netto']) ?> Rupiah
<hr>
	
<div style="text-align: justify">INSTRUKSI KEPADA PENYEDIA: Penagihan hanya dapat dilakukan setelah penyelesaian pekerjaan yang diperintahkan dalam SPK ini dan dibuktikan dengan Berita Acara Serah Terima. Jika pekerjaan tidak dapat diselesaikan dalam jangka waktu pelaksanaan pekerjaan karena kesalahan atau kelalaian Penyedia maka Penyedia berkewajiban untuk membayar denda kepada PPK sebesar 1/1000 (satu per seribu) dari nilai SPK untuk setiap hari keterlambatan.</div>   														

	
	<hr>
	
<table width="100%" border="0">
  <tbody>
    <tr>
      <td width="35%">&nbsp;</td>
      <td width="17%">&nbsp;</td>
      <td width="48%">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Untuk dan atas nama</td>
      <td>&nbsp;</td>
      <td align="center">Untuk dan atas nama</td>
    </tr>
    <tr>
      <td align="center">RSUD AJIBARANG</td>
      <td>&nbsp;</td>
      <td align="center"><?php echo $DATA_OBAT['nama_supplier']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><u><?php echo $DATA_OBAT['pd_nickname']; ?></u></td>
      <td>&nbsp;</td>
      <td align="center"><u><?php echo $DATA_OBAT['nama_pj']; ?></u></td>
    </tr>
    <tr>
      <td align="center"><?php echo $DATA_OBAT['nip']; ?></td>
      <td>&nbsp;</td>
      <td align="center"><?php echo $DATA_OBAT['posisi']; ?></td>
    </tr>
  </tbody>
</table>
	
<div class="pagebreak"> </div>
	
	
<div class="judul"><center>
	  <p><strong>SYARAT UMUM<br>SURAT PERINTAH KERJA (SPK)</strong>
    </p></center>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" id="sheet0" style="text-align: justify; table-layout: fixed;">
        <tbody>
          <tr >
            <td width="3%" >1.</td>
            <td  colspan="14">LINGKUP PEKERJAAN                                                                                                                                                                                                                                                                                            </td>
          </tr>
          <tr >
            <td width="3%" ></td>
            <td colspan="14">Penyedia yang ditunjuk berkewajiban untuk menyelesaikan pekerjaan dalam jangka waktu yang ditentukan, sesuai dengan volume, spesifikasi teknis dan harga yang tercantum dalam SPK</td>
          </tr>
          <tr class="row4">
            <td width="3%" >2.</td>
            <td  colspan="14">HUKUM YANG BERLAKU</td>
          </tr>
          <tr class="row5">
            <td width="3%" ></td>
            <td  colspan="14">Keabsahan, interpretasi, dan pelaksanaan SPK ini didasarkan kepada hukum Republik Indonesia</td>
          </tr>
          <tr class="row6">
            <td width="3%" >3.</td>
            <td  colspan="14">HARGA SPK</td>
          </tr>
          <tr class="row8">
            <td width="3%" ></td>
            <td width="3%" id="sheet0" >a.</td>
            <td  colspan="13">PPK membayar kepada penyedia atas pelaksanaan pekerjaan dalam SPK sebesar harga SPK.</td>
          </tr>
          <tr class="row8">
            <td width="3%" ></td>
            <td width="3%" id="sheet0" >b.</td>
            <td  colspan="13">Harga SPK telah memperhitungkan keuntungan, beban pajak dan biaya overhead serta biaya asuransi (apabila dipersyaratkan).</td>
          </tr>
          <tr class="row9">
            <td width="3%" ></td>
            <td width="3%" id="sheet0" >c.</td>
            <td  colspan="13">Rincian harga SPK sesuai dengan rincian yang tercantum dalam daftar kuantitas dan harga</td>
          </tr>
          <tr class="row10">
            <td width="3%" >4.</td>
            <td  colspan="14" id="sheet0">HAK KEPEMILIKAN</td>
          </tr>
          <tr class="row11">
            <td width="3%" ></td>
            <td width="3%"  valign="top" id="sheet0">a.</td>
            <td  colspan="13">PPK berhak atas kepemilikan semua barang/bahan yang terkait langsung atau disediakan sehubungan dengan jasa yang diberikan oleh penyedia kepada PPK. Jika diminta oleh PPK maka penyedia berkewajiban untuk membantu secara optimal pengalihan hak kepemilikan tersebut kepada PPK sesuai dengan hukum yang berlaku.</td>
          </tr>
          <tr class="row12">
            <td width="3%" ></td>
            <td width="3%"  valign="top" id="sheet0">b.</td>
            <td  colspan="13">Hak kepemilikan atas peralatan dan barang/bahan yang disediakan oleh PPK tetap pada PPK, dan semua peralatan tersebut harus dikembalikan kepada PPK pada saat SPK berakhir atau jika tidak diperlukan lagi oleh penyedia. Semua peralatan tersebut harus dikembalikan dalam kondisi yang sama pada saat diberikan kepada penyedia dengan pengecualian keausan akibat pemakaian yang wajar.</td>
          </tr>
          <tr class="row13">
            <td width="3%" >5.</td>
            <td  colspan="14">CACAT MUTU</td>
          </tr>
          <tr class="row14">
            <td width="3%" ></td>
            <td  colspan="14">PPK akan memeriksa setiap hasil pekerjaan penyedia dan memberitahukan secara tertulis penyedia atas setiap cacat mutu yang ditemukan. PPK dapat memerintahkan penyedia untuk menemukan dan mengungkapkan cacat mutu, serta menguji pekerjaan yang dianggap oleh PPK mengandung cacat mutu. Penyedia bertanggung jawab atas cacat mutu selama 6 (enam) bulan setelah serah terima hasil pekerjaan.</td>
          </tr>
          <tr class="row15">
            <td width="3%" >6.</td>
            <td  colspan="14">PERPAJAKAN</td>
          </tr>
          <tr class="row16">
            <td width="3%" ></td>
            <td  colspan="14">Penyedia berkewajiban untuk membayar semua pajak, bea, retribusi, dan pungutan lain yang sah yang dibebankan oleh hukum yang berlaku atas pelaksanaan SPK. Semua pengeluaran perpajakan ini dianggap telah termasuk dalam harga SPK.</td>
          </tr>
          <tr class="row17">
            <td width="3%" >7.</td>
            <td  colspan="14">PENGALIHAN DAN ATAU SUB KONTRAK</td>
          </tr>
          <tr class="row18">
            <td width="3%" ></td>
            <td  colspan="14">Penyedia dilarang untuk mengalihkan dan/atau mensubkontrakkan sebagian atau seluruh pekerjaan, kecuali kepada penyedia spesialis untuk bagian pekerjaan tertentu. Pengalihan seluruh pekerjaan hanya diperbolehkan dalam hal pergantian nama penyedia, baik sebagai akibat peleburan (merger) atau akibat lainnya</td>
          </tr>
          <tr class="row19">
            <td width="3%" >8.</td>
            <td  colspan="14">JADWAL</td>
          </tr>
          <tr class="row20">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">SPK ini berlaku efektif pada tanggal penandatanganan oleh para pihak atau pada tanggal yang ditetapkan dalam SP.</td>
          </tr>
          <tr class="row21">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Waktu pelaksanaan SPK adalah sejak tanggal mulai kerja yang tercantum dalam SP</td>
          </tr>
          <tr class="row22">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">Penyedia harus menyelesaikan pekerjaan sesuai jadwal yang ditentukan. </td>
          </tr>
          <tr class="row23">
            <td width="3%" ></td>
            <td width="3%"  valign="top">d.</td>
            <td  colspan="13">Apabila penyedia berpendapat tidak dapat menyelesaikan pekerjaan sesuai jadwal karena keadaan diluar pengendaliannya dan penyedia telah melaporkan kejadian tersebut kepada PPK, maka PPK dapat melakukan penjadwalan kembali pelaksanaan tugas penyedia dengan adendum SPK.</td>
          </tr>
          <tr class="row24">
            <td width="3%" >9.</td>
            <td  colspan="14">ASURANSI</td>
          </tr>
          <tr class="row25">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">Apabila dipersyaratkan, penyedia wajib menyediakan asuransi sejak SP sampai dengan tanggal selesainya pemeliharaan untuk:</td>
          </tr>
          
          <tr class="row27">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">1)</td>
            <td width="1130"  colspan="12">semua barang dan peralatan yang mempunyai risiko tinggi terjadinya kecelakaan, pelaksanaan pekerjaan, serta pekerja untuk pelaksanaan pekerjaan, atas segala risiko terhadap kecelakaan, kerusakan, kehilangan, serta risiko lain yang tidak dapat diduga;</td>
          </tr>
          <tr class="row28">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">2)</td>
            <td  colspan="12">pihak ketiga sebagai akibat kecelakaan di tempat kerjanya; dan</td>
          </tr>
          <tr class="row29">
            <td width="3%" ></td>
            <td width="3%" >b.</td>
            <td  colspan="13">Besarnya asuransi sudah diperhitungkan dalam penawaran dan termasuk dalam harga SPK.</td>
          </tr>
          <tr class="row30">
            <td width="3%" >10.</td>
            <td  colspan="14">PENANGGUNGAN DAN RISIKO</td>
          </tr>
          <tr class="row31">
            <td width="3%" ></td>
            <td width="3%" >a.</td>
            <td  colspan="13">Penyedia berkewajiban untuk melindungi, membebaskan, dan menanggung tanpa batas PPK beserta instansinya terhadap semua bentuk tuntutan, tanggung jawab, kewajiban, kehilangan, kerugian, denda, gugatan atau tuntutan hukum, proses pemeriksaan hukum, dan biaya yang dikenakan terhadap PPK beserta instansinya (kecuali kerugian yang mendasari tuntutan tersebut disebabkan kesalahan atau kelalaian berat PPK) sehubungan dengan klaim yang timbul dari hal-hal berikut terhitung sejak Tanggal Mulai Kerja sampai dengan tanggal penandatanganan berita acara penyerahan akhir:</td>
          </tr>
          <tr class="row32">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >1)</td>
            <td  colspan="12">kehilangan atau kerusakan peralatan dan harta benda penyedia dan Personil;</td>
          </tr>
          <tr class="row33">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >2)</td>
            <td  colspan="12">cidera tubuh, sakit atau kematian Personil;</td>
          </tr>
          <tr class="row34">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >3)</td>
            <td  colspan="12">kehilangan atau kerusakan harta benda, dan cidera tubuh, sakit atau kematian pihak ketiga;</td>
          </tr>
          <tr class="row35">
            <td width="3%" ></td>
            <td width="3%" >b.</td>
            <td  colspan="13">Terhitung sejak Tanggal Mulai Kerja sampai dengan tanggal penandatanganan berita acara penyerahan awal, semua risiko kehilangan atau kerusakan Hasil Pekerjaan ini, Bahan dan Perlengkapan merupakan risiko penyedia, kecuali kerugian atau kerusakan tersebut diakibatkan oleh kesalahan atau kelalaian PPK.</td>
          </tr>
          <tr class="row36">
            <td width="3%" ></td>
            <td width="3%" >c.</td>
            <td  colspan="13">Pertanggungan asuransi yang dimiliki oleh penyedia tidak membatasi kewajiban penanggungan dalam syarat ini.</td>
          </tr>
          <tr class="row37">
            <td width="3%" ></td>
            <td width="3%" >d.</td>
            <td  colspan="13">Kehilangan atau kerusakan terhadap Hasil Pekerjaan atau Bahan yang menyatu dengan Hasil Pekerjaan selama Tanggal Mulai Kerja dan batas akhir Masa Pemeliharaan harus diganti atau diperbaiki oleh penyedia atas tanggungannya sendiri jika kehilangan atau kerusakan tersebut terjadi akibat tindakan atau kelalaian penyedia.</td>
          </tr>
          <tr class="row38">
            <td width="3%" >11.</td>
            <td  colspan="14">PENGAWASAN DAN PEMERIKSAAN</td>
          </tr>
          <tr class="row39">
            <td width="3%" ></td>
            <td  colspan="14">PPK berwenang melakukan pengawasan dan pemeriksaan terhadap pelaksanaan pekerjaan yang dilaksanakan oleh penyedia. Apabila diperlukan, PPK dapat memerintahkan kepada pihak ketiga untuk melakukan pengawasan dan pemeriksaan atas semua pelaksanaan pekerjaan yang dilaksanakan oleh penyedia.</td>
          </tr>
          <tr class="row40">
            <td width="3%" >12.</td>
            <td  colspan="14">PENGUJIAN</td>
          </tr>
          <tr class="row41">
            <td width="3%" ></td>
            <td  colspan="14">Jika PPK atau Pengawas Pekerjaan memerintahkan penyedia untuk melakukan pengujian Cacat Mutu yang tidak tercantum dalam Spesifikasi Teknis dan Gambar, dan hasil uji coba menunjukkan adanya Cacat Mutu maka penyedia berkewajiban untuk menanggung biaya pengujian tersebut. Jika tidak ditemukan adanya Cacat Mutu maka uji coba tersebut dianggap sebagai Peristiwa Kompensasi.</td>
          </tr>
          <tr class="row42">
            <td width="3%" >13.</td>
            <td  colspan="14">LAPORAN HASIL PEKERJAAN</td>
          </tr>
          <tr class="row43">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">Pemeriksaan pekerjaan dilakukan selama pelaksanaan SPK untuk menetapkan volume pekerjaan atau kegiatan yang telah dilaksanakan guna pembayaran hasil pekerjaan. Hasil pemeriksaan pekerjaan dituangkan dalam laporan kemajuan hasil pekerjaan.</td>
          </tr>
          <tr class="row44">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Untuk merekam kegiatan pelaksanaan kegiatan, PPK dapat menugaskan Pejabat Penerima Hasil Pekerjaan membuat foto-foto dokumentasi pelaksanaan pekerjaan di lokasi pekerjaan.</td>
          </tr>
          <tr class="row45">
            <td width="3%" >14.</td>
            <td  colspan="14">WAKTU PENYELESAIAN PEKERJAAN</td>
          </tr>
          <tr class="row46">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">Kecuali SPK diputuskan lebih awal, penyedia berkewajiban untuk memulai pelaksanaan pekerjaan pada Tanggal Mulai Kerja, dan melaksanakan pekerjaan sesuai dengan program mutu, serta menyelesaikan pekerjaan selambat-lambatnya pada Tanggal Penyelesaian yang ditetapkan dalam SP.</td>
          </tr>
          <tr class="row47">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Jika pekerjaan tidak selesai pada Tanggal Penyelesaian bukan akibat Keadaan Kahar atau Peristiwa Kompensasi atau karena kesalahan atau kelalaian penyedia maka penyedia dikenakan denda.</td>
          </tr>
          <tr class="row48">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">Jika keterlambatan tersebut semata-mata disebabkan oleh Peristiwa Kompensasi maka PPK dikenakan kewajiban pembayaran ganti rugi. Denda atau ganti rugi tidak dikenakan jika Tanggal Penyelesaian disepakati oleh Para Pihak untuk diperpanjang.</td>
          </tr>
          <tr class="row49">
            <td width="3%" ></td>
            <td width="3%"  valign="top">d.</td>
            <td  colspan="13">Tanggal Penyelesaian yang dimaksud dalam ketentuan ini adalah tanggal penyelesaian semua pekerjaan.</td>
          </tr>
          <tr class="row50">
            <td width="3%" >15.</td>
            <td  colspan="14">SERAH TERIMA PEKERJAAN</td>
          </tr>
          <tr class="row51">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">Setelah pekerjaan selesai 100% (seratus perseratus), penyedia mengajukan permintaan secara tertulis kepada PPK untuk penyerahan pekerjaan.</td>
          </tr>
          <tr >
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Dalam rangka penilaian hasil pekerjaan, PPK menugaskan Pejabat Penerima Hasil Pekerjaan.</td>
          </tr>
          <tr class="row53">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">Pejabat Penerima Hasil Pekerjaan melakukan penilaian terhadap hasil pekerjaan yang telah diselesaikan oleh penyedia. Apabila terdapat kekurangan-kekurangan dan/atau cacat hasil pekerjaan, penyedia wajib memperbaiki/menyelesaikannya, atas perintah PPK.</td>
          </tr>
          <tr class="row54">
            <td width="3%" ></td>
            <td width="3%"  valign="top">d.</td>
            <td  colspan="13">PPK menerima penyerahan pertama pekerjaan setelah seluruh hasil pekerjaan dilaksanakan sesuai dengan ketentuan SPK dan diterima oleh Pejabat Penerima Hasil Pekerjaan.</td>
          </tr>
          <tr class="row55">
            <td width="3%" ></td>
            <td width="3%"  valign="top">e.</td>
            <td  colspan="13">Pembayaran dilakukan sebesar 100% (seratus perseratus) dari harga SPK dan penyedia harus menyerahkan Sertifikat Garansi sebesar 5% (lima perseratus) dari harga SPK.</td>
          </tr>
          <tr class="row56">
            <td width="3%" >16. </td>
            <td  colspan="14">JAMINAN BEBAS CACAT MUTU/GARANSI</td>
          </tr>
          <tr class="row57">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">Penyedia dengan jaminan pabrikan dari produsen pabrikan (jika ada) berkewajiban untuk menjamin bahwa selama penggunaan secara wajar oleh PPK, Barang tidak mengandung cacat mutu yang disebabkan oleh tindakan atau kelalaian Penyedia, atau cacat mutu akibat desain, bahan, dan cara kerja.</td>
          </tr>
          <tr class="row58">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Jaminan bebas cacat mutu ini berlaku sampai dengan 12 (dua belas) bulan setelah serah terima Barang.</td>
          </tr>
          <tr class="row59">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">PPK akan menyampaikan pemberitahuan cacat mutu kepada Penyedia segera setelah ditemukan cacat mutu tersebut selama Masa Layanan Purnajual.</td>
          </tr>
          <tr class="row60">
            <td width="3%" ></td>
            <td width="3%"  valign="top">d.</td>
            <td  colspan="13">Terhadap pemberitahuan cacat mutu oleh PPK, Penyedia berkewajiban untuk memperbaiki atau mengganti Barang dalam jangka waktu yang ditetapkan dalam pemberitahuan tersebut.</td>
          </tr>
          <tr class="row61">
            <td width="3%" ></td>
            <td width="3%" >e.</td>
            <td  colspan="13">Jika Penyedia tidak memperbaiki atau mengganti Barang akibat cacat mutu dalam jangka waktu yang ditentukan maka PPK akan menghitung biaya perbaikan yang diperlukan, dan PPK secara langsung atau melalui pihak ketiga yang ditunjuk oleh PPK akan melakukan perbaikan tersebut. Penyedia berkewajiban untuk membayar biaya perbaikan atau penggantian tersebut sesuai dengan klaim yang diajukan secara tertulis oleh PPK. Biaya tersebut dapat dipotong oleh PPK dari nilai tagihan Penyedia. </td>
          </tr>
          <tr class="row62">
            <td width="3%" ></td>
            <td width="3%" >f.</td>
            <td  colspan="13">Terlepas dari kewajiban penggantian biaya,  PPK dapat memasukkan Penyedia yang lalai memperbaiki cacat mutu ke dalam daftar hitam.</td>
          </tr>
          <tr class="row63">
            <td width="3%" >17.</td>
            <td  colspan="14">PERUBAHAN SPK</td>
          </tr>
          <tr class="row64">
            <td width="3%" ></td>
            <td width="3%" >a.</td>
            <td  colspan="13">SPK hanya dapat diubah melalui adendum SPK</td>
          </tr>
          <tr class="row65">
            <td width="3%" ></td>
            <td width="3%" >b.</td>
            <td  colspan="13">Perubahan SPK bisa dilaksanakan apabila disetujui oleh para pihak, meliputi:</td>
          </tr>
          <tr class="row66">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >1)</td>
            <td  colspan="12">perubahan pekerjaan disebabkan oleh sesuatu hal yang dilakukan oleh para pihak dalam SPK sehingga mengubah lingkup pekerjaan dalam SPK;</td>
          </tr>
          <tr class="row67">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >2)</td>
            <td  colspan="12">perubahan jadwal pelaksanaan pekerjaan akibat adanya perubahan pekerjaan; </td>
          </tr>
          <tr class="row68">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >3)</td>
            <td  colspan="12">perubahan harga SPK akibat adanya perubahan pekerjaan dan/atau perubahan pelaksanaan pekerjaan.</td>
          </tr>
          <tr class="row69">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">Untuk kepentingan perubahan SPK, PA/KPA dapat membentuk Pejabat Peneliti Pelaksanaan Kontrak atas usul PPK.</td>
          </tr>
          <tr class="row70">
            <td width="3%" >18.</td>
            <td  colspan="14">PERISTIWA KOMPENSASI</td>
          </tr>
          <tr class="row71">
            <td width="3%" ></td>
            <td width="3%" >a.</td>
            <td  colspan="13">Peristiwa Kompensasi dapat diberikan kepada penyedia dalam hal sebagai berikut:</td>
          </tr>
          <tr class="row72">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >1)</td>
            <td  colspan="12">PPK mengubah jadwal yang dapat mempengaruhi pelaksanaan pekerjaan;</td>
          </tr>
          <tr class="row73">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >2)</td>
            <td  colspan="12">keterlambatan pembayaran kepada penyedia;  </td>
          </tr>
          <tr class="row74">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >3)</td>
            <td  colspan="12">PPK tidak memberikan gambar-gambar, spesifikasi dan/atau instruksi sesuai jadwal yang dibutuhkan;</td>
          </tr>
          <tr class="row75">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >4)</td>
            <td  colspan="12">penyedia belum bisa masuk ke lokasi sesuai jadwal;</td>
          </tr>
          <tr class="row76">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >5)</td>
            <td  colspan="12">PPK menginstruksikan kepada pihak penyedia untuk melakukan pengujian tambahan yang setelah dilaksanakan pengujian ternyata tidak ditemukan kerusakan/kegagalan/penyimpangan;</td>
          </tr>
          <tr class="row77">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >6)</td>
            <td  colspan="12">PPK memerintahkan penundaan pelaksanaan pekerjaan;</td>
          </tr>
          <tr class="row78">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >7)</td>
            <td  colspan="12">PPK memerintahkan untuk mengatasi kondisi tertentu yang tidak dapat diduga sebelumnya dan disebabkan oleh PPK;</td>
          </tr>
          <tr class="row79">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%" >8)</td>
            <td  colspan="12">ketentuan lain dalam SPK.</td>
          </tr>
          <tr class="row80">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Jika Peristiwa Kompensasi mengakibatkan pengeluaran tambahan dan/atau keterlambatan penyelesaian pekerjaan maka PPK berkewajiban untuk membayar ganti rugi dan/atau memberikan perpanjangan waktu penyelesaian pekerjaan.</td>
          </tr>
          <tr class="row81">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">Ganti rugi hanya dapat dibayarkan jika berdasarkan data penunjang dan perhitungan kompensasi yang diajukan oleh penyedia kepada PPK, dapat dibuktikan kerugian nyata akibat Peristiwa Kompensasi.</td>
          </tr>
          <tr class="row82">
            <td width="3%" ></td>
            <td width="3%"  valign="top">d.</td>
            <td  colspan="13">Perpanjangan waktu penyelesaian pekerjaan hanya dapat diberikan jika berdasarkan data penunjang dan perhitungan kompensasi yang diajukan oleh penyedia kepada PPK, dapat dibuktikan perlunya tambahan waktu akibat Peristiwa Kompensasi.</td>
          </tr>
          <tr class="row83">
            <td width="3%" ></td>
            <td width="3%"  valign="top">e.</td>
            <td  colspan="13">Penyedia tidak berhak atas ganti rugi dan/atau perpanjangan waktu penyelesaian pekerjaan jika penyedia gagal atau lalai untuk memberikan peringatan dini dalam mengantisipasi atau mengatasi dampak Peristiwa Kompensasi.</td>
          </tr>
          <tr class="row84">
            <td width="3%" >19.</td>
            <td  colspan="14">PERPANJANGAN WAKTU</td>
          </tr>
          <tr class="row85">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">jika terjadi Peristiwa Kompensasi sehingga penyelesaian pekerjaan akan melampaui Tanggal Penyelesaian maka penyedia berhak untuk meminta perpanjangan Tanggal Penyelesaian berdasarkan data penunjang. PPK berdasarkan pertimbangan Pengawas Pekerjaan memperpanjang Tanggal Penyelesaian Pekerjaan secara tertulis. Perpanjangan Tanggal Penyelesaian harus dilakukan melalui adendum SPK jika perpanjangan tersebut mengubah Masa SPK.</td>
          </tr>
          <tr class="row86">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">PPK dapat menyetujui perpanjangan waktu pelaksanaan setelah melakukan penelitian terhadap usulan tertulis yang diajukan oleh penyedia.</td>
          </tr>
          <tr class="row87">
            <td width="3%" >20.</td>
            <td  colspan="14">PENGHENTIAN DAN PEMUTUSAN SPK</td>
          </tr>
          <tr class="row88">
            <td width="3%" ></td>
            <td width="3%"  valign="top">a.</td>
            <td  colspan="13">Penghentian SPK dapat dilakukan karena pekerjaan sudah selesai atau terjadi Keadaan Kahar.</td>
          </tr>
          <tr class="row89">
            <td width="3%" ></td>
            <td width="3%"  valign="top">b.</td>
            <td  colspan="13">Dalam hal SPK dihentikan, maka PPK wajib membayar kepada penyedia sesuai dengan prestasi pekerjaan yang telah dicapai, termasuk:</td>
          </tr>
          <tr class="row90">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">1)</td>
            <td  colspan="12">biaya langsung pengadaan bahan dan perlengkapan untuk pekerjaan ini. Bahan dan perlengkapan ini harus diserahkan oleh Penyedia kepada PPK, dan selanjutnya menjadi hak milik PPK;</td>
          </tr>
          <tr class="row91">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">2)</td>
            <td  colspan="12">biaya langsung pembongkaran dan demobilisasi hasil pekerjaan sementara dan peralatan; </td>
          </tr>
          <tr class="row92">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">3)</td>
            <td  colspan="12">biaya langsung demobilisasi personil.</td>
          </tr>
          <tr class="row93">
            <td width="3%" ></td>
            <td width="3%"  valign="top">c.</td>
            <td  colspan="13">Pemutusan SPK dapat dilakukan oleh pihak penyedia atau pihak PPK.</td>
          </tr>
          <tr class="row94">
            <td width="3%" ></td>
            <td width="3%"  valign="top">d.</td>
            <td  colspan="13">Menyimpang dari Pasal 1266 dan 1267 Kitab Undang-Undang Hukum  erdata, pemutusan SPK melalui pemberitahuan tertulis dapat dilakukan apabila:</td>
          </tr>
          <tr class="row95">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">1)</td>
            <td  colspan="12">penyedia lalai/cidera janji dalam melaksanakan kewajibannya dan tidak memperbaiki kelalaiannya dalam jangka waktu yang telah ditetapkan;</td>
          </tr>
          <tr class="row96">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">2)</td>
            <td  colspan="12">penyedia tanpa persetujuan Pengawas Pekerjaan, tidak memulai pelaksanaan pekerjaan;</td>
          </tr>
          <tr class="row97">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">3)</td>
            <td  colspan="12">penyedia menghentikan pekerjaan selama 28 (dua puluh delapan) hari dan penghentian ini tidak tercantum dalam program mutu serta tanpa persetujuan Pengawas Pekerjaan;</td>
          </tr>
          <tr class="row98">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">4)</td>
            <td  colspan="12">penyedia berada dalam keadaan pailit;</td>
          </tr>
          <tr class="row99">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">5)</td>
            <td  colspan="12">penyedia selama Masa SPK gagal memperbaiki Cacat Mutu dalam jangka waktu yang ditetapkan oleh PPK;</td>
          </tr>
          <tr class="row100">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">6)</td>
            <td  colspan="12">denda keterlambatan pelaksanaan pekerjaan akibat kesalahan penyedia sudah melampaui 5% (lima perseratus) dari harga SPK dan PPK menilai bahwa Penyedia tidak akan sanggup menyelesaikan sisa pekerjaan;</td>
          </tr>
          <tr class="row101">
            <td width="3%" ></td>
            <td width="3%"  valign="top">e.</td>
            <td  colspan="13">Dalam hal pemutusan SPK dilakukan karena kesalahan penyedia:</td>
          </tr>
          <tr class="row102">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">1)</td>
            <td  colspan="12">penyedia membayar denda; dan/atau</td>
          </tr>
          <tr class="row103">
            <td width="3%" ></td>
            <td width="3%" ></td>
            <td width="3%"  valign="top">2)</td>
            <td  colspan="12">penyedia dimasukkan dalam Daftar Hitam.</td>
          </tr>
          <tr class="row104">
            <td width="3%" ></td>
            <td width="3%"  valign="top">f.</td>
            <td  colspan="13">Dalam hal pemutusan SPK dilakukan karena PPK terlibat penyimpangan prosedur, melakukan KKN dan/atau pelanggaran persaingan sehat dalam pelaksanaan pengadaan, maka PPK dikenakan sanksi berdasarkan peraturan perundang-undangan.</td>
          </tr>
          <tr>
<td width="3%">21.</td>
            <td colspan="14">PEMBAYARAN</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%">a.</td>
            <td colspan="13">pembayaran prestasi hasil pekerjaan yang disepakati dilakukan oleh PPK, dengan ketentuan:</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%"></td>
            <td width="3%">1)</td>
            <td colspan="12">penyedia telah mengajukan tagihan disertai laporan kemajuan hasil pekerjaan;</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%"></td>
            <td width="3%">2)</td>
            <td colspan="12">pembayaran dilakukan dengan [sistem bulanan/sistem termin/pembayaran secara sekaligus];</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%"></td>
            <td width="3%">3)</td>
            <td colspan="12">pembayaran harus dipotong denda (apabila ada), dan pajak ;</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%">b.</td>
            <td colspan="13">pembayaran terakhir hanya dilakukan setelah pekerjaan selesai 100%  seratus perseratus) dan Berita Acara penyerahan pekerjaan diterbitkan.</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%">c.</td>
            <td colspan="13">PPK dalam kurun waktu 7 (tujuh) hari kerja setelah pengajuan permintaan pembayaran dari penyedia harus sudah mengajukan surat permintaan pembayaran kepada Pejabat Penandatangan Surat Perintah Membayar (PPSPM).</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td width="3%">d.</td>
            <td colspan="13">bila terdapat ketidaksesuaian dalam perhitungan angsuran, tidak akan menjadi alasan untuk menunda pembayaran. PPK dapat meminta penyedia untuk menyampaikan perhitungan prestasi sementara dengan mengesampingkan hal-hal yang sedang menjadi perselisihan.</td>
          </tr>
          <tr>
            <td width="3%">22.</td>
            <td colspan="14">DENDA</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td colspan="14">Penyedia berkewajiban untuk membayar sanksi finansial berupa Denda sebagai akibat wanprestasi atau cidera janji terhadap kewajiban-kewajiban penyedia dalam SPK ini. PPK mengenakan Denda dengan memotong angsuran pembayaran prestasi pekerjaan penyedia. Pembayaran Denda tidak mengurangi tanggung jawab kontraktual penyedia.</td>
          </tr>
          <tr>
            <td width="3%">23.</td>
            <td colspan="14">PENYELESAIAN PERSELISIHAN</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td colspan="14">PPK dan penyedia berkewajiban untuk berupaya sungguh-sungguh menyelesaikan secara damai semua perselisihan yang timbul dari atau berhubungan dengan SPK ini atau interpretasinya selama atau setelah pelaksanaan pekerjaan.  Jika perselisihan tidak dapat diselesaikan secara musyawarah maka perselisihan akan diselesaikan melalui pengadilan negeri dalam wilayah hukum Republik Indonesia.</td>
          </tr>
          <tr>
            <td width="3%">24.</td>
            <td colspan="14">LARANGAN PEMBERIAN KOMISI</td>
          </tr>
          <tr>
            <td width="3%"></td>
            <td colspan="14">Penyedia menjamin bahwa tidak satu pun personil satuan kerja PPK telah atau akan menerima komisi atau keuntungan tidak sah lainnya baik langsung maupun tidak langsung dari SPK ini. Penyedia menyetujui bahwa pelanggaran syarat ini merupakan pelanggaran yang mendasar terhadap SPK ini.</td>
          </tr>
        </tbody>
    </table>

</div>
	



	
	
</body>
</html>
<?php
 $html = ob_get_clean();
require_once("../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$paper_size = array(0,0, 8.26 * 72, 11.69 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('laporanpengeluaran.pdf',array('Attachment' => 0));
?>
