<?php
session_start();
error_reporting(0);

include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/database.php';
	
$log_prompts = array(
	'invalid_login' => 'Please check the email or password', 
	'success_login' => 'Logged in successfully',
	'attempts' => 'You guess your password wrong '.$_SESSION['attempts'].' times',
	'captcha' => '<img src="https://developers.google.com/recaptcha/images/newCaptchaAnchor.gif" height="80" style="width: 100%;" />'
	
);

$_SESSION['attempts'] = isset($_SESSION['attempts']) ? $_SESSION['attempts'] : 1;

// going to start with test strings and then 
// use the post variables
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT user_id, email, password FROM test_users WHERE email='$email'";
// it's possible I can modify the query to check for the existence of an email 

if ($result = $mysqli->query($sql)){
	if ($result->num_rows == 1){
		$row = $result->fetch_assoc();
		
		if (password_verify($password, $row['password'])){
			session_regenerate_id();
			$_SESSION['user_log'] = $row['user_id'];
			// todo: modify session later to save a login key into our login databse and associate this with the logged_in user
			unset($_SESSION['attempts']); //destroy our attempts counter
			$result->close();
			echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'"; </script>';
		}
		else {
			// post a captcha if user has at least 5 failed attempts. 
			// todo: upgrade to 10 after testing
			if ($_SESSION['attempts'] >= 5){
				$_SESSION['attempts'] ++;
				echo $log_prompts['invalid_login'] . '<br />';
				echo $log_prompts['captcha'];
				$result->close();
			} 
			
			if ($_SESSION['attempts'] < 5){
				$_SESSION['attempts'] ++;
				echo $log_prompts['invalid_login'] . '<br />';
				echo $_SESSION['attempts'];
				$result->close();
			}
		}
	} else {
			echo $log_prompts['invalid_login'];
			$result->close();
	}
}

?>
