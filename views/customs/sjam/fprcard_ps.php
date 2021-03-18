<h5 class="screen" >
	Front (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| &blank
</h5>

<?php 

/* impt */
$fontsize="1.0em"; 
$logo_src = URL."public/images/weblogo_{$sch}.png";

// pr($data);

?>


<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />

<style>

.refcenter {
    margin: auto;
    width: 50%;
    border: 3px solid green;
    padding: 10px;
}




.divleft{ border: 1px solid red-white; float:left; }
.tblwidth{ width: 100%; table-layout:fixed; font-size:<?php echo $fontsize; ?>; }
.tblwidth td{  }
td.attdtxt{ width:320px; text-align:left; }

.tdrmks{ width:20%; border:1px solid ;}
.divrmks{ min-height:320px;position:relative; }
.pgsign{ position:absolute;bottom:0;text-align:center;left:auto;left:30px; }


div{ border:1px solid white;}
div.divright{ border:1px solid red-white; margin:auto; }

.h1{ font-size:1.8em;}
.h2{ font-size:1.6em;}
.h5{ font-size:1.4em;}

.schname{ font-size:1.6em; font-family: "Times New Roman", Times, serif; }

.tblstud{ width:52%;font-size:1.0em; }
.studkey{ width:30%; }

.attdfont,.rmksfont,.studfont,.schfont { }

.xspacer{ border: 1px solid red; min-height:200px; float:left; }

.div1{ width:13in;height:100%;border:1px solid red-white;margin:0;padding:0; clear:both; }

.divleft{ width:48%;height:100%;border:1px solid red-white;  }
.divright{ width:48%;height:100%;border:1px solid white; padding-left:3%; float:right;text-align:center;  }

.divleft,.divright{ float:left; }
	
.coltr{ border:1px solid white;width:4.2in;float:left;padding-left:0.2in; }
    
</style>


<?php 

	$lvl = $classroom['level_id'];
	include_once('rptincs/rcardFxns.php');
	
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
	<?php $attendance=$students[$i]['attendance'];include('rptincs/coverleft_p1.php'); ?>
	<?php include('rptincs/coverright_p1.php'); ?>
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


