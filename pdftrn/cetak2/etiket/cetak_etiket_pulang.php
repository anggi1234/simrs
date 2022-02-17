<?php session_start();
include 'connect.php';
$ID_DETAIL_PENJUALAN  = $_GET['ID_DETAIL_PENJUALAN'];
?>

<?php
function datetimes($tgl,$Jam=true){
$tanggal = strtotime($tgl);
$bln_array = array (
      '01'=>'Januari',
      '02'=>'Februari',
      '03'=>'Maret',
      '04'=>'April',
      '05'=>'Mei',
      '06'=>'Juni',
      '07'=>'Juli',
      '08'=>'Agustus',
      '09'=>'September',
      '10'=>'Oktober',
      '11'=>'November',
      '12'=>'Desember'
      );
$hari_arr = Array ('0'=>'Minggu',
           '1'=>'Senin',
           '2'=>'Selasa',
          '3'=>'Rabu',
          '4'=>'Kamis',
          '5'=>'Jum`at',
          '6'=>'Sabtu'
           );
$hari = @$hari_arr[date('w',$tanggal)];
$tggl = date('j',$tanggal);
$bln = @$bln_array[date('m',$tanggal)];
$thn = date('Y',$tanggal);
$jam = $Jam ? date ('H:i:s',$tanggal) : '';
return "$tggl $bln $thn";     
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cetak E-Tiket</title>
<style>
table {
  color: #000;
        font-size: 9px;
        margin: 5px;
        font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
        font-size: 9px;
  }

.tanggal {

}


</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<?php

$sql2 = "Select g.nama as POLI,d.NOMR,date_format(a.TANGGAL, '%d/%m/%y') as TANGGAL , e.NAMA, e.TGLLAHIR, c.NAMA_BARANG,f.aturan,a.QTY from z_detail_penjualan_rajal a 
LEFT OUTER JOIN z_detail_barang b ON a.ID_DETAIL_BARANG=b.ID_DETAIL_BARANG
LEFT OUTER JOIN z_barang c ON b.ID_BARANG=c.ID_BARANG
LEFT OUTER JOIN t_pendaftaran d ON a.IDXDAFTAR=d.IDXDAFTAR
LEFT OUTER JOIN m_pasien e ON d.NOMR=e.NOMR
LEFT OUTER JOIN z_aturan f on a.id_aturan=f.id_aturan
LEFT OUTER JOIN m_poly g on d.KDPOLY=g.kode
where a.ID_DETAIL_PENJUALAN=$ID_DETAIL_PENJUALAN";
$sql3 = mysql_query($sql2);
$data = mysql_fetch_array($sql3);

?>
<br><br>
<table border="0" width="200">
  <tr>
    <td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">NOMR</td><td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">: <?php echo $data['NOMR']; ?></td>
  </tr>
  <tr>    
    <td colspan="2" align="center" style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    "><?php echo $data['NAMA']; ?></td>
  </tr>
  <tr>
    <td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">Tgl Lahir</td><td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">: <?php echo $data['TGLLAHIR']; ?></td>
  </tr>
  <tr>
    <td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">Poli</td>
    <td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">: <?php echo $data['POLI']; ?></td>
  </tr>
  <tr>  
    <td colspan="2" align="center" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 25px;
  letter-spacing: 2px;
  font-weight: bold;
    ">
    <hr>
    <?php echo $data['NAMA_BARANG']; ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 10px 0px;
  font-size: 16px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    "><?php echo $data['aturan']; ?></td>
  </tr>
  <tr>
    <td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    "><?php echo date("d-M-Y") ?></td>
    <td style="
  font-family: times, Times New Roman, times-roman, georgia, serif;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0px;
  font-weight: bold;
    ">Jumlah : <?php echo $data['QTY']; ?></td>
  </tr>
   
</table>
</body>
</html>