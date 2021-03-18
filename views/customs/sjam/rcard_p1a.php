<?php 
// $vfile='customs/sjam';
// pr($vfile);
?>

<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />
<style>

	.div2{ width:14.0in;height:8.5in;border:1px solid white;margin:0;padding:0;font-size:1.0em; }
	.coltr{ border:1px solid white;width:4.2in;float:left;padding-left:0.2in; }

    
</style>


<?php 

	$lvl = $classroom['level_id'];
	include_once('rptincs/rcardFxns.php');
	include_once('rptincs/menu.php');
	
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

	$tr=$students[0]['conducts'];	
	$numtr=count($tr);
	$numrows=24;
	$ndc=ceil($numtr/$numrows);	/* numdivs_computer vs numdivs_running ndr */


?>



<?php if(!$is_locked): ?><p class="screen red" > Q<?php echo $qtr; ?> - NOT FINALIZED !</p><?php endif; ?>


<?php


for($i=0;$i<$num_students;$i++): 
	$ndr=0;
	$student=$students[$i];
	$grades=$students[$i]['grades'];
	$conducts =$students[$i]['conducts'];
	ob_start();	

	
?>


<!-- traits -->
<div class="div2 clear" >	
<p><?php echo $student['name']; ?></p>
<div class='coltr' >
<table class="gis-table-bordered" >
<tr><th colspan=3 ><?php echo $conducts[0]['critype']; ?></th></tr>
<?php for($it=0;$it<$numtr;$it++): ?>
	<?php $iu=$it+1; ?>
	<?php if((($it%$numrows)==0) && ($it>0)): ?>	
		<?php $ndr++; ?>
		<?php if($ndr<$ndc): ?></table></div><div class='coltr' ><table class="gis-table-bordered" ><?php endif; ?>
	<?php endif; ?>	

	<tr><td><?php echo $conducts[$it]['trait']; ?></td>
		<td class="vc30 center" ><?php echo $conducts[$it]['dg2']; ?></td>
		<td class="vc30 center" ><?php echo ($qtr>3)? $conducts[$it]['dg4']:NULL; ?></td>
	<?php if(isset($conducts[$iu]['critype_id']) && ($conducts[$it]['critype_id']!=@$conducts[$iu]['critype_id'])): ?>
		<tr><th colspan=3 ><?php echo '#'.@$conducts[$iu]['critype_id'].'-'.@$conducts[$iu]['critype']; ?></th></tr>
	<?php endif; ?>	
<?php endfor; ?>	
</table></div>

</div> 	<!-- div2 -->






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


