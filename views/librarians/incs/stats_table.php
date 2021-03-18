<style>


</style>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();

})


</script>


<table class="gis-table-bordered" >
	<tr>
	<th>Date Range</th>
	<td><?php echo $_GET['start']; ?> ~ <?php echo $_GET['end']; ?></td>
	
	</tr>
</table><br />


<!--------------->

<table id="tblExport" class="gis-table-bordered center" >

<tr>
	<th>Stud \ Lib</th>
	<th>Def<br />Lib</th>
	<th>GS<br />Lib</th>
	<th>HS<br />Lib</th>
	<th>SHS<br />Lib</th>
	<th>Total</th>
	<?php $gtotal=0; ?>
</tr>

<tr>
	<th class="left" >GS</th>
	<td><?php echo $rows[0][2]['count']; ?></td>
	<td><?php echo $rows[2][2]['count']; ?></td>
	<td><?php echo $rows[3][2]['count']; ?></td>
	<td><?php echo $rows[4][2]['count']; ?></td>
	<td>
		<?php
			$sum=0;
			for($i=0;$i<5;$i++){
				if($i==1) continue;$sum+=$rows[$i][2]['count'];
			}
			echo $sum;
			$gtotal+=$sum;
		?>
	</td>
	
</tr>

<tr>
	<th class="left" >HS</th>
	<td><?php echo $rows[0][3]['count']; ?></td>
	<td><?php echo $rows[2][3]['count']; ?></td>
	<td><?php echo $rows[3][3]['count']; ?></td>
	<td><?php echo $rows[4][3]['count']; ?></td>
	<td>
		<?php
			$sum=0;
			for($i=0;$i<5;$i++){
				if($i==1) continue;$sum+=$rows[$i][3]['count'];
			}
			echo $sum;
			$gtotal+=$sum;
			
		?>
	</td>
	
</tr>

<tr>
	<th class="left" >SHS</th>
	<td><?php echo $rows[0][4]['count']; ?></td>
	<td><?php echo $rows[2][4]['count']; ?></td>
	<td><?php echo $rows[3][4]['count']; ?></td>
	<td><?php echo $rows[4][4]['count']; ?></td>
	<td>
		<?php
			$sum=0;
			for($i=0;$i<5;$i++){
				if($i==1) continue;$sum+=$rows[$i][4]['count'];
			}
			echo $sum;
			$gtotal+=$sum;			
		?>
	</td>
</tr>


<tr>
	<th class="left" >Empl</th>
	<td><?php echo $rows[0][9]['count']; ?></td>
	<td><?php echo $rows[2][9]['count']; ?></td>
	<td><?php echo $rows[3][9]['count']; ?></td>
	<td><?php echo $rows[4][9]['count']; ?></td>
	<td>
		<?php
			$sum=0;
			for($i=0;$i<5;$i++){
				if($i==1) continue;$sum+=$rows[$i][9]['count'];
			}
			echo $sum;
			$gtotal+=$sum;			
		?>
	</td>	
</tr>


<!------------------------------->
<tr>
	<th class="left" >Total</th>
	<td>
		<?php
			$sum=0;
			for($j=2;$j<5;$j++){
				if($i==1) continue;$sum+=$rows[0][$j]['count'];
			}
			$sum+=$rows[0][9]['count'];
			echo $sum;
		?>
	</td>

	<td>
		<?php
			$sum=0;
			for($j=2;$j<5;$j++){
				if($i==1) continue;$sum+=$rows[2][$j]['count'];
			}
			$sum+=$rows[2][9]['count'];
			echo $sum;
		?>
	</td>
	
	<td>
		<?php
			$sum=0;
			for($j=2;$j<5;$j++){
				if($i==1) continue;$sum+=$rows[3][$j]['count'];
			}
			$sum+=$rows[3][9]['count'];			
			echo $sum;
		?>
	</td>	
	
	<td>
		<?php
			$sum=0;
			for($j=2;$j<5;$j++){
				if($i==1) continue;$sum+=$rows[4][$j]['count'];
			}
			$sum+=$rows[4][9]['count'];
			echo $sum;
		?>
	</td>	
	<td><?php echo $gtotal; ?></td>

	
</tr>





</table>





