<h5>
	Prepare Summaries,Attendance,Promotions (every beginning of sy) <br />
	<?php $this->shovel('homelinks','mis'); ?>
</h5>


<?php 
	

?>

<form method="POST" >
<table class="gis-table-bordered table-fx" >

	<tr>
		<td> <input class="pdl05" type="number" value="<?php echo $_SESSION['sy']; ?>"  name="sy" /> </td>
	</tr>

	<tr>
		<td> <input type="submit" name="init" value="Initialize"  /> </td>
	</tr>
	
</table>

</form>