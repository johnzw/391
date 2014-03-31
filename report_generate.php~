<?php
include("PHPconnectionDB.php");
?>
<?php

//if the user is not admin, then redirect to home page
if(empty($_COOKIE['class'])){
	header("Location:index.html");	
}
elseif($_COOKIE['class']!='a') {
	header("Location:index.html");	
}

?>

<html>
	<center>
		<br>
		<h1>Report Generating</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Diagnosis: </label><input type="text" name="diagnosis"><br><br>
		<label>Start Date: </label><input type="date" name="start_date"><br>
		<label>End Date: </label><input type="date" name="end_date"><br><br>
		<input type="submit" value="Generate"><br>
		</form>
		
		
		
		<?php
			//collect the data
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				echo "<hr>";
				$diagnosis = $_POST["diagnosis"];
				$start_date = $_POST["start_date"];
				$end_date = $_POST["end_date"];
				
				//do some special things to diagnosis
				$diagnosis = trim($diagnosis);
				
				echo "Diagnosis you search: ".$diagnosis."<br>from ".$start_date." to ".$end_date."<br>";
				
				//fetch the data from data base
				$conn = connect();
				$sql = "select persons.first_name, persons.last_name,
							persons.address, persons.phone, test_date
							from persons
							inner join
							(select patient_id, MIN(test_date) as test_date
							from radiology_record
							where diagnosis like :pattern and test_date>= to_date(:start_date,'yyyy-mm-dd')
							and test_date<=to_date(:end_date, 'yyyy-mm-dd')
							group by patient_id)
							on persons.person_id=patient_id";
							
				$stid = oci_parse($conn, $sql);
				
				$diagnosis = "%".$diagnosis."%";
				oci_bind_by_name($stid, ":pattern", $diagnosis);
				oci_bind_by_name($stid, ":start_date", $start_date);
				oci_bind_by_name($stid, ":end_date", $end_date);
				
				$r = oci_execute($stid);
				//check
				if (!$r) {    
   				$e = oci_error($stid);
    				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				}
				$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
				if($nrows>0) {
					echo "<table border = '1'>";
					echo "<tr><td>First Name</td><td>Last Name</td> <td>Address</td> <td>Phone</td><td>Test Date</td></tr>";
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
				
				oci_free_statement($stid);
				oci_close($conn);
			}				
		?>
	</center>
</html>

<?php
//set back button
echo '<div style="position: absolute; top: 0; right: 10; width: 100px; text-align:right;">
        <h4><a href = "admin.html">Back To Panel</a><h4>
    </div>';
?>