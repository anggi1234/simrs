<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Riwayat Pembelian</title>
  <link rel="stylesheet" href="../../adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../../adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body>

<?php
include('../connect.php');	
$id_master_obat_detail= $_GET['id_master_obat_detail'];
$sqlitemkasir="SELECT 
    DATE_FORMAT(b.tanggal, '%d-%m-%Y') AS tanggal,
    userlevelname as unit,
    a.qty_masuk as qty,
    a.harga_beli
FROM
    simrs.bill_detail_pengambilan_obat a
        LEFT JOIN
    simrs.bill_pengambilan_obat b ON a.id_bill_pengambilan_obat = b.id_bill_pengambilan_obat
        LEFT JOIN
    userlevels c ON b.userlevelid = c.userlevelid
WHERE
    a.id_master_obat_detail = $id_master_obat_detail";
 $queryitemkasir = mysql_query($sqlitemkasir);

?>

 				<a href="../../bill_pengambilan_obatadd.php?showdetail=bill_detail_pengambilan_obat" class="btn btn-block btn-social btn-bitbucket">
                <i class="fa fa-plus-square-o"></i> Tambah Pengambilan
              </a>
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title">Data Riwayat Pengambilan</h3>
			</div>
			<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr>
				  <th>No.</th>
				  <th>Tanggal Beli</th>
				  <th>Nama Unit</th>
				  <th>Jumlah</th>
				  <th>Harga Obat</th>
				</tr>
				</thead>
				<tbody>
<?php
		$no=1;
		while($data=mysql_fetch_assoc($queryitemkasir)){
			echo '<tr>';
	echo '<td>'.$no.'</td>';
	echo '<td>'.$data['tanggal'].'</td>';
	echo '<td>'.$data['unit'].'</td>';
	echo '<td>'.$data['qty'].'</td>';
	echo '<td align="right">'.number_format($data['harga_beli'], 2,",",".").'</td>';
			echo '</tr>';
			$no++;
		}
	
	?>
				</tbody>
				<tfoot>
				<tr>
				  <th>No.</th>
				  <th>Tanggal Beli</th>
				  <th>Nama Supplier</th>
				  <th>Jumlah</th>
				  <th>Harga Beli</th>
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