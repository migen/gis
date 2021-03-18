<?php


class Pagination {
	
  public $currentPage;
  public $perPage;
  public $totalCount;

  public function __construct($page=1,$perPage=20,$totalCount=0){
  	$this->currentPage = (int)$page;
    $this->perPage = (int)$perPage;
    $this->totalCount = (int)$totalCount;
  }

  
/* which record to start // (currPage - 1) * perPage */  
  public function offset() {	
    return ($this->currentPage - 1) * $this->perPage;
  }

public function totalPages() {
	$totalPages=ceil($this->totalCount/$this->perPage);
	return $totalPages;	
}
	
  public function previousPage() {
    return $this->currentPage - 1;
  }
  
  public function nextPage() {
    return $this->currentPage + 1;
  }

	public function hasPreviousPage() {
		return $this->previousPage() >= 1 ? true : false;
	}

	public function hasNextPage() {
		return $this->nextPage() <= $this->totalPages() ? true : false;
	}

	
public function pageNav($controller,$axn='index',$paramString=null){
			
	$pageNav = '<br />Total of '.$this->totalCount.' records. ';
	$get = isset($_GET)? sages($_GET):'';	 
	if(isset($_GET['sort'])) {unset($_GET['sort']); }
	$totalPages=$this->totalPages();

	if($totalPages > 1) {		
		if($this->hasPreviousPage()) { 
    	// $pageNav .= '<a href="'.URL.$controller.'/'.$axn.'/'.$this->previousPage().''.$get.'"> &laquo; Previous</a> &nbsp;';
    	$pageNav .= '<a href="'.URL.$controller.'/'.$axn.'/'.$this->previousPage().'/'.$paramString.''.$get.'"> &laquo; Previous</a> &nbsp;';
		}
		$tp = ($totalPages < 20)? $totalPages : 20;
		for($i=1; $i <= $tp; $i++) {
			if($i == $this->currentPage) {
				$pageNav .= '<a class="selected">'.$i.'</a>&nbsp;';
			} else {
				$pageNav .= '<a href="'.URL.$controller.'/'.$axn.'/'.$i.'/'.$paramString.''.$get.'">'.$i.'</a>&nbsp;';
			}
		}
		if($this->hasNextPage()) { 
			$pageNav .= '<a href="'.URL.$controller.'/'.$axn.'/'.$this->nextPage().'/'.$paramString.''.$get.'">Next &raquo; </a>';
		}		
	}
	return $pageNav;
}		
		
	

	

} 	/* Pagination */
