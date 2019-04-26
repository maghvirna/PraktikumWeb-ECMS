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
    <title>HRMS (Human Resource Management System)</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!-- Ionicons -->
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
            Member
            <small>HRMS</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Member</li>
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
                  <h3 class="box-title">Edit Data Member</h3>
                  <div class="box-tools pull-right">
                  <!-- <form action='admin.php' method="POST">
    	             <div class="input-group" style="width: 230px;">
                      <input type="text" name="qcari" class="form-control input-sm pull-right" placeholder="Cari Usename Atau Nama">
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-default tooltips" data-placement="bottom" data-toggle="tooltip" title="Cari Data"><i class="fa fa-search"></i></button>
                        <a href="admin.php" class="btn btn-sm btn-success tooltips" data-placement="bottom" data-toggle="tooltip" title="Refresh"><i class="fa fa-refresh"></i></a>
                      </div>
                    </div>
                    </form> -->
                  </div> 
                </div><!-- /.box-header -->
                 <?php
            $kd = $_GET['id'];
			$sql = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nik='$kd'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: member.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			/** if(isset($_POST['update'])){
				$nik	    = $_POST['nik'];
				$nama       = $_POST['nama'];
				$bagian     = $_POST['bagian'];
				$k1_join    = $_POST['k1_join'];
				$k1_finish  = $_POST['k1_finish'];
                $k2_join    = $_POST['k2_join'];
				$k2_finish  = $_POST['k2_finish']; 
   	            $status     = $_POST['status'];
				
				$update = mysqli_query($koneksi, "UPDATE karyawan SET nama='$nama', bagian='$bagian', k1_join='$k1_join', k1_finish='$k1_finish', k2_join='$k2_join', k2_finish='$k2_finish', status='$status' WHERE nik='$kd'") or die(mysqli_error());
				if($update){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data berhasil disimpan.</div>';
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data gagal disimpan, silahkan coba lagi.</div>';
				}
			} **/
			
            if(isset($_POST['update'])){
$namafolder="foto_member/"; //tempat menyimpan file

//if (!empty($_FILES["nama_file"]["tmp_name"]))
//{
	$jenis_gambar=$_FILES['nama_file']['type'];
                $nik	    = $_POST['nik'];
				$nama       = $_POST['nama'];
				$bagian     = $_POST['bagian'];
				$k1_join    = $_POST['k1_join'];
				$k1_finish  = $_POST['k1_finish'];
                $k2_join    = $_POST['k2_join'];
				$k2_finish  = $_POST['k2_finish']; 
   	            $status     = $_POST['status'];
		
	//if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/JPG" || $jenis_gambar=="image/gif" || $jenis_gambar=="image/x-png")
	//{			
		$gambar = $namafolder . basename($_FILES['nama_file']['name']);		
		if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $gambar)) {
			$sql="UPDATE karyawan SET nama='$nama', bagian='$bagian', k1_join='$k1_join', k1_finish='$k1_finish', k2_join='$k2_join', k2_finish='$k2_finish', status='$status', gambar='$gambar' WHERE nik='$kd'";
			$res=mysqli_query($koneksi, $sql) or die (mysqli_error());
			//echo "Gambar berhasil dikirim ke direktori".$gambar;
            echo "<script>alert('Data karyawan berhasil diupdate!'); window.location = 'member.php'</script>";	   
		} else {
		   echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>Gambar gagal dikirim</p></div>';
		}
  // } else {
//		echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Jenis gambar yang anda kirim salah. Harus .jpg .gif .png</div>';
  // }
//} else {
//	echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Anda Belum Memilih Gambar</div>';
//}
}
			//if(isset($_GET['pesan']) == 'sukses'){
			//	echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data berhasil disimpan.</div>';
			//}
			?>
                <div class="box-body">
                <form class="form-horizontal style-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                         <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Nik</label>
                              <div class="col-sm-4">
                                  <input name="nik" type="text" id="nik" class="form-control" value="<?php echo $row['nik']; ?>" placeholder="Auto Number" autocomplete="off" autofocus="on" required="required" />
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Nama</label>
                              <div class="col-sm-4">
                            <input name="nama" type="text" id="nama" class="form-control" value="<?php echo $row['nama']; ?>" placeholder="Nama Karyawan" autocomplete="off" required />
                              
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Bagian</label>
                              <div class="col-sm-4">
                            <input name="bagian" type="text" id="bagian" class="form-control" value="<?php echo $row['bagian']; ?>" placeholder="Bagian" autocomplete="off" required />
                              
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Kontrak 1 Join</label>
                              <div class="col-sm-4">
                            <input type='text' class="input-group date form-control" data-date="" data-date-format="yyyy-mm-dd" name='k1_join' value="<?php echo $row['k1_join']; ?>" id="tanggal_beli" placeholder='Kontrak 1 Join' required />
                            
                            </div>
                          </div>
                           <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Kontrak 1 Finish</label>
                              <div class="col-sm-4">
                            <input type='text' class="input-group date form-control" data-date="" data-date-format="yyyy-mm-dd" name='k1_finish' value="<?php echo $row['k1_finish']; ?>" id="tanggal_beli" placeholder='Kontrak 1 Finish' required />
                            
                            </div>
                          </div>
                           <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Kontrak 2 Join</label>
                              <div class="col-sm-4">
                            <input type='text' class="input-group date form-control" data-date="" data-date-format="yyyy-mm-dd" name='k2_join' value="<?php echo $row['k2_join']; ?>" id="tanggal_beli" placeholder='Kontrak 2 Join' required />
                            
                            </div>
                          </div>
                           <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Kontrak 2 Finish</label>
                              <div class="col-sm-4">
                            <input type='text' class="input-group date form-control" data-date="" data-date-format="yyyy-mm-dd" name='k2_finish' value="<?php echo $row['k2_finish']; ?>" id="tanggal_beli" placeholder='Kontrak 2 Finish' required />
                            
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Status</label>
                              <div class="col-sm-4">
                            <select id="status" name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="tetap">Tetap</option>
                            <option value="magang">Magang</option> 
                            <option value="kontrak">Kontrak</option> 
                            </select>  
                            </div>
                             <label class="col-sm-3 col-sm-3 control-label">Status Sebelumnya : </label>
                              <div class="col-sm-3">
                              <span class="label label-primary"><?php echo $row['status']; ?></span>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Foto</label>
                              <div class="col-sm-4">
                            <input name="nama_file" type="file" id="nama_file" class="form-control" placeholder="Pilih Gambar Produk" autocomplete="off" required />
                              
                            </div>
                            <label class="col-sm-3 col-sm-3 control-label">Foto Sebelumnya : </label>
                              <div class="col-sm-3">
                              <img src="<?php echo $row['gambar']; ?>" class="img-circle" height="80" width="80" style="border: 2px solid #666666;" />
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"></label>
                              <div class="col-sm-10">
                                  <input type="submit" name="update" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
	                              <a href="member.php" class="btn btn-sm btn-danger">Batal </a>
                              </div>
                          </div>
                      </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

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
    <!-- jQuery UI 1.11.4 -->
    <script src="../css/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <script>
	//options method for call datepicker
	$(".input-group.date").datepicker({ autoclose: true, todayHighlight: true });
	
    </script>
  </body>
</html>
