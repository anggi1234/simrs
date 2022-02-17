<link rel="stylesheet" href="../../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../../adminlte/bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="../../adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="../../adminlte/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="../../adminlte/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<?php
include('../connect.php');	
$id_bill_detail_tarif= $_GET['id_bill_detail_tarif'];

?>


			<div class="box-body">
			  <table id="simrslab" class="table table-bordered table-striped">
				<thead>
				<tr>
				  <th>TGL REG</th>
				  <th>JAM ENTRI LAB</th>
				  <th>CARA BAYAR</th>
				  <th>POLI PENGIRIM</th>
				  <th>CETAK</th>
				</tr>
				</thead>
				<tbody>
<?php


$sqlitemkontrol="SELECT 
    b.tglreg, a.tanggal_input, c.nama, d.userlevelname, a.id_bill_detail_tarif_detail
FROM
    simrs.bill_detail_tarif_detail a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.id_bill_detail_tarif = b.id_bill_detail_tarif
        LEFT JOIN
    simrs2012.m_carabayar c ON b.kdcarabayar = c.kode
        LEFT JOIN
    simrs.userlevels d ON a.userlevelid_asal = d.userlevelid
WHERE
    a.userlevelid = 16 AND a.id_bill_detail_tarif = $id_bill_detail_tarif";
 $queryitemkontrol = mysql_query($sqlitemkontrol);


	if(mysql_num_rows($queryitemkontrol)==0){
		echo '<tr><td colspan="9">Data Tidak Ada</td></tr>';
	}
	else{
		while($data1=mysql_fetch_assoc($queryitemkontrol)){
			echo '<tr>';
	  echo '<td>'.$data1['tglreg'].'</td>';
	  echo '<td>'.$data1['tanggal_input'].'</td>';
	  echo '<td>'.$data1['nama'].'</td>';
	  echo '<td>'.$data1['userlevelname'].'</td>';
	  echo "<td><a class=\"btn btn-block bg-teal btn-xs\" href=\"expertise_laboratorium_semua.php?id_bill_detail_tarif_detail=" . $data1['id_bill_detail_tarif_detail'] . "\">Lihat Expertise Lab</a></td>";
			echo '</tr>';
		}
	}
 ?>
				</tbody>

			  </table>
			</div>
			
			
<script src="../../adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../../adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>
<script src="../../adminlte/dist/js/demo.js"></script>
<script src="../../adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../../adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../../adminlte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="../../adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>
			