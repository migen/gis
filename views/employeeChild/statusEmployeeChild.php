<h3>
	Employee Child Status | <?php $this->shovel('homelinks'); ?>	
	<?php if($scid): ?>
		| <a href='<?php echo URL."students?scid=$scid"; ?>' >Student Portal</a>
	<?php else: ?>
		| <a href='<?php echo URL."students"; ?>' >Student Portal</a>
	<?php endif; ?>

</h3>


<?php 

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
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td class="vc200" ><?php echo $row['studname']; ?></td></tr>
<tr><th>Status</th><td><?php echo ($row['is_employee_child']==1)? 'IS Employee Child':'NOT an Employee Child'; ?></td></tr>
<tr><th>Change</th><td>
	
	<select name="post[is_employee_child]"   >
		<option value="0" <?php echo ($row['is_employee_child']==0)? 'selected':NULL; ?> >NOT an employee child</option>
		<option value="1" <?php echo ($row['is_employee_child']==1)? 'selected':NULL; ?> >IS employee child</option>
	</select>
</td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>

</table>
</form>
<?php endif; ?> 	<!-- scid -->

<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/employeeChild/status/'+id;	
	window.location=url;
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
