<h3>
	SJAM Paymode SY<?php echo ($sy); ?> | <?php $this->shovel('homelinks'); ?>
	<?php if($srid!=RSTUD): ?>
		| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
	<?php endif; ?>	
	<?php if($srid!=RSTUD): ?>
		| <a href="<?php echo URL.'ensteps/student/'.$scid.DS.$sy; ?>" >Enrollment-Steps</a>
	<?php endif; ?>
		| <a href='<?php echo URL."students/tuitions/$scid/".$sy; ?>' >Tuitions</a>		
		| <a href='<?php echo URL."students/feespolicies"; ?>' >Policies</a>		


	

	| <?php if($sy==DBYR): ?>
		<a href="<?php echo URL.'students/paymode/'.$scid.DS.(DBYR+1); ?>" ><?php echo 'SY'.(DBYR+1); ?></a>
	<?php else: ?>
		<a href="<?php echo URL.'students/paymode/'.$scid.DS.(DBYR); ?>" ><?php echo 'SY'.DBYR; ?></a>	
	<?php endif; ?>


</h3>


<?php 

// prx($data);


extract($row);
$strand_selection=($level_id>13)? true:false;



if($strand_selection){

	// 1 - 
	$q="SELECT cr.id AS crid,cr.name AS classroom,m.id,m.code AS strand
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.crid=cr.id
		INNER JOIN {$dbo}.05_strands AS m ON cr.num=m.id
		WHERE summ.scid=$scid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$stud02=$sth->fetch();
	
	
	// 2 - strands
	$cond_sxn=($level_id==14)? 'cr.section_id=1':'cr.section_id<>1';
	$q="SELECT cr.id AS crid,cr.num,cr.name AS classroom,m.id,m.code AS strand,s.name AS section
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.05_sections AS s ON cr.section_id=s.id
		INNER JOIN {$dbo}.05_strands AS m ON cr.num=m.id
		WHERE cr.level_id=$level_id AND $cond_sxn; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$strands=$sth->fetchAll();
	debug($q);
	debug($strands);
	
	
}	/* shs */




$today=$_SESSION['today'];


/* navigation controls */
echo $controls."<div class='clear'>&nbsp;</div>";

/* locking */
$is_locked=($srid==RSTUD)? isFinalizedEnstep($db,$scid,$enstep=2):false;


$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";




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
<form method="POST" id="form" >
<table class="gis-table-bordered" >
<tr><th>Level</th><td><?php echo $row['level']; ?>
&nbsp; <span class="tf10" >(<?php echo $row['classroom']; ?>)</span>
</td></tr>
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td class="vc200" ><?php echo $row['studname']; ?></td></tr>

<?php if($srid==RSTUD): ?>
	<tr><th>Status</th><td><?php echo ($is_locked)? 'Locked':'Open'; ?></td></tr>
<?php endif; ?>

<tr><th>Paymode</th><td><?php echo $row['paymode']; ?></td></tr>

<?php if($strand_selection): ?>
	<tr><th>Strand</th><td><?php echo $stud02['strand']; ?></td></tr>
<?php endif; ?>

<?php if(($srid==RSTUD) && ($is_locked)){ echo "</table>"; exit; } ?>
	<?php if($row['level_id']>2): ?>
		<tr><th>Change</th><td>
			<input type="hidden" name="summ[id]" value="<?php echo $row['pkid']; ?>" >
			<select name="summ[paymode_id]"   >
				<?php foreach($paymodes AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo ($row['paymode_id']==$sel['id'])? 'selected':NULL; ?> >
						<?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td></tr>
	<?php else: ?>	
		<tr><th>Change</th><td>
			<input type="hidden" name="summ[id]" value="<?php echo $row['pkid']; ?>" >
			<select name="summ[paymode_id]"   >
				<option value=1 <?php echo ($row['paymode_id']==1)? 'selected':NULL; ?> >Yearly</option>
				<option value=3 <?php echo ($row['paymode_id']==3)? 'selected':NULL; ?> >Monthly</option>
			</select>
		</td></tr>
	<?php endif; ?>		

	
	<?php if($strand_selection): ?>
		<tr><th>Change</th><td>
			<select name="summ[crid]"   >
				<?php foreach($strands AS $sel): ?>
					<option <?php echo ($sel['crid']==$stud02['crid'])? 'selected':NULL; ?> value="<?php echo $sel['crid']; ?>" >
						<?php echo $sel['strand'].' - '.$sel['classroom']; ?></option>
				<?php endforeach; ?>
			</select>
		</td></tr>		
	<?php endif; ?>
	
	

</table>

<div class="screen clear action-btn">
	<div class="form-group">
		<div class="input-group">								
		<?php if($srid!=RSTUD) : ?>							
			<br />
			<div class="" >
				<input class="btn input-control datasheet-btn" 
					id="btnSave" type="submit" name="submit" value="Save" >
			</div>
		<?php endif; ?>

		<?php if(($srid==RSTUD) && (!$is_locked)): ?>
			<br />
			<div class="" ><br />
			<input class="btn datasheet-btn" id="btnSave"
				 type="submit" name="submit" value="Save"  >							
			<input class="btn datasheet-btn" id="btnFinalize"
				 type="submit" name="submit" value="Finalize" 
				onclick="return confirm('One time update only. Sure?');" >
			</div>
		<?php endif; ?>
				
				
		</div>
	</div>
</div>


</form>
<?php endif; ?> 	<!-- scid -->

<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var today="<?php echo $today; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

	$('#btnFinalize').click(function(){
		var lock = "<input name='contact[enstep]' readonly value=3 >";
		lock+="<input name='step[finalized_s2]' readonly value='"+today+"' >";
		$('#form').append(lock);
	})

	
})	/* fxn */

function axnFilter(id){
	var url = gurl+'/students/paymode/'+id+'/'+sy;	
	window.location=url;
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
