<h5>
	MIS Subjects-Courses CodeName Updater
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<p>*Updates 1) subjects and 2) courses </p>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
<th>Field</th>
<td>
	<select name="field" >
		<option value="code" >Code</option>
		<option value="name" >Name</option>
	</select>
</td>
</tr>
<tr><th>From</th><td><input name="from" ></td></tr>
<tr><th>To</th><td><input name="to" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Submit" /></th></tr>

</table>
</form>
