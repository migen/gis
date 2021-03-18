<h5>
	Tuition Modes of Payment
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'accounts'; ?>" >Accounts</a>	

</h5>

<p>*Dates - Separated by comma and no space in between.</p>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>Mode</th>
	<th class="vc50" >Surg (%)</th>
	<th class="vc500" >Dates</th>
	<th class="vc200" >Periods</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><input class="full pdl05" name="posts[<?php echo $i; ?>][surcharge]" value="<?php echo $rows[$i]['surcharge']; ?>" ></td>
	<td><input class="full pdl05" name="posts[<?php echo $i; ?>][dates]" value="<?php echo $rows[$i]['dates']; ?>" ></td>
	<td><input class="full pdl05" name="posts[<?php echo $i; ?>][periods]" value="<?php echo $rows[$i]['periods']; ?>" ></td>
</tr>
	<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" >
<?php endfor; ?>
</table>

<p>
<button onclick="tracehd();return false;" >Update</button>
</p>

<p class="hd" >
	<input onclick="" type="submit" name="submit" value="Save" />
</p>
</form>

<!------------------------------->

<script>

$(function(){
	hd();
})


</script>