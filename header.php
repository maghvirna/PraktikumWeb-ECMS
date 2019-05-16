<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>E</b>CM</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>ECM</b> System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if ($_SESSION['privilege'] == "admin" ) {

                            $q_header = mysqli_query($koneksi, "select g.gambar from guru g inner join user u on u.user_id = g.user_id where kd_guru='" . $_SESSION['username'] . "'");
                            $header = mysqli_fetch_array($q_header);

                            if (mysqli_num_rows($q_header) > 0) {

                                $_SESSION['gambar'] = $header['gambar'];
                            } else {
                                echo("Gagal Mengambil query");
                            }
                            ?>
                            <img src="<?php echo $header['gambar']; ?>" class="user-image" style="border: 1px solid white;" alt="User Image">
                            <?php
                        } elseif ($_SESSION['privilege'] == "superuser") {

                            $q_header = mysqli_query($koneksi, "select s.gambar from staff s inner join user u on u.user_id = s.user_id where kd_staff='" . $_SESSION['username'] . "'");
                            $header = mysqli_fetch_array($q_header);
                            if (mysqli_num_rows($q_header) > 0) {
                                $_SESSION['gambar'] = $header['gambar'];
                            } else {
                                echo("Gagal Mengambil query");
                            }
                            ?>
                            <img src="<?php echo $header['gambar']; ?>" class="user-image" style="border: 1px solid white;" alt="User Image">
                            <?php
                        } elseif ($_SESSION['privilege'] == "user") {

                            $q_header = mysqli_query($koneksi, "select  m.gambar from murid m inner join user u on u.user_id = m.user_id where username='" . $_SESSION['username'] . "'");
                            $header = mysqli_fetch_array($q_header);

                            if (mysqli_num_rows($q_header) > 0) {
                                $_SESSION['gambar'] = $header['gambar'];
                            } else {
                                echo("Gagal Mengambil query");
                            }
                            ?>
                            <img src="<?php echo $header['gambar']; ?>" class="user-image" style="border: 1px solid white;" alt="User Image">
                            <?php
                        }
                       
                        ?>

                        <span class="hidden-xs"><?php echo $_SESSION['fullname']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                            if ($_SESSION['privilege'] == "admin") {

                                $q_header = mysqli_query($koneksi, "select g.gambar from guru g inner join user u on u.user_id = g.user_id where username='" . $_SESSION['username'] . "'");
                                $header = mysqli_fetch_array($q_header);

                                if (mysqli_num_rows($q_header) > 0) {

                                    $_SESSION['gambar'] = $header['gambar'];
                                } else {
                                    echo("Gagal Mengambil query");
                                }
                                ?>
                                <img src="<?php echo $header['gambar']; ?>" class="img-circle" alt="User Image">
                                <?php
                            } elseif ($_SESSION['privilege'] == "superuser") {

                                $q_header = mysqli_query($koneksi, "select s.gambar from staff s inner join user u on u.user_id = s.user_id where username='" . $_SESSION['username'] . "'");
                                $header = mysqli_fetch_array($q_header);
                                if (mysqli_num_rows($q_header) > 0) {
                                    $_SESSION['gambar'] = $header['gambar'];
                                } else {
                                    echo("Gagal Mengambil query");
                                }
                                ?>
                                <img src="<?php echo $header['gambar']; ?>" class="img-circle" alt="User Image">
                                <?php
                            } elseif ($_SESSION['privilege'] == "user") {

                                $q_header = mysqli_query($koneksi, "select  m.gambar from murid m inner join user u on u.user_id = m.user_id where username='" . $_SESSION['username'] . "'");
                                $header = mysqli_fetch_array($q_header);

                                if (mysqli_num_rows($q_header) > 0) {
                                    $_SESSION['gambar'] = $header['gambar'];
                                } else {
                                    echo("Gagal Mengambil query");
                                }
                                ?>
                                <img src="<?php echo $header['gambar']; ?>" class="img-circle" alt="User Image">
                                <?php
                            }
                            ?>         
                            <p>
                                <?php echo $_SESSION['fullname']; ?><br>
                                   <?php echo $_SESSION['privilege']; ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="produk.php">Produk</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Transaksi</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="supplier.php">Supplier</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="detail-admin.php?hal=edit&kd=<?php echo $_SESSION['user_id']; ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>

                            <div class="pull-right">
                                <a href="../logout.php" class="btn btn-default btn-flat" onclick="return confirm('Apakah Anda Akan Keluar.?');"> Keluar </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-spin fa-gear"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>