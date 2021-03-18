<h5>
	Loading
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| GIS Report Printed: <?php echo $_SESSION['today']; ?>
	
</h5>




<?php 
	foreach($teachers AS $k=>$v){
		$count = $counts[$k];
		echo "<div style='border:1px solid white;width:23%;float:left;' >";
			echo "<h4>".$teachers[$k]['name']." ($count)</h4>";
			foreach($loads[$k] AS $row){
				echo $row['course'].'<br />';
			}
			// echo "<hr />";
		echo "</div>";
	}
	

	
?>

<!----------------------------------------------------------------------->
<?php  echo "<div class='pagebreak clear' ><hr /></div>"; ?>	

<h4>Legends:</h4>
<?php 
	$x=$numsubs/2;
?> 
<table class="gis-table-bordered" >
<tr>
	<td>
		<?php 
			for($i=0;$i<$x;$i++){
				echo $i.' - '.$subjects[$i]['code'].' - '.$subjects[$i]['name'].'<br />';
			}

		?>
	</td>
	<td>
		<?php 
			$x=round($x);
			for($i=$x;$i<$numsubs;$i++){
				echo $i.' '.$subjects[$i]['code'].' - '.$subjects[$i]['name'].'<br />';
			}

		?>
	</td>

</tr>
</table>


