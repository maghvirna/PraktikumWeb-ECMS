<?php
include "../admin/koneksi.php";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'nama_pelajaran',
    1 => 'nama_guru', 
	2 => 'jam_mulai',
    3 => 'jam_selesai',
	4 => 'nama_ruang',

);

// getting total number records without any search
$sql = "select nama_pelajaran, nama_guru, jam_mulai, jam_selesai, nama_ruang, kategori_kelas ";
$sql.="  from jadwal WHERE kategori_kelas ='SMP' ";
$query=mysqli_query($conn, $sql) or die("ajax-grid-d_siswa.php: get d_siswa");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "select nama_pelajaran, nama_guru, jam_mulai, jam_selesai, nama_ruang, kategori_kelas ";
	$sql.="  from jadwal WHERE kategori_kelas ='SMP' ";
	$sql.=" OR p.nama_pelajaran LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR g.nama_guru LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR j.jam_mulai LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR j.jam_selesai LIKE '".$requestData['search']['value']."%' ";
	 $sql.=" OR r.nama_ruang LIKE '".$requestData['search']['value']."%' ";
      
	  
	$query=mysqli_query($conn, $sql) or die("ajax-grid-d_siswa.php: get d_siswa");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	
	$query=mysqli_query($conn, $sql) or die("ajax-grid-d_siswa.php: get d_siswa"); // again run query with limit
	
} else {	

	$sql = "select nama_pelajaran, nama_guru, jam_mulai, jam_selesai, nama_ruang, kategori_kelas ";
	$sql.="  from jadwal WHERE kategori_kelas ='SMP' ";
	$query=mysqli_query($conn, $sql) or die("ajax-grid-d_siswa.php: get d_siswa");   
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nama_pelajaran"];
    $nestedData[] = $row["nama_guru"];
	$nestedData[] = $row["jam_mulai"];
    $nestedData[] = $row["jam_selesai"];
      $nestedData[] = $row["nama_ruang"];
	
	$data[] = $nestedData;
    
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
