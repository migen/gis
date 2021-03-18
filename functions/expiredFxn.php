<?php


function expiredRedirect($row){	
	$dbo=PDBO;
	$rurl=$row['url'];
	$expired_controllers=array('xmis','xhome','xgrades','contacts','mis','rcards','grades');	
	$rurl_array=explode("/",$rurl);
	$rurl_ctlr=$rurl_array[0];
	$is_allowed=in_array($rurl_ctlr,$expired_controllers);
		
	if(!$is_allowed){ 
		$srid=$_SESSION['srid'];
		switch($srid){
			case 2:	flashRedirect('xaccounts','Expired redirect accounts');break;			
			case 9: flashRedirect('xgrades','Expired redirect grades');break;
			case 5: flashRedirect('xmis','Expired redirect mis');break;				
			case 10: flashRedirect('xinventory','Expired redirect inventory');break;			
			default:
				flashRedirect('xhome','from loginRedirect');break;
		}
		
	}	/* not allowed */
	
	// exit;
	
	
	
}	/* fxn */
	


	
	
	


