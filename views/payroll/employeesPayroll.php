<?php 

$q=$_SESSION['q'];debug($q,"views-employeesPayroll,ajax-xemployees");

?>


<h5>
	Paygroup (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clearance/one'; ?>" >Status</a>
	<?php if($_SESSION['user']['role_id']==RMIS): ?>| <a href="<?php echo URL.'paymaster/sync'; ?>" >Sync</a><?php endif; ?>	
	<?php if(!isset($_GET['all'])): ?>| <a href="<?php echo URL.'payroll/employees?all'; ?>" >All</a><?php endif; ?>	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Ecid</th>
	<th>Status</th>
	<th>Employee</th>
	<th>PGID<br />
		<input class="pdl05 vc50" id="ipgid" /><br />	
		<input type="button" value="All" onclick="populateColumn('pgid');" >								
	</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr class="<?php echo ($rows[$i]['is_active']==1)? "":"red"; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ecid']; ?></td>
	<td><a href="<?php echo URL.'clearance/one/'.$rows[$i]['ecid']; ?>" >Status</a></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><input id="pgid-<?php echo $i; ?>" class="vc50 center pgid" type="number" 
		name="posts[<?php echo $i; ?>][pgid]" value="<?php echo $rows[$i]['paygroup_id']; ?>" /></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][ecid]" value="<?php echo $rows[$i]['ecid']; ?>" >			
	<td><button id="csb-<?php echo $i; ?>" onclick="xeditPaygroup(<?php echo $i.','.$rows[$i]['ecid']; ?>);return false;" >Save</button></td>	
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save All" onclick="return confirm('Sure?');" /></p>

</form> <!-- for batch -->

<div class="ht100" ></div>

<script>

var gurl="http://<?php echo GURL; ?>";

function xeditPaygroup(i,ecid){
	$('#csb-'+i).hide();var pgid = $('#pgid-'+i).val();		
	var vurl=gurl+'/ajax/xemployees.php'; var task="xeditPaygroup";	
	var pdata="task="+task+"&ecid="+ecid+"&pgid="+pgid;
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });					
}	/* fxn */


</script>