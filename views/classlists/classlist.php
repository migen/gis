




<?php


$dept=$classroom['department_id'];
$in_rl = in_remarksLevel($classroom);



function getStatus($status_id){
	switch($status_id){
		case 0: return 'D'; break;
		// case 2: return 'T'; break;
		default: return 'A'; break;
	}
}	/* fxn */

// pr($boys[0]);


?>
<?php 
// pr($admin);
?>


<h5>
	Class List
	<?php echo $classroom['level'].' - '.$classroom['section']." ($numtotal)"; ?>
	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a href='<?php echo URL."pr/classlist/$crid/$sy"; ?>'>Printable</a>		
	| <a href='<?php echo URL."matrix/grades/$crid/$sy"; ?>'>Matrix</a>		
	| <a href='<?php echo URL."profiles/classroom/$crid/$sy"; ?>'>Profiling</a>			
	| <a href='<?php echo URL."promotions/sfold/$crid/$sy"; ?>'>Promotions</a>			
	<?php if($in_rl): ?>
		| <a href='<?php echo URL."remarks/classroom/$crid"; ?>'>Remarks</a>	
	<?php endif; ?>

		| <a href='<?php echo URL."photos/classroom/$crid"; ?>'>Photos</a>		
	<?php if($_SESSION['settings']['advsxn_setup']==1): ?>
		| <a href='<?php echo URL."rosters/classroom/$crid"; ?>'>Roster</a>	
	<?php endif; ?>
	
<?php if(($user['role_id'] == RREG) || ($user['role_id'] == RMIS)): ?>	
		| <a href="<?php echo URL.'rosters/classroom/'.$crid; ?>">Roster</a>		
		| <a href="<?php echo URL.'students/sectioner'; ?>">Sectioner</a>		
		| <a href="<?php echo URL.'registration/one'; ?>">Registration</a>
<?php endif; ?>	

<?php 
	$d['sy']=$sy;$d['repage']="classlists/classroom/$crid";
	$this->shovel('sy_selector',$d); 
?>	

	
</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<?php if(!$crid){ echo "Need classroom param."; exit; } ?>


<?php 

// pr($data);
// pr($classroom);




?>

<!-- ========================  page info / user info =================================-->
<form method="POST" >

<div class="third" >
<table class='gis-table-bordered table-fx'>
<?php if($user['role_id'] != RTEAC): ?>
<tr><th class="white bg-blue2" >ID Number</th><td><?php echo $classroom['adviser_code']; ?></td></tr>
<tr><th class="white bg-blue2" >Adviser</th><td><?php echo $classroom['adviser']; ?></td></tr>	
<?php endif; ?>	
</table>
</div>

<div class="third" >
<table class='gis-table-bordered table-fx'>
<?php if($user['role_id'] != RTEAC): ?>
<?php 
	$d['classrooms'] = $classrooms;
	$d['sy']		 = $sy;
	$d['axn']		 = 'classroom';	
	$this->shovel('redirect_classroom',$d); 
?>
	
<?php endif; ?>	


</table>
</div>

<div class="clear" ></div>


<p><?php $this->shovel('hdpdiv'); ?></p>



<!-- =================== BOYS ===================  -->
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc30" >#</th>
	<th class="vc30" >PK</th>
	<th class="vc100" >ID Number</th>
	<th class="vc400" >Boys</th>
	<th></th>
	<?php if($_SESSION['settings']['rcard_adviser']==1): ?><th></th><?php endif; ?>
	
</tr>

<?php $k=0; ?>
<?php for($i=0;$i<$num_boys;$i++): ?>
<?php $k+=1; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $boys[$i]['scid']; ?></td>
	<td><a href="<?php echo URL.'students/links/'.$boys[$i]['scid']; ?>" ><?php echo $boys[$i]['student_code']; ?></a></td>
	<td><?php echo $boys[$i]['student']; ?></td>
	<td><a href='<?php echo URL."profiles/student/".$boys[$i]['scid']; ?>' >Profile</a></td>		
	<?php if($_SESSION['settings']['rcard_adviser']==1): ?>
		<td><a href='<?php echo URL."rcards/scid/".$boys[$i]['scid']."/$sy/$qtr/0?tpl=".$dept; ?>' >
			Report Card</a></td>		
	<?php endif; ?>

	
</tr>


<?php endfor; ?>

</table>


<p></p>
<!-- =================== GIRLS ===================  -->
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc30" >#</th>
	<th class="vc30" >PK</th>
	<th class="vc100" >ID Number</th>
	<th class="vc400" >Girls</th>
	<th></th>
	<?php if($_SESSION['settings']['rcard_adviser']==1): ?><th></th><?php endif; ?>	
</tr>


<?php for($i=0;$i<$num_girls;$i++): ?>
<?php $k+=1; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $girls[$i]['scid']; ?></td>
	<td><?php echo $girls[$i]['student_code']; ?></td>
	<td><?php echo $girls[$i]['student']; ?></td>
	<td><a href="<?php echo URL.'profiles/student/'.$girls[$i]['scid'].DS.$sy; ?>" >Profile</a></td>
	<?php if($_SESSION['settings']['rcard_adviser']==1): ?>
		<?php $dropped = ($girls[$i]['is_active']==0)? '?dropped':NULL; ?>
	
		<td><a href='<?php echo URL."rcards/scid/".$girls[$i]['scid']."/$sy/$qtr/0?dropped"; ?>' >Report Card</a></td>		
	<?php endif; ?>		

	
</tr>


<?php endfor; ?>

</table>


</form>

<!-------------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var crid="<?php echo $crid; ?>";
var home = '<?php echo 'classlists'; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();

})




</script>


