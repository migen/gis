<h5>
	Traits
	
</h5>

<table class="gis-table-bordered table-fx" >
<tr><th>Classroom</th>
<td>
	<select class="" name="" onchange="jsredirect('trs/teachers/'+this.value);" >
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>



</table>



<!------------------------------------------>

<script>

var gurl = "http://<?php echo GURL; ?>";
var home = "<?php echo $_SESSION['home']; ?>";

$(function(){
	
})

</script>