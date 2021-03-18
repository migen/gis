

<script>




</script>

<?php 

// pr($_SESSION['registrar']['levels']);

// ================= DEFINE VARS ====================

$sy = $_SESSION['sy'];
$num_classrooms = $data['num_classrooms'];

?>



<h5>
	Reports |
	<a href="<?php echo URL.'registrars'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

</h5>

<form method="POST" >


<div class="third" >

<h4> qtr Level Ranking </h4>
<table class="gis-table-bordered" >

<tr>
	<td class="vc200">
		<select class="full" name="qlr[level_id]"  >
			<?php for($i=0;$i<$num_levels;$i++): ?>
				<option value="<?php echo $levels[$i]['id']; ?>" >  <?php echo $levels[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>

<tr>
	<td>
		<select class="full" name="qlr[hidesection]" >
			<option value="0">Show Section</option>		
			<option value="1">Hide Section</option>
		</select>
	</td>
</tr>

<tr>
	<td>
		<select name="qlr[qtr]" >
			<option value="1">Q1</option>
			<option value="2">Q2</option>
			<option value="3">Q3</option>
			<option value="4">Q4</option>
			<option value="5">FG</option>
		</select>
	</td>
</tr>

<input type="hidden" name="qlr[sy]" value="<?php echo $sy; ?>" />

</table>


<br /><input type="submit" name="qs" value="Get"  />


<!-- ================================================================================== -->

<br /><br /> <hr /> <br /><br />

<h4> Promotions </h4>

<table class="gis-table-bordered" >



<tr>
	<td class="vc200" >
		<select class="full" name="pr[crid]"  >
			<option>Choose Section</option>
			<?php for($i=0;$i<$num_classrooms;$i++): ?>
				<option value="<?php echo $classrooms[$i]['id']; ?>" >  <?php echo $classrooms[$i]['name']; ?> </option>			
			<?php endfor; ?>
		</select>
	</td>
</tr>


<tr>
	<td>
		<select class="full" name="pr[front]" >
			<option value="_front">Front</option>
			<option value="">Detailed</option>		
		</select>
	</td>
</tr>


<input type="hidden" name="pr[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="prs" value="Get"  />

</div>


<!-- =====================================================================================================  -->


<div class="fourth" >

<h4> Honors </h4>


<table class="gis-table-bordered" >



<tr>
	<td class="vc200">
		<select class="full" name="ch[level_id]"  >
			<?php for($i=0;$i<$num_levels;$i++): ?>
				<option value="<?php echo $levels[$i]['id']; ?>" >  <?php echo $levels[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>


<input type="hidden" name="ch[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="chs" value="Get"  />


</div>


<!-- =====================================================================================================  -->


<div class="third" >

<h4> MCR </h4>


<table class="gis-table-bordered" >



<tr>
	<td class="vc200" >
		<select class="full" name="mcr[crid]"  >
			<option>Choose Section</option>
			<?php for($i=0;$i<$num_classrooms;$i++): ?>
				<option value="<?php echo $classrooms[$i]['id']; ?>" >  <?php echo $classrooms[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>

<tr>
	<td>
		<select name="mcr[qtr]" >
			<option value="1">Q1</option>
			<option value="2">Q2</option>
			<option value="3">Q3</option>
			<option value="4">Q4</option>
		</select>
	</td>
</tr>


<input type="hidden" name="mcr[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="mcrs" value="Get"  />


</div>



<!-- =====================================================================================================  -->


<div class="fourth" >

<h4> Subject Level Ranking </h4>


<table class="gis-table-bordered" >

<tr>
	<td class="vc200">
		<select class="full" name="slr[subject_id]"  >
			<?php for($i=0;$i<$num_subjects;$i++): ?>
				<option value="<?php echo $subjects[$i]['id']; ?>" >  <?php echo $subjects[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>


<tr>
	<td class="vc200">
		<select class="full" name="slr[level_id]"  >
			<?php for($i=0;$i<$num_levels;$i++): ?>
				<option value="<?php echo $levels[$i]['id']; ?>" >  <?php echo $levels[$i]['name']; ?> </option>
			<?php endfor; ?>
		</select>
	</td>
</tr>

<tr>
	<td><input class="full" type="number" name="slr[sy]" value="<?php echo $sy?>"  ></td>
</tr>

<tr>
	<td>
		<select name="slr[qtr]" >
			<option value="1">Q1</option>
			<option value="2">Q2</option>
			<option value="3">Q3</option>
			<option value="4">Q4</option>
			<option value="5">FG</option>
		</select>
	</td>
</tr>

<input type="hidden" name="slr[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="ss" value="Get"  />

</div>

<!-- =====================================================================================================  -->


<div class="third" >

<h4> Report Card </h4>


<table class="gis-table-bordered" >



<tr>
	<td class="vc200" >
		<select class="full" name="rc[crid]"  >
			<option>Choose Section</option>
			<?php for($i=0;$i<$num_classrooms;$i++): ?>
				<option value="<?php echo $classrooms[$i]['id']; ?>" >  <?php echo $classrooms[$i]['name']; ?> </option>			
			<?php endfor; ?>
		</select>
	</td>
</tr>

<tr>
	<td>
		<select name="rc[qtr]" >
			<option value="1">Q1</option>
			<option value="2">Q2</option>
			<option value="3">Q3</option>
			<option value="4">Q4</option>
		</select>
	</td>
</tr>




<input type="hidden" name="rc[official]" value="1" />
<input type="hidden" name="rc[sy]" value="<?php echo $sy; ?>" />

</table>

<br /><input type="submit" name="rcs" value="Get"  />


</div>



<!-- =====================================================================================================  -->





</form>

</div>



