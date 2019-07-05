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
$sql.= "from jadwal";
$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal.php: get jadwal");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "select kd_jadwal, nama_pelajaran, nama_guru, kategori_kelas, hari, tanggal, jam_mulai, jam_selesai, nama_ruang from jadwal";
	$sql.=" WHERE nama_pelajaran LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR nama_guru LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR kategori_kelas LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR hari LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jam_mulai LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR jam_selesai LIKE '".$requestData['search']['value']."%' ";
	 $sql.=" OR nama_ruang LIKE '".$requestData['search']['value']."%' ";
      
	  
	$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal.php: get jadwal");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	
	$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal.php: get jadwal"); // again run query with limit
	
} else 
	

	$sql = "select kd_jadwal, nama_pelajaran, nama_guru, kategori_kelas, hari, tanggal, jam_mulai, jam_selesai, nama_ruang ";
$sql.= "from jadwal";
	$query=mysqli_query($conn, $sql) or die("ajax-grid-jadwal.php: get jadwal");   
	

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	
	$nestedData[] = $row["nama_pelajaran"];
    $nestedData[] = $row["nama_guru"];
    $nestedData[] = $row["kategori_kelas"];
    $nestedData[] = $row["hari"];
    $nestedData[] = $row["tanggal"];
    $nestedData[] = $row["jam_mulai"];
    $nestedData[] = $row["jam_selesai"];
    $nestedData[] = $row["nama_ruang"];
       $nestedData[] = '<td><center>
                    
                     <a href="edit-jadwal.php?id='.$row['kd_jadwal'].'"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i> </a>
                  
                         
                       <a href="jadwal.php?aksi=delete&id='.$row['kd_jadwal'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus data '.$row['kd_jadwal'].'?\')" class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-trash"> </i> </a>
	                 </center></td>';		
	
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
