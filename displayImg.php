<?php
	include ("PHPconnectionDB.php");   
?>

<?php
	
	//connect to oracle
	if($_GET["image_id"]){
		$image_id = $_GET["image_id"];
		$conn = connect();
		//sql command
		$sql = "SELECT regular_size, full_size
				FROM pacs_images
				where image_id = :image_id";
					
		$parse = oci_parse($conn, $sql);
		
		oci_bind_by_name($parse, ":image_id", $image_id);
		oci_execute($parse, OCI_DEFAULT);
		
		$row = oci_fetch_assoc($parse);
	
		$lob = $row['REGULAR_SIZE']->load();
	
		//header("Content-type: image/JPEG");
	
		$image = imagecreatefromstring($lob);
		ob_start(); //You could also just output the $image via header() and bypass this buffer capture.
		imagejpeg($image, null, 90);
		$data = ob_get_contents();
		ob_end_clean();
		echo '<img src="data:image/jpg;base64,' .  base64_encode($data)  . '" /><br>';
		
		
		$lob = $row['FULL_SIZE']->load();
	
		//header("Content-type: image/JPEG");
	
		$image = imagecreatefromstring($lob);
		ob_start(); //You could also just output the $image via header() and bypass this buffer capture.
		imagejpeg($image, null, 80);
		$data = ob_get_contents();
		ob_end_clean();
		echo '<img src="data:image/jpg;base64,' .  base64_encode($data)  . '" />';
		
		oci_free_statement($parse);
	
   	oci_close($conn); // log off
   	
	}
	else {
		echo "Are you HACKING?";
	}
?>