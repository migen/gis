<?php 

$lvl=isset($_GET['lvl'])? $_GET['lvl']:4;

?>

<h3>
	Rcard Schedule SY<?php echo $sy; ?> (Student Viewing) (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'schedules/rcards&sync'; ?>" >Sync</a>
	| <a href="<?php echo URL.'schedules/ensteps?lvl='.$lvl; ?>" >Ensteps</a>
	
	
	
</h3>

<div class="clear" >
	<a href="<?php echo URL.'schedules/rcards'; ?>" >All</a> |
<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'schedules/rcards?lvl='.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>
</div>
<br>

<table class="gis-table-bordered" >
	<tr><th colspan=3>Status</th></tr>
	<tr><th>Open</th><td>1</td><td>Students can view their report cards.</td></tr>
	<tr><th>Close</th><td>0</td><td>Students <span class="b" >CANNOT</span> view their report cards.</td></tr>
</table><br />

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Level</th>
	<th>Num</th>
	<th>Classroom - ID</th>
	<th>Status<br />
		<input autofocus type="number" min=0 max=1 class="pdl05 vc50 center" id="istatus" value=1 /><br />	
		<input type="button" value="All" onclick="populateColumn('status');" >									
	</th>
	<th></th>
</tr>
<?php foreach($rows AS $i=>$row): ?>
<?php 
if($row['section_id']<3) continue;
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['crid']; ?></td>
	<td><?php echo $row['level']; ?></td>
	<td><?php echo $row['num']; ?></td>
	<td><?php echo $row['name'].' #'.$row['id']; ?></td>
	<td>
		<input type="number" min=0 max=1 class="vc50 status center" value="<?php echo $row['is_open']; ?>"
			id="is_open-<?php echo $i; ?>" name="posts[<?php echo $i; ?>][is_open]"  />
		<input type="hidden" id="pkid-<?php echo $i; ?>" name="posts[<?php echo $i; ?>][id]" value="<?php echo $row['pkid']; ?>" class="vc50" >
	</td>
	
	<td><button id="btn-<?php echo $i; ?>" onclick="xeditRow(<?php echo $i; ?>);return false;" >Save</button></td>	
	
	
</tr>
<?php endforeach; ?>
</table>

<input type="submit" value="Save" name="submit" >

</form>

<div class="ht100" ></div>

<script>

const gurl="http://<?php echo GURL; ?>";
const dbtable="<?php echo $dbtable; ?>";

$(function(){
	selectFocused();
	nextViaEnter();

	
})



function xeditRow(i){
	$('#btn-'+i).hide();		
	const pkid = $('#pkid-'+i).val();
	const is_open = $('#is_open-'+i).val();
	
	var vurl 	= gurl + '/ajax/axdata.php';	
	var task	= "xeditData";	
	var pdata = "task="+task+"&dbtable="+dbtable+"&id="+pkid+"&is_open="+is_open;

	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){} });				
	
}	/* fxn */





</script>
