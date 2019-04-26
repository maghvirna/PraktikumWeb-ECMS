<?php
 // Define relative path from this script to mPDF
 $nama_file='ID Card'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../mpdf60/');
define("_JPGRAPH_PATH", '../mpdf60/graph_cache/src/');

//define("_JPGRAPH_PATH", '../jpgraph/src/'); 
 
include(_MPDF_PATH . "mpdf.php");
include(_MPDF_PATH . "graph.php");

//include(_MPDF_PATH . "graph_cache/src/");

$mpdf=new mPDF('utf-8', 'A4'); // Create new mPDF Document
 
//Beginning Buffer to save PHP variables and HTML tags
ob_start(); 

//$mpdf->useGraphs = true;

?>
<?php include "../conn.php"; ?>
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
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="../plugins/select2/select2.css">
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

     
      <!-- Left side column. contains the logo and sidebar -->
    
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
              </div>
             <div id="print-area-2" class="print-area">
            <section class="col-lg-12 connectedSortable">

              <!-- TO DO List -->
              <?php
            //$query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE nik='$_GET[id]'");
            //$data  = mysqli_fetch_array($query);
            $query1="select * from karyawan where nik='123456'";
                    
                    /** if(isset($_POST['nikawal']) && isset($_POST['nikakhir'])){
	               $nikawal=$_POST['nikawal'];
                   $nikakhir=$_POST['nikakhir'];
                   
	               $query1="SELECT * FROM  karyawan
	               where (nik between '$nikawal'
	               and '$nikakhir')  "; 
                    }**/
                    $tampil=mysqli_query($koneksi, $query1) or die(mysqli_error());
            ?>
            <?php 
                     $no=0;
                     while($data=mysqli_fetch_array($tampil))
                    { $no++; ?>
              <div class="box-primary">
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
                <div class="col-lg-3 box-body">
                  <div class="form-panel">
                      <table id="example">
                      <tr>
                      <td><img src="../dist/img/logo.png" height="50" width="220"/></td>
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
                      <tr bgcolor="green" width="220">
                      <td style="font-family: Arial Black; color: black; font-size: 16px;"><center><div>NIK : <?php echo $data['nik']; ?> </div></center></td>
                      </tr>
                      </table>
                     
                      
                  </div>
                </div>
                </div>
                
                
                 <!-- /.box-body -->
                <!-- <div class="box-footer clearfix no-border">
                  <a href="#" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Tambah Admin</a>
                </div> -->
              </div><!-- /.box -->
              
<?php } ?>
                </div>
            </section><!-- /.Left col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <?php

$html = ob_get_contents(); //Proses untuk mengambil data
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,1);

$mpdf->Output($nama_file."-".$data['nik'].".pdf" ,'I');

 


exit;
?>
    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Select 2 -->
    <script src="../plugins/select2/select2.js"></script> 
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
    <!-- AdminLTE App
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes 
    <script src="../dist/js/demo.js"></script> -->
  </body>
</html>