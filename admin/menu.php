<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $_SESSION['gambar']; ?>" height="200" width="200" style="border: 2px solid white;" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['fullname']; ?></p>
              <a href="index.php"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div><br />
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENU UTAMA</li>
            <li class="active treeview">
              <a href="index.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>

            
            <li>
              <a href="#">
                <i class="fa fa-user"></i> <span>Staff</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="member.php"><i class="fa fa-circle-o"></i>Data Staff</a></li>
                <li><a href="input-member.php"><i class="fa fa-circle-o"></i> Input Staff</a></li>
         
              </ul>
                
            </li>
            <li>
              <a href="#">
                <i class="fa fa-user"></i> <span>Guru</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="guru.php"><i class="fa fa-circle-o"></i>Data Guru</a></li>
                <li><a href="input-member.php"><i class="fa fa-circle-o"></i> Input Guru</a></li>
               
              </ul>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-user"></i> <span>Murid</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="murid.php"><i class="fa fa-circle-o"></i>Data Murid</a></li>
                <li><a href="input-member.php"><i class="fa fa-circle-o"></i> Input Murid</a></li>
                
                
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
            <?php $tampil=mysqli_query($koneksi, "select * from user order by user_id desc");
                        $total=mysqli_num_rows($tampil);
                    ?>
            <li>
              <a href="#">
                <i class="fa fa-lock"></i> <span>Admin</span>
                <small class="label pull-right bg-yellow"><?php echo $total; ?></small>
              </a>
               <ul class="treeview-menu">
                <li><a href="admin.php"><i class="fa fa-circle-o"></i> Admin</a></li>
                <li><a href="input-admin.php"><i class="fa fa-circle-o"></i> Tambah Admin</a></li>
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