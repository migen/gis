<?php

// pr($sy);
// pr($data);

?>


<h5>
	Class Year
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 

<?php  if($user['role_id'] == RREG): ?>	
		| <a href="<?php echo URL.'registrars/registration'; ?>">Registration</a>
		| <a href="<?php echo URL.'sectioning/crid/'.$sy.DS.$crid; ?>">Sectioning</a>		
<?php elseif($user['role_id'] == RMIS): ?>	
		| <a href="<?php echo URL.'mis/classpool/'.$crid; ?>">Sectioning</a>		
<?php endif; ?>	
	
</h5>



<?php 






?>

<!-- ========================  page info / user info =================================-->
<table class='gis-table-bordered table-fx'>
<tr><th class="bg-blue2" >Level</th><td><?php echo $classroom['level']; ?></td></tr>
<tr><th class="bg-blue2" >Section</th><td><?php echo $classroom['section']; ?></td></tr>
<tr><th class="bg-blue2" >School year</th>
<td><?php echo $sy.' - '.($sy+1); ?></td></tr>

<?php if($user['role_id'] != RTEAC): ?>
<tr><th class="bg-blue2" >ID Number</th><td><?php echo $_SESSION['user']['code']; ?></td></tr>
<tr><th class="bg-blue2" >Teacher</th><td><?php echo $_SESSION['user']['fullname']; ?></td></tr>
<tr><th class="bg-blue2" >Go</th>
	<td>
		<select class="vc200" onchange="redirCls('classyear',this.value);" >
			<option value="0">Classroom </option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>
	
<?php endif; ?>	


</table>


<!-- =================== BOYS ===================  -->
<h4> Boys </h4>
<table class="gis-table-bordered" >
<tr class="headrow" >
	<th class="vc30" >#</th>
	<th class="vc100" >ID Number</th>
	<th class="vc400" >Student</th>
<?php  if($user['role_id'] != RTEAC): ?>	
	<th class="vc50" >EAF</th>
<?php endif; ?>	

</tr>

<?php for($i=0;$i<$num_boys;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $boys[$i]['student_code']; ?></td>
	<td><?php echo $boys[$i]['student']; ?></td>
<?php  if($user['role_id'] != RTEAC): ?>	
	<td><a href="<?php echo URL.'registrars/assessment/'.$sy.DS.$boys[$i]['scid']; ?>" >EAF</a></td>
<?php endif; ?>	
</tr>


<?php endfor; ?>

</table>



<!-- =================== GIRLS ===================  -->
<h4> Girls </h4>
<table class="gis-table-bordered" >
<tr class="headrow" >
	<th class="vc30" >#</th>
	<th class="vc100" >ID Number</th>
	<th class="vc400" >Student</th>
<?php  if($user['role_id'] != RTEAC): ?>
	<th class="vc50" >EAF</th>
<?php endif; ?>	
</tr>

<?php for($i=0;$i<$num_girls;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $girls[$i]['student_code']; ?></td>
	<td><?php echo $girls[$i]['student']; ?></td>
<?php  if($user['role_id'] != RTEAC): ?>	
	<td><a href="<?php echo URL.'registrars/assessment/'.$sy.DS.$girls[$i]['scid']; ?>" >EAF</a></td>
<?php endif; ?>	
</tr>


<?php endfor; ?>

</table>



<!----------------------------------------------------------------->

<?php // $this->shovel('debug',$q); ?>


<!-- ------------------------------------------------------------------------------------------------------  -->



<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	= '<?php echo $sy; ?>';

$(function(){
	// hd();

})

function redirCls(axn,crid){
	var rurl 	= gurl + '/registrars/'+axn+'/'+sy+'/'+crid;		
	window.location = rurl;		
}


</script>
