<?php
ob_start();
include('../connect.php');

function hari_indo($tanggal, $cetak_hari = false)
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
			return $hari[$num];
		}
		return $tgl_indo;
	}

// $tanggal = "2020-10-06";
$tanggal = $_POST['date'];
$sqlitem="SELECT
  (
  SELECT
    GROUP_CONCAT( IFNULL( z.keterangan, '' ) SEPARATOR ', ' ) AS diagnosa 
  FROM
    simrs.bill_detail_penyakit z 
  WHERE
    z.id_bill_detail_tarif = a.id_bill_detail_tarif 
  GROUP BY
    z.id_bill_detail_tarif 
  ) AS diagnosa,
  b.id_bill_detail_tarif,
  a.ok AS OK,
  c.NAMA,
  b.nomr,
  e.NAMA AS penjamin,
  c.TGLLAHIR AS tgllahir,
  c.JENISKELAMIN AS jk,
  b.kelas,
CASE
    
    WHEN f.id_instalasi = '1' THEN
    d.NAMADOKTER ELSE (
    SELECT
      ee.NAMADOKTER 
    FROM
      bill_detail_tarif aa
      LEFT JOIN simrs2012.m_dokter ee ON ee.KDDOKTER = aa.kddokter 
    WHERE
      aa.idxdaftar = a.idxdaftar 
      AND aa.userlevelid = '40' 
    ) 
  END AS DOKTER,
  f.userlevelname AS ruang,
  SUBSTR( a.jam_mulai, 1, 10 ) AS TANGGAL_OP,
  SUBSTR( a.jam_mulai, 11, 14 ) AS JAM_OP,
  a.lensa AS lensa,
  a.rencana_tindakan AS op_rencana_tindakan,
  a.jenis_anastesi AS op_janastesi,
  h.jenis_tindakan AS op_ja,
CASE
    
    WHEN b.op_terlaksana = '0' THEN
    'Belum OP' 
    WHEN b.op_terlaksana = '1' THEN
    'Sudah OP' ELSE 'Batal' 
  END AS status_op 
FROM
  simrs.bill_order_ibs a
  LEFT JOIN simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
  LEFT JOIN simrs2012.m_pasien c ON c.NOMR = b.nomr
  LEFT JOIN simrs2012.m_dokter d ON d.kddokter = b.kddokter
  LEFT JOIN simrs2012.m_carabayar e ON e.KODE = b.kdcarabayar
  LEFT JOIN simrs.userlevels f ON f.userlevelid = b.userlevelid
  LEFT JOIN simrs.master_ruang_op g ON g.nama_ruang = a.ok
  LEFT JOIN simrs.l_jenis_tindakan_operasi h ON h.id_jenis_tindakan_operasi = a.id_jenis_operasi 
WHERE
  SUBSTR( a.jam_mulai, 1, 10 ) = '".$tanggal."' 
ORDER BY
  a.ok ASC,
  a.jam_mulai ASC";

$queryitem = mysql_query($sqlitem);

// print_r($sqlitem);
// die();

?>



<html>
<head>
<meta charset="utf-8">
<title>JADWAL Operasi</title>
<style type="text/css">
  @page {
            margin-top: 0.5 cm;
            margin-left: 0.5 cm;
      margin-right: 0.5 cm;
      margin-bottom: 0.5 cm;
    font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
  }
  
.tabel {
  border-collapse: collapse;
  font-size: 8px;
  text-align: right;
}  
  
.header {
  font-size: 12px;
} 
.footer {
  font-size: 8px;
}

.pagebreak { 
    page-break-before: always;
  }

</style>
</head>

<body>
  <table width="100%" style="border:0;" cellpadding="0">
    <tbody>
      <tr>
        <td width="100%" align="center"><span class="header"><strong><b>JADWAL OPERASI
        <br>TANGGAL <?php echo $tanggal ?>
        <br>RSUD AJIBARANG
        </b></strong></span></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td style="text-align:left;" vtext-align="top"></td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>

<table width="100%" cellspacing="0" border="1" class="tabel">
  <tbody>
    <tr>
      <td>NO</td>
          <td  align="center">OK</td>
          <td  align="center">JAM MULAI</td>
          <td  align="center">NAMA</td>
          <td  align="center">NOMR</td>
          <td  align="center">PENJAMIN</td>
          <td  align="center">TGLLAHIR</td>
          <td  align="center">JK</td>
          <td  align="center">RUANG</td>
          <td  align="center">KELAS</td>
          <td  align="center">DIAGNOSA</td>
          <td  align="center">R.TINDAKAN</td>
          <td  align="center">LENSA</td>
          <td  align="center">J.ANASTESI</td>
          <td  align="center">DOKTER</td>
          <td  align="center">STATUS OP</td>
    </tr>
    <?php

      while($data=mysql_fetch_assoc($queryitem)){
        @$no++;
        echo '<tr>';
        echo '<td align="center">'.$no.'</td>';
        echo '<td align="center">'.$data['OK'].'</td>';
         echo '<td align="center">'.$data['JAM_OP'].'</td>';
         echo '<td align="center">'.$data['NAMA'].'</td>';
         echo '<td align="center">'.$data['nomr'].'</td>';
         echo '<td align="center">'.$data['penjamin'].'</td>';
        echo '<td align="center">'.$data['tgllahir'].'</td>';
         echo '<td align="center">'.$data['jk'].'</td>';
         echo '<td align="center">'.$data['ruang'].'</td>';
         echo '<td align="center">'.$data['kelas'].'</td>';
         echo '<td align="center">'.$data['diagnosa'].'</td>';
         echo '<td align="center">'.$data['op_rencana_tindakan'].'</td>';
         echo '<td align="center">'.$data['lensa'].'</td>';
         echo '<td align="center">'.$data['op_janastesi'].'</td>';
        echo '<td align="center">'.$data['DOKTER'].'</td>';
         echo '<td align="center">'.$data['status_op'].'</td>';
        echo '</tr>';
        
        // $no++;
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
$paper_size = array(0,0, 8.66 * 72, 5.51 * 72);
$dompdf->set_paper($paper_size, 'portrait');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('dashboard_operasi.pdf',array('Attachment' => 0));
?>