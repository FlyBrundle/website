session_start();

	$user_data = ['ip' => $_SERVER['REMOTE_ADDR'], 'time' => time(), 'agent' => $_SERVER['HTTP_USER_AGENT'], 'log_id' = uniqid()];
function parse_query($assoc_arr_data){
	foreach($assoc_arr_data as $key => $value){
		$sql .= "$key = '$value'";
	}
	return $sql;
}
function login_session($email){
	$sql = "UPDATE logins SET " . parse_query($user_data) . " WHERE user_id = (SELECT user_id FROM users WHERE email='$email')";
	
	
	if ($result = $mysqli->query($sql)){
		if ($result->num_rows == 1){
			$row = $result->fetch_assoc();
			$_SESSION['sess_id'] = $row['sess_id'];
			$_SESSION['ip'] = $user_data['ip'];
			$result->free_result();
			$mysqli->close();
		}
	}
}
