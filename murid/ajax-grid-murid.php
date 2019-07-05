<?php

include "../admin/koneksi.php";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    0 => 'kd_murid',
    1 => 'nama_murid', 
    2 => 'kelas',
    3 => 'kategori_kelas',
    4 => 'alamat_murid',
    5 => 'no_hp'	
);

// getting total number records without any search
$sql = "SELECT kd_murid, nama_murid, kelas, kategori_kelas, alamat_murid, no_hp";
$sql.=" FROM murid";
$query=mysqli_query($conn, $sql) or die("ajax-grid-murid.php: get murid");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT kd_murid, nama_murid, kelas, kategori_kelas, alamat_murid, no_hp";
	$sql.=" FROM murid";
	$sql.=" WHERE kd_murid LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR nama_murid LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR kelas LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR kategori_kelas LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR alamat_murid LIKE '".$requestData['search']['value']."%' ";
        $sql.=" OR no_hp LIKE '".$requestData['search']['value']."%' ";
	$query=mysqli_query($conn, $sql) or die("ajax-grid-murid.php: get murid");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($conn, $sql) or die("ajax-grid-murid.php: get murid"); // again run query with limit
	
} else {	
        
	$sql = "SELECT kd_murid, nama_murid, kelas, kategori_kelas, alamat_murid, no_hp";
	$sql.=" FROM murid";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($conn, $sql) or die("ajax-grid-murid.php: get murid");   
	
}

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["kd_murid"];
        $nestedData[] = $row["nama_murid"];
	$nestedData[] = $row["kelas"];
        $nestedData[] = $row["kategori_kelas"];
        $nestedData[] = $row["alamat_murid"];
        $nestedData[] = $row["no_hp"];
    $nestedData[] = '<td><center>
                     <a href="detail-murid.php?id='.$row['kd_murid'].'"  data-toggle="tooltip" title="View Detail" class="btn btn-sm btn-success"> <i class="glyphicon glyphicon-search"></i> </a>
                     <a href="edit-murid.php?id='.$row['kd_murid'].'"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i> </a>
                  
                         
                       <a href="murid.php?aksi=delete&id='.$row['kd_murid'].'"  data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin akan menghapus data '.$row['nama_murid'].'?\')" class="btn btn-sm btn-danger"> <i class="glyphicon glyphicon-trash"> </i> </a>
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
