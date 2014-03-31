<!doctype html>
<?php
include("PHPconnectionDB.php");
?>
<html>
<head>
<meta charset="UTF-8">
<title>User Management</title>
</head>

<body>
<h1>User Management</h1>
<?php
	//check if it is admin
	if (!isset($_COOKIE["user"])) {
		echo '<p>Access denied. You are not an Administrator.</p>';
		echo '</body>';
		echo '</html>';
		die();
	}
	else {
		$conn = connect();
		$sid = $_COOKIE["user"];
		$sql = "select class from users where user_name = '".$sid."'";
		$stmt = oci_parse($conn, $sql);
		oci_execute($stmt);
		$row = oci_fetch_row($stmt);
		$class = $row[0];
		if ($class != 'a') {
			echo '<p>Access denied. You are not an Administrator.</p>';
			echo '</body>';
			echo '</html>';
			die();
		}
	}
oci_free_statement($stmt);
oci_close($conn);
?>
<p><a href="person.php">Personal Information Change</a></p>
<p><a href="user.php">Login Information Change</a></p>
<p><a href="reg.php">Add New User</a></p>

</body>
</html>
