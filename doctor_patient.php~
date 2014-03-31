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
		<h1> Doctor and Patient</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
		Doctor ID:<input type="text" name="d_id"><br>
		Patient ID:<input type="text" name="p_id"><br>
		<input type="submit"><br>
		</form>
		
		<?php
			if($_SERVER["REQUEST_METHOD"] == "POST") {
				//get the data from post method
				$d_id = $_POST["d_id"];
				$p_id = $_POST["p_id"];
				
				$sql = "INSERT INTO family_doctor VALUES(:d_id, :p_id)";
				$conn = connect();
				
				$stid = oci_parse($conn, $sql);
				
				//binding process
				oci_bind_by_name($stid, ":d_id", $d_id);
				oci_bind_by_name($stid, ":p_id", $p_id);
				
				$r = oci_execute($stid);
				//check
				if (!$r) {    
   				$e = oci_error($stid);
   				echo htmlentities($e['message']);
    				trigger_error(htmlentities($e['message']), E_USER_ERROR);
				}
				else {
					echo "<hr><h2>Success!</h2>";	
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