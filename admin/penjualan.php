<?php 
session_start();
if (empty($_SESSION['username'])){
	header('location:../index.php');	
} else {
	include "../conn.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS (Point Of Sales) V 1.0</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!-- Ionicons -->
    
    <link rel="stylesheet" href="../plugins/iCheck/all.css">
    
    <link rel="stylesheet" href="../css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- css table datatables/dataTables -->
	<link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css"/>
    
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php include "header.php"; ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include "menu.php"; ?>

<?php
$timeout = 10; // Set timeout minutes
$logout_redirect_url = "../index.php"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script>alert('Session Anda Telah Habis!'); window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();
?>
<?php } ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Penjualan
            <small>Point Of Sales</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Penjualan</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">

              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Transaksi Penjualan</h3>
                  <div class="box-tools pull-right">
                  </div> 
                </div><!-- /.box-header -->
                
                <div class="box-body">
                <?php
             if(isset($_GET['hal']) == 'hapus'){
				$id = $_GET['kd'];
				$cek = mysqli_query($koneksi, "SELECT * FROM transaksi_temporary WHERE kd_produk='$id'");
				if(mysqli_num_rows($cek) == 0){
					echo "<script>window.location = 'penjualan.php'</script>";
                    //echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Data tidak ditemukan.</div>';
				}else{
					$delete = mysqli_query($koneksi, "DELETE FROM transaksi_temporary WHERE kd_produk='$id'");
					if($delete){
					echo "<script>window.location = 'penjualan.php'</script>";
                    	//echo '<div class="alert alert-primary alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Data berhasil dihapus.</div>';
					}else{
						//echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Data gagal dihapus.</div>';
					echo "<script>window.location = 'penjualan.php'</script>";
                    }
				}
			}
			?>
            
            <?php
            //input po transit dan tampil ke tabel
            if(isset($_POST['input'])){
                $tanggal = date("Y/m/d");
                $qty = $_POST['qty'];
                $kd = $_POST['kode'];
                $sql = mysqli_query($koneksi, "SELECT * FROM produk WHERE kd_produk='$kd'");
             if(mysqli_num_rows($sql) == 0){
				header("Location: penjualan.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
            
                $nama_produk = $row['nama_produk'];
                $harga_beli  = $row['harga_beli'];
                $harga_jual  = $row['harga_jual'];
                $total       = $qty * $harga_jual;
                $tot         = $qty * $harga_beli;
                $profit      = $total - $tot;
				
                
						$insert = mysqli_query($koneksi, "INSERT INTO transaksi_temporary(tanggal, kd_produk, nama_produk, harga_beli, harga_jual, qty, total, profit, session)
						                                  VALUES('$tanggal', '$kd', '$nama_produk', '$harga_beli', '$harga_jual', '$qty', '$total', '$profit', '$_SESSION[user_id]');") or die(mysqli_error());
						if($insert){
						         echo "<script>window.location = 'penjualan.php'</script>";   
                                    //}
                        }else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Ups, Data Gagal Di simpan !</div>';
						}
			}
            ?>
                <!-- <form action='admin.php' method="POST">
          
	       <input type='text' class="form-control" style="margin-bottom: 4px;" name='qcari' placeholder='Cari berdasarkan User ID dan Username' required /> 
           <input type='submit' value='Cari Data' class="btn btn-sm btn-primary" /> <a href='admin.php' class="btn btn-sm btn-success" >Refresh</i></a>
          	</div>
            </form>-->
            <form id="form1" name="foem1" method="post" action="">
            <div class="col-md-6">
                  <div class="form-group">
                    <label></label>
                    <select class="form-control select2" name="kode" id="kode" style="width: 100%;">
                    <option value="">----- Pilih Produk -----</option>
                       <?php
                    $query1="select * from produk order by kd_produk";
                    $tampil=mysqli_query($koneksi, $query1) or die(mysqli_error());
                    while($data=mysqli_fetch_array($tampil))
                    {
                    ?>
                              
                                  
							
							<option value="<?php echo $data['kd_produk'];?>"><?php echo $data['kd_produk']; ?> - <?php echo $data['nama_produk'];?> - <?php echo $data['kategori']; ?></option>
						    <?php } ?>
                    </select>
                  </div><!-- /.form-group -->
                  </div>
                  <div class="col-md-1">
                  <div class="form-group">
                    <label></label>
                    <input type="text" class="form-control" name="qty" id="qty" autocomplete="off" required="required"/>
                  </div><!-- /.form-group -->
                  </div>
                  <div class="col-md-1">
                  <div class="form-group">
                    <label></label>
                    <input type="submit" class="btn btn btn-primary" name="input" id="input" value="Tambah" autocomplete="off" required="required"/>
                  </div><!-- /.form-group -->
                  </div>
            </form>
          
          
            
            <form id="formku" name="formku" method="post">
		 
            <br />
            <?php
                    $query1="select * from transaksi_temporary";
                    
                    $tampil=mysqli_query($koneksi, $query1) or die(mysqli_error());
                    ?>
		<table name="table1" class="table table-hover table-bordered" id="table1">  
			<thead bgcolor="eeeeee" align="center">
            <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Produk</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Profit</th>
            <th>Remove</th><tr>
			</thead>
            <?php 
                     $no=0;
                     while($data=mysqli_fetch_array($tampil))
                    { $no++; ?>
                    <tbody>
                    <tr>
                    <td><center><?php echo $no; ?></center></td>
                    <td><center><?php echo $data['tanggal'];?></center></td>
                    <td><center><?php echo $data['kd_produk'];?></center></td>
                    <td><center><?php echo $data['nama_produk'];?></center></td>
                    <td><center>Rp. <?php echo number_format($data['harga_beli'],0,",",".");?></center></td>
                    <td><center>Rp. <?php echo number_format($data['harga_jual'],0,",",".");?></center></td>
                    <td><center><?php echo $data['qty'];?></center></td>
                    <td><center>Rp. <?php echo number_format($data['total'],0,",",".");?></center></td>
                    <td><center>Rp. <?php echo number_format($data['profit'],0,",",".");?></center></td>
                    <td><center><div id="thanks"><a class="btn btn-sm btn-danger tooltips" data-placement="bottom" data-toggle="tooltip" title="Hapus List" href="penjualan.php?hal=hapus&kd=<?php echo $data['kd_produk'];?>"><span class="glyphicon glyphicon-trash"></a></center></td></tr></div>
                 
                 <?php   
                 $a=$data['tanggal'];
                 $b=$data['kd_produk'];
                 $c=$data['nama_produk'];
                 $d=$data['harga_beli'];
                 $e=$data['harga_jual'];
                 $f=$data['qty'];
                 $g=$data['total'];
                 $h=$data['profit'];
  
                 
                if(isset($_POST['simpanpo'])){
				$tanggal1	 = $a;
				$kd_produk1	 = $b;
				$nama_produk1= $c;
				$harga_beli1 = $d;
				$harga_jual1 = $e;
                $qty1        = $f;
                $total1      = $g;
                $profit1     = $h;
                
        $cekno= mysqli_query($koneksi, "SELECT * FROM produk ORDER BY kd_produk DESC");
        
        
        $data1=mysqli_num_rows($cekno);
        $cekQ1=$data1;
        //$data=mysqli_fetch_array($ceknomor);
        //$cekQ=$data['f_kodepart'];
        #menghilangkan huruf
        //$awalQ=substr($cekQ,0-6);
        #ketemu angka awal(angka sebelumnya) + dengan 1
        $next1=$cekQ1+1;

        #menhitung jumlah karakter
        $kode1=strlen($next1);
        $p = "TP";
        if(!$cekQ1)
        { $no1='000001'; }
        elseif($kode1==1)
        { $no1='00000'; }
        elseif($kode1==2)
        { $n1o='0000'; }
        elseif($kode1==3)
        { $no1='000'; }
        elseif($kode1==4)
        { $no1='00'; }
        elseif($kode1==5)
        { $no1='0'; }
        elseif($kode1=6)
        { $no=''; }

        // masukkan dalam tabel penjualan
        $kode=$p.$no1.$next1;
                
				//$cek = mysqli_query($koneksi, "SELECT * FROM t_po WHERE f_pono='$pono'");
				//if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($koneksi, "INSERT INTO t_po(f_pono, f_podate, f_plantcode, f_eta, f_vendor, f_createdby, f_createdon, f_modifiedby, f_modifiedon)
						                                  VALUES('$pono1','$podate1', '$plantcode1', '$eta1', '$vendor1', '$createdby1', '$createdon1', '$modifiedby1', '$modifiedon1');") or die(mysqli_error());
						if($insert){
						            //$cek2 = mysqli_query($koneksi, "SELECT * FROM t_po_detail WHERE f_pono='$pono'");
                                    //if(mysqli_num_rows($cek2) == 0){
                                    $input = mysqli_query($koneksi, "INSERT INTO t_po_detail(f_pono, f_partcode, f_orderqty)
															VALUES('$pono1','$partcode1', '$orderqty1')") or die(mysqli_error());
                                                            
                                    $delete = mysqli_query($koneksi, "DELETE FROM t_po_transit");
					                      //}
                                          session_unset();
                                          session_destroy();
                              echo "<script>alert('PO Berhasil dimasukan!'); window.location = 'po.php'</script>";      
                                    //}
                        }else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Ups, Data Departement Gagal Di simpan !</div>';
						}
				//}else{
				//	echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No PO Sudah Ada..!</div>';
				//}
                
			} ?>
            <?php  } 
              ?>
              <thead bgcolor="eeeeee" align="center">
            <tr>
            <th colspan="6"><center>Total</center></th>
            <th>
            <?php $sql1 = mysqli_query($koneksi, "SELECT SUM(qty) AS jum FROM transaksi_temporary WHERE session='$_SESSION[user_id]'");
             if(mysqli_num_rows($sql1) == 0){
				header("Location: penjualan.php");
			}else{
				$row1 = mysqli_fetch_assoc($sql1);
			} 
            ?>
            <center><?php echo $row1['jum']; ?></center>
            
            </th>
            <th> 
            <?php $sql2 = mysqli_query($koneksi, "SELECT SUM(total) AS tot FROM transaksi_temporary WHERE session='$_SESSION[user_id]'");
             if(mysqli_num_rows($sql2) == 0){
				header("Location: penjualan.php");
			}else{
				$row2 = mysqli_fetch_assoc($sql2);
			} 
            ?>
            <center><font style="color : blue;">Rp. <?php echo number_format($row2['tot'],0,",","."); ?>
            <input type="hidden" size="5" class="form-control" id="total" name="total" value="<?php echo $row2['tot']; ?>"/>
            </font></center>
            </th>
            <th>
            <?php $sql3 = mysqli_query($koneksi, "SELECT SUM(profit) AS pro FROM transaksi_temporary WHERE session='$_SESSION[user_id]'");
             if(mysqli_num_rows($sql3) == 0){
				header("Location: penjualan.php");
			}else{
				$row3 = mysqli_fetch_assoc($sql3);
			} 
            ?>
            <center><font style="color : green;">Rp. <?php echo number_format($row3['pro'],0,",","."); ?></font></center>
            </th>
            <th></th></tr>
            <tr>
            <th colspan="6"><center>Bayar</center></th>
            <th></th>
            <th><input type="text" size="5" class="form-control" id="bayar" name="bayar" onkeyup="hitung()" onkeydown="hitung()" onchange="hitung()" autocomplete="off" required="required" /></th>
            <th></th>
            <th></th>
            </tr>
            <tr>
            <th colspan="6"><center>Kembali</center></th>
            <th></th>
            <th><input type="text" size="5" class="form-control" id="kembali" name="kembali" readonly="readonly" /></th>
            <th></th>
            <th></th>
            </tr>
			</thead>
            </table>
            	<div class="col-md-0">
					<button id="simpanpo" name="simpanpo" class="btn btn-success"><i class="fam-page-save"></i> Save Sales </button> 
				</div>
			</div> 
            </form>   
            </section><!-- /.Left col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include "footer.php"; ?>

      <?php include "sidecontrol.php"; ?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <script src="../plugins/select2/select2.full.min.js"></script>
	  <!--<script type="text/javascript"> 

            $(function () {
                $("#lookup").dataTable({"lengthMenu":[25,50,75,100],"pageLength":25});
            });
  
   
        </script>-->
        <script type="text/javascript">
    function hitung() {
var total = document.formku.total.value;
var bayar = document.formku.bayar.value;
var kembali = document.formku.kembali.value;

kembali =  (bayar - total ) ;
document.formku.kembali.value = Math.floor( kembali);

}
</script>
        
        <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });
    </script>
 <script>
        $(document).ready(function() {
				var dataTable = $('#lookup').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"ajaxin-grid-data.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".lookup-error").html("");
							$("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#lookup_processing").css("display","none");
							
						}
					}
				} );
			} );
        </script>
  </body>
</html>
