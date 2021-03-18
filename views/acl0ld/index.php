<?php 

// pr($_SERVER);

?>

<h5>ACL
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."acl/add"; ?>' >Add</a>

</h5>


<p>
<form method='GET' >

<table class="gis-table-bordered" >
<tr class="headrow" >
<th>Sort</th><th>Order</th><th># Rows</th><th>Page</th><th>Role</th><th>URL</th><th>&nbsp;</th></tr>
<tr>
	<td>
		<select name="sort" >
			<option value="a.wurl">WURL</option>
			<option value="r.name">Role</option>
		</select>
	</td>	
	<td>
		<select name="order" >
			<option value="ASC" >Asc</option>
			<option value="DESC" <?php $order = (isset($_SESSION['get']['order']) && ($_SESSION['get']['order']=='DESC'))? true:false; 
				echo ($order)? 'selected': null; ?> >Desc</option>
		</select>
	</td>		
	<td><input class="pdl05 vc50" type='number' name='numrows' 
		value="<?php echo (isset($_SESSION['get']['numrows']))? $_SESSION['get']['numrows']:'50'; ?>" /></td>		
	<td><input id="cpage" class="vc50 pdl05" type="number" name="page" value="1" /></td>	

	<td>
		<select name="role" >
			<option value="0" >All</option>
			<?php foreach($roles AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
	</td>		
	<td><input class="pdl05 vc150" type='text' name='wurl' placeholder="Web URL" autofocus /></td>	
	<td><input type='submit' name='submit' value='Filter'></td>		
</tr>
</table>
</form>
</p>

<?php 
	// for sorting
	$get = isset($_GET)? sages($_GET):'';	 
		
?>




<form method="POST" >

<table class="gis-table-bordered table-altrow" >

<tr class="headrow" >
	<th class="vc20" >&nbsp;</th>
	<th>#</th>
	<th>ID</th>
	<th>WURL</th>
	<th>Title</th>
	<th>Role</th>
	<th>Priv</th>
	<th>2x click</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr id="trow<?php echo $i; ?>" >
	<td><input type="checkbox" name="rows[<?php echo $rows[$i]['id'];?>]" 
		value="<?php echo $rows[$i]['id']; ?>" /></td>	
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['wurl']; ?></td>
	<td><?php echo $rows[$i]['title']; ?></td>
	<td><?php echo $rows[$i]['role']; ?></td>
	<td><?php echo $rows[$i]['privilege_id']; ?></td>
	
	<?php 
		$tbl 	= DBO.".acl";
		$id 	= $rows[$i]['id']; 	
	?>
	<td><span class="u" ondblclick='xdelrow("<?=$tbl; ?>","<?=$id; ?>","<?=$i; ?>");' >DELETE</span></td>
</tr>
<?php endfor; ?>

</table>


<p>
	<input type='submit' name='batch' value='Batch' >
	<?php $this->shovel('boxes'); ?>
</p>

</form> <!-- for batch -->



<!------------------------------------------------------------------------>

<p>

	<!-- pagination -->
	<?php  if(isset($num_pages) && $num_pages){ echo $data['pages']; } ?>
</p>

<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	// alert(gurl);
	// tracehd();
	$('#hdpdiv').hide();
	
	nextViaEnter();

})





</script>


