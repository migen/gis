<?php 

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

?>



<h5>
	Tasks
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'tasks/add'; ?>" />Add</a>  
	
	
</h5>

<?php include_once('incs/tasks_filter.php'); ?>



<?php if(isset($_GET['submit'])):  ?>
<form method="POST" >
<br />
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th><input type="checkbox" id="chkAlla"  /></th>
	<th>#</th>
	<th>Date</th>
	<th>Item</th>
	<th>Remarks</th>
	<th>User</th>
	<th>Status</th>
	<th>ID</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>		
	<td class="screen" >
		<?php if(($_SESSION['ucid']==$rows[$i]['ucid']) || ($_SESSION['srid']==RMIS)): ?>
		<input type="checkbox" name="rows[<?php echo $i;?>]" class="chka" tabIndex="2"
			value="<?php echo $rows[$i]['id']; ?>" />
		<?php endif; ?>	
	</td>		
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td class="vc500" ><?php echo $rows[$i]['item']; ?></td>
	<td class="vc300" ><?php echo $rows[$i]['remarks']; ?></td>
	<td><?php echo $rows[$i]['user']; ?></td>
	<td><?php echo ($rows[$i]['is_done']==1)? 'Done':'Pending'; ?></td>
	<td><?php echo $rows[$i]['tid']; ?></td>	
</tr>
<?php endfor; ?>
<tr>
<th colspan="8" >
	<input type="submit" name="batch" value="Edit" />
	<?php if($_SESSION['ucid']==1): ?>
		<input type="submit" name="batch" value="Delete" /> (Delete by UCID#1 Only)
	<?php endif; ?>
</th>
</tr>
</table>
</form>
<?php endif; ?>




<script>

var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var hdpass = "<?php echo HDPASS; ?>";


var day_id = "<?php echo $day_id; ?>";
var tomorrow = "<?php echo $tomorrow; ?>";



$(function(){
	hd();
	$('#hdpdiv').hide();
	excel();
	chkAllvar('a');
	
	$('html').live('click',function(){
		$('#names').hide();
	});
	

})


function nolimits(){
	$('#page').val(1);
	$('#limits').val(0);
}	/* fxn */

function redirContact(ucid){
	$('#ucid').val(ucid);
}	/* fxn */


function getContactID(id,val){
	$('#'+id).val(val);
}	/* fxn */



</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
