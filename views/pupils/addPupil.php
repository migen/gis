<style>

#content div { border: 1px solid black; }
#studform input { padding-left:5px; } 


</style>

<h3 class="pagelinks" >

	Add / Edit Student <?php $this->shovel('homelinks'); ?>


</h3>

<p>
Carl to do <br />
Section - Fields: <br />

 <br />


</p>


<form id="studform" method="POST" >
<div class="full" >
<table class="gis-table-bordered" >
<tr>
	<th>Surname</th>
	<th>Firstname</th>
	<th>Middlename</th>
</tr>

<tr>
	<td><input name="profile[last_name]" placeholder="Last name" <?php echo ($row)? $row['last_name']:NULL; ?> ></td>
	<td><input name="profile[first_name]" placeholder="First name" ></td>
	<td><input name="profile[middle_name]" placeholder="Middle name" ></td>
</tr>

<tr>
	<th>ID No.</th>
	<th>Phone</th>
	<th>Email</th>
</tr>

<tr>
	<td><input name="profile[code]" placeholder="ID Number" ></td>
	<td><input name="profile[phone]" placeholder="phone" ></td>
	<td><input name="profile[email]" placeholder="email" ></td>
</tr>


<tr>
	<th>Address</th>
	<td colspan=2 ><input name="profile[address]" placeholder="Address" class="full" ></td>
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


