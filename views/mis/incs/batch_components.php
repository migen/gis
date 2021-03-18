<div class="third" >
<form method="POST" >
<h5 onclick="tracepass();" >Batch Create</h5>
<table class="hd gis-table-bordered" >
	<tr><td>Level ID's</td><td><input class="pdl05" name="level_string" /></td></tr>
	<tr><td>Subject ID's</td><td><input class="pdl05" name="subject_string" /></td></tr>
	<tr><td>Subject ID's</td><td><input class="pdl05" name="subject_string" /></td></tr>
	<tr><td colspan="2" ><input onclick="return confirm('Proceed?');" type="submit" name="create" value="Create"  /></td></tr>
</table>
</form>

<!--------------delete--------------->
<form method="POST" >
<div class="hd" >
<h5>*Dangerous Batch DELETE</h5>
<table class="hd gis-table-bordered" >
	<tr><td>Course ID's</td><td><input class="pdl05" name="courses_string" /></td></tr>
	<tr><td colspan="2" ><input onclick="return confirm('DANGEROUS! Proceed?');" type="submit" name="delete" value="DELETE"  /></td></tr>
</table>
</form>
</div>
</div>
