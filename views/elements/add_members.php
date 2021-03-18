<?php 

	// pr($data);
?>

<p> &nbsp; </p>

<form method="POST" >
<table class="gis-table-bordered table-fx"  >


<tr class="headrow" >
	<th>#</th>
	<th>New Member</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr class="rc" id="tr-<?php echo $i; ?>" >
	<td> &nbsp; </td>	
	<td>
		<select class="vc300" id="mem-<?php echo $i; ?>" class="r-<?php echo $i; ?>" name="members[<?php echo $i; ?>][ucid]" >
			<?php foreach($data['contacts'] AS $sel): ?> 
				<option value="<?php echo $sel['id']; ?>"   ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>

</tr>

<?php endfor; ?>
</table>


<p>
	<input type="hidden" name="room_id" value="<?php echo $data['room_id']; ?>"  />
	<input type="submit" name="add" value="Add"  />
</p>
</form>

<?php $this->shovel('numrows'); ?>


<!------------------------------------------------------------------------------------------------------------------------>

<script>



var gurl 	= 'http://<?php echo GURL; ?>';


$(function(){
	rc('rc');
	hd();
	$('#hdpdiv').hide();

})


function delRow(i){
	$('#tr-'+i).remove();

}



</script>

