<?php

include("query.php");
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
		<h1> Data Analysis</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">	
			Patient<input type="checkbox" name="patient_check"><br>
			Test Type<input type="checkbox" name="test_type_check"><br>
			No<input type="radio" name="time_check" value="no" checked>
			Weekly<input type="radio" name="time_check" value="week">
			Monthly<input type="radio" name="time_check" value="month">
			Yearly<input type="radio" name="time_check" value="year"><br>
			<input type="submit" value="Go">
		</form>
		
		<?php
			
			//collect the data from post
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				echo "<hr>";
				
				//collect the setting from user
				$patient_check = $_POST["patient_check"];
				$test_type_check = $_POST["test_type_check"];
				$time_check = $_POST["time_check"];
				
				queryProcess($time_check, $test_type_check, $patient_check);
				
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

