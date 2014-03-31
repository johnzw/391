<?php
include("PHPconnectionDB.php");
?>

<?php
//well, long list of parameters..
function insertRecord($patient_id, $doctor_id, $radiologist_id, $test_type,
                       $p_date, $t_date, $diagnosis, $description) {
	
	$conn = connect();
	
	$insertSql = "INSERT INTO 
						RADIOLOGY_RECORD
						(patient_id, doctor_id, radiologist_id, test_type,
						prescribing_date, test_date, diagnosis, description
						)
						VALUES
						(:patient_id_bv, :doctor_id_bv, :radiologist_id_bv, :test_type_bv,
						TO_DATE(:prescribing_date_bv, 'YYYY-MM-DD'), TO_DATE(:test_date_bv, 'YYYY-MM-DD'),
						:diagnosis_bv, :description_bv)";
	
	$stid = oci_parse($conn, $insertSql);
	
	//binding process
	oci_bind_by_name($stid, ":patient_id_bv", $patient_id);

	oci_bind_by_name($stid, ":doctor_id_bv", $doctor_id);

	oci_bind_by_name($stid, ":radiologist_id_bv", $radiologist_id);

	oci_bind_by_name($stid, ":test_type_bv", $test_type);

	//$p_date = "TO_DATE('".$p_date."', 'YYYY-MM-DD')";
	oci_bind_by_name($stid, ":prescribing_date_bv", $p_date);

	//$t_date = "TO_DATE('".$t_date."', 'YYYY-MM-DD')";
	oci_bind_by_name($stid, ":test_date_bv", $t_date);

	oci_bind_by_name($stid, ":diagnosis_bv", $diagnosis);

	oci_bind_by_name($stid, ":description_bv", $description);

	
	$res = oci_execute($stid, OCI_NO_AUTO_COMMIT);
	//checking for error
	if (!$res) {
		$err = oci_error($stid); 
		echo htmlentities($err['message']);
		trigger_error(htmlentities($err['message']), E_USER_ERROR);
	}

	//select the record id of this record
	$stid = oci_parse($conn, "SELECT max(RECORD_ID) FROM RADIOLOGY_RECORD");
	$res = oci_execute($stid, OCI_NO_AUTO_COMMIT);

	//checking for error
	if (!$res) {    
    	$err = oci_error($stid);
    	oci_rollback($conn);  // rollback changes to both tables
    	echo htmlentities($err['message']);
    	trigger_error(htmlentities($err['message']), E_USER_ERROR);
	}

	$record_id = oci_fetch_row($stid);
	
	// Commit the changes to both tables
	$res = oci_commit($conn);
	if (!$res) {
    	$err = oci_error($conn);
    	echo htmlentities($err['message']);
    	trigger_error(htmlentities($err['message']), E_USER_ERROR);
	}

	oci_free_statement($stid);
	oci_close($conn);
	
	return $record_id[0];
}

function insertIMG($record_id, $image_id, $lob_date_a,$lob_date_b,$lob_date_c){
	//connect to oracle
	
	$conn=connect();

	$sql = "INSERT INTO 
			   pacs_images
        		VALUES
        		(:record_id,:image_id ,EMPTY_BLOB(),EMPTY_BLOB(),EMPTY_BLOB())
        		returning 
        		thumbnail,regular_size,full_size into :LOB_T,:LOB_R,:LOB_F";

    $parse_sql = oci_parse($conn, $sql);

    //create empty lob descriptor
    $lob_a = oci_new_descriptor($conn, OCI_D_LOB);
    $lob_b = oci_new_descriptor($conn, OCI_D_LOB);
    $lob_c = oci_new_descriptor($conn, OCI_D_LOB);
	
    // bind the sql variable to php variable
	oci_bind_by_name($parse_sql, ":record_id", $record_id);
	oci_bind_by_name($parse_sql, ":image_id", $image_id);
	
	// bind the LOB fields
	oci_bind_by_name($parse_sql, ':LOB_T', $lob_a, -1, OCI_B_BLOB);
	oci_bind_by_name($parse_sql, ':LOB_R', $lob_b, -1, OCI_B_BLOB);
	oci_bind_by_name($parse_sql, ':LOB_F', $lob_c, -1, OCI_B_BLOB);
	
	if(!oci_execute($parse_sql, OCI_DEFAULT)) {
  		$e = error_get_last();
 		$f = oci_error();
  		echo "Message: ".$e['message']."\n";
  		echo "File: ".$e['file']."\n";
  		echo "Line: ".$e['line']."\n";
  		echo "Oracle Message: ".$f['message'];

  		// exit if you consider this fatal
  		//And I have not idea why exit(9)  		
  		exit(9);
	} else {
 		
  		// save the blob data
  		$lob_a->save($lob_date_a);
  		$lob_b->save($lob_date_b);
  		$lob_c->savefile($lob_date_c);
  		// commit the query
  		oci_commit($conn);
  		
  		//just to test if it commits
  		// free up the blob descriptors
  		
  		oci_free_statement($parse_sql);
  		$lob_a->free();
  		$lob_b->free();
  		$lob_c->free();
 
	}
	
	oci_free_statement($parse_sql);
	oci_close($conn);
}
?>
