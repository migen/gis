<?php

//------------------------------------------------
$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = ($parts[0]))? $c : 'index'; 			


?>


<h5>
	Status	
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr><th><input type="text" class="pdl05" name="code" placeholder="ID Number"  />
	<input type="submit" name="search" value="Search"  />
</th></tr>
</table>
</form>


<!---------------------------------------------------------------------->


<?php
	
	
	
?>

<!---------------------------------------------------------------------->

<form method="POST" >

<table class="gis-table-bordered table-fx" >
<tr><th><a href='<?php echo URL."contacts/edit/".$contact['id']; ?>'>Edit</a></th><td class="vc300" ><?php echo $contact['id']; ?></td></tr>
<tr><th>ID Number</th><td><?php echo $contact['code']; ?></td></tr>
<tr><th>Name</th><td><?php echo $contact['name']; ?></td></tr>

<?php if($with_chinese): ?>
	<tr><th>Chinese</th><td><?php echo $contact['chinese_name']; ?></td></tr>
<?php endif; ?>

<tr><th>Title</th><td><?php echo $contact['title_id']; ?></td></tr>
<tr><th>Login</th><td><?php echo $contact['account']; ?></td></tr>
<tr><th>Status</th>
<td>
	<select name='status' class="full"  >
		<option value="1" <?php echo ($contact['is_active']==1)? 'selected':null; ?> >Active</option>
		<option value="0" <?php echo ($contact['is_active']!=1)? 'selected':null; ?> >Inactive</option>
	</select>	
</td>	
</tr>

<tr><td colspan="2" >
	<input type="submit" name="submit" value="Update" />
	<button>Cancel</button>
</td></tr>
</table>

<input type="hidden" name="cid" value="<?php echo $contact['id']; ?>" />
</form>