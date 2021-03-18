<?php 


pr($data);

$dc_today = date_create(date('Y-m-d'));
$this->shovel('age');


?>

<h5>
	<a href="<?php echo URL.'registrars'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>

<form method="POST" >
<?php $s = $data['student']; ?>
<?php // pr($s); ?>

<!-- ================== Profile ================== -->

<h4> Profile </h4>

<table class="gis-table-bordered" >

<tr class="hd" >
	<th class="vc200 bg-gray3" >SCID</th>
	<td class="vc200" ><?php echo $s['scid']; ?></td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >ID Number</th>
	<td class="vc200" ><?php echo $s['student_code']; ?></td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >Student</th>
	<td class="vc200" ><?php echo $s['student']; ?></td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >First Name</th>
	<td class="vc200" > <input class="full" type="text" name="data[first_name]" value="<?php echo $s['first_name']; ?> " /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >Middle Name</th>
	<td class="vc200" > <input class="full" type="text" name="data[middle_name]" value="<?php echo $s['middle_name']; ?> " /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >Last Name</th>
	<td class="vc200" > <input class="full" type="text" name="data[last_name]" value="<?php echo $s['last_name']; ?> " /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" > Mobile </th>
	<td class="vc200" ><input class="full" type="text" name="data[sms]" value="<?php echo $s['sms']; ?>"  /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >Email</th>
	<td class="vc200" ><input class="full" type="text" name="data[email]" value="<?php echo $s['email']; ?>"  /> </td>
</tr>


<tr>
	<th class="vc200 bg-gray3" >Birthdate</th>
	<td class="vc200" ><input class="full" type="date" name="data[birthdate]" value="<?php echo $s['birthdate']; ?>"  /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >Age</th>
	<td class="vc200" ><input class="vc50 center" type="text" name="data[age]" value="<?php echo getAge($s['birthdate'],$dc_today);  // echo $s['age']; ?>"  /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >City</th>
	<td class="vc200" >
	
	
		<select class="full" name="data[city_id]" >
			<?php foreach($data['selects']['cities'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($s['city_id'] == $sel['id'])? 'selected' : null; ?> > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>		
	</td>
</tr>

<tr>
	<th class="vc200 bg-gray3" >0-Inactive <br /> 1-Active</th>
	<td class="vc200" ><input class="vc50 center" type="text" name="data[is_active]" value="<?php echo $s['is_active']; ?>"  /> </td>
</tr>


</table>

<!-- ================== Student ================== -->

<br /><hr />
<h4> Promotion </h4>

<table class="gis-table-bordered">

<tr>
	<th class="vc200 bg-gray3" >0-New <br /> 1-Old Student</th>
	<td class="vc200" ><input class="vc50 center" type="text" name="data[is_old]" value="<?php echo $s['is_old']; ?>"  /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" > Is Promoted </th>
	<td class="vc200" ><input class="vc50 center" type="text" name="data[is_finalized]" value="<?php echo $s['is_finalized']; ?>"  /> </td>
</tr>

<tr>
	<th class="vc200 bg-gray3" > Previous Class </th>
	<td class="vc200" >
		<select class="full" name="data[prevcrid]" >
			<?php foreach($data['selectsClassrooms'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($s['prevcrid'] == $sel['id'])? 'selected' : null; ?> > <?php echo $sel['level'].' - '.$sel['section']; ?> </option>
			<?php endforeach; ?>
		</select>		
	</td>
</tr>

<tr>
	<th class="vc200 bg-gray3" > Promoted Class </th>
	<td class="vc200" >
		<select class="full" name="data[crid]" >
			<?php foreach($data['selectsClassrooms'] as $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($s['crid'] == $sel['id'])? 'selected' : null; ?> > <?php echo $sel['level'].' - '.$sel['section']; ?> </option>
			<?php endforeach; ?>
		</select>		
	</td>
</tr>


</table>


<!-- ================== SUBMIT ================== -->
<br /><input type="submit" name="submit" value="Update" >
<button><?php echo isset($_SERVER['HTTP_REFERER'])? '<a style="color:#000;text-decoration:none;" href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : '<a style="color:#000;text-decoration:none;" href="'.URL.'registrars/promoted/'.$_SESSION['promoted_crid'].DS.$_SESSION['promoted_sy'].'" >Cancel</a>'; ?></button>

</form>

<script>
	$(function(){
		nextViaEnter();
	})

</script>