<?php
	
	$past = time() - 3600;
	
	if(isset($_COOKIE['id'])){
        setcookie("id", "",  $past);
	}
	if(isset($_COOKIE['class'])){
        setcookie("class", "", $past);
	}
	if(isset($_COOKIE['user'])){
        setcookie("user", "",$past);
	}
	
	//redirect to the home page	
	header("Location: index.html");

?>