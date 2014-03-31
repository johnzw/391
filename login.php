<!doctype html>
<?php
include("PHPconnectionDB.php");
?>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
</head>
<body>
<?php
	if (isset($_POST['validate'])) {
		//collect the information from POST
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$conn = connect();
		//doing the query, check if username and password are in the database
		$sql = "select person_id, class from users where user_name = '".$username."' and password = '".$password."'";
		$stmt = oci_parse($conn, $sql);
		oci_execute($stmt);
        
			if(($row = oci_fetch_row($stmt)) == true) {
			
				$id = $row[0];
				$class = $row[1];
				
				//set cookie for users, so that they could get into the system with certain informatino
				setcookie("user", "$username", time()+7200);
				setcookie("id", "$id", time()+7200);
				setcookie("class", "$class", time()+7200);
					
					//redirect to different sites based on class
					if ($class == 'a') {
					header("Location: admin.html");
					}
					elseif ($class == 'p') {
						header("Location: patient.html");
					}
					elseif ($class == 'r') {
						header("Location: radio.html");
					}
					elseif ($class == 'd') {
						header("Location: doc.html");
					}
			}
			else {
				echo '<p>Wrong username or password, please try again.</p>';
				echo '<a href="index.html">Return to front page.</a>';
				echo '</body>';
				echo '</html>';
				die();
			}
	}
oci_free_statement($stmt);
oci_close($conn);
?>
</body>
</html>
