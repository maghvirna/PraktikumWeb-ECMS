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
                <?php
                if ($_SESSION['privilege'] == "superuser") {

                    include "../admin/menu.php";
                } else {
                    include "../guru/menu_guru.php";
                }
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
                        Guru
                        <small>ECMS</small>
                    </h1>
                    <?php
                    if ($_SESSION['privilege'] == "admin") {
                        ?> <ol class="breadcrumb">
                            <li><a href="d_guru.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li class="active">Guru</li>
                        </ol>    
                    <?php } else {
                        ?>
                        <ol class="breadcrumb">
                            <li><a href="guru.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                            <li class="active">Guru</li>
                        </ol>    
                        <?php
                    }
                    ?>
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
                                    <h3 class="box-title">Edit Data Guru</h3>
                                    <div class="box-tools pull-right">

                                    </div> 
                                </div><!-- /.box-header -->
                                <?php
                                if ($_SESSION['privilege'] == "admin") {

                                    $sql = mysqli_query($koneksi, "select g.kd_guru, u.user_id, u.username, pel.nama_pelajaran ,u.privilege, g.nama_guru, g.alamat_guru, g.no_hp, g.gambar from guru g inner join pelajaran pel on g.kd_guru = pel.kd_guru  inner join user u on u.user_id = g.user_id where username='" . $_SESSION['username'] . "'");

                                    if (mysqli_num_rows($sql) == 0) {
                                        header("Location: ../guru/d_guru.php");
                                    } else {
                                        $row = mysqli_fetch_assoc($sql);
                                    }

                                    if (isset($_POST['update'])) {
                                        $namafolder = "../guru/foto_guru/"; //tempat menyimpan file
//if (!empty($_FILES["nama_file"]["tmp_name"]))
//{
                                        $jenis_gambar = $_FILES['nama_file']['type'];
                                        $kdg = $_POST['kd_guru'];

                                        $nama_guru = $_POST['nama_guru'];
                                        $alamat_guru = $_POST['alamat_guru'];
                                        $no_hp = $_POST['no_hp'];



                                        $gambar = $namafolder . basename($_FILES['nama_file']['name']);
                                        if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $gambar)) {
                                            $sql = "UPDATE guru SET nama_guru='$nama_guru', alamat_guru='$alamat_guru',  no_hp='$no_hp', gambar='$gambar' WHERE kd_guru='$kdg'";
                                           
                                            $res = mysqli_query($koneksi, $sql) or die(mysqli_error());
                                           
                                            
                                            //echo "Gambar berhasil dikirim ke direktori".$gambar;
                                            echo "<script>alert('Data Guru berhasil diupdate !'); window.location = 'detail-guru.php'</script>";
                                        }
                                        else
                                            $sql = "UPDATE guru SET nama_guru='$nama_guru', alamat_guru='$alamat_guru',  no_hp='$no_hp' WHERE kd_guru='$kdg'";
                                       
                                        $res = mysqli_query($koneksi, $sql) or die(mysqli_error());
                                         
                                        //echo "Gambar berhasil dikirim ke direktori".$gambar;
                                        echo "<script>alert('Data Guru berhasil diupdate !'); window.location = 'detail-guru.php'</script>";
                                    }
                                    ?>
                                    <div class="box-body">
                                        <form class="form-horizontal style-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Kode Guru</label>
                                                <div class="col-sm-4">
                                                    <input name="kd_guru" type="text" id="kd_guru" class="form-control" value="<?php echo $row["kd_guru"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Nama Lengkap</label>
                                                <div class="col-sm-4">
                                                    <input name="nama_guru" type="text" id="nama" class="form-control" value="<?php echo $row['nama_guru']; ?>" placeholder="Nama Karyawan" autocomplete="off" required />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Nama Pelajaran</label>
                                                <div class="col-sm-4">
                                                    <input name="nama_guru" type="text" id="nama" class="form-control" value="<?php echo $row['nama_pelajaran']; ?>" placeholder="Nama Pelajaran" readonly="readonly" autofocus="on" />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Alamat</label>
                                                <div class="col-sm-4">
                                                    <input name="alamat_guru" type="text" id="alamat" class="form-control" value="<?php echo $row['alamat_guru']; ?>" placeholder="Bagian" autocomplete="off" required />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">No HP</label>
                                                <div class="col-sm-4">
                                                    <input name="no_hp" type="text" id="no_hp" class="form-control" maxlength="12" minlength="12" value="<?php echo $row['no_hp']; ?>" placeholder="Bagian" autocomplete="off" required />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Foto </label>
                                                <div class="col-sm-4">
                                                    <input name="nama_file" type="file"  id="nama_file" class="form-control" placeholder="Pilih Foto Anda"  />


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
                                                    <a href="d_guru.php" class="btn btn-sm btn-danger">Batal </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <?php
                                } else {
                                    $kdg = $_GET['id'];
                                    $sql = mysqli_query($koneksi, "select g.kd_guru, u.user_id, u.username, u.password, g.nama_guru, g.alamat_guru, g.no_hp, g.gambar from guru g inner join user u on u.user_id = g.user_id  where g.kd_guru='$kdg'");
                                    if (mysqli_num_rows($sql) == 0) {
                                        header("Location: ../guru/guru.php");
                                    } else {
                                        $row = mysqli_fetch_assoc($sql);
                                    }

                                    if (isset($_POST['update'])) {
                                        $namafolder = "../guru/foto_guru/"; //tempat menyimpan file
//if (!empty($_FILES["nama_file"]["tmp_name"]))
//{
                                        $jenis_gambar = $_FILES['nama_file']['type'];
                                        $kd_guru = $_POST['kd_guru'];
                                       $password = $_POST['password'];
                                        $nama_guru = $_POST['nama_guru'];
                                       
                                        $alamat_guru = $_POST['alamat_guru'];
                                        $no_hp = $_POST['no_hp'];

                                        $gambar = $namafolder . basename($_FILES['nama_file']['name']);
                                        if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $gambar)) {
                                            $sql = "UPDATE guru SET nama_guru='$nama_guru', alamat_guru='$alamat_guru',  no_hp='$no_hp', gambar='$gambar' WHERE kd_guru='$kdg'";
                                           
                                            $sql2 = "UPDATE user SET password='$password' where username='$kdg'";
                                            
                                            $res = mysqli_query($koneksi, $sql) or die(mysqli_error());       
                                            
                                            $res2 = mysqli_query($koneksi, $sql2) or die(mysqli_error());
                                           
                                            //echo "Gambar berhasil dikirim ke direktori".$gambar;
                                            echo "<script>alert('Data Guru berhasil diupdate !'); window.location = 'guru.php'</script>";
                                        }
                                        else
                                            $sql = "UPDATE guru SET nama_guru='$nama_guru', alamat_guru='$alamat_guru', no_hp='$no_hp' WHERE kd_guru='$kdg'";
                                     
                                        $sql2 = "UPDATE user SET password='$password' where username='$kdg'";
                                        $res = mysqli_query($koneksi, $sql) or die(mysqli_error());
                                        
                                           $res2 = mysqli_query($koneksi, $sql2) or die(mysqli_error());
                                        //echo "Gambar berhasil dikirim ke direktori".$gambar;
                                        echo "<script>alert('Data Guru berhasil diupdate !'); window.location = 'guru.php'</script>";
                                    }
                                    ?>
                                    <div class="box-body">
                                        <form class="form-horizontal style-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Kode Guru</label>
                                                <div class="col-sm-4">
                                                    <input name="kd_guru" type="text" id="kd_guru" class="form-control" value="<?php echo $row["kd_guru"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Username</label>
                                                <div class="col-sm-4">
                                                    <input name="nama_guru" type="text" id="nama" class="form-control" value="<?php echo $row["kd_guru"]; ?>" readonly="readonly" autofocus="on" />

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Password</label>
                                                <div class="col-sm-4">
                                                    <input name="password" type="text" id="Password" class="form-control" value="<?php echo $row["password"]; ?>" placeholder="Auto Number" autocomplete="off" required />
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Nama Lengkap</label>
                                                <div class="col-sm-4">
                                                    <input name="nama_guru" type="text" id="nama" class="form-control" value="<?php echo $row['nama_guru']; ?>" placeholder="Nama Karyawan" autocomplete="off" required />

                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Alamat</label>
                                                <div class="col-sm-4">
                                                    <input name="alamat_guru" type="text" id="alamat" class="form-control" value="<?php echo $row['alamat_guru']; ?>" placeholder="Bagian" autocomplete="off" required />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">No HP</label>
                                                <div class="col-sm-4">
                                                    <input name="no_hp" type="text" id="no_hp" class="form-control" value="<?php echo $row['no_hp']; ?>" placeholder="Bagian" autocomplete="off" required />

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Foto</label>
                                                <div class="col-sm-4">  

                                                    <input name="nama_file" type="file" id="nama_file" class="form-control" value="<?php echo $row['gambar']; ?>"   /> 


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
                                                    <a href="guru.php" class="btn btn-sm btn-danger">Batal </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>

                                <!-- /.box-body -->
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
            $(".input-group.date").datepicker({autoclose: true, todayHighlight: true});

        </script>
    </body>
</html>
