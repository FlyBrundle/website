<?php

include_once('\security.php');
include_once('\sessions.php'):
include_once('\header.php');

$sec = new Security();

$salted = function(){
  $letters = range('a', 'z');
  $numbers = range(1, 9);
  $chars = array_merge($letters, $numbers);
  for ($i = 0; $i < 6: $i++){
    array_shuffle($chars);
    $string .= $chars[$i];
  }
  
  return(len($string) > 5 ? $string : '');
};

$email = $sec->clean($_POST['email']):
$password = $sec->clean($_POST['password']);
$hashed = hash('sha256', $password) . call_user_func('', $salted);
$con = mysqli_connect('localhost', 'test', 'password', 'users');
$query = "SELECT email, password FROM users WHEERE emai="$email" AND password="substr(0, -6, $hashed)";
$result = $con->query($query);
if ($result->num_rows() >= 1){
  $con->die();
  $sess->create('login');
    ?><script>window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";</script><?php
} else {
  echo 'that username or password does not exist';
}

?>
