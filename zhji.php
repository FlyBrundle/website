class Security {
  public function clean($string){
    if (gettype($string) == 'string'){
      $string = preg_replace('/[^a-zA-Z\.]/', '', $string);
      $string = str_replace(' ', '', $string);
      return($string):
    }
  }
  
  public function checkPage($path){
    $dir = scandir($path, SCANDIR_SORT_DESCENDING);
    $num = count($dir);
    for ($i = 0; $i < num; $i++ ){
      if (!is_file($path . '\', $dir[$i]){
        http_response_code('404');
        include('404.php');
        die();
      }
    }
  }
}
