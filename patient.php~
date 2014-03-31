<!doctype html>
<?php
include("PHPconnectionDB.php");
?>
<html>
<head>
<meta charset="UTF-8">
<title>Person Information</title>
</head>

<body>
<h1>Person Information Change</h1>
<p>Please enter the email address associated with the person you wish to search.</p>
<form action="nperson.php" method="post" name="form2" id="form2">
  <p>
    <label for="email2">Email:</label>
    <input name="email2" type="email" id="email2">
    <input type="submit" name="submit" id="submit" value="Submit">
  </p>
</form>
<?php
   $conn = connect();
	if (isset($_POST['submit'])) {
		$email=$_POST['email2'];
		$sql = "select person_id, first_name, last_name, address, email, phone from persons where email = '".$email."'";
		
		$stmt = oci_parse($conn, $sql);
		$r = oci_execute($stmt);
		
		if (!$r) {    
    		$e = oci_error($stmt);
    		echo htmlentities($e['message']);
    		trigger_error(htmlentities($e['message']), E_USER_ERROR);
		}
		
		if(($row = oci_fetch_row($stmt))!=false){
			
			$id = $row[0];
			$firstname = $row[1];
			$lastname = $row[2];
			$address = $row[3];
			$email = $row[4];
			
			$phone = $row[5];
			
		}
		else {
			echo '<p>No Person Found</p>';
		}
		
		
	}
?>
<form action="nperson.php" method="post" name="form1" id="form1">
  <p>
    <label for="textfield">PersonID:</label>
<?php
echo '<input name="id" type="text" id="textfield" value='.$id.'>';
?>
  </p>
  <p>
    <label for="textfield">First Name:</label>
<?php
echo '<input name="firstname" type="text" id="textfield" value='.$firstname.'>';
?>
  </p>
  <p>
    <label for="textfield2">Last Name:</label>
<?php
echo '<input name="lastname" type="text" id="textfield2" value='.$lastname.'>';
?>
  </p>
  <p>
    <label for="textfield3">Address:</label>
<?php
echo '<input name="address" type="text" id="textfield3" value='.$address.'>';
?>
  </p>
  <p>
    <label for="email">Email:</label>
<?php
echo '<input name="email" type="email" id="email" value='.$email.'>';
?>
  </p>
  <p>
    <label for="tel">Tel:</label>
<?php
echo '<input name="tel" type="tel" id="tel" value='.$phone.'>';
?>
    <br>
  </p>
  <p>
    <input type="submit" name="confirm" id="submit" value="Confirm">
  </p>
</form>

<?php
if (isset($_POST['confirm'])) {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$phone = $_POST['tel'];
		$id = $_POST['id'];

$sql = "update persons set first_name = '".$firstname."', last_name = '".$lastname."', address = '".$address."', email = '".$email."', phone = '".$phone."' where person_id = ".$id."";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

echo "Update Successful";
}
?>

<hr>

<h1>Person Password Change</h1>
<p>Please change your password of your current account.</p>
<form action="nperson.php" id="form2" name="form2" method="post">
  <p>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
  </p>
  <p>
    <input type="submit" name="submit2" id="submit2" value="Submit">
    <br>
  </p>
</form>
<?php
if (isset($_POST['submit2'])) {
	$username = $_COOKIE["user"];
	$password = $_POST['password'];
$sql = "update users set password = '".$password."' where user_name = '".$username."'";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
echo "Update Successful";
}
oci_free_statement($stmt);
oci_close($conn);
?>
</body>
</html>
