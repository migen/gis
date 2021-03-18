<h5>
	Chinese 
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
</h5>


<?php 



?>


<?php if(isset($row)): ?>

<table class="gis-table-bordered tf20" >
<tr>
<th><?php echo $row['classroom']; ?></th>
<td>
<?php if($row['sem2']): ?>
<a href='<?php echo URL."aggregates/tally/".$row['crid'].DS.$row['crsid'].DS.$row['subid']."/$sy/$qtr"; ?>' >
	Sem2</a>
<?php else: ?>	
<a href='<?php echo URL."aggregates/tally/".$row['crid'].DS.$row['crsid'].DS.$row['subid']."/$sy/$qtr"; ?>' >
	Tally</a>
<?php endif; ?>	
</td>
<td><a href='<?php echo URL."alien/sumoRanking/".$row['crid']."/$sy/$qtr"; ?>' >Rank</a></td>
</tr>
</table>


<?php endif; ?>



