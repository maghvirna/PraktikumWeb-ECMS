<?php
include "../admin/koneksi.php";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'kd_guru',
    1 => 'nama_guru', 
	2 => 'alamat_guru',
	3 => 'no_hp',
        4 => 'gambar',
	
);

// getting total number records without any search
$sql = "SELECT kd_guru, nama_guru, alamat_guru, no_hp, gambar";
$sql.=" FROM guru";
$query=mysqli_query($conn, $sql) or die("ajax-grid-guru.php: get guru");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT kd_guru, nama_guru, alamat_guru, no_hp, gambar";
	$sql.=" FROM guru";
	$sql.=" WHERE kd_guru LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR nama_guru LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR alamat_guru LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR no_hp LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR gambar LIKE '".$requestData['search']['value']."%' ";
    
	$query=mysqli_query($conn, $sql) or die("ajax-grid-guru.php: get guru");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($conn, $sql) or die("ajax-grid-guru.php: get guru"); // again run query with limit
	
} else {	

	$sql = "SELECT kd_guru, nama_guru, alamat_guru, no_hp, gambar";
	$sql.=" FROM guru";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($conn, $sql) or die("ajax-grid-guru.php: get guru");   
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["kd_guru"];
    $nestedData[] = $row["nama_guru"];
	$nestedData[] = $row["alamat_guru"];
	$nestedData[] = $row["no_hp"];  
    $nestedData[] = '<td><center>
                     <a href="../guru/detail-guru.php?id='.$row['kd_guru'].'"  data-toggle="tooltip" title="View Detail" class="btn btn-sm btn-success"> <i class="glyphicon glyphicon-search"></i> </a>
                     <a href="../guru/edit-guru.php?id='.$row['kd_guru'].'"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i> </a>
                    <a href="guru.php?aksi=delete&kd_guru='.$row['kd_guru'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus data '.$row['nama_guru'].'?\')" class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-trash"> </i> </a>
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
