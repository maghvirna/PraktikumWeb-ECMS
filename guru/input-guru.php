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
                <?php include "../admin/menu.php"; ?>

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
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="active">Guru</li>
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
                                    <h3 class="box-title">Input Data Guru</h3>
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
                                /** 	if(isset($_POST['input'])){
                                  $kd_staff		= $_POST['kd_staff'];
                                  $nama_staff     = $_POST['nama_staff'];
                                  $alamat_staff   = $_POST['alamat_staff];



                                  $cek = mysqli_query($koneksi, "SELECT * FROM kd_staff WHERE kd_staff='$kd_staff'");
                                  if(mysqli_num_rows($cek) == 0){
                                  $insert = mysqli_query($koneksi, "INSERT INTO staff(kd_staff, nama_staff, alamat_staff)
                                  VALUES('$kd_staff','$nama_staff','$alamat_staff')") or die(mysqli_error());
                                  if($insert){
                                  echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data Staff Berhasil Di Simpan.</div>';
                                  }else{
                                  echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Ups, Data Staff Gagal Di simpan !</div>';
                                  }
                                  }else{
                                  echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Staff Sudah Ada..!</div>';
                                  }
                                  } * */
                                $sql = mysqli_query($koneksi, "SELECT max(kd_guru) as kdg FROM guru");
                                $tm_cari = mysqli_fetch_array($sql);
                                $kode = substr($tm_cari['kdg'], 1, 4);
                                $tambah = $kode + 1;
                                if ($tambah < 10) {
                                    $kd_guru = "G00" . $tambah;
                                } else {

                                    $kd_guru = "G0" . $tambah;
                                }

                                $query = "SELECT max(user_id) as usridm FROM user";
                                $hasil = mysqli_query($koneksi, $query);
                                $data = mysqli_fetch_array($hasil);
                                $user_id = $data['usridm'];
                                $noUrut = (int) substr($user_id, 3, 3);
                                $noUrut++;
                                $char = "ID";
                                $user_id = $char . sprintf("%03s", $noUrut);

                                if (mysqli_num_rows($sql) == 0) {
                                    header("Location: ../guru/guru.php");
                                } else {
                                    $row = mysqli_fetch_assoc($sql);
                                }




                                if (isset($_POST['input'])) {
                                    $namafolder = "../guru/foto_guru/"; //tempat menyimpan file

                                    if (!empty($_FILES["nama_file"]["tmp_name"])) {
                                        $jenis_gambar = $_FILES['nama_file']['type'];
                                        $kdg = $_POST['kd_guru'];
                                        $nama_guru = $_POST['nama_guru'];
                                        $alamat_guru = $_POST['alamat_guru'];
                                        $no_hp = $_POST['no_hp'];
                                        $password = $_POST['password'];

                                        /*                                         * $cekno= mysqli_query($koneksi, "SELECT * FROM produk ORDER BY kd_produk DESC");


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
                                          $p = "P";
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
                                          $kode=$p.$no1.$next1;* */

                                        if ($jenis_gambar == "image/jpeg" || $jenis_gambar == "image/jpg" || $jenis_gambar == "image/gif" || $jenis_gambar == "image/png") {
                                            $gambar = $namafolder . basename($_FILES['nama_file']['name']);
                                            if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $gambar)) {
                                                $query2 = "INSERT INTO user(user_id, username, password, fullname, privilege, gambar_user) VALUES ('$user_id','$kdg','$password','$nama_guru','admin','$gambar')";
                                                $query1 = "INSERT INTO guru(kd_guru, user_id, nama_guru, alamat_guru, no_hp, gambar) VALUES ('$kdg', (select user_id from user where username='$kdg') ,'$nama_guru','$alamat_guru','$no_hp','$gambar')";


                                                $res2 = mysqli_query($koneksi, $query2);
                                                $res = mysqli_query($koneksi, $query1);


                                                //echo "Gambar berhasil dikirim ke direktori".$gambar;
                                                echo "<script>alert('Data Guru berhasil disimpan !'); window.location = 'guru.php'</script>";
                                            } else {
                                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>Gambar gagal disimpan !</p></div>';
                                            }
                                        } else {
                                            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Gambar harus .jpg .gif .png !</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Anda belum memasukkan gambar !</div>';
                                    }
                                }
                                ?>
                                <div class="box-body">
                                    <form class="form-horizontal style-form" action="input-guru.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Kode Guru</label>
                                            <div class="col-sm-4">
                                                <input name="kd_guru" type="text" id="nik" class="form-control" value="<?php echo $kd_guru; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Password </label>
                                            <div class="col-sm-4">
                                                <input name="password" type="password" id="password" class="form-control" placeholder="Masukkan password" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nama Lengkap </label>
                                            <div class="col-sm-4">
                                                <input name="nama_guru" type="text" id="nama_staff" class="form-control" placeholder="Masukkan nama" autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Alamat</label>
                                            <div class="col-sm-4">
                                                <input name="alamat_guru" type="text" id="alamat_staff" class="form-control" placeholder="Masukkan alamat" autocomplete="off" required />

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">No HP</label>
                                            <div class="col-sm-4">
                                                <input name="no_hp" type="text" id="no_hp" class="form-control" maxlength="12" minlength="12" placeholder="Masukkan Nomor " autocomplete="off" required />

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Foto</label>
                                            <div class="col-sm-8">

                                                <input name="nama_file" type="file" id="nama_file" class="form-control" placeholder="Pilih Gambar " autocomplete="off" required />

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label"></label>
                                            <div class="col-sm-10">
                                                <input type="submit" name="input" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
                                                <a href="guru.php" class="btn btn-sm btn-danger">Batal </a>
                                            </div> 
                                        </div>
                                    </form>
                                </div><!-- /.box-body -->
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
