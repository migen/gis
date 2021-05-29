<h3>
	Enrollment Steps Student Locking | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>

</h3>


<?php 

$dbo=PDBO;
$today=$_SESSION['today'];
$dbcontacts="{$dbo}.00_contacts";

// echo 's1: ';print($row['finalized_s1']); echo '<br>';
// echo 's2: ';print($row['finalized_s2']); echo '<br>';

?>



<?php if($srid!=RSTUD): ?>
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,30);return false;' />
		
	</td></tr>
	
</table></p>
<div id="names" >names</div>
<?php endif; ?>	<!-- !user_is_student -->


<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>SY</th><td><?php echo $sy; ?></td></tr>
<tr><th>Step ID</th><td><?php echo $row['step_id']; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $row['classroom']; ?></td></tr>
<tr><th>Scid</th><td><?php echo $row['scid']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['studname']; ?></td></tr>

<tr><th>Enstep Ptr (pointer)</th><td>
	<input type="number" min=1 max=10 name="contact[enstep]" value="<?php echo $row['enstep']; ?>" >
</td></tr>


<?php for($i=1;$i<=$num_ensteps;$i++): ?>
	<tr><th>Finalized Step <?php echo $i; ?></th><td>
		<input class="pdl05" type="date" tabIndex=2 id="date-<?php echo $i; ?>" name="step[finalized_s<?php echo $i; ?>]" 
			value="<?php echo $row['finalized_s'.$i]; ?>" >
		<span class='button' onclick="clearDate(<?php echo $i; ?>);" >Clear</span>	
		<span class='button' onclick="setToday(<?php echo $i; ?>);" >Today</span>	
	</td></tr>
<?php endfor; ?>


<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>

</table>
</form>
<?php endif; ?> 	<!-- scid -->

<br>
<?php

	$incfile=SITE.'views/customs/'.VCFOLDER.'/enstep_notes_'.VCFOLDER.'.php';
	if(is_readable($incfile)){ require_once($incfile); } 		

?>


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var today = "<?php echo $today; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/ensteps/student/'+id+'/'+sy;	
	window.location=url;
}	/* fxn */

function clearDate(i){
	$('#date-'+i).val(null);
}

function setToday(i){
	$('#date-'+i).val(today);
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
