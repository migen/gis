<?php 

// pr($rows[3]);

$lvl=isset($_GET['lvl'])? $_GET['lvl']:4;


?>

<h3>
	Scheduling (Enrollment Steps) (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'schedules/rcards&sync'; ?>" >Sync</a>
	| Schedules (
		<a href="<?php echo URL.'schedules/ensteps'; ?>" >All</a>
		| <a href="<?php echo URL.'schedules/rcards?lvl='.$lvl; ?>" >Rcards</a>
		| <a href="<?php echo URL.'schedules/tuitions?lvl='.$lvl; ?>" >Tuitions</a>
		| <a href="<?php echo URL.'schedules/booklists?lvl='.$lvl; ?>" >Booklists</a>
	)
	| <a href="<?php echo URL.'ensteps/student'; ?>" >Student-Ensteps</a>
	
	
</h3>
<div class="clear" >
	<a href="<?php echo URL.'schedules/ensteps'; ?>" >All</a> |
<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'schedules/ensteps?lvl='.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>
</div>
<br>
<table class="gis-table-bordered" >
	<tr><th colspan=3>Status</th></tr>
	<tr><th>Open</th><td>1</td><td>Students can perform enrollment steps.</td></tr>
	<tr><th>Close</th><td>0</td><td>Students <span class="b" >CANNOT</span> access enrollment steps.</td></tr>
</table><br />

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Level</th>
	<th>Num</th>
	<th>Classroom - ID</th>
	<th>Enstep<br />
		<input autofocus type="number" min=0 max="<?php echo $num_ensteps; ?>" class="pdl05 vc50 center" id="ienstep" value=0 /><br />	
		<input type="button" value="All" onclick="populateColumn('enstep');" >									
	</th>
	<th></th>
</tr>
<?php foreach($rows AS $i=>$row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['crid']; ?></td>
	<td><?php echo $row['level']; ?></td>
	<td><?php echo $row['num']; ?></td>
	<td><?php echo $row['name'].' #'.$row['id']; ?></td>
	<td>
		<input type="number" min=0 max="<?php echo $num_ensteps; ?>" class="vc50 enstep center" value="<?php echo $row['enstep']; ?>"
			id="enstep-<?php echo $i; ?>" name="posts[<?php echo $i; ?>][enstep]"  />
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
	const enstep = $('#enstep-'+i).val();
	
	var vurl 	= gurl + '/ajax/axdata.php';	
	var task	= "xeditData";	
	var pdata = "task="+task+"&dbtable="+dbtable+"&id="+pkid+"&enstep="+enstep;

	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){} });				
	
}	/* fxn */





</script>
