<!doctype html>
<?php
include("PHPconnectionDB.php");
?>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
</head>

<body>
<h1>Register</h1>
<?php
	//check if it is admin
	if (!isset($_COOKIE["user"])) {
		echo '<p>Access denied. You are not an Administrator.</p>';
		echo '</body>';
		echo '</html>';
		die();
	}
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
?>

<form action="reg.php" id="form1" name="form1" method="post">
  <p>
    <label for="textfield">First Name:</label>
    <input type="text" name="firstname" id="textfield">
  </p>
  <p>
    <label for="textfield2">Last Name:</label>
    <input type="text" name="lastname" id="textfield2">
  </p>
  <p>
    <label for="textfield3">Address:</label>
    <input type="text" name="address" id="textfield3">
  </p>
  <p>
    <label for="textfield4">Email:</label>
    <input type="text" name="email" id="textfield4">
  </p>
  <p>
    <label for="textfield5">Phone:</label>
    <input type="text" name="phone" id="textfield5">
  </p>
  <p>
    <label for="textfield6">Username:</label>
    <input type="text" name="username" id="textfield6">
  </p>
  <p>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
  </p>
  <p>
    <label>
      <input type="radio" name="RadioGroup1" value="p" id="RadioGroup1_0">
      Patient</label>
    <br>
    <label>
      <input type="radio" name="RadioGroup1" value="d" id="RadioGroup1_1">
      Doctor</label>
    <br>
    <label>
      <input type="radio" name="RadioGroup1" value="r" id="RadioGroup1_2">
      Radiologist</label>
    <br>
    <label>
      <input type="radio" name="RadioGroup1" value="a" id="RadioGroup1_3">
      Admin</label>
  </p>
  <p>
    <input name="submit" type="submit" id="submit" formaction="reg.php" value="Submit">
    <br>
  </p>
</form>
<?php

//insert the certain information into the database from the POST
if (isset($_POST['submit'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$class = $_POST['RadioGroup1'];
	
	$conn = connect();
	$sql = "insert into persons (first_name, last_name, address, email, phone) values ('".$firstname."', '".$lastname."', '".$address."', '".$email."', '".$phone."')";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);
	
	$sql = "select person_id from persons where email = '".$email."'";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);
	$row = oci_fetch_row($stmt);
	$id = $row[0];
	$date = date("Y-m-d");
	$sql = "insert into users values ('".$username."', '".$password."', '".$class."', '".$id."', to_date('".$date."','yyyy-mm-dd'))";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);
	
	echo "Add successful";
}
oci_free_statement($stmt);
oci_close($conn);
?>
</body>
</html>