<?php 
// pr($sacs[0]);


// pr($_SESSION['q']);

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	<?php echo $dept; ?> Subject Coordinators (<?php echo $num_sacs; ?>)
	| <?php 	$this->shovel('homelinks','mis'); ?>	
	| <a href="<?php echo URL.'sac/sacs/'.'1'; ?>"  >PS</a>
	| <a href="<?php echo URL.'sac/sacs/'.'2'; ?>"  >GS</a>
	| <a href="<?php echo URL.'sac/sacs/'.'3'; ?>"  >HS</a> &nbsp; 

	<span class="hd" >HD</span>
	<button class="" ><a onclick="return confirm('Proceed?');" class="no-underline" 
		href="<?php echo URL.'syncs/syncSACS/'.$dept_id; ?>"  >Sync Subjects</a></button>

	
</h5>


<!------------------------------------------------------------------------------------------------------------------------>


<form method="POST" >
<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th class="vc150" >Subject</th>
	<th class="vc200" >Coordinator</th>
</tr>
<!----------------------- data ------------------------------------------------------------>
<?php for($i=0;$i<$num_sacs;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $sacs[$i]['subject']; ?></td>
		<td>
			<select class="vc200" name="sacs[<?php echo $i; ?>][hcid]"  >
				<option value='0'>Choose Coordinator</option>
				<?php foreach($coordinators AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$sacs[$i]['hcid'])? 'selected':null; ?> ><?php echo $sel['name'].' - '.$sel['account']; ?></option>
				<?php endforeach; ?>
			</select>			
		</td>
		
		
		
		<td><a href="<?php echo URL.'mis/delsac/'.$dept_id.DS.$sacs[$i]['sacid'].DS.$sy; ?>">Del</a></td>
		<td><input type="hidden" class="vc50" name="sacs[<?php echo $i; ?>][sacid]"  value="<?php echo $sacs[$i]['sacid']; ?>"  />
			<button id="btn-<?php echo $i; ?>" onclick="xeditSuco(<?php echo $i; ?>);return false;" >Save</button></td>
		<td><?php echo $sacs[$i]['emplcode'].' '.$sacs[$i]['ctp']; ?></td>
		<td><a href="<?php echo URL.'contacts/ucis/'.$sacs[$i]['hcid']; ?>" >Edit</a></td>
	</tr>	
<?php endfor; ?>

</table>

<p><input type="submit" name="update" value="Update"   /></p>

</form>

<hr />
<!------------------------------------------------------------------------->

<form method="POST"  >
<table class="gis-table-bordered table-fx" >
<tr><th>#</th><th>Subject</th><th>Coordinator</th></tr>

	<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
	<?php for($i=0;$i<$numrows;$i++): ?>

<!---------------------------------------------------------------------------->	

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select name="sacs[<?php echo $i; ?>][subid]"  >
			<?php	foreach($subjects as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>		
	<td>
		<select name="sacs[<?php echo $i; ?>][hcid]"  >
			<?php	foreach($coordinators as $sel): ?><option value="<?php echo $sel['ucid']; ?>"><?php echo $sel['name'].' - '.$sel['account']; ?></option><?php	endforeach; ?>				
		</select>
	</td>	
</tr>
	
<?php endfor; ?>			
</table>

<p><input type="submit" name="add" value="Add"  /></p>
</form>

<!------------------------------------------------------------------------->
	<p><?php $this->shovel('numrows'); ?></p>
<!------------------------------------------------------------------------->


<script>

var gurl = 'http://<?php echo GURL; ?>';



$(function(){

hd();

		
})


function xeditSuco(i){

var sacid    = $('input[name="sacs['+i+'][sacid]"]').val();
var ucid    = $('select[name="sacs['+i+'][hcid]"]').val();

var vurl 	= gurl + '/ajax/xsetup.php';	
var task	= "xeditSuco";

$.ajax({
	url: vurl,type: 'POST',async: true,
	data: 'task='+task+'&ucid='+ucid+'&sacid='+sacid,					
	success: function() { $('#btn-'+i).hide(); }		  
});				


}	/* fxn */






</script>


