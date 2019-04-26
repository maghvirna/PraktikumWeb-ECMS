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
   <script type="text/javascript">
   $.getScript('../plugins/select2/select2.js',function(){
   

  $("#nikawal").select2({
    allowClear:true
  });
  $("#nikakhir").select2({
    allowClear:true
  });
});
</script>

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
            Karyawan
            <small>HRMS</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Detail Karyawan</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="row">
                    
              <div class="col-lg-8">
              <form action='cetak-idcard.php' method="POST">
          
	       <div class="col-lg-4">
           <select name="nikawal" id="nikawal" class="form-control select2" required>
                              <option value=""> --- Pilih Karyawan --- </option>
                              <?php 
                    $query1="select * from karyawan order by nik";
                    $tampil=mysqli_query($koneksi, $query1) or die(mysqli_error());
                    while($data=mysqli_fetch_array($tampil))
                    {
                    ?>
                              
                                  
							
							<option value="<?php echo $data['nik'];?>"><?php echo $data['nik'];?> - <?php echo $data['nama'];?></option>
						    <?php } ?>
                              
                              </select>  </div> 
           <div class="col-lg-4"> 
          <select name="nikakhir" id="nikakhir" class="form-control select2" required>
                              <option value=""> --- Pilih Karyawan --- </option>
                              <?php 
                    $query2="select * from karyawan order by nik";
                    $tampil=mysqli_query($koneksi, $query2) or die(mysqli_error());
                    while($data1=mysqli_fetch_array($tampil))
                    {
                    ?>
                              
                                  
							
							<option value="<?php echo $data1['nik'];?>"><?php echo $data1['nik'];?> - <?php echo $data1['nama'];?></option>
						    <?php } ?>
                              
                              </select> 
           </div>
           <input type='submit' value='Cari Data' class="btn btn-sm btn-primary" /> <a href='cetak-idcard.php' class="btn btn-sm btn-success" > Refresh</a>
           </form>
           </div>
              </div>
             <div id="print-area-2" class="print-area">
            <section class="col-lg-12 connectedSortable">

              <!-- TO DO List -->
              <?php
            //$query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nik='$_GET[id]'");
            //$data  = mysqli_fetch_array($query);
            $query1="select * from karyawan";
                    
                    if(isset($_POST['nikawal']) && isset($_POST['nikakhir'])){
	               $nikawal=$_POST['nikawal'];
                   $nikakhir=$_POST['nikakhir'];
                   
	               $query1="SELECT * FROM  karyawan
	               where (nik between '$nikawal'
	               and '$nikakhir')  "; 
                    }
                    $tampil=mysqli_query($koneksi, $query1) or die(mysqli_error());
            ?>
            <?php 
                     $no=0;
                     while($data=mysqli_fetch_array($tampil))
                    { $no++; ?>
              <div class="box-primary col-lg-3 ">
                <!--<div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Detail Data Karyawan</h3>
                  <div class="box-tools pull-right">
                    <ul class="pagination pagination-sm inline">
                      <li><a href="#">&laquo;</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">&raquo;</a></li>
                    </ul>
                  </div> 
                </div>--> <!-- /.box-header -->
                
                <div id="print-area-2" class="print-area">
                <div class="box-body">
                  <div class="form-panel">
                      <table id="example">
                      <tr>
                      <td><img src="../dist/img/niqoweb.png" height="50" width="220"/></td>
                     <!-- <td style="margin-left: 10px; font-family: Arial Black; color: #1E824C; font-size: 18px; margin-top: 0px;"><i>PT TSUCHIYA<br />MANUFACTURING<br />INDONESIA</i></td><br />-->
                      </tr> 
                      <tr>
                      <td colspan="2" style="font-family: Arial Black; color: black; font-size: 16px;"><center><?php echo $data['bagian']; ?></center></td>
                      </tr>
                      <tr>
                      <td colspan="2"><center><img src="<?php echo $data['gambar']; ?>" class="img-rounded" style="border: 2px solid #666;" height="150" width="130" /></center></td>
                      </tr>
                      <tr>
                      <td colspan="2" style="font-family: Arial Black; color: red; font-size: 16px;"><center><?php echo $data['nama']; ?></center></td>
                      </tr>
                      <tr>
                      <td style="font-family: Arial Black; color: black; font-size: 16px;"><center><div style="background: green;">NIK : <?php echo $data['nik']; ?> </div></center></td>
                      </tr>
                      </table>
                     <br /><br /><br />
                      
                  </div>
                </div>
                </div>
                
                
                 <!-- /.box-body -->
                <!-- <div class="box-footer clearfix no-border">
                  <a href="#" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Tambah Admin</a>
                </div> -->
              </div><!-- /.box -->
              <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<?php } ?>


                <div class="text-right">
                  <a href="javascript:printDiv('print-area-2');" class="btn btn-sm btn-warning">Cetak <i class="fa fa-print"></i></a>
              
                </div>
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

<script type="text/javascript">
     
     function printDiv(elementId) {
    var a = document.getElementById('print-area-2').value;
    var b = document.getElementById(elementId).innerHTML;
    window.frames["print_frame"].document.title = document.title;
    window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}
</script>

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
    <script>
     $(function () {
    $(".select2").select2();
    });
    </script>
  </body>
</html>
