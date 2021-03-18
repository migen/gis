<!-- hyperlinks -->
<?php 

// pr($data);
?>

<h5>
	<?php echo $data['classroom']['level'].' - '.$data['classroom']['section'].'<br />'; ?>
	Edit Units |
	<a href="<?php echo URL; ?>teachers">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'teachers/units/'.$data['classroom']['crid']; ?>" />Cancel</a>	
</h5>

<?php // pr($data["students"][0]); ?>


<form method="POST">	
<table class="gis-table-bordered table-fx ">
<!-- ======== headrow ======= -->
<tr class='bg-blue2'>
	<th id="c1" >#</th>
	<th id="c2" >ID Number</th>
	<th id="c3" >Student</th>
	<th id="c4" class="vc80" >Year <br />Entry</th>
	<th id="c5" class="vc80" >Level <br />Entry</th>
	<th id="c6" class="vc80" >Year of <br />Target <br />Graduation </th>
	<th id="c7" class="vc80" >Units <br />Previously <br />Earned</th>
	<th id="c8" class="vc80" >Units <br />Current</th>
	<th id="c9" class="vc80" >Units <br />Total</th>
	<th id="c10" class="vc80" ># Years <br />Earned<br />(Total)</th>
		
</tr>


<tr>	<!-- populate control row -->
	<td id="c1" >&nbsp;</td>
	<td id="c2" >&nbsp;</td>
	<td id="c3" >&nbsp;</td>	
	<td id="c4" class="vc80" >
		<input class="vc80" type="text" id="iyei" value="" >
		<input type="button" value="All" onclick="populateColumn('yei');" >		
	</td>	
	<td id="c5" class="vc80" >
		<input class="vc80" type="text" id="ilei" value="" >
		<input type="button" value="All" onclick="populateColumn('lei');" >		
	</td>	
	<td id="c6" class="vc80" >
		<input class="vc80" type="text" id="igbi" value="" >
		<input type="button" value="All" onclick="populateColumn('gbi');" >		
	</td>	
	<td id="c7" class="vc80" >
		<input class="vc80" type="text" id="iupi" value="" >
		<input type="button" value="All" onclick="populateColumn('upi');" >		
	</td>		
	<td id="c8" class="vc80" >
		<input class="vc80" type="text" id="iuci" value="" >
		<input type="button" value="All" onclick="populateColumn('uci');" >		
	</td>		
	<td id="c9" class="vc80" >
		<input class="vc80" type="text" id="iuti" value="" >
		<input type="button" value="All" onclick="populateColumn('uti');" >		
	</td>		
	<td id="c10" class="vc80" >
		<input class="vc80" type="text" id="iyeti" value="" >
		<input type="button" value="All" onclick="populateColumn('yeti');" >		
	</td>			
	
</tr>

<?php $i=1; ?>
<?php foreach($data['students'] AS $row): ?>
<tr>
	<td id="c1" ><?php echo $i; ?></td>
	<td id="c2" ><?php echo $row['student_code']; ?></td>
	<td id="c3" ><?php echo $row['student']; ?></td>
	<td id="c4" class="colshading vc80" ><input class="yei vc80 " type="text" name="data[Student][<?php echo $i; ?>][year_entry]" value="<?php echo $row['year_entry']; ?>" /></td>
	<td id="c5" class="colshading vc80" ><input class="lei vc80 " type="text" name="data[Student][<?php echo $i; ?>][level_entry]" value="<?php echo $row['level_entry']; ?>" /></td>
	<td id="c6" class="colshading vc80" ><input class="gbi vc80 " type="text" name="data[Student][<?php echo $i; ?>][batch]" value="<?php echo $row['batch']; ?>" /></td>
	<td id="c7" class="colshading vc80" ><input class="upi vc80 " type="text" name="data[Student][<?php echo $i; ?>][units_previous]" value="<?php echo $row['units_previous']; ?>" /></td>
	<td id="c8" class="colshading vc80" ><input class="uci vc80 " type="text" name="data[Student][<?php echo $i; ?>][units_current]" value="<?php echo $row['units_current']; ?>" /></td>
	<td id="c9" class="colshading vc80" ><input class="uti vc80 " type="text" name="data[Student][<?php echo $i; ?>][units_total]" value="<?php echo $row['units_total']; ?>" /></td>
	<td id="c9" class="colshading vc80" ><input class="yeti vc80 " type="text" name="data[Student][<?php echo $i; ?>][years_earned]" value="<?php echo $row['years_earned']; ?>" /></td>
	<input type="hidden" name="data[Student][<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" />
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>

<input type="hidden" name="data[current_level]" value="<?php echo $data['classroom']['level_id']; ?>" />
<input type="hidden" name="data[sy]" value="<?php echo $_SESSION['sy']; ?>" />

<input type="submit" name="submit" value="Update" />
<a class="button" href="<?php echo URL.'registrars/units/'.$data['classroom']['crid']; ?>">Cancel</a>
</form>



<script>
	$(function(){
		nextViaEnter();
		columnHighlighting();
	
	});
		
	

	function populateUnitsPrevious(){
		var up = $("#up").val();
		$(".upInput").val(up);
		
	};
	

</script>


