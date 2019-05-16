<?php
include "../admin/koneksi.php";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'kd_staff',
    1 => 'nama_staff', 
	2 => 'alamat_staff',
    3 => 'no_hp',
    4 => 'gambar',

);

// getting total number records without any search
$sql = "SELECT kd_staff, nama_staff, alamat_staff, no_hp, gambar";
$sql.=" FROM staff";
$query=mysqli_query($conn, $sql) or die("ajax-grid-member.php: get staff");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT kd_staff, nama_staff, alamat_staff, no_hp, gambar";
	$sql.=" FROM staff";
	$sql.=" WHERE kd_staff LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR nama_staff LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR alamat_staff LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR no_hp LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR gambar LIKE '".$requestData['search']['value']."%' ";
    
	$query=mysqli_query($koneksi, $sql) or die("ajax-grid-member.php: get staff");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($conn, $sql) or die("ajax-grid-member.php: get staff"); // again run query with limit
	
} else {	

	$sql = "SELECT kd_staff, nama_staff, alamat_staff, no_hp, gambar";
	$sql.=" FROM staff";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($conn, $sql) or die("ajax-grid-member.php: get staff");   
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["kd_staff"];
    $nestedData[] = $row["nama_staff"];
	$nestedData[] = $row["alamat_staff"];
    $nestedData[] = $row["no_hp"];
    $nestedData[] = '<td><center>
                     <a href="detail-member.php?kds='.$row['kd_staff'].'"  data-toggle="tooltip" title="View Detail" class="btn btn-sm btn-success"> <i class="glyphicon glyphicon-search"></i> </a>
                     <a href="edit-member.php?kd_staff='.$row['kd_staff'].'"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i> </a>
                    <a href="member.php?aksi=delete&kd_staff='.$row['kd_staff'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus data '.$row['nama_staff'].'?\')" class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-trash"> </i> </a>
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
