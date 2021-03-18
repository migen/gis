<?php

function paginationSages(){
	$limit=isset($_GET['limit'])? $_GET['limit']:30;
	$page=isset($_GET['page'])? $_GET['page']:1;
	$cond=isset($_GET['cond'])? $_GET['cond']:"1=1";
	$get="?limit=$limit&page=$page&cond=$cond";
	return $get;
}	/* fxn */


function pagenav($url,$totalCount,$offset,$perPage,$currPage,$perSet=10){
	$str="";
	$numPages=ceil($totalCount/$perPage);		
	$set=ceil($currPage/$perSet);	
	$begPage=(($set-1)*$perSet)+1;
	$endPage=($set)*$perSet;
	$nextPage=true;
	
	$debug="";
	$debug.="numPages: $numPages <br />";
	$debug.="begPage: $begPage <br />";
	$debug.="endPage: $endPage <br />";
	debug($debug);
	unset($_GET['page']);
	$get=sages($_GET);
	$get=trim($get,"?");
	if($get){ $get="&".$get; }
	debug($get);

	if($set!=1){ 
		$str.="<a href='".URL.$url."?page=1".$get."' >First</a> "; 
		$str.="<a href='".URL.$url."?page=".($begPage-1).$get."' >Prev</a> "; 
	}		
	for($i=$begPage;$i<=$endPage;$i++){
		if($currPage==$i){ $str.="<span class='brown'>(".$i.")</span> "; continue; } 
		if($i>$numPages){ $nextPage=false; break; }		
		$str.="<a href='".URL.$url."?page=".$i.$get."' >".$i."</a> ";
	}
	if(($currPage)<$numPages){ 
		if($nextPage){ 
			$str.="<a href='".URL.$url."?page=".($endPage+1).$get."' >Next</a> "; 
			$str.="<a href='".URL.$url."?page=".$numPages.$get."' >Last</a>"; 	
		}
	}
	return $str;
		
}	/* fxn */




function pagenavOK($url,$count,$numpages,$offset,$perPage,$currPage){
	$str="";		
	for($i=1;$i<=$numpages;$i++){
		if($currPage==$i){ continue; } 
		$str.="<a href='".URL.$url."&page=".$i."' >".$i."</a> | ";		
	}
	$str=rtrim($str," | ");
	return $str;
		
}


function paginationNOK($db,$dbtable,$cond,$perPage,$currPage){
	$q="S";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	$data['offset']=($currPage-1)*$perPage;
	$data['totalCount']=$totalCount=$count;
	$data['totalPages']=ceil($totalCount/$perPage);
	$data['record_start']=($currPage-1)*$perPage+1;
	$data['record_end']=($currPage)*$perPage;
	
	
	return $data;
	
	
}	/* fxn */




