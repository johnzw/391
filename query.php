<?php
include("PHPconnectionDB.php");
?>

<?php
	function queryProcess($time_check, $test_type_check, $patient_check){
		$conn = connect();		
		if($time_check == "no") {
			if(isset($patient_check)) {
				if(isset($test_type_check)) {
					$sql = "select patient_id, persons.first_name, persons.last_name, test_type, amount
								from persons
								inner join
								(select patient_id, test_type, count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id, test_type)
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Test Type</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select patient_id, persons.first_name, persons.last_name, amount
								from persons
								inner join
								(select patient_id, count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id)
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}

				}	
			}
			else {
				if(isset($test_type_check)) {
					$sql = "select test_type, count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by test_type";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Test Type</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
			}
		}
		elseif($time_check == "week") {
			if(isset($patient_check)) {
				if(isset($test_type_check)) {
					$sql = "select patient_id, persons.first_name, persons.last_name, test_type, week, amount
								from persons
								inner join
								(select patient_id, test_type, to_char(test_date,'yyyy-ww') as week, count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id, test_type,to_char(test_date,'yyyy-ww'))
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Test Type</td><td>Week</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					
					$sql = "select patient_id, persons.first_name, persons.last_name, week,amount
								from persons
								inner join
								(select patient_id, to_char(test_date,'yyyy-ww') as week,count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id,to_char(test_date,'yyyy-ww'))
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Week</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}	
			}
			else {
				if(isset($test_type_check)) {
					$sql = "select test_type, to_char(test_date,'yyyy-ww'),count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by test_type, to_char(test_date,'yyyy-ww')";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Test Type</td><td>Week</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select to_char(test_date,'yyyy-ww'), count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by to_char(test_date,'yyyy-ww')";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Week</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
			}
			
		}
		elseif($time_check == "month") {
			if(isset($patient_check)) {
				if(isset($test_type_check)) {
					$sql = "select patient_id, persons.first_name, persons.last_name, test_type, month, amount
								from persons
								inner join
								(select patient_id, test_type, to_char(test_date,'yyyy-mm') as month, count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id, test_type,to_char(test_date,'yyyy-mm'))
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Test Type</td><td>Month</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select patient_id, persons.first_name, persons.last_name, month,amount
								from persons
								inner join
								(select patient_id, to_char(test_date,'yyyy-mm') as month,count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id,to_char(test_date,'yyyy-mm'))
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Month</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}	
			}
			else {
				if(isset($test_type_check)) {
					$sql = "select test_type, to_char(test_date,'yyyy-mm'),count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by test_type, to_char(test_date,'yyyy-mm')";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Test Type</td><td>Month</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select to_char(test_date,'yyyy-mm'), count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by to_char(test_date,'yyyy-mm')";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Month</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
			}
			
		}
		elseif($time_check == "year") {
			if(isset($patient_check)) {
				if(isset($test_type_check)) {
					$sql = "select patient_id, persons.first_name, persons.last_name, test_type, year, amount
								from persons
								inner join
								(select patient_id, test_type, to_char(test_date,'yyyy') as year, count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id, test_type,to_char(test_date,'yyyy'))
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Test Type</td><td>Year</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select patient_id, persons.first_name, persons.last_name, year,amount
								from persons
								inner join
								(select patient_id, to_char(test_date,'yyyy') as year,count(image_id) as amount
								from ((radiology_record 
								right join (select person_id from users where class ='p') on 1 = 1)
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by patient_id,to_char(test_date,'yyyy'))
								on person_id = patient_id";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Person ID</td><td>First Name</td><td>Last Name</td><td>Year</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}	
			}
			else {
				if(isset($test_type_check)) {
					$sql = "select test_type, to_char(test_date,'yyyy'),count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by test_type, to_char(test_date,'yyyy')";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Test Type</td><td>Year</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
				else {
					$sql = "select to_char(test_date,'yyyy'),count(image_id) as amount
								from (radiology_record
								left join
								pacs_images
								on radiology_record.record_id= pacs_images.record_id)
								group by to_char(test_date,'yyyy')";
					$stid = oci_parse($conn, $sql);
					
					$r = oci_execute($stid);
					//check
					if (!$r) {    
   					$e = oci_error($stid);
    					trigger_error(htmlentities($e['message']), E_USER_ERROR);
					}
					$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
					if($nrows>0) {
						echo "<table border = '1'>";
						echo "<tr><td>Year</td><td>Number of Images</td></tr>";
						foreach($res as $row){
							echo "<tr>";
							foreach($row as $item){
								echo "<td>".$item."</td>";
							}
							echo "</tr>";						
						}
						echo "</table>";					
					}
					else{
						echo "<h2>No Result</h2>"; 	
					}
				}
			}
		}
		
		oci_close($conn);
	}
?>
