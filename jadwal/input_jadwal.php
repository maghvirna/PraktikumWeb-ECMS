
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
                <section class="content-header" >

                  <h1>

                    Jadwal
                    
                    <small>ECMS</small>
                    
                  </h1>

                  <ol class="breadcrumb">
                    <li ><a href="jadwal.php" > &nbsp; <i class="fa fa-dashboard" > </i> Dashboard</a></li>
                    <li class="active">Jadwal</li>
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
                          <h3 class="box-title">Input Jadwal </h3>
                          <h5 id="timestamp"></h5>
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

                                $tampil_guru = mysqli_query($koneksi, "SELECT kd_guru, nama_guru from guru order by nama_guru ASC");



                                $sql = "SELECT max(kd_jadwal) as kdjad FROM jadwal";
                                $hasil = mysqli_query($koneksi, $sql);
                                $data = mysqli_fetch_array($hasil);
                                $kd_jadwal = $data['kdjad'];
                                $noUrut = (int) substr($kd_jadwal, 3, 3);
                                $noUrut++;
                                $char = "J";
                                $kd_jadwal = $char . sprintf("%03s", $noUrut);

                                if (isset($_POST['input'])) {

                                  $kd_jad = $_POST['kd_jadwal'];
                                  $kd_pel = $_POST['kd_pelajaran'];
                                  $kd_guru = $_POST['kd_guru'];
                                  $kd_ruang = $_POST['kd_ruang'];
                                  $nama_guru = $_POST['nama_guru'];
                                  $nama_pelajaran = $_POST['nama_pelajaran'];
                                  $kategori_kelas = $_POST['kategori_kelas'];
                                  $nama_ruang = $_POST['nama_ruang'];
                                  $hari = $_POST['hari'];
                                  $tanggal = $_POST['tanggal'];
                                  $jam_mulai = $_POST['jam_mulai'];
                                  $jam_selesai = $_POST['jam_selesai'];


                                  $sql1 = "INSERT INTO jadwal(kd_jadwal, kd_pelajaran, kd_guru, kd_ruang, nama_guru, nama_pelajaran, kategori_kelas, nama_ruang, hari, tanggal, jam_mulai, jam_selesai) VALUES ('$kd_jad','$kd_pel','$kd_guru', '$kd_ruang','$nama_guru','$nama_pelajaran','$kategori_kelas','$nama_ruang','$hari','$tanggal','$jam_mulai','$jam_selesai')";
                                  $res = mysqli_query($koneksi, $sql1);

                                    //echo "Gambar berhasil dikirim ke direktori".$gambar;
                                  echo "<script>alert('Data Jadwal berhasil disimpan !'); window.location = 'jadwal.php'</script>";
                                }
                                ?>

                                <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
                                <script type="text/javascript">
                                  $(document).ready(function(){
                                    $('#nama_pelajaran_id').change(function() {
                                      var mapel_id = $(this).val();
                                      $.ajax ({
                                        type : 'POST',
                                        url : 'nama_guru.php',
                                        data : 'mapel='+mapel_id,
                                        success : function (response){
                                          $('#nama_guru_id').html(response);
                                        }

                                      });

                                    })



                                  });
                                </script>

                                <div class="box-body">
                                  <form class="form-horizontal style-form" action="input_jadwal.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                    <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Kode Jadwal</label>
                                      <div class="col-sm-4">



                                        <input name="kd_jadwal" type="text" id="kd_jadwal" class="form-control" value="<?php echo $kd_jadwal; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Nama Pelajaran</label>
                                      <div class="col-sm-4">

                                        <?php 
                                        $query = mysqli_query($koneksi, "SELECT kd_guru, nama_guru, kd_pelajaran, nama_pelajaran FROM pelajaran group by nama_pelajaran"); 
                                        $jsArray_pelajaran = "var ruangPel = new Array();\n"; 


                                        echo '<select name="nama_pelajaran" id="nama_pelajaran_id" class="form-control" >';


                                        echo '<option>-- Pilih Pelajaran--</option>';

                                        while($data = mysqli_fetch_array($query)){ 

                                         echo '<option value="' . $data['nama_pelajaran'] . '">' . $data['nama_pelajaran'] . '</option>';


                                       }
                                       echo '</select>'; ?>
                                     </div>
                                   </div>


                                   <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Nama Guru</label>
                                    <div class="col-sm-4">

                                     <!--  <?php
                                      $mapel = $_POST['mapel'];

                                      $auto_guru = mysqli_query($koneksi, "SELECT kd_guru, nama_guru, kd_pelajaran, nama_pelajaran FROM pelajaran where nama_pelajaran=$mapel ");  
                                      ?>
                                      <select name="nama_guru" id="nama_guru_id" class="form-control">
                                         <option>-- Pilih Guru--</option>

                                        <?php while ($data_guru = mysqli_fetch_array($auto_guru)){  ?>
                                          <option value="<?php echo $data_guru['kd_guru'] ?> "><?php echo $data_guru['nama_guru'] ?> </option>

                                        <?php }
                                        ?> -->

                                        <?php 

                                        $auto_pel = mysqli_query($koneksi, "SELECT kd_pelajaran, nama_pelajaran, kd_guru, nama_guru FROM pelajaran"); 
                                        $jsArray_pel = "var ruangPel = new Array();\n"; 

                                        echo '<select name="nama_guru" class="form-control" id= "nama_guru_id" onchange="changeValue(this.value)">';
                                        echo '<option>-- Pilih Guru--</option>';
                                        
                                        while($data_pel = mysqli_fetch_array($auto_pel)){ 

                                         $jsArray_pel .= "ruangPel['" . $data_pel['nama_guru'] . "'] = {kode:'".addslashes($data_pel['kd_pelajaran'])."', kdg:'".addslashes($data_pel['kd_guru'])."'};\n"; 
                                       }
                                       echo '</select>'; ?>
                                       <script type="text/javascript">  

                                        function changeValue(id){
                                          document.getElementById('kd_pelajaran_id').value = ruangPel[id].kode;
                                          document.getElementById('kd_guru_id').value = ruangPel[id].kdg;

                                        };
                                      </script>


                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Kode Pelajaran</label>
                                    <div class="col-sm-4">
                                      <input name="kd_pelajaran" type="text" id="kd_pelajaran_id" class="form-control" placeholder="Auto Number" readonly="readonly" autofocus="on" />

                                      <script type="text/javascript">
                                        <?php echo $jsArray_pel; ?>
                                      </script>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Kode Guru</label>
                                    <div class="col-sm-4">
                                      <input name="kd_guru" type="text" id="kd_guru_id" class="form-control" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                                      <script type="text/javascript">
                                        <?php echo $jsArray_pel; ?>
                                      </script>

                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Kategori Kelas</label>
                                    <div class="col-sm-4">
                                      <select name="kategori_kelas" class="form-control" required>
                                        <option value=""> -- Pilih Kategori Kelas-- </option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                      </select>
                                    </div>
                                  </div>



                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Nama Ruang</label>
                                    <div class="col-sm-4">
                                      <?php 

                                      $auto_ruang = mysqli_query($koneksi, "SELECT kd_ruang, nama_ruang FROM ruang"); 
                                      $jsArray_ruang = "var ruangName = new Array();\n"; 

                                      echo '<select name="nama_ruang" class="form-control" onchange="document.getElementById(\'kd_ruang_id\').value = ruangName[this.value]">';
                                      echo '<option>-- Pilih Ruang--</option>';
                                      while($data_ruang = mysqli_fetch_array($auto_ruang)){ 
                                        echo '<option value="' . $data_ruang['nama_ruang'] . '">' . $data_ruang['nama_ruang'] . '</option>';
                                        $jsArray_ruang .= "ruangName['" . $data_ruang['nama_ruang'] . "'] = '" . addslashes($data_ruang['kd_ruang']) . "';\n";
                                      }
                                      echo '</select>'; ?>



                                    </div>

                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Kode Ruang</label>
                                    <div class="col-sm-4">
                                      <input name="kd_ruang" type="text" id="kd_ruang_id" class="form-control" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                                      <script type="text/javascript">
                                        <?php echo $jsArray_ruang; ?>
                                      </script>

                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Hari </label>
                                    <div class="col-sm-4">
                                      <select name="hari" class="form-control" required>
                                        <option value=""> -- Pilih Hari-- </option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                      </select>
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Tanggal </label>
                                    <div class="col-sm-4">
                                      <input type="date" name="tanggal" class="form-control" placeholder="Masukkan tanggal" autocomplete="off" required />
                                    </div>

                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Jam Mulai </label>
                                    <div class="col-sm-4">
                                      <input name="jam_mulai" type="time" id="jam_mulai" class="form-control" placeholder="Masukkan jam mulai" autocomplete="off" required />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">Jam Selesai </label>
                                    <div class="col-sm-4">
                                      <input name="jam_selesai" type="time" id="jam_selesai" class="form-control"   placeholder="Masukkan jam selesai" autocomplete="off" required />

                                      <!-- value="<?php $formated_time = date("H:i", strtotime['jam_selesai']); echo "$formated_time"; ?>" -->
                                    </div>
                                  </div>


                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                      <input type="submit" name="input" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
                                      <a href="jadwal.php" class="btn btn-sm btn-danger">Batal </a>
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
