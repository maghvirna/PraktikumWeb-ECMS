<?php

session_start();
include ("conn.php");
date_default_timezone_set('Asia/Jakarta');

$username = $_POST['username'];
$password = $_POST['password'];

//$username = mysqli_real_escape_string($username);
//$password = mysqli_real_escape_string($password);

if (empty($username) && empty($password)) {
    header('location:index.php?error1');
} else if (empty($username)) {
    header('location:index.php?error=2');
} else if (empty($password)) {
    header('location:index.php?error=3');
}

$q = mysqli_query($koneksi, "select * from user where username= '$username' and password='$password'");
$row = mysqli_fetch_array($q);

if (mysqli_num_rows($q) == 1) {
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['privilege'] = $row['privilege'];
    $_SESSION['gambar_user'] = $row['gambar_user'];
    
    if ($row['privilege'] == "superuser") {
        header("location:member/d_member.php");
		

    }
    elseif ($row['privilege'] == "admin") {
        header("location:guru/d_guru.php"); 
    }
    elseif ($row['privilege'] == "user") {
        header("location:murid/d_murid.php"); 
    }
    
}else {
    header('location:index.php?error=4');
}
?>