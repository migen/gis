<?php // $size="2.0em"; ?>

<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />
<style>
	.attdfont,.rmksfont,.studfont,.schfont { }
	
	.div1,.div2{ width:14.0in;height:8.5in;border:1px solid white;margin:0;padding:0; }
	.div1a,.div1b{ width:6.93in;height:8.5in;border:1px solid redwhite; float:left; }
	
	.coltr{ border:1px solid white;width:4.2in;float:left;padding-left:0.2in; }
    
</style>


<?php 

	$lvl = $classroom['level_id'];
	include_once('rptincs/rcardFxns.php');
	// include_once('rptincs/menu.php');
	
	/* remarks */
	$cond=isset($scid)? "summ.scid=$scid":"summ.crid='$crid'";	
	$condlimit=isset($_GET['limit'])? " LIMIT ".$_GET['limit']:NULL;
	$order=$_SESSION['settings']['classlist_order'];
	$q="SELECT c.id AS scid,c.code AS studcode,c.name AS student,r.* 
		FROM {$dbg}.05_summaries AS summ 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
			LEFT JOIN {$dbg}.50_remarks AS r ON summ.scid = r.scid
		WHERE $cond ORDER BY $order $condlimit ;";	
	$sth=$db->querysoc($q);
	$remarks=$sth->fetchAll();

	/* age */
	function getAgeYM($birthdate){
		$birthmonth=date('m',strtotime($birthdate));
		$birthyear=date('Y',strtotime($birthdate));
		$age=DBYR-$birthyear;
		$endmonth=4;
		$mos=0;
		$ar['yrs']=($birthmonth>$endmonth)? $age:($age+1);
		$ar['mos']=($birthmonth!=$endmonth)? (12-$birthmonth+$endmonth):0;		
		$ar['mos']=($ar['mos']<12)? $ar['mos']:$ar['mos']-12;
		return $ar;		
	}



?>



<?php if(!$is_locked): ?><p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p><?php endif; ?>


<?php


for($i=0;$i<$num_students;$i++): 
	$ndr=0;
	$student=$students[$i];
	ob_start();	

	
?>


<div class="div1" > <!-- div1 -->
	<div class="div1a center" ><?php $attendance=$students[$i]['attendance'];include('rptincs/coverleft_p1.php'); ?></div>
	<div class="div1b center" ><?php include('rptincs/coverright_p1.php'); ?></div>
</div> 	<!-- div1 -->

<p class='pagebreak'>&nbsp; </p>









<?php
	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();

	endfor; 	/* loop students  */
 
	for($j=0;$j<$num_students;$j++){
		$ob = "ob$j";
		echo $$ob;

	}	
 

?>


