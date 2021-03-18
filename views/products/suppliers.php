<?php 

?>

<?php 
	$readonly = isset($_SESSION['readonly'])? $_SESSION['readonly'] : true;

	
?>

<!-------------------------------------------------------------------->

<h5> 	
	<span class="u" ondblclick="traceshd();" >Suppliers</span> 	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'suppliers/add'; ?>">Add Supplier</a> 
	
</h5>

	
<?php if($_SESSION['srid']==RMIS): ?>
<table>
<tr><th class="white bg-blue2" >Role</th>
	<td>
		<select class="vc200" onchange="jsredirect('products/suppliers/'+this.value);" >
			<option>Choose One</option>
			<option value="0">All with Teachers</option>
			<option value="1">All Non-Teachers</option>
			<?php foreach($roles AS $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php endforeach; ?>
		</select>
	</td>
</tr>
</table>
<p>*Ajax UpdateRow, Attschema</p>

<?php endif; ?>


<!-------------------------------------------------------------------->


<form method="POST" >


<table class="gis-table-bordered table-fx table-altrow" >

<tr class="headrow" >
	<th>#</th>
	<th>U|P</th>
	<th>ID<br />Number</th>
	<th>Name</th>	
	<th class="" ></th>
	

</tr>

<?php 
	$num_sum=0;
?>


<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>	
<td>
	<?php echo $employees[$i]['ucid']; ?>		
	<?php if($employees[$i]['ucid']!=$employees[$i]['pcid']){ echo "|".$employees[$i]['pcid']; } ?>				
</td>	
	
	<td class="u" id="<?php echo $employees[$i]['ctp']; ?>" ondblclick="alert(this.id);" ><?php echo $employees[$i]['code']; ?></td>
	<td><?php echo $employees[$i]['employee']; ?></td>
				
	
	<td class="" >
		<a href='<?php echo URL."suppliers/view/".$employees[$i]['ucid']; ?>' class="txt-blue underline" >View</a>
		| <a href='<?php echo URL."suppliers/edit/".$employees[$i]['ucid']; ?>' class="txt-blue underline" >Edit</a>
	</td>

</tr>
<?php endfor; ?>
</table>

<?php if($_SESSION['srid']==RMIS): ?>
	<p>For mis/employing use only.</p>
	<p><input onclick="return confirm('Proceed?');" type="submit" name="submit" value="Save All"   /></p>
<?php endif; ?>
</form>









<script>


var gurl="http://<?php echo GURL; ?>";

$(function(){

	
})

</script>






