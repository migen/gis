<?php 

// pr($_SESSION['q']);
// pr($room);

?>

<h5> Edit Circle - <?php echo $room['name']; ?> 
	| <a href="<?php echo URL.'circles'; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a onclick="doubleConfirm();return false;" href="<?php echo URL.'mis/eradicateCircle/'.$room['id']; ?>" >Eradicate</a>

</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr><th class="bg-blue2 white" >Privacy</th><td>
	<select class="full"  name="is_public" >
		<option value="0" <?php echo ($room['is_public']=='0')? 'selected':NULL; ?> >Private</option>
		<option value="1" <?php echo ($room['is_public']=='1')? 'selected':NULL; ?> >Public</option>
	</select>
</td></tr>

<tr><th class="bg-blue2 white" >Tag Category</th><td>
	<select class="full"  name="ctagcategory_id" >
		<option value="0" >None</option>
		<?php foreach($ctc AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$room['ctagcategory_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>


</td></tr>

<tr><th class="bg-blue2 white" >Name</th><td><input class="pdl05 full" type="text" name="name" value="<?php echo $room['name']; ?>" ></td></tr>
<tr><th class="bg-blue2 white" >Topic</th><td><input class="pdl05 full" type="text" name="topic" value="<?php echo $room['topic']; ?>" ></td></tr>


</table>

<p>
	<input type="submit" name="submit" value="Update"   />
	<button><a href="<?php echo URL.'circles'; ?>" class="black no-underline" >Cancel</a></button>	
		
</p>

</form>