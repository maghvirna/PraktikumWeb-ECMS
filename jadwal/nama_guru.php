<?php
include "../conn.php";

$mapel = $_POST['mapel'];

$auto_guru = mysqli_query($koneksi, "SELECT kd_guru, nama_guru, kd_pelajaran, nama_pelajaran FROM pelajaran where nama_pelajaran = '$mapel' ");?>


<option value="">-- Pilih Guru Baru --</option> ';
<?php while ($data_guru = mysqli_fetch_array($auto_guru)){

	echo '<option value="' . $data_guru['nama_guru'] . '">' . $data_guru['nama_guru'] . '</option>';
}
	?>