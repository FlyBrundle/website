
<?php 

class Pagination {
	public $pages;
	public $per_page = 20;
	private $page;
	public $servername;
	public $password;
	public $username;
	public $dbName = 'test';
	public $total_pages;
	public $results;
	
	
	public function __construct($servername, $username, $password){
		$this->servername = $servername;
		$this->password = $password;
		$this->username = $username;
	}
	
	public function display_products($page, $search_term = ''){
		$mysqli = new mysqli($this->servername, 
							$this->username, 
							$this->password, 
							$this->dbName);
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$per_page = 20;
		$offset = ceil(($page - 1) * $per_page);
		$sql = (!empty($search_term) ? "SELECT * FROM test_products WHERE title LIKE '%$search_term%' ORDER BY id DESC LIMIT $offset, $per_page" : 
									   "SELECT * FROM test_products ORDER BY id DESC LIMIT $offset, $per_page");
		$result = $mysqli->query($sql);
		
		while ($row = $result->fetch_assoc()){
			$this->results[] = $row;
		}
	 
		return $this->results;
		
	}
	
	public function check_page($page, $total){
		// when performing paginations, we want to make sure the user
		// doesn't input a random page value 
		if ($page > $this->total_pages || !is_int($page)){
			?><script>window.location=<?php echo $_SERVER['HTTP_REFERER']; ?></script><?php
		}
	}
	
	public function display_pages($page){
		$this->page = (isset($page) ? $this->page : 1);
		$mysqli = new mysqli($this->servername, 
							$this->username, 
							$this->password, 
							$this->dbName);
		
		$sql_total = "SELECT COUNT(*) FROM test_products";
		$max_items = $mysqli->query($sql_total);
		$row = $max_items->fetch_row();
		$this->total_pages = ceil($row[0]/$this->per_page);

		for ($i = 1; $i <= $this->total_pages; $i++ ){
			echo '<li class="pagination_list">';
			echo '<a href="?page='.$i.'">'.$i.'</a>';
			echo '</li>';
		}
	}
}

?>
