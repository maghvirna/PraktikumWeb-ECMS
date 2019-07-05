<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
             <script>
  // Function ini dijalankan ketika Halaman ini dibuka pada browser
  $(function(){
     setInterval(timestamp, 1000);//fungsi yang dijalan setiap detik, 1000 = 1 detik
   });

    //Fungi ajax untuk Menampilkan Jam dengan mengakses File ajax_timestamp.php
    function timestamp() {
     $.ajax({
       url: '../ajax_timestamp.php',
       success: function(data) {
         $('#timestampss').html(data);
       },
     });
   }
 </script>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                if ($_SESSION['privilege'] == "superuser") {

                    $qu = mysqli_query($koneksi, "select u.username, s.gambar from staff s inner join user u on u.user_id = s.user_id where username='" . $_SESSION['username'] . "'");
                    $row_akun = mysqli_fetch_array($qu);
                    if (mysqli_num_rows($qu) > 0) {
                        $_SESSION['gambar'] = $row_akun['gambar'];
                    } else {
                        echo("Gagal Mengambil query");
                    }
                    ?>
                    <img src="<?php echo $row_akun['gambar']; ?>" class="user-image" style="border: 1px solid white;" alt="User Image">
                    <?php
                }
                ?>
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['fullname']; ?></p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
                <h5 id="timestampss"></h5>
            </div>
        </div><br />
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU UTAMA<</li>
            <li class="active treeview">
                <a href="../member/d_member.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>


            <li>
                <a href="#">
                    <i class="fa fa-user"></i> <span>Staff</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../member/member.php"><i class="fa fa-circle-o"></i>Data Staff</a></li>
                    <li><a href="../member/input-member.php"><i class="fa fa-circle-o"></i> Input Staff</a></li>

                </ul>

            </li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i> <span>Guru</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../guru/guru.php"><i class="fa fa-circle-o"></i>Data Guru</a></li>
                    <li><a href="../guru/input-guru.php"><i class="fa fa-circle-o"></i> Input Guru</a></li>

                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i> <span>Murid</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../murid/murid.php"><i class="fa fa-circle-o"></i>Data Murid</a></li>
                    <li><a href="../murid/input-murid.php"><i class="fa fa-circle-o"></i> Input Murid</a></li>


                </ul>

            </li>
            <li>
                <a href="#">
                    <i class="fa fa-file"></i> <span>Pelajaran</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../pelajaran/pelajaran.php"><i class="fa fa-circle-o"></i> Data Pelajaran</a></li>
                    <li><a href="../pelajaran/input-pelajaran.php"><i class="fa fa-circle-o"></i> Input Pelajaran</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-file"></i> <span>Jadwal</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../jadwal/jadwal.php"><i class="fa fa-circle-o"></i> Data Jadwal</a></li>
                     <li><a href="../jadwal/input_jadwal.php"><i class="fa fa-circle-o"></i>Input Jadwal</a>
                    <li><a href="../jadwal/jadwal_sd.php"><i class="fa fa-circle-o"></i>Jadwal SD</a></li>
                    <li><a href="../jadwal/jadwal_smp.php"><i class="fa fa-circle-o"></i>Jadwal SMP</a></li>
                    
                </ul>
            </li>
            
            <li>
                <a href="#">
                    <i class="fa fa-file"></i> <span>Cetak ID Card</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="cetak-idcard.php"><i class="fa fa-circle-o"></i> Cetak ID Card</a></li>
                </ul>
            </li>
            <?php
            $tampil = mysqli_query($koneksi, "select * from user order by user_id desc");
            $total = mysqli_num_rows($tampil);
            ?>
            <li>
                <a href="#">
                    <i class="fa fa-lock"></i> <span>User Management</span>
                    <small class="label pull-right bg-yellow"><?php echo $total; ?></small>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../admin/admin.php"><i class="fa fa-circle-o"></i> User Management</a></li>
                    
                </ul>
            </li>
            <!-- <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
              </ul>
            </li>-->
    </section>
    <!-- /.sidebar -->
</aside>