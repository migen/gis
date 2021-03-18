<style>

#content div { border: 1px solid black; }
#studform input { padding-left:5px; } 


</style>

<?php 

// pr($row);

// echo ($row)? "row edit ":"no row - add";
// echo "<br />";

?>

<h3 class="pagelinks" >

	Add / Edit Student <?php $this->shovel('homelinks'); ?>


</h3>

<p>
Carl to do <br />
Default - here <br />
Then remaining columns - single row foreach <br />



</p>


<form id="studform" method="POST" >
<div class="full" >
<?php 
	$first_name=($row)? $row['first_name']:NULL;
	$father=($row)? $row['father']:NULL;
?>


<table class="gis-table-bordered" >
<tr>
	<th>Surname</th>
	<th>Firstname</th>
	<th>Middlename</th>
</tr>
<tr>
	<td><input name="profile[last_name]" placeholder="Last name" value="<?php echo ($row)? $row['last_name']:NULL; ?>" ></td>
	<td><input name="profile[first_name]" placeholder="First name" value="<?php echo $first_name; ?>" ></td>
	<td><input name="profile[middle_name]" placeholder="Middle name" ></td>
</tr>

<tr>
	<th>ID No.</th>
	<th>Phone</th>
	<th>Email</th>
</tr>
<tr>
	<td><input name="contact[code]" placeholder="ID Number" ></td>
	<td><input name="profile[phone]" placeholder="phone" ></td>
	<td><input name="profile[email]" placeholder="email" ></td>
</tr>


<tr>
	<th>Address</th>
	<td colspan=2 ><input name="profile[address]" placeholder="Address" class="full" ></td>
</tr>


<tr>
	<th>Father</th>
	<th>Mother</th>
	<th>Guardian</th>
</tr>
<tr>
	<td><input name="profile[father]" placeholder="Father" value="<?php echo $first_name; ?>" ></td>
	<td><input name="profile[mother]" placeholder="Mother" ></td>
	<td><input name="profile[guardian]" placeholder="Guardian" ></td>
</tr>

<tr>
	<th>Father's Occupation</th>
	<th>Mother's Occupation</th>
	<th>Guardian's Relationship</th>
</tr>
<tr>
	<td><input name="profile[father_occupation]" placeholder="Father's Occupation" ></td>
	<td><input name="profile[mother_occupation]" placeholder="Mother's Occupation" ></td>
	<td><input name="profile[guardian_relationship]" placeholder="Guardian's Relationship" ></td>
</tr>




<tr>
	<th colspan=3><input type="submit" name="submit" value="Submit" ></th>
</tr>



</table>
</div>
</form>



<script>

$(function(){
	$('input[name="surname"]').focus();
	
})



</script>


