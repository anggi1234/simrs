  <link rel="stylesheet" href="../../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Riwayat Kunjungan</title>
</head>

<body>

<?php
	
ob_start();
session_start();
include('../connect.php');	
$nomr= $_GET['nomr'];
$sqlitemkasir="SELECT
	a.nomr,
	b.nama,
	date_format( a.tglreg, '%d-%m-%Y' ) AS tglreg,
	f.nama AS poli,
	e.NAMADOKTER AS dpjp 
FROM
	simrs2012.t_pendaftaran a
	LEFT JOIN simrs2012.m_pasien b ON a.nomr = b.nomr
	LEFT JOIN simrs2012.m_dokter e ON a.KDDOKTER = e.KDDOKTER
	LEFT JOIN simrs2012.m_poly f ON a.KDPOLY = f.kode 
WHERE
	a.nomr = $nomr 
ORDER BY
	a.idxdaftar DESC";
 $queryitemkasir = mysql_query($sqlitemkasir);

?>

		<div class="box box-info">
			<div class="box-header">
			  <h3 class="box-title">Data Riwayat Kunjungan Pasien</h3>
			</div>
			<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr>
				  <th>No.</th>
				  <th>NO.RM</th>
				  <th>Nama Pasien</th>
				  <th>Tgl Reg</th>
				  <th>Poli</th>
				  <th>DPJP</th>
				</tr>
				</thead>
				<tbody>
<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemkasir)){
			echo '<tr>';
	echo '<td>'.$no.'</td>';
	echo '<td>'.$data['nomr'].'</td>';
	echo '<td>'.$data['nama'].'</td>';
	echo '<td>'.$data['tglreg'].'</td>';
			echo '<td>'.$data['poli'].'</td>';
			echo '<td>'.$data['dpjp'].'</td>';
			echo '</tr>';
			$no++;
		}
	
	?>
				</tbody>
				<tfoot>
				<tr>
				  <th>No.</th>
				  <th>NO.RM</th>
				  <th>Nama Pasien</th>
				  <th>Tgl Reg</th>
				  <th>Poli</th>
				  <th>DPJP</th>
				</tr>
				</tfoot>
			  </table>
			</div>
			<!-- /.box-body -->
		  </div>


</body>
</html>


<script src="../../adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../../adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>
<script src="../../adminlte/dist/js/demo.js"></script>
		  
		  
<script>
  $(function () {
	$('#example1').DataTable()
	$('#example2').DataTable({
	  'paging'      : true,
	  'lengthChange': false,
	  'searching'   : false,
	  'ordering'    : true,
	  'info'        : true,
	  'autoWidth'   : false
	})
  })
</script>		