<style>

#content div { border: 1px solid black; }

</style>

<h3 class="pagelinks" >

	Add Student <?php $this->shovel('homelinks'); ?>


</h3>

<form method="" >
<div class="full" >
<table class="gis-table-bordered" >
<tr>
	<th>Surname</th>
	<th>Firstname</th>
	<th>Middlename</th>
</tr>

<tr>
	<td><input name="surname" placeholder="Surname" ></td>
	<td><input name="firstname" placeholder="First name" ></td>
	<td><input name="middlename" placeholder="Middle name" ></td>
</tr>

<tr>
<th>ID No.</th>
<td><input name="code" placeholder="ID No."   ></td>

<th>Birthdate</th>
<td><input name="birthdate" placeholder="Birthdate" type="date"   ></td>

</tr>



</table>
</div>
</form>
