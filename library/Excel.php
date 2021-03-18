<?PHP

class Excel{

  private function cleanData(&$str){
		$str = preg_replace("/\t/","\\t",$str);
		$str = preg_replace("/\r?\n/","\\n",$str);
		if($str == 't') $str = 'TRUE';
		if($str == 'f') $str = 'FALSE';

		if(preg_match("/^0/",$str) || preg_match("/^\+?\d{8,}$/",$str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/",$str)) {
		  $str = "'$str";
		}
		if(strstr($str,'"')) $str = '"' . str_replace('"','""',$str) . '"';

  }

public function export($data,$prefix='webdata'){
      $filename = $prefix."_".date('YMd_His').".xls";

	  header("Content-Disposition: attachment; filename=\"$filename\"",false);
	  header("Content-Type: application/vnd.ms-excel",false);
	  // header("Content-Type: text/plain");

	  // echo '<br />export: '; print_r($data);
    $flag = false;
	foreach($data as $row){
		if(false !== $row){
			if(!$flag){
				echo implode("\t",array_keys($row)) . "\r\n";
				$flag = true;			
			}
		}
		# array_walk($row,'cleanData');
		echo implode("\t",array_values($row)) . "\r\n";			
	}
	
    // exit;
	    
} /* fxn */

  
  
  
} 	/* Excel */


  
  
  
  
?>