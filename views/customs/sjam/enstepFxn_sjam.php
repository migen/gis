<style>

.btn-steps{
	padding:6px ;
	border:1px solid #ccc;
	border-radius:6px;
}


.btn-steps a {
	font-size:1.2em;
	color:#333;

}



</style>

<?php



if($_SESSION['srid']==1):





/* 1 - ensched */
if(in_array($axn,['paymode','assessment'])){
	$enschedPtr = $ensched['enstep'];
	if($enschedPtr==0){
		flashRedirect('students','Enrollment schedule closed.');			
	}
}	/* if */


/* 1 - ensched */
if(in_array($axn,['booklist'])){
	$schedPtr = $sched['booklist'];
	if($schedPtr==0){
		flashRedirect('students','Booklist viewing schedule closed.');			
	}
}	/* if */


/* 1 - ensched */
if(in_array($axn,['tuitions'])){
	$schedPtr = $sched['tuition'];
	if($schedPtr==0){
		flashRedirect('students','Tuition viewing schedule closed.');			
	}
}	/* if */




/* 2 - enstep */

$scid=$_SESSION['ucid'];
$q="SELECT id,name,enstep FROM {$dbo}.00_contacts WHERE id=$scid LIMIT 1; ";
$sth=$db->querysoc($q);
$contact=$sth->fetch();
$stud_enstep = $contact['enstep'];
$sy_payments=$_SESSION['settings']['sy_payments'];


$ensteps = array(
	1 => [
		'label' => 'Datasheet',
		'action' => 'datasheet',
		'url' => 'students/datasheet',
	],
	2 => [
		'label' => 'Mode of Payment',
		'action' => 'paymode',
		'url' => 'students/paymode',
	],
	3 => [
		'label' => 'Assessment',
		'action' => 'assessment',
		'url' => 'students/assessment',
	],		
	
);




// 1 - get index of current method
function axnOne($axn,$ensteps){
	foreach($ensteps AS $i => $en){
		if($axn==$en['action']){
			return $i;
		}
	}
	return false;
	
}	/* fxn */

/* 2 - redirect if advance step */
function axnTwo($sy_payments,$scid,$stud_enstep,$axnIndex,$ensteps){
	if($axnIndex>$stud_enstep){
		$url=$ensteps[$stud_enstep]['url'].DS.$scid.DS.$sy_payments;
		flashRedirect($url,'Redirected from advanced enrollment step.');
	}	
}	/* fxn */


function isFinalizedEnstep($db,$scid,$step=1){
	$dbo=PDBO;
	$q="SELECT finalized_s{$step} FROM {$dbo}.05_steps WHERE scid=$scid AND type='enrollment' LIMIT 1;";
	debug("enstep isFinalized: $q");
	$sth=$db->querysoc($q);
	$row=$sth->fetch();	
	$is_locked = (isset($row['finalized_s'.$step]) && ($row['finalized_s'.$step]!=='0000-00-00'))? true:false;
	return $is_locked;	
}	/* fxn */



ob_start();

$axnIndex=axnOne($axn,$ensteps);


function getControls($axnIndex,$sy_payments,$scid,$ensteps){
	foreach($ensteps AS $i => $en){	
		if($axnIndex==$i){ 
			echo "Step {$i}) - ".$en['label'];	
		} else {
			$btn_name='';
			if($i==($axnIndex-1)){ $btn_name=htmlspecialchars('<Prev>'); }
			if($i==($axnIndex+1)){ $btn_name=htmlspecialchars('<Next>');; }
			echo "<button class='btn-steps' ><a class='redBtn no-underline' href='".URL."".$en['url']."/".$scid."/".$sy_payments."' >{$btn_name} Step {$i}) - ".$en['label']."</a></button>";		
		}
		echo '&nbsp;&nbsp;';

		
		
	}
	
}

getControls($axnIndex,$sy_payments,$scid,$ensteps);


$controls = ob_get_contents();


ob_end_clean();



axnTwo($sy_payments,$scid,$stud_enstep,$axnIndex,$ensteps);





endif; 	// if srid==RSTUD