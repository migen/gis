
<?php 

// pr($num_levels);


?>

<?php if($num_am_levels < $num_levels): ?>
	<button><a class="no-underline" href="<?php echo URL.'mis/syncAM/'.$sy; ?>" >Sync Levels</a></button>
<?php endif; ?>

<!----------------------------------------------------------------------->
<h5>
	<?php echo $sy.' '; ?>
	Attendance Months
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'setup/editMonthsQuarters'; ?>">Months-Quarters</a> 
	
</h5>


<!----------------------------------------------------------------------->
<form method="POST" >
<table class="gis-table-bordered table-fx"  >

<tr class="headrow" >
	<th>#</th>
	<th>Level</th>

	<th class="center" > Jun <br /><input class="center vc50" type="text" id="ijun" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('jun');" ></th>			
	
	<th class="center" > Jul <br /><input class="center vc50" type="text" id="ijul" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('jul');" ></th>			
	
	<th class="center" > Aug <br /><input class="center vc50" type="text" id="iaug" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('aug');" ></th>			

	<th class="center" > Sep <br /><input class="center vc50" type="text" id="isep" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('sep');" ></th>			
	
	<th class="center" > Oct <br /><input class="center vc50" type="text" id="ioct" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('oct');" ></th>			
	
	<th class="center" > Nov <br /><input class="center vc50" type="text" id="inov" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('nov');" ></th>			

		
	<th class="center" > Dec <br /><input class="center vc50" type="text" id="idec" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('dec');" ></th>			
	
	<th class="center" > Jan <br /><input class="center vc50" type="text" id="ijan" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('jan');" ></th>			
	
	<th class="center" > Feb <br /><input class="center vc50" type="text" id="ifeb" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('feb');" ></th>			

	<th class="center" > Mar <br /><input class="center vc50" type="text" id="imar" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('mar');" ></th>			
	
	<th class="center" > Apr <br /><input class="center vc50" type="text" id="iapr" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('apr');" ></th>			
	
	<th class="center" > May <br /><input class="center vc50" type="text" id="imay" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('may');" ></th>			

	<th class="center" > Q1 <br /><input class="center vc50" type="text" id="iq1" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('q1');" ></th>			

	<th class="center" > Q2 <br /><input class="center vc50" type="text" id="iq2" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('q2');" ></th>			
	<th class="center" > Q3 <br /><input class="center vc50" type="text" id="iq3" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('q3');" ></th>			
	<th class="center" > Q4 <br /><input class="center vc50" type="text" id="iq4" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('q4');" ></th>			
		
	<th> Total <br /><input class="center vc50" type="text" id="itotal" value="" ><br />
		<input type="button" value="All" onclick="populateColumn('total');" ></th>		
		
</tr>

<!----------- data ------------------------------------------------------------>

<?php for($i=0; $i<$num_am_levels; $i++): ?>
<tr class="tr" id="<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $am[$i]['level']; ?></td>
<td><input class="lvl<?php echo $i; ?> jun center vc50" name="am[<?php echo $i; ?>][jun]" value="<?php echo $am[$i]['jun_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> jul center vc50" name="am[<?php echo $i; ?>][jul]" value="<?php echo $am[$i]['jul_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> aug center vc50" name="am[<?php echo $i; ?>][aug]" value="<?php echo $am[$i]['aug_days_total']; ?>" ></td>


<td><input class="lvl<?php echo $i; ?> sep center vc50" name="am[<?php echo $i; ?>][sep]" value="<?php echo $am[$i]['sep_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> oct center vc50" name="am[<?php echo $i; ?>][oct]" value="<?php echo $am[$i]['oct_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> nov center vc50" name="am[<?php echo $i; ?>][nov]" value="<?php echo $am[$i]['nov_days_total']; ?>" ></td>


<td><input class="lvl<?php echo $i; ?> dec center vc50" name="am[<?php echo $i; ?>][dec]" value="<?php echo $am[$i]['dec_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> jan center vc50" name="am[<?php echo $i; ?>][jan]" value="<?php echo $am[$i]['jan_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> feb center vc50" name="am[<?php echo $i; ?>][feb]" value="<?php echo $am[$i]['feb_days_total']; ?>" ></td>


<td><input class="lvl<?php echo $i; ?> mar center vc50" name="am[<?php echo $i; ?>][mar]" value="<?php echo $am[$i]['mar_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> apr center vc50" name="am[<?php echo $i; ?>][apr]" value="<?php echo $am[$i]['apr_days_total']; ?>" ></td>
<td><input class="lvl<?php echo $i; ?> may center vc50" name="am[<?php echo $i; ?>][may]" value="<?php echo $am[$i]['may_days_total']; ?>" ></td>

<td><input class="lvl<?php echo $i; ?> q1 center vc50" name="am[<?php echo $i; ?>][q1]" 
	value="<?php echo $am[$i]['q1_days_total']; ?>" ></td>
	
<td><input class="lvl<?php echo $i; ?> q2 center vc50" name="am[<?php echo $i; ?>][q2]" 
	value="<?php echo $am[$i]['q2_days_total']; ?>" ></td>

<td><input class="lvl<?php echo $i; ?> q3 center vc50" name="am[<?php echo $i; ?>][q3]" 
	value="<?php echo $am[$i]['q3_days_total']; ?>" ></td>

<td><input class="lvl<?php echo $i; ?> q4 center vc50" name="am[<?php echo $i; ?>][q4]" 
	value="<?php echo $am[$i]['q4_days_total']; ?>" ></td>	

<td><input id="total<?php echo $i; ?>" class="total center vc50" name="am[<?php echo $i; ?>][total]" 
	value="<?php echo $am[$i]['year_days_total']; ?>" ></td>
<input type="hidden" name="am[<?php echo $i; ?>][amid]" value="<?php echo $am[$i]['amid']; ?>"  />

</tr>
<?php endfor; ?>

<!-- month days total --->




</table>



<p>

<button onclick="tallyTotal();return false;"  >Tally</button>
<input type="submit" name="submit" value="Update"   />
</p>
</form>

<!----------------------------------------------------------------------->

<script>

$(function(){

	nextViaEnter();

})


function tallyTotal(){
	$('.tr').each(function(){
		var i = this.id;
		var total = 0; 
		$('.lvl'+i).each(function(){
			total += parseFloat($(this).val());
		})	
		$('#total'+i).val(total);	
	});
}	// fxn


</script>