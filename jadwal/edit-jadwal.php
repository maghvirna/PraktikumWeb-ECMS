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
                    Jadwal
                    <small>ECMS</small>
                  </h1>                 
                  <ol class="breadcrumb">
                    <li><a href="jadwal.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
                          <h3 class="box-title">Edit Jadwal</h3>
                          <div class="box-tools pull-right">

                          </div> 
                        </div><!-- /.box-header -->

                        <?php
                        $jadwal = $_GET['id'];
                        $sql_jadwal = mysqli_query($koneksi, "select j.kd_jadwal, p.kd_pelajaran, g.kd_guru, r.kd_ruang, g.nama_guru, p.nama_pelajaran, r.nama_ruang, j.jam_mulai, j.hari, j.tanggal, p.kategori_kelas, j.jam_mulai, j.jam_selesai from pelajaran p inner join jadwal j on j.kd_guru = p.kd_guru inner join ruang r on r.kd_ruang = j.kd_ruang inner join guru g on g.kd_guru = j.kd_guru where j.kd_jadwal='$jadwal'");

                        if (mysqli_num_rows($sql_jadwal) == 0) {
                          header("Location: ../jadwal/jadwal.php");
                        } else {
                          $row = mysqli_fetch_assoc($sql_jadwal);
                        }

                        if (isset($_POST['update'])) {
                             
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
                        
                          $sql_update_jadwal = "UPDATE jadwal SET kd_pelajaran='$kd_pel', kd_guru='$kd_guru', kd_ruang='$kd_ruang', nama_guru='$nama_guru', nama_pelajaran='$nama_pelajaran', kategori_kelas='$kategori_kelas', nama_ruang='$nama_ruang', hari='$hari', tanggal='$tanggal', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE kd_jadwal='$jadwal'";

                          $res = mysqli_query($koneksi, $sql_update_jadwal) or die(mysqli_error());

                                    //echo "Gambar berhasil dikirim ke direktori".$gambar;
                          echo "<script>alert('Data pelajaran berhasil diupdate !'); window.location = 'jadwal.php'</script>";

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
                          <form class="form-horizontal style-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Kode Jadwal</label>
                              <div class="col-sm-4">
                                <input name="kd_jadwal" type="text" id="kd_jadwal" class="form-control" value="<?php echo $row["kd_jadwal"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Nama Pelajaran</label>
                              <div class="col-sm-4">

                               <input name="nama_pelajaran" type="text" class="form-control" value="<?php echo $row["nama_pelajaran"]; ?>" readonly="readonly" autofocus="on" required/>
                             </div>

                           </div>

                           <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-4">

                             <?php 
                             $query = mysqli_query($koneksi, "SELECT kd_guru, nama_guru, kd_pelajaran, nama_pelajaran FROM pelajaran group by nama_pelajaran"); 
                             $jsArray_pelajaran = "var ruangPel = new Array();\n"; ?>


                             <select name="nama_pelajaran" id="nama_pelajaran_id" class="form-control" required>


                             <option value="">-- Pilih Pelajaran Baru--</option>';

                             <?php while($data = mysqli_fetch_array($query)){ 

                               echo '<option value="' . $data['nama_pelajaran'] . '">' . $data['nama_pelajaran'] . '</option>';


                             }
                             echo '</select>'; ?>
                           </div>
                         </div>

                         <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Nama Guru</label>
                          <div class="col-sm-4" >
                                   <input name="nama_guru" type="text" class="form-control" value="<?php echo $row["nama_guru"]; ?>" readonly="readonly" autofocus="on" required/>
                      
                        </div>
                         </div>

                          <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label"></label>
                          <div class="col-sm-4" >

                            <?php 

                            $auto_pel = mysqli_query($koneksi, "SELECT kd_pelajaran, nama_pelajaran, kd_guru, nama_guru FROM pelajaran"); 
                            $jsArray_pel = "var ruangPel = new Array();\n";  ?>

                            <select name="nama_guru" class="form-control" autocomplete="off" required  onchange="changeValue(this.value)" id= "nama_guru_id" >
                            <option value="">-- Pilih Guru Baru--</option> 

                            <?php while($data_pel = mysqli_fetch_array($auto_pel)){ 

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
                          <input name="kd_pelajaran" type="text" id="kd_pelajaran_id" class="form-control" value="<?php echo $row["kd_pelajaran"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />


                          <script type="text/javascript">
                            <?php echo $jsArray_pel; ?>
                          </script>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Kode Guru</label>
                        <div class="col-sm-4">
                          <input name="kd_guru" type="text" id="kd_guru_id" class="form-control"  value="<?php echo $row["kd_guru"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                          <script type="text/javascript">
                            <?php echo $jsArray_pel; ?>
                          </script>

                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Kategori Kelas</label>
                        <div class="col-sm-4">
                         <input name="kategori_kelas" type="text" id="kategori_kelas_id" class="form-control" value="<?php echo $row["kategori_kelas"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />

                          </div>

                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label"></label>
                          <div class="col-sm-4">

                         <select name="kategori_kelas" class="form-control" >
                          <option value="<?php echo $row["kategori_kelas"]; ?>"> -- Pilih Kategori Kelas-- </option>
                          <option value="SD">SD</option>
                          <option value="SMP">SMP</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Nama Ruang</label>
                      <div class="col-sm-4">
                        <input name="nama_ruang" type="text" id="nama_ruang" class="form-control" value="<?php echo $row["nama_ruang"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" /> 
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label"></label>
                      <div class="col-sm-4">
                        <?php 

                        $auto_ruang = mysqli_query($koneksi, "SELECT kd_ruang, nama_ruang FROM ruang"); 
                        $jsArray = "var ruangName = new Array();\n"; 

                        echo '<select name="nama_ruang" class="form-control" onchange="document.getElementById(\'kd_ruang_id\').value = ruangName[this.value]">'; ?>

                        <option value="<?php echo $row['nama_ruang']; ?>">-- Pilih Ruang--</option>';
                        <?php
                        while($data_ruang = mysqli_fetch_array($auto_ruang)){ 
                          echo '<option value="' . $data_ruang['nama_ruang'] . '">' . $data_ruang['nama_ruang'] . '</option>';
                          $jsArray .= "ruangName['" . $data_ruang['nama_ruang'] . "'] = '" . addslashes($data_ruang['kd_ruang']) . "';\n";
                        }
                        echo '</select>'; ?>



                      </div>

                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Kode Ruang</label>
                      <div class="col-sm-4">
                        <input name="kd_ruang" type="text" id="kd_ruang_id" class="form-control" value="<?php echo $row["kd_ruang"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" />
                        <script type="text/javascript">
                          <?php echo $jsArray; ?>
                        </script>

                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Hari</label>
                      <div class="col-sm-4">
                        <input name="hari" type="text" id="hari" class="form-control" value="<?php echo $row["hari"]; ?>" placeholder="Auto Number" readonly="readonly" autofocus="on" /> 
                      </div>
                    </div>                

                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label"></label>
                      <div class="col-sm-4">

                        <select name="hari" class="form-control" required>
                          <option value="<?php echo $row["hari"]; ?>"> -- Pilih Hari-- </option>
                          <option value="Sabtu">Sabtu</option>
                          <option value="Minggu">Minggu</option>
                        </select>
                      </div>
                    </div>

                      <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Tanggal</label>
                      <div class="col-sm-4">
                        <input name="tanggal" type="date" id="tanggal" class="form-control" value="<?php echo $row["tanggal"]; ?>" required/> 
                      </div>
                    </div>
                    

                
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Jam Mulai </label>
                      <div class="col-sm-4">
                       <input name="jam_mulai" type="time" id="nama_ruang" class="form-control" value="<?php echo $row["jam_mulai"]; ?>" placeholder="Jam Mulai" autocomplete="off" required />
                     </div>
                   </div>
                   <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">Jam Selesai </label>
                    <div class="col-sm-4">
                      <input name="jam_selesai" type="time" id="nama_ruang" class="form-control"  
                      value="<?php echo $row["jam_selesai"]; ?>" placeholder="Jam Selesai" autocomplete="off" required />



                    </div>
                  </div>


                                  <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                      <input type="submit" name="update" value="Simpan" class="btn btn-sm btn-primary" />&nbsp;
                                      <a href="jadwal.php" class="btn btn-sm btn-danger">Batal </a>
                                    </div>
                                  </div>
                                </form>
                              </div>


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
