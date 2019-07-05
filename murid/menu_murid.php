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
                if ($_SESSION['privilege'] == "user_smp") {

                    $qu_smp = mysqli_query($koneksi, "select u.username, m.gambar from murid m inner join user u on u.user_id = m.user_id where u.username='" . $_SESSION['username'] . "'");
                    $row_akun_smp = mysqli_fetch_array($qu_smp);

                    if (mysqli_num_rows($qu_smp) > 0) {
                        $_SESSION['gambar'] = $row_akun_smp['gambar'];
                    } else {
                        echo("Gagal Mengambil query");
                    }
                    ?>
                    <img src="<?php echo $row_akun_smp['gambar']; ?>" height="200" width="200" style="border: 2px solid white;" class="img-circle" alt="User Image">
                    <?php

                } elseif ($_SESSION['privilege'] == "user_sd") {

                    $qu = mysqli_query($koneksi, "select u.username, m.gambar from murid m inner join user u on u.user_id = m.user_id where u.username='" . $_SESSION['username'] . "'");
                    $row_akun = mysqli_fetch_array($qu);

                    if (mysqli_num_rows($qu) > 0) {
                        $_SESSION['gambar'] = $row_akun['gambar'];
                    } else {
                        echo("Gagal Mengambil query");
                    }
                    ?>
                    <img src="<?php echo $row_akun['gambar']; ?>" height="200" width="200" style="border: 2px solid white;" class="img-circle" alt="User Image">
                <?php } ?>

            </div>
            <?php
            if ($_SESSION['privilege'] == "user_smp") {
                ?>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['fullname']; ?></p>
                    <a><i class="fa fa-circle text-success"></i> Online</a>
                    <h5 id="timestampss"></h5>
                </div>
            </div><br />
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">

                <li class="header">MENU UTAMA</li>
                <li class="active treeview">
                    <a href="../murid/d_murid_smp.php">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <?php
            } else {
                ?>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['fullname']; ?></p>
                    <a href="../admin/index.php"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div><br />
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                
                <li class="header">MENU UTAMA</li>
                <li class="active treeview">
                    <a href="../murid/d_murid_smp.php">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i> <span>Profil</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../murid/detail-murid.php"><i class="fa fa-circle-o"></i>View Profil</a></li>
                    <li><a href="../murid/edit-murid.php"><i class="fa fa-circle-o"></i> Edit Profil</a></li>

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