
<?php 

// pr($students[0]);
?>

<!-------------------------------------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<h5>
	Printable Class List
	<?php echo $classroom['level'].' - '.$classroom['section']." ($count)"; ?>
	(<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)
	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."classlists/printOne/$crid/$sy"; ?>'>Alphabetical</a>			
<?php else: ?>	
	| <a href='<?php echo URL."classlists/printOne/$crid/$sy?sort=c.position"; ?>'>Position</a>				
<?php endif; ?>			
	
	| <a href='<?php echo URL."matrix/grades/$crid/$sy"; ?>'>Matrix</a>		
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy"; ?>'>Profiling</a>			
	| <a href='<?php echo URL."promotions/sfold/$crid/$sy"; ?>'>Promotions</a>			
	| <a href='<?php echo URL."promotions/report/$crid/$sy"; ?>'>Report</a>			

	| <a class="u" id="btnExport" >Excel</a> 	
	
	
	
<?php  if(($user['role_id'] == RREG) || ($user['role_id'] == RMIS)): ?>	
		| <a href="<?php echo URL.'sectioning/crid/'.$crid.DS.$sy; ?>">Sectioning</a>		
		| <a href="<?php echo URL.'students/sectioner'; ?>">Sectioner</a>		
		| <a href="<?php echo URL.'setup/students'; ?>">Registration</a>
<?php endif; ?>	
	
	
</h5>



<?php 

// pr($data);
// pr($classroom);




?>

<!-- ========================  page info / user info =================================-->
<form method="POST" >

<div class="third" >
<table class='gis-table-bordered table-fx'>
<?php if($user['role_id'] != RTEAC): ?>
<tr>
	<th class="white bg-blue2" >ID Number</th><td><?php echo $classroom['adviser_code']; ?></td>
	<th class="white bg-blue2" >Adviser</th><td><?php echo $classroom['adviser']; ?></td>
</tr>	
<?php endif; ?>	
</table>
</div>



<div class="clear" ></div>


<!-- =================== Students ===================  -->
<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow">
	<th class="vc30" >#</th>
	<th class="" >Pos</th>
	<th class="vc100" >ID Number</th>
	<th class="vc400" >Students of <?php echo $classroom['lvlcode'].' - '.$classroom['sxncode']; ?> </th>
	<th>Male</th>
</tr>

<?php $k=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $k+=1; ?>
<tr class="<?php echo ($students[$i]['is_male']!=1)? 'bg-pink':NULL; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['position']; ?></td>
	<td><?php echo $students[$i]['student_code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td><?php echo ($students[$i]['is_male']==1)? 'M':'-'; ?></td>	
</tr>


<?php endfor; ?>

</table>


<!-------------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = '<?php echo 'advisers'; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
	excel();

})



</script>


