<?php 
	
	// pr($data);
	// pr($classroom);
	// pr($teacher);
	$tcid=$_SESSION['ucid'];
	
	
	


?>

<h5>
	Conduct (<?php echo $count; ?>) - <?php echo $teacher['name']; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."loads/crids/$tcid"; ?>' >Crids</a>
	| <span class="u" onclick="traceshd();" >SHD</span>	
	
	<?php if(isset($_GET['edit'])): ?>
		| <a href='<?php echo URL."cdt/grades/$crid/$tcid"; ?>' >View</a>
	<?php else: ?>
		| <a href='<?php echo URL."cdt/grades/$crid/$tcid?edit"; ?>' >Edit</a>
	<?php endif; ?>
	
	<?php if($tcid==$acid): ?>
		| <a href='<?php echo URL."cdt/tally/$crid"; ?>' >Tally</a>
	<?php endif; ?>	
	| <a href='<?php echo URL."cdt/tally/$crid"; ?>' >Tally On</a>
	
</h5>

<?php 
	$srid=$_SESSION['srid'];
	$min=isset($_GET['min'])? $_GET['min']:70;
	$max=isset($_GET['max'])? $_GET['max']:100;
?>


<h4 class="<?php echo ($srid!=RMIS)? 'shd':NULL; ?>" >
<table class="gis-table-bordered" >
<tr>
<td>Min<input id="min" class="vc50" value="<?php echo (isset($_GET['min']))? $_GET['min']:$min; ?>" ></td>
<td>Max<input id="max" class="vc50" value="<?php echo (isset($_GET['max']))? $_GET['max']:$max; ?>" ></td>
<td><span class="u" onclick="randomize('grades');" >Randomize</span></td>
<td><span class="u" onclick="gotoUrl();" >RandomizeUrl</span></td>
</tr>
</table>
</h4>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th class="vc100" >Classroom</th>
	<td>ID#<?php echo $classroom['id'].'-'.$classroom['name']; ?></td>
	<th>Adviser</th>
	<td>ID#<?php echo $classroom['acid'].'-'.$classroom['adviser']; ?></td>
	<th>Status</th>
	<td><?php echo $is_locked? "Locked":"Open"; ?></td>	
	<?php if(!$is_locked): ?>
		<th>
			<a href="<?php echo URL.'finalizers/closeConduct/'.$crid.DS.$sy.DS.$qtr; ?>" >Finalize</a>
		</th>		
	<?php endif; ?>	
	<?php if($is_locked && $is_admin): ?>	
		<th>
			<a href="<?php echo URL.'finalizers/openConduct/'.$crid.DS.$sy.DS.$qtr; ?>" >Open On</a>
		</th>		
	<?php endif; ?>	
	
	
</tr>
</table><br />

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Grade
	<?php if(isset($_GET['edit'])): ?>
		<br /><input class="vc50 center" type="text" id="igrade" placeholder="All" />
		<br /><button onclick="populateColumn('grade');return false;">All</button>							
	<?php endif; ?>
	</th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>
<?php 

	$grade=$grades[$i]['grade'];	
	$grade=number_format($grade,$deciconducts); 



?>



<tr>
	<td><?php echo $i+1; ?>
		<?php 
			
		
		?>
	</td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<?php if(isset($_GET['edit'])): ?>
		<td>
			<input class="vc50 center grade" name="posts[<?php echo $i; ?>][grade]" value="<?php echo $grade; ?>" 
				id="grades<?php echo $i; ?>" />
			<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $grades[$i]['gid']; ?>" />	
		</td>
	<?php else: ?>
		<td class="center" ><?php echo $grade; ?></td>
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>


<?php if($is_admin || $is_mine): ?>
	<?php if(isset($_GET['edit'])): ?>
		<p><input type="submit" name="submit" value="Save"  /></p>
	<?php endif; ?>
<?php endif; ?>

</form>


<script>

var min=<?php echo isset($_GET['min'])? $_GET['min']:$min; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:$max; ?>;
var count=<?php echo isset($count)? $count:10; ?>;
var has_errors="<?php echo $has_errors; ?>";

$(function(){
	shd();
	selectFocused();
	nextViaEnter();
	if(has_errors){ alert('Synced.');location.reload(); }
	
})


function randomize(aim){ 
	for(var i=0;i<count;i++){ var x=getRandomInt(min,max);document.getElementById(aim+i).value=x; }	
}	/* fxn */

function getRandomInt(min,max) { return Math.floor(Math.random()*(max-min+1))+min; }


</script>
