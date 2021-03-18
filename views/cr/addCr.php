<style>

.cdiv{ float:left; width:60%;  }

</style>

<?php 


?>

<h5>
	Add Classrooms
	| <?php $this->shovel('homelinks'); ?>
	
</h5>




<div class="cdiv" >
<form method="POST" >
<input type="hidden" name="last_id" value="<?php echo $crid; ?>" />
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Lvl<br />
		<input class="pdl05 vc50" type="text" id="ilvl" placeholder="Lvl" /><br />	
		<input type="button" value="All" onclick="populateColumn('lvl');" >						
	</th>
	<th>Sxn<br />
		<input class="pdl05 vc50" type="text" id="isxn" placeholder="" /><br />	
		<input type="button" value="All" onclick="populateColumn('sxn');" >						
	</th>
</tr>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<?php $crid+=1; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="vc50" name="post[<?php echo $i; ?>][id]" value="<?php echo $crid; ?>" ></td>
	<td><input class="vc50 lvl" name="post[<?php echo $i; ?>][level_id]" value="" ></td>
	<td><input class="vc50 sxn" name="post[<?php echo $i; ?>][section_id]" tabIndex="2" ></td>
</tr>
<?php endfor; ?>
<tr><th colspan=4 ><input type="submit" name="submit" value="Submit"  /></th></tr>
</table>
</form>


<p><?php $this->shovel('numrows'); ?></p>
</div>	<!-- add -->

<div class="third" >
<table class="levels" >
<tr><th>Levels</th></tr>
<?php foreach($levels AS $sel): ?>
<tr><td><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></td></tr>
<?php endforeach; ?>
</table>
<br />
<table class="sections" >
<tr><th>Sections</th></tr>
<?php foreach($sections AS $sel): ?>
<tr><td><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></td></tr>
<?php endforeach; ?>
</table>


<div class="ht50" ></div>

</div>	<!-- lsm -->


