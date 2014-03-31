<?php
function connect(){
	$conn = oci_connect('shihao1', '19881128Zw');
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	return $conn;
}
?>
