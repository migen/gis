<?php 

// pr($_SESSION['q']);

?>

<h5>
	Tuition Fees Table	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	

<?php 
	$d['sy']=$sy;$d['repage']="tfees/table";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."tuitions/level/".$sel['id']."/$sy?num=1"; ?>' ><?php echo $sel['code']; ?></a> &nbsp;  &nbsp;  
<?php endforeach; ?>
</p>


<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >
<tr>
<th>#</th>
<th>L#</th>
<th>Level</th>
<th>Label</th>
<th class="vc60" >Num
	<br /><input class="vc50" id="inum" />
	<input type="button" value="All" onclick="populateColumn('num');" >						
</th>
<th class="vc60" >Tuition
	<br /><input class="vc80" id="iamount" />
	<input type="button" value="All" onclick="populateColumn('amount');" >						
</th>


</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['tid']; ?>" readonly /></td>
	<td><?php echo $rows[$i]['lvlid']; ?></td>
	<td>
		<select name="posts[<?php echo $i; ?>][level_id]" >
			<?php foreach($levels AS $sel): ?>	
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$rows[$i]['lvlid'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input class="vc100" name="posts[<?php echo $i; ?>][label]" tabindex="10"
		value="<?php echo $rows[$i]['label']; ?>" /></td>
	
	<td><input class="num vc50" name="posts[<?php echo $i; ?>][num]" tabindex="20"
		value="<?php echo $rows[$i]['num']; ?>" /></td>

	<td><input class="amount vc80 right" name="posts[<?php echo $i; ?>][amount]" tabindex="30"
		value="<?php echo $rows[$i]['amount']; ?>" /></td>					
		
		
		
</tr>
<?php endfor; ?>

</table>

<p>
	<input class="hd" type="submit" name="update" value="Update" onclick="return confirm('Sure?');" />
</p>

</form>


<script>

$(function(){
	hd();
	
})

</script>