<?php
include("../conn.php");
 session_start();
if(empty($_SESSION)){
	header("Location: ../index.php");
}  
?>

 
			<?php
		 			 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=karyawan.xls");
 
// Tampilkan isi table
			# fungsi ubah tanggal 
						/** function rubah_tanggal($tgl)
						 {
						 $exp = explode('-',$tgl);
						 if(count($exp) == 3)
						 {
						 $tgl = $exp[2].'-'.$exp[1].'-'.$exp[0];
						 }
						 return $tgl;
						 }
			 $plantname = $_GET['toxls'];
			 $date1	= rubah_tanggal($_GET['date1']);
			 $date2	= rubah_tanggal($_GET['date2']);**/
							 
			$sqlshow = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nik ASC
																  
												"); 
										
		
			?>
	  
 
	<h3>Data Karyawan Kontrak PT. Tsuchiya Manufacturing Indonesia</h3>
	  
	<!-- <table>
	
			<tr>
			 <td width="0px">Plant :</td>  <td><?php //echo $plantname ?></td> 
			 <td width="0px">From : <?php //echo date("d-m-Y",strtotime($_GET['date1'])) ?></td>  
			 <td width="0px">Until : <?php //echo date("d-m-Y",strtotime($_GET['date2'])) ?></td> 
			 
		 </tr>
	</table>-->	
    <table>
	
			<tr>
			
			 <td width="0px">Tanggal : <?php echo date("d-m-Y") ?></td>  
			 
			 
		 </tr>
	</table>	
		 
		<table bordered="1">  
			<thead bgcolor="eeeeee" align="center">
			<tr bgcolor="eeeeee" >
	           <th>Nik</th>
			   <th>Nama</th>
			   <th>Bagian</th>
			   <th>K1 Join</th>
               <th>K1 Finish</th>
               <th>K2 Join</th>
               <th>K2 Finish</th>
               <th>Status</th>
			  </tr>
			</thead>
			<tbody>
	 	
					
		</tbody>

		</div>
    </div>
</div>
   <?php
						
						//if (isset($_POST['show'])) {
							$rowshow = mysqli_fetch_assoc($sqlshow);
							  
								$nomor=0;
							while($rowshow = mysqli_fetch_assoc($sqlshow)){					 
                                 $nomor++;
								echo '<tr>';
                                //echo '<td>'.$nomor.'</td>';
								echo '<td>'.$rowshow['nik'].'</td>';
								echo '<td>'.$rowshow['nama'].'</td>';
       	                        echo '<td>'.$rowshow['bagian'].'</td>';
                                echo '<td>'.$rowshow['k1_join'].'</td>';
                                echo '<td>'.$rowshow['k1_finish'].'</td>';
                                echo '<td>'.$rowshow['k2_join'].'</td>';
                                echo '<td>'.$rowshow['k2_finish'].'</td>';
                                echo '<td>'.$rowshow['status'].'</td>';
								echo '</tr>';
							}
						 
								 
							
					//	}			//EOF IF				
					 ?>
  </table>   
 
   