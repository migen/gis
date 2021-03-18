<?php


// AttendanceController - for sidelist, boys and girls


	if($urid==RSTUD){ 
		$data['contact'] = $contact	= $this->model->contactAttendance($dbg,$sy,$ucid,$fields="");
		$crid	= $contact['crid'];	
		$allowed = (in_array($crid,$_SESSION['teacher']['advisory_ids']))? true: false;
	} else {
		$data['contact'] = $contact	= $this->model->contactAttendance($dbg,$sy,$ucid,$fields="");		
	}


// ------------- before post-submit
	if($empl){
		if(isset($_SESSION['urid'])){
			if($_SESSION['urid']!=$urid) $this->model->sessionizeRoleContacts($dbg,$urid);		/* GSModel */
		} else {
			$_SESSION['urid'] = $urid;
			$this->model->sessionizeRoleContacts($dbg,$urid);	
		}		
	} else {
		if($urid!=RSTUD){
			if(isset($_SESSION['crid'])){
				if($_SESSION['crid']!=$crid) $this->model->sessionizeCridStudents($dbg,$crid);		/* GModel */
			} else {
				$_SESSION['crid'] = $crid;
				$this->model->sessionizeCridStudents($dbg,$crid);	
			}			
		}
	}

	if($urid!=RSTUD){
		$data['boys']  = $_SESSION['boys'];
		$data['girls'] = $_SESSION['girls'];	
	}


// ------------------ views
// at the bottom
?>

<?php /*nf = name field, for emp = contact, for students = student */
	$nf = ($empl)? 'contact':'student';
?>

<div class="fifth"  >
<h5>Boys</h5>
<?php foreach($boys AS $row): ?>
<p><a href='<?php echo URL."$home/attendanceLogs/$sy/$moid/".$row['ucid']."/$empl"; ?>' ><?php echo $row[$nf]; ?></a></p>
<?php endforeach; ?>
</div>

<div class="fifth"  >
<h5>Girls</h5>
<?php foreach($girls AS $row): ?>
<p><a href='<?php echo URL."$home/attendanceLogs/$sy/$moid/".$row['ucid']."/$empl"; ?>' ><?php echo $row[$nf]; ?></a></p>
<?php endforeach; ?>
</div>

<!------------------------------------------------------------------------->


	


