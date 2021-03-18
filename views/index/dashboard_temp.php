<h5>
	<?php echo $this->shovel('breadlinks'); ?>
	<a href="<?php echo URL.'admins'; ?>">Admin</a>
</h5>



<script>

function selectTable(i){
	$("#table"+i).attr('checked',true);
}

function accordionSearch(){

	$(".accordParent table:not(:first)").hide();	
	$('.accordParent').click(function(){
		$(this).children('table').show();		
	})
	
}
</script>


<?php  
	// pr($_SESSION); 
?>

<?php echo $this->shovel('smartlinks'); ?>

<div class='third'>

<h2 class='brown'>Dashboard</h2>

<?php 
	// pr($data);
?>

<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<td colspan=2>Stats</td>
</tr>

<tr>
	<td>Open Transactions</td>
	<td><?php echo count($data['txns']); ?></td>
</tr>

<tr>
	<td>Contacts with Due</td>
	<td><?php echo count($data['contacts']); ?></td>
</tr>

</table>

</div>


<div class='half'>

<h2 class='brown'>Search</h2>

<form method='post'>



	<div class='accordParent' >
		<div>Database</div>
		<table class='gis-table-bordered table-fx' >
			<tr>
				<td colspan='2' class='vc200' >
					<input id='table1' type='radio' name='data[table]' value='1' >Contact<br />
					<input id='table2' type='radio' name='data[table]' value='2' checked >Transaction<br />
					<input id='table3' type='radio' name='data[table]' value='3' >Any<br />
				</td>
			</tr>
		</table>
	</div>
	
	
	<div class='accordParent' onclick='selectTable(this.id);return false;' id='1' >
		<div>Contacts</div>
		<table class='gis-table-bordered table-fx' >
		
		<tr>
			<td>Contact ID</td>			
			<td><select class='full' name='data[Contact][contact_id]' ><option value=''>Choose One</option>
				<?php	foreach($data['selects']['contacts'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>
			</select></td>			
		</tr>				
		
		<tr>
			<td>Contact</td>
			<td><input class='full' type='text' name='data[Contact][name]'></td>
		</tr>

		<tr>
			<td>City</td>			
			<td><select class='full' name='data[Contact][city_id]' ><option value=''>Choose One</option>
				<?php	foreach($data['selects']['cities'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>
			</select></td>					
		</tr>		
		
		<tr>
			<td>Phone</td>
			<td><input class='full' type='text' name='data[Contact][phone]'></td>
		</tr>

		<tr>
			<td>Email</td>
			<td><input class='full' type='text' name='data[Contact][email]'></td>
		</tr>		
				
		</table>
	</div>


	<div class='accordParent' onclick='selectTable(this.id);return false;' id='2' >
		<div>Transactions</div>
		<table class='gis-table-bordered table-fx' >		
		<tr>
			<td>Year</td>
			<td><input class='full' type='text' name='data[Txn][year]'></td>
		</tr>		
		<tr>
			<td>Status</td>			
			<td><select class='full' name='data[Txn][status_id]' ><option value=''>Choose One</option>
				<?php	foreach($data['selects']['statuses'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>
			</select></td>					
		</tr>		
		
		<tr>
			<td>Date From</td>
			<td><input class='juice full' type='date' name='data[Txn][date_from]'></td>
		</tr>
		<tr>
			<td>Date To</td>
			<td><input class='juice full' type='date' name='data[Txn][date_to]'></td>
		</tr>

		</table>
	</div>
	

	
	<div class='accordParent' onclick='selectTable(this.id);return false;' id='3'>
		<div>Search All</div>
		<table class='gis-table-bordered table-fx'>
				
		<tr>
			<td>Keyword</td>
			<td><input class='full' type='text' name='data[name]'></td>
		</tr>

				
		</table>
	</div>
	

	
	
	<input type='submit' name='submit' value='Search' />
</form>

</div>