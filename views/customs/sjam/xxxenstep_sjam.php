<style>

.btn-steps{
	padding:12px;
	border:1px solid #ccc;
	border-radius:6px;
}

.btn-steps a {
	font-size:1.2em;

}

</style>

<?php

if($_SESSION['srid']==1):

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
		'label' => 'Booklist',
		'action' => 'booklist',
		'url' => 'students/booklist',
	],	
	4 => [
		'label' => 'Assessment',
		'action' => 'assessment',
		'url' => 'students/assessment',
	],		
	
);


ob_start();

foreach($ensteps AS $i => $en){	
	if($stud_enstep==$i){ 
		echo "Step {$i}) - ".$en['label'];
	} else {
		echo "<button class='btn-steps' ><a class='no-underline' href='".URL."".$en['url']."/".$scid."/".$sy_payments."' >Step {$i}) - ".$en['label']."</a></button>";		
	}
	echo '&nbsp;&nbsp;';

	
	
}



$content = ob_get_contents();
ob_end_clean();



// 1 - get index of current method
function axnOne($axn,$ensteps){
	foreach($ensteps AS $i => $en){
		if($axn==$en['action']){
			return $i;
		}
	}
	return false;
	
}	/* fxn */

// 2 - redirect if advance
function axnTwo($sy_payments,$scid,$stud_enstep,$axnIndex,$ensteps){
	pr("axnIndex: $axnIndex");
	if($axnIndex>$stud_enstep){
		$url=$ensteps[$stud_enstep]['url'].DS.$scid.DS.$sy_payments;
		echo "flashRedirect - ".$url."<br>";
		// flashRedirect($url,'Redirected from advanced step.');
	}	
}	/* fxn */



$axnIndex=axnOne($axn,$ensteps);
// axnTwo($sy_payments,$scid,$stud_enstep=1,$axnIndex=4,$ensteps);
axnTwo($sy_payments,$scid,$stud_enstep,$axnIndex,$ensteps);





endif; 	// if srid==RSTUD