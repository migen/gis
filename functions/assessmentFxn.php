<?php

function checkBackAccount($db,$scid,$sy,$negligible=0){
	$dbo=PDBO;
	$sy_prev=$sy-1;
	$sy_beg=$_SESSION['settings']['sy_beg'];
	$sy_end=$_SESSION['settings']['sy_end'];
	$q="SELECT name,sy from {$dbo}.`00_contacts` WHERE id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$csy=$row['sy'];
	$old_student=($row['sy']!=$sy)? true:false;
		
	if(($sy>$sy_beg) && ($old_student)){		
		$pdbg=VCPREFIX.$sy_prev.US.DBG;
		$q="SELECT assessed FROM {$pdbg}.03_tsummaries WHERE scid='$scid' LIMIT 1; ";
		debug($q);
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$amt1=$row['assessed'];
		/* 2 addons */
		$q="SELECT SUM(a.amount) AS amount FROM {$pdbg}.`30_auxes` AS a 
			LEFT JOIN {$pdbg}.03_feetypes AS b ON a.feetype_id=b.id 
			WHERE a.scid='$scid' AND b.is_discount=0 LIMIT 1; ";
		debug($q);		
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$amt2=$row['amount'];
		/* 3 discounts */
		$q="SELECT SUM(a.amount) AS amount FROM {$pdbg}.`30_auxes` AS a 
			LEFT JOIN {$pdbg}.03_feetypes AS b ON a.feetype_id=b.id 
			WHERE a.scid='$scid' AND b.is_discount=1 LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$amt3=$row['amount'];		
		$total_payables=$amt1+$amt2-$amt3;
		
		/* 4 payments */
		$q="SELECT SUM(a.amount) AS amount FROM {$pdbg}.30_payments AS a WHERE a.scid='$scid' LIMIT 1; ";
		debug($q);
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$total_payments=$row['amount'];		
		$back_account=$total_payables-$total_payments;

		if($back_account>$negligible){			
			$home=URL.$_SESSION['home'];
			$asmt=URL."assessment/assess";
			$editcsy=URL."contacts/csy/$scid";
			$ledger=URL."ledgers/pay/$scid/$sy_prev";
		
			echo "<h3 class='red' >HAS BACK ACCOUNT OF P".number_format($back_account,2)."! ";
			echo "<br />Please settle at the accounting office.";
			echo "<br />*Old student. Registered SY $csy ";
			echo ' | <a href="' . $editcsy . '">Change SY</a></h3>';			
			echo '<a href="' . $home . '">Home</a>';
			echo ' | <a href="' . $asmt . '">Assessment</a>';
			if($_SESSION['srid']<>RREG){ echo ' | <a href="' . $ledger . '">Ledger</a>';}
			exit;
		}
	}

}	/* fxn */


function assessTsum($db,$dbg,$scid,$obid){	
	$dbo=PDBO;
	$q = "
		SELECT 
			c.id AS ucid,c.parent_id AS pcid,c.is_active,c.is_cleared,p.address,
			c.code AS student_code,c.name AS student,c.role_id,
			tsum.*,t.*,cr.name AS classroom,l.name AS level,sxn.name AS section,
			tsum.scid AS tsumscid,c.crid AS concrid,
			pm.count AS numperiods,pm.code AS paymode_code,pm.name AS paymode,pm.dates AS paydates,
			taux.amount AS obal,taux.id AS tauxid,taux.scid AS tauxscid,
			summ.scid AS sumscid,cr.num AS cridnum,cr.acid AS acid,
			t.label AS tlabel			
		";
	$q .= "
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
			LEFT JOIN {$dbg}.03_tsummaries AS tsum on summ.scid = tsum.scid
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON (t.level_id = cr.level_id && t.num = cr.num)
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`03_paymodes` AS pm on tsum.paymode_id = pm.id ";
	$q .= "
			LEFT JOIN {$dbg}.`30_auxes` AS taux ON 
				(taux.scid = c.id && taux.feetype_id = '$obid')	
	";		

	$q .= " WHERE c.id 	= '$scid'; ";
	debug($q,'assessmentFxn: assessTsum');
	$sth = $db->querysoc($q);
	if(isset($_GET['debug'])){ $_SESSION['q']=$q; }	
	return $sth->fetch();

}	/* fxn */


function tpays($db,$dbg,$scid,$fields=NULL){	
	$dbo=PDBO;
	$q = "SELECT ec.name AS employee,tp.*,tp.id AS tpid,tpay.name AS paytype,fty.name AS feetype,b.code AS bank_code
		FROM {$dbo}.30_payments AS tp 
			LEFT JOIN {$dbo}.`03_paytypes` AS tpay on tp.paytype_id = tpay.id
			LEFT JOIN {$dbo}.`03_feetypes` AS fty on tp.feetype_id = fty.id
			LEFT JOIN {$dbo}.`00_contacts` AS ec on tp.ecid = ec.id
			LEFT JOIN {$dbo}.`03_banks` AS b on tp.bank_id = b.id
		WHERE tp.scid = '$scid' ORDER BY tp.feetype_id,tp.pointer; ";	
	debug($q,'assessmentFxn: tpays');
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function taux($db,$dbg,$scid){	
	$dbo=PDBO;
	$q = " SELECT taux.*,taux.id AS tauxid,fty.name AS feetype,fty.*,taux.amount AS amount
		FROM {$dbg}.`30_auxes` AS taux 
			LEFT JOIN {$dbo}.`03_feetypes` AS fty on taux.feetype_id = fty.id
		WHERE taux.scid = '$scid' ORDER BY taux.feetype_id; ";
	debug($q,'assessmentFxn: taux');	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



