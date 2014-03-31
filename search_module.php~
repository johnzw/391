<?php
include("PHPconnectionDB.php");
?>

<html>
	<center>
	<h1>Advanced Search</h1>
		<form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Key Words1: </label><input type="text" name="key1"> 
			in <select name="select1" form = "form"> 
				<option value="test_type">Test Type</option>
				<option value="diagnosis">Diagnosis</option>
				<option value="description">Description</option>
			</select><br>
		<label>Key Words2: </label><input type="text" name="key2"> 
			in <select name="select2" form ="form"> 
				<option value="test_type">Test Type</option>
				<option value="diagnosis">Diagnosis</option>
				<option value="description">Description</option>
			</select><br>
		
		<label>Key Words3: </label><input type="text" name="key3"> 
			in <select name="select3" form="form"> 
				<option value="test_type">Test Type</option>
				<option value="diagnosis">Diagnosis</option>
				<option value="description">Description</option>
			</select><br><br>
			
		<label>Start Date: </label><input type="date" name="start_date">
		<label>End Date: </label><input type="date" name="end_date"><br>
		most-recent-first<input type="radio" name="rank" value="first">
		most-recent-last<input type="radio" name="rank" value="last">		
		<input type="submit" value="Search">
		
		</form>
		
		<?php
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				echo "<hr>";
				$key1= $_POST["key1"];
				$select1 = $_POST["select1"];
				
				$key2= $_POST["key2"];
				$select2 = $_POST["select2"];
				
				$key3= $_POST["key3"];
				$select3 = $_POST["select3"];
				
				$start_date = $_POST["start_date"];
				$end_date = $_POST["end_date"];
				$option = $_POST["rank"];
				
				$key1 = trim($key1);
				$key2 = trim($key2);
				$key3 = trim($key3);
				
				//little processing to these key words so that it suffice for query
				if($key1){
					$key1 = "%".$key1."%";
				}
				else {
					$key1='';
				}
				if($key2){
					$key2 = "%".$key2."%";
				}
				else {
					$key2 ='';
				}
				if($key3){
					$key3 = "%".$key3."%";
				}
				else {
					$key3='';
				}
				
				//need cookie here to set the class and person_id
				$class = $_COOKIE["class"];
				$person_id = $_COOKIE["id"];
				
				//check for authentication, based on different class, it has different query
				if ($class == 'a'){
					$original_sql = " select *
							from radiology_record
							where test_date>= to_date(:start_date,'yyyy-mm-dd')
							and test_date<=to_date(:end_date, 'yyyy-mm-dd')
							and (LOWER(".$select1.") like LOWER(:key1) or LOWER(".$select2.") like LOWER(:key2)
							or LOWER(".$select3.") like LOWER(:key3))";
				}
				elseif($class == 'd') {
					$original_sql = " select *
							from radiology_record
							where test_date>= to_date(:start_date,'yyyy-mm-dd')
							and patient_id in ( select patient_id from family_doctor where doctor_id =".$person_id.")
							and test_date<=to_date(:end_date, 'yyyy-mm-dd')
							and (LOWER(".$select1.") like LOWER(:key1) or LOWER(".$select2.") like LOWER(:key2)
							or LOWER(".$select3.") like LOWER(:key3))";
				}
				elseif($class == 'r') {
					$original_sql = " select *
							from radiology_record
							where test_date>= to_date(:start_date,'yyyy-mm-dd')
							and radiologist_id=".$person_id."
							and test_date<=to_date(:end_date, 'yyyy-mm-dd')
							and (LOWER(".$select1.") like LOWER(:key1) or LOWER(".$select2.") like LOWER(:key2)
							or LOWER(".$select3.") like LOWER(:key3))";
				}
				elseif($class == 'p'){
					$original_sql = " select *
							from radiology_record
							where test_date>= to_date(:start_date,'yyyy-mm-dd')
							and patient_id=".$person_id."
							and test_date<=to_date(:end_date, 'yyyy-mm-dd')
							and (LOWER(".$select1.") like LOWER(:key1) or LOWER(".$select2.") like LOWER(:key2)
							or LOWER(".$select3.") like LOWER(:key3))";
				}
				else {
					header("Location: index.html");	
				}	
							
				
				$conn = connect();
				
				//how user want to rank the result
				if($option == "first"){
					$sql = $original_sql." order by test_date DESC";
				}
				elseif($option == "last") {
					$sql = $original_sql." order by test_date";
				}
				else {
					//remember to change this 
					$sql = $original_sql." order by test_date DESC";
				}
				
				$stid = oci_parse($conn, $sql);
				
				oci_bind_by_name($stid, ":start_date", $start_date);
				oci_bind_by_name($stid, ":end_date", $end_date);
				oci_bind_by_name($stid, ":key1", $key1);
				oci_bind_by_name($stid, ":key2", $key2);
				oci_bind_by_name($stid, ":key3", $key3);
				
				$r = oci_execute($stid);
				//check if there is error
				if (!$r) {    
   				$e = oci_error($stid);
    				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				}
				
				$nrows = oci_fetch_all($stid, $res,null,null,OCI_FETCHSTATEMENT_BY_ROW);
				
				oci_free_statement($stid);
				oci_close($conn);
				
				if($nrows>0) {
					echo "<table border = '1'>";
					echo "<tr><td>Record ID</td><td>Patient ID</td> <td>Doctor ID</td>";
					echo "<td>Radiologist ID</td><td>Test Type</td><td>Prescribing Date</td>";
					echo "<td>Test Date</td><td>Diagnosis</td><td>Description</td><td>Images</td></tr>";
					foreach($res as $row){
						echo "<tr>";
						$r_id = $row['RECORD_ID'];
						foreach($row as $item){
							echo "<td>".$item."</td>";
						}
						displayImg($r_id);
						echo "</tr>";						
					}
					echo "</table>";					
				}
				else{
					echo "<h2>No Result</h2>";
				}
				
				
				
			}
		
		
		?>
	</center>
</html>

<?php
function displayImg($r_id) {
	//connect to oracle
	$conn = connect();
	//quite useless here
	//sql command
	$sql = "SELECT image_id, thumbnail
				FROM pacs_images
				where record_id =".$r_id;
	
	$parse = oci_parse($conn, $sql);
	
	oci_execute($parse, OCI_DEFAULT);
	echo "<td>";
	while(($row = oci_fetch_assoc($parse))!=false){
		$lob = $row['THUMBNAIL']->load();
		$image = imagecreatefromstring($lob);
		ob_start(); //You could also just output the $image via header() and bypass this buffer capture.
		imagejpeg($image, null, 90);
		$data = ob_get_contents();
		ob_end_clean();
		echo '<a href="displayImg.php?image_id='.$row['IMAGE_ID'].'">';
		echo '<img src="data:image/jpg;base64,' .  base64_encode($data)  . '" />';
		echo '</a>';
	}
	echo "</td>";
	//echo $lob;
	oci_free_statement($parse);
   oci_close($conn); // log off	
   	
}
?>
<?php
//set back button
$class = $_COOKIE["class"];
if ($class == 'a'){
	$link = "admin.html";				
}
elseif($class == 'd') {
	$link = "doc.html";					
}
elseif($class == 'r') {
	$link = "radio.html";
}
elseif($class == 'p'){
	$link = "patient.html";
}
else {
	header("Location: index.html");	
}	

echo '<div style="position: absolute; top: 0; right: 10; width: 100px; text-align:right;">
        <h4><a href = "'.$link.'">Back To Panel</a><h4>
    </div>';
?>