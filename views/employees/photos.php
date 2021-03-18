<?php 


?>

<h5>
	Employees
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

	| <select class="vc200" onchange="looper('employees,photos,'+this.value);"  >
		<option value="" >Roles</option>
		<option value="" >All</option>
		<?php foreach($roles AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</h5>

<p><?php $this->shovel('hdpdiv'); ?></p>



<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Actv</th>
	<th>ID:U|P</th>
	<th>Photo</th>
	<th>Employee</th>
	<th>Role</th>
	<th class="center" >Manager</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ($employees[$i]['is_active']==1)? 'Y':'--'; ?>
	<td><?php echo $employees[$i]['ucid']; ?>
		<?php if($employees[$i]['ucid']!=$employees[$i]['pcid']){ echo "<br />".$employees[$i]['pcid']; } ?>
	</td>	
	<td>
		<?php if(isset($employees[$i]['photo_id'])): ?>
			<img src="data:image/jpeg;base64,<?= base64_encode($employees[$i]['photo']); ?>" width="120" border="0" />
		<?php else: ?>
			<a href='<?php echo URL."syncs/photo/".$employees[$i]['parent_id']; ?>' >Sync</a>
		<?php endif; ?>
	</td>
	<td><?php echo $employees[$i]['name']; ?></td>
	<td><?php echo $employees[$i]['role']; ?></td>	
	<td>
		<a href='<?php echo URL."photos/one/".$employees[$i]['parent_id']; ?>'>Upload</a>
		<!-- 
		| <a href='<?php echo URL."img/getpic/".$employees[$i]['parent_id']; ?>'>GET</a>
		
		-->
	<?php if($_SESSION['srid']==RMIS): ?>
		<span class="hd" >
			| <a href='<?php echo URL."mis/purge/".$employees[$i]['ucid']; ?>' onclick="return confirm('Dangerous! Proceed?');" >Purge</a>
		</span>
	<?php endif; ?>	</td>	
	
</tr>
<?php endfor; ?>
</table>

<!---------------------------------------------->

<script>
var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	
})


</script>
