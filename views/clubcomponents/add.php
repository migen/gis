<h5>
	Add Club Components
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<h4 class="brown" >*Enter the ID# of Criteria or Club, NOT the name.</h4>

<p><table class="gis-table-bordered" >
<tr>
<th>Lookups:</th>
<th>Criteria</th>
<th><select class="vc300" >
<?php foreach($criteria AS $sel): ?>
	<option><?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?></select></th><th>Clubs</th>

<th><select class="vc200" ><?php foreach($clubs AS $sel): ?>
	<option><?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?></select>
</th></tr></table></p>

<form method="POST" >

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Criteria
		<br /><input class="vc70" id="icri" /><br />	
		<input type="button" value="All" onclick="populateColumn('cri');" >						
	</th>
	<th>Club
		<br /><input class="vc70" id="iclub" /><br />	
		<input type="button" value="All" onclick="populateColumn('club');" >							
	</th>
	<th>Weight
		<br /><input class="vc70" id="iwt" /><br />	
		<input type="button" value="All" onclick="populateColumn('wt');" >							
	</th>
</tr>
<?php $nr=isset($_GET['numrows'])? $_GET['numrows']:1; ?>
<?php for($i=0;$i<$nr;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input tabindex="1" class="cri vc70" name="post[<?php echo $i; ?>][criteria_id]"  /></td>
	<td><input tabindex="2" class="club vc70" name="post[<?php echo $i; ?>][club_id]"  /></td>
	<td><input tabindex="3" class="wt vc70" name="post[<?php echo $i; ?>][weight]"  /></td>
</tr>
<?php endfor; ?>
<tr><td colspan=4 ><input type="submit" name="submit" value="Submit"  /></td></tr>
</table>
</form>

<script>

$(function(){

	nextViaEnter();
})

</script>
