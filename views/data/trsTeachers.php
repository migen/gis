<?php 

	// pr($classrooms[0]);
	// pr($teacs[0]);

?>


<h5>
	Traits Teachers By Classroom
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| GIS Report Printed: <?php echo $_SESSION['today']; ?>
	
</h5>


<?php 
	foreach($classrooms AS $k=>$v){
		$trsid = $v['trsid'];
		$acid = $v['acid'];
		// pr($trsid);
		$count = @$counts[$k];
		if($count>0){
			echo "<div style='border:1px solid white;width:23%;float:left;' >";
				echo "<h4>".$classrooms[$k]['classroom']." ($count) #$trsid </h4>";
				foreach($teacs[$k] AS $row){

					if($row['tcid']==$acid){
						echo '#'.$row['tcid'].'-'.$row['teacher'].'<br />';					
					} else {
						echo "<a href='".URL."trs/view/".$trsid.DS.$row['tcid']."'>".$row['teacher']."</a><br />";  						
					}
									
				}
			echo "</div>";		
		}

	}
	

	
?>


