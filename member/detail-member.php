<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:../admin/index.php');
} else {
    include "../conn.php";
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>ECMS (Education Course Management System)</title>
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

                <?php include "../header.php"; ?>
                <!-- Left side column. contains the logo and sidebar -->
                <?php include "../admin/menu.php";
                ?>

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
                        Staff
                        <small>ECMS</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../member/d_member.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">Detail Staff</li>
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
                                    <h3 class="box-title">Detail Data Staff</h3>
                                    <!-- <div class="box-tools pull-right">
                                      <ul class="pagination pagination-sm inline">
                                        <li><a href="#">&laquo;</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">&raquo;</a></li>
                                      </ul>
                                    </div> -->
                                </div><!-- /.box-header -->
                                <?php
                                if ($_SESSION['privilege'] == "superuser") {

                                    $q_edit_murid = mysqli_query($koneksi, "select s.kd_staff, u.username, s.nama_staff, s.alamat_staff, s.no_hp ,s.gambar from staff s inner join user u on u.user_id = s.user_id where kd_staff='" . $_GET['kds'] . "'");
                                    $edit_staff = mysqli_fetch_array($q_edit_murid);

                                    if (mysqli_num_rows($q_edit_murid) > 0) {


                                        $_SESSION['kd_staff'] = $edit_staff['kd_staff'];
                                        $_SESSION['username'];
                                        $_SESSION['nama_staff'] = $edit_staff['nama_staff'];
                                        $_SESSION['alamat_staff'] = $edit_staff['alamat_staff'];
                                        $_SESSION['no_hp'] = $edit_staff['no_hp'];
                                        $_SESSION['gambar'] = $edit_staff['gambar'];
                                        // alihkan ke halaman dashboard admin
                                    } else {

                                        echo("Gagal Mengambil query");
                                    }
                                    ?>

                                    <div class="box-body">
                                        <div class="form-panel">
                                            <table id="example" class="table table-hover table-bordered">
                                                <tr>
                                                    <td>Kode</td>
                                                    <td><?php echo $edit_staff['kd_staff']; ?></td>
                                                    <td rowspan="8"><img src="<?php echo $edit_staff['gambar']; ?>" class="img-rounded" height="300" width="225" style="border: 2px solid #666666;" /></td>
                                                </tr>                   
                                                
                                                <tr>
                                                    <td>Nama Lengkap</td>
                                                    <td><?php echo $edit_staff['nama_staff']; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Alamat</td></td>
                                                    <td><?php echo $edit_staff['alamat_staff'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No HP</td>
                                                    <td><?php echo $edit_staff['no_hp']; ?></td>
                                                </tr>

                                            </table>
                                            <tr>
    <?php }
?>
                                        <div class="text-right">
                                            <a href="../member/member.php" class="btn btn-sm btn-warning">Kembali <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>



                                        <!-- /.box-body -->
                                        <!-- <div class="box-footer clearfix no-border">
                                          <a href="#" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Tambah Admin</a>
                                        </div> -->
                                    </div><!-- /.box -->

                                    </section><!-- /.Left col -->
                                </div><!-- /.row (main row) -->

                        </section><!-- /.content -->
                    </div><!-- /.content-wrapper -->
<?php include "../footer.php"; ?>

                    <?php include "../sidecontrol.php"; ?>
                    <!-- Add the sidebar's background. This div must be placed
                         immediately after the control sidebar -->
                    <div class="control-sidebar-bg"></div>
            </div><!-- ./wrapper -->

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
    </body>
</html>
