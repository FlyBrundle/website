<?php
session_start();

//include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/security.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/database.php';

// for testing purposes, I created two new functions, one to handle file upload, and the other 
// to handle error messages
// once all functionality is rendered, i want 
function file_upload(){
	$target_dir = 'uploads/';
	$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	
	if (getimagesize($_FILES['fileToUpload']['tmp_name'])){
		if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
			$image = basename($_FILES['fileToUpload']['name']);
			return $image;
		}
	}
	
	else if (!in_array($imageFileType['extension'], array('jpg', 'gif'))){
		$_SESSION['err'] = 'Please upload a jpg or gif image file';
	}
}

function check_errors(){
	$required = ['title', 'category'];
	$err = false;
	
	foreach($required as $field){
		if (empty($_POST[$field]) || !isset($_POST[$field])){
			$err = true;	
		}
	}
	
	$err = false;
}

// going to start with test strings and then 
// use the post variables
$title = $_POST['title'];
$category = $_POST['category'];
$price = $_POST['price'];
$description = $_POST['description'];
$user_id = isset($_SESSION['user_log']) ? $_SESSION['user_log'] : uniqid();
$item_id = uniqid('', True);

// message prompts for the ajax call
$selling_prompts = array(
	'empty_values' => 'All fields must be filled out', 
	'success_login' => 'Successfully registered...redirecting',
	'email_exists' => 'That email is already registered'
);

if (isset($_POST['submit'])){
	// if our error function returns false
	if (!check_errors()){
		$new_image = file_upload();
		// if the file_upload function returns true
		if ($new_image){
			echo 'what';
			$sql = "INSERT INTO test_products (item_id, user_id, title, category, image, price, description) VALUES('$item_id', '$user_id', '$title', '$category', '$new_image', '$price', '$description')";
			if ($result = $mysqli->query($sql)){
				
				//$result->close();
				$selling_prompts['success_login'];
				
				header('Location: product.php?item_id=' . $item_id);
				
			}  else {
					
			}
		}
	} else {
		// if there is an error found with the input fields, throw this
		// error message
		echo $selling_prompts['empty_values'];
	}
}




?>
