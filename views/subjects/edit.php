<?php 

	// pr($data);
	// pr($subcourses[0]);
	// pr($subject);
	// pr($_SESSION['q']);

?>


<h5>
	Edit Subject | 
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr><th class="">Subject</th><td><?php echo $subject['name'].' #'.$subject['id']; ?></td></tr>
<tr><th class="">Name</th><td><input class="vc200 pdl05" type="text" name="subject[name]" value="<?php echo $subject['name']; ?>" /></td></tr>
<tr><th class="">Code</th><td><input class="vc200 pdl05" type="text" name="subject[code]" value="<?php echo $subject['code']; ?>" /></td></tr>
<tr><th class="">Type</th><td>	
	<select class="vc200" name="subject[crstype_id]"  >
		<?php	foreach($crstypes as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$subject['crstype_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td></tr>

<?php foreach($field_array AS $fkey): ?>
	<tr>
		<th><?php echo ucfirst($fkey); ?></th>
		<td>
			<input name="subject[<?php echo $fkey; ?>]" value="<?php echo $row[$fkey]; ?>" >
		</td>
	</tr>
<?php endforeach; ?>
<input type="hidden" name="subject[year]" value="<?php echo $subject['year']; ?>" />
<tr><th colspan="2" ><input class="" type="submit" name="submit" value="Save" />
<button><a href="<?php echo URL.'mis/subjects'; ?>" class="no-underline" >Cancel</a></button>
</th></tr>
</table>

</form>

<div class="ht100" ></div>


<script>

$(function(){
	selectFocused();
	nextViaEnter();
	
})


</script>

