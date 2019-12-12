<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/database.php';

class Session {
	private $unique;
	private $time;
	private $ip;
	private $mysqli;
	const SERVERNAME = 'localhost';
	const USERNAME = 'root';
	const PASSWORD = '';
	const DATABASE = 'test';
	private $data;

	
	public function __construct(){
		// create the connection
		$this->mysqli = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DATABASE);
		// we need some basic user data for authentication
		$this->data = [
			'ip' => !isset($this->ip) ? $_SERVER['REMOTE_ADDR'] : $this->ip,
			'time' => time(),
			'host' => $_SERVER['REMOTE_HOST']
		];
	}

	public function create_session($string){

		if (is_string($string)){
			// this->unique is a unique string generated each time this function is called.
			$this->unique = uniqid();
			// update the logged_in value each time the user logs in
			// to our unique string value.
			$sql = "UPDATE test_users SET logged_id = '$this->unique' 
					WHERE user_id = '$string'";
			$result = $this->mysqli->query($sql) or die($mysqli->error);
			// im checking only to see if the logged in session is set
			// as the other sessions dont matter if logged doesn't exist.
			if (!isset($_SESSION['logged'])){ 
				$_SESSION['logged'] = $this->unique;
				// set our time and ip sessions as well
				$_SESSION['time'] = $this->data['time'];
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				
			}
		}
	}
	
	public function check_values(){
		// im checking to see if there has been inactivity for 5 minutes
		// or if the ip address changes.
		if (($_SESSION['time'] - time()) > 300){
			$this->destroy();
			
		}
		
    // if ip addresses are different
		if ($_SESSION['ip'] != $ip){
			$this->destroy();
		}
	}
	
	public function destroy(){
		unset($_SESSION);
		// we dont necessarily need to remove our logged entry
		// as long as it is updated on each subsequent log in.
	}
}



?>
