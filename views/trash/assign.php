<h5>
	Assign Items
	<span class="u" ondblclick="tracehd();" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products/assignments'; ?>" >Assignments</a>
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>

</h5>

<div class="third" >
<form method="POST" >
<table class="gis-table-bordered table-fx" > 
<tr class="headrow" >
	<th>#</th>
	<th colspan="" class="center" > 
		<select id="iprod" class='vc120'>	
			<option>-Product-</option>
			<?php foreach($products as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].'-'.$sel['id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('prod');" >	
	</th>	
	<th colspan="" class="center" > 
		<select id="isupp" class='vc120'>	
			<option>-Supplier-</option>
			<?php foreach($suppliers as $sel): ?>
				<option value="<?php echo $sel['parent_id']; ?>"> <?php echo $sel['name'].'-'.$sel['parent_id']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('supp');" >	
	</th>		
</tr>
<?php $numrows = isset($_POST['numrows'])? $_POST['numrows']:1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select id="prod<?php echo $i; ?>" class="prod" name="posts[<?php echo $i; ?>][product_id]" >
			<option value="0" >Product</option>
			<?php foreach($products AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td>
		<select id="supp<?php echo $i; ?>" class="supp" name="posts[<?php echo $i; ?>][suppid]" >
			<option value="0" >Supplier</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['parent_id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>		
</tr>
<?php endfor; ?>
</table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
</p>

</form>

<?php $this->shovel('numrows'); ?>

</div>


<div style="width:50px;float:left;height:100px;" ></div>
<div class="" style="width:200px;float:left;"  >
<p class="smartboard" >
<select id="classbox" >
	<option value="prod" >Product</option>
	<option value="pcat" >Category</option>
</select>
</p>
<?php $d['width'] = '40'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<!---------------------------------------------------------------------------->

<script>

$(function(){
	itago('smartboard');

})



</script>
