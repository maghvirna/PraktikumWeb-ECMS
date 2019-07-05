<?php
include "../admin/koneksi.php";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'kd_jadwal',
	1 => 'nama_pelajaran',
    2 => 'nama_guru',
    3 => 'kategori_kelas', 
    4 => 'hari',
    5 => 'tanggal',
	6 => 'jam_mulai',
    7 => 'jam_selesai',
	8 => 'nama_ruang',

);

// getting total number records without any search
$sql = "select kd_jadwal, nama_pelajaran, nama_guru, kategori_kelas, hari, tanggal, jam_mulai, jam_selesai, nama_ruang ";
$sql.="from jadwal WHERE kategori_kelas='SMP'";
$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal-smp.php: get jadwal_smp");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "select kd_jadwal, nama_pelajaran, nama_guru, kategori_kelas, hari, tanggal, jam_mulai, jam_selesai, nama_ruang ";
$sql.="from jadwal WHERE kategori_kelas='SMP'";

	$sql.=" OR p.nama_pelajaran LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR g.nama_guru LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR j.kategori_kelas LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR j.hari LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR j.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR j.jam_mulai LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR j.jam_selesai LIKE '".$requestData['search']['value']."%' ";
	 $sql.=" OR r.nama_ruang LIKE '".$requestData['search']['value']."%' ";
      
	  
	$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal-smp.php: get jadwal_smp");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	
	$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal-smp.php: get jadwal_smp"); // again run query with limit
	
} else {	

	$sql = "select kd_jadwal, nama_pelajaran, nama_guru, kategori_kelas, hari, tanggal, jam_mulai, jam_selesai, nama_ruang, ";
$sql.="if(tanggal = curdate(),  'benar', 'salah') as hariini,if(tanggal >= curdate(), 'benar', 'salah') as besok, if(jam_selesai >= curtime(), 'benar', 'salah') as jam from jadwal WHERE kategori_kelas='SMP'";

	$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal-smp.php: get jadwal_smp");   
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	if ($row['hariini'] == "benar") {
		if ($row['jam'] == "benar") {

	$nestedData=array(); 
	
	$nestedData[] = $row["nama_pelajaran"];
    $nestedData[] = $row["nama_guru"];
    $nestedData[] = $row["kategori_kelas"];
    $nestedData[] = $row["hari"];
    $nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam_mulai"];
    $nestedData[] = $row["jam_selesai"];
    $nestedData[] = $row["nama_ruang"];
    $nestedData[] = $row["hariini"];
    $nestedData[] = $row["besok"];
    $nestedData[] = $row["jam"];   
	
	$data[] = $nestedData;
    

}
} elseif ($row['besok'] == "benar") {
	if ($row['jam'] == "benar" || $row['jam'] == "salah") {
    $nestedData=array(); 
	
	$nestedData[] = $row["nama_pelajaran"];
    $nestedData[] = $row["nama_guru"];
    $nestedData[] = $row["kategori_kelas"];
    $nestedData[] = $row["hari"];
    $nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam_mulai"];
    $nestedData[] = $row["jam_selesai"];
    $nestedData[] = $row["nama_ruang"];
    $nestedData[] = $row["hariini"];
    $nestedData[] = $row["besok"];
    $nestedData[] = $row["jam"];      
	
	$data[] = $nestedData;
}
}
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
