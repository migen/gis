<?php 

// pr($qtr);


?>


<!--------- SCRIPT ON TOP COZ there is an exit condition ---------------------------------------------------------->
<script> 

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = 'reports';

$(function(){ 
	columnHighlighting();	
	excel();
}) 	


function excel(){
	$("#btnExport").click(function () {
		$("#tblExport").btechco_excelexport({
			containerid: "tblExport"
		   ,datatype: $datatype.Table
		});
	});

}



</script>

<!---------------------------------------------------------------------------------------------->

<?php 
/* @gcontroller-mcr */


	$deciscores = $_SESSION['settings']['deciscores'];
	$decigrades = $_SESSION['settings']['decigrades'];
	$decipnv 	= $_SESSION['settings']['decipnv'];
	$decitnv 	= $_SESSION['settings']['decitnv'];
	$deciftnv 	= $_SESSION['settings']['deciftnv'];
	$deciranks 	= $_SESSION['settings']['deciranks'];
	$deciconducts 	= $_SESSION['settings']['deciconducts'];
	$decigenave 	= $_SESSION['settings']['decigenave'];
	


$is_k12 = $classroom['is_k12'];
$k12 	= ($is_k12)? '_k12' : '';


function getmcr($classroom){
	if($classroom['is_k12'] && !$classroom['is_ps']){
		return '_k12';
	} else {
		return '';
	}
}	

$cr  		= $classroom;
$sgs 		= $_SESSION['settings'];


	$rgrade 	= isset($_GET['cutoff'])? $_GET['cutoff']:$sgs['rank_grade'];
	$rgenave 	= isset($_GET['cutoff'])? $_GET['cutoff']:$sgs['rank_genave'];
	$rconduct 	= isset($_GET['cutoff'])? $_GET['cutoff']:$sgs['rank_conduct'];	
	
	// pr($rgrade);
	// pr($rgenave);

 
?>


<h5 class="screen" >
	Academic Report
<span class="screen" >		
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href='<?php echo URL."reports/ccr/$crid/$sy/$qtr"; ?>' >CCR</a> 	
	| <a href='<?php echo URL."qcr/qcr/$crid/$sy/$qtr"; ?>' >QCR</a>
	<?php if($classroom['is_sem']): ?>
		| <a href='<?php echo URL."mcr/view/$crid/$sy/$qtr/0"; ?>' >All</a> 		
		| <a href='<?php echo URL."mcr/view/$crid/$sy/$qtr/1"; ?>' >Sem 1</a> 		
		| <a href='<?php echo URL."mcr/view/$crid/$sy/$qtr/2"; ?>' >Sem 2</a> 		
	<?php endif; ?>
	

<!-- 
	
	| <a class="button" id="btnExport" style="font-size:14px;" >Excel</a> &nbsp; 

-->
	
</span>



	
</h5>

<!--------------------------------------------------------------------------------------------------------------->
<div style="width:40%;float:left;"  >
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Classroom | Status</th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?>
		<span class="hd f10 screen" >(CRID<?php echo $classroom['id']; ?>)</span>
	
	<?php if($qtr<5): ?>
		| <?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?> 
	<?php endif; ?>
	</td></tr>
	<tr><th class="white headrow" >Cutoff</th>
		<td><form method="GET" >
			<input name="cutoff" class="vc60 center" value="<?php echo $sgs['rank_grade']; ?>" />
			<input type="submit" name="submit" value="Cutoff" />
		</form>
		</td>
	</tr>
	
</table>
</div>

<div class="third" >
<table class='gis-table-bordered table-fx'>
	
<?php 
	if($user['role_id']!=RTEAC){
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'rcr';
		$this->shovel('redirect_classroom',$d); 	
	}
?>
		
</table>
</div>

<div class="third" >
<?php 
	$year_finalized = date('Y',strtotime($classroom['finalized_date_q'.$qtr]));
	$finalized_date = $classroom['finalized_date_q'.$qtr];	
	$finalized_date = ($year_finalized<DBYR)? 'OPEN':date('M-d, Y D',strtotime($finalized_date));
?>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Finalized Date</th>
		<td class="vc150" ><?php echo $finalized_date; ?></td></tr> 
	<tr><th class='white headrow'>Printed Date</th>
		<td><?php echo date('M-d, Y D',strtotime($_SESSION['today'])); ?></td></tr> 
</table>
</div>


<div class="clear" ></div>

<p class="screen" >Do <span class="red" >NOT</span> Print if Status is OPEN because NOT yet Finalized. </p>


<!--------------------------------------------------------------------------------------------------------------->


<?php 	
// pr($data);
if(empty($students)){ exit; }  ?>

<!--------------------------------------------------------------------------------------------------------------->


<table id="tblExport" class='gis-table-bordered table-fx table-altrow'>
<thead>
	<tr class='headrow'>
		<th>#</th>
		<th>Student</th>
		<th>Qtr</th>
	<?php $s=0; ?>
	<?php foreach($data['subjects'] AS $row): ?>
	<?php $s++; ?>		
		<th class="vc50 center" >
			<?php echo $s.'<br />'; ?>
			<?php if($user['role_id'] == RREG):   ?>		
				<a href="<?php echo URL; ?>registrars/course/<?php echo $row['course_id'].DS.$sy.DS.$qtr; ?>" ><?php echo $row['course_code']; ?></a>
			<?php else: ?>
				<?php echo $row['course_code']; ?>			
			<?php endif; ?>				
		</th>	
	<?php endforeach; ?>
	
		<th class="center">CG
			<?php if($is_k12): ?> CDG <?php endif; ?>
		</th>	
		
		<th class="center">AG
			<?php if($is_k12): ?> DG <?php endif; ?>
		</th>
			
		<th class="center" >Rank</th>
		
	</tr>
</thead>

<tbody>

<?php $num_subjects = count($data['subjects']); ?>
<?php $x=0; // students index  ?>
<?php foreach($data['grades'] AS $row): ?>
		<tr> 
			<td><?php echo $x+1; ?></td>
			<td id="<?php echo $students[$x]['scid'].' : '.$students[$x]['student_code']; ?>" ondblclick="alert(this.id);" >
				<?php echo $students[$x]['student']; ?></td>
			<td class="colshading" >Q1</td>
	<?php for($i=0;$i<$num_subjects;$i++): ?>		
			<?php 				
				$score  = (isset($row[$i]['q1']))? $row[$i]['q1'] : 0;				
				$subpar = (number_format($score,$decigrades) < $rgrade)? true:false;
				
			?>	
	
			<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> " >
				<?php echo number_format($score,$decigrades); ?>				
				<?php if($is_k12): ?> <br /><?php echo (isset($row[$i]['dg1']))? $row[$i]['dg1'] : 'N'; ?> <?php endif; ?>
			</td>
	<?php endfor; ?>			
			<?php 
			 // $rgrade, $rgenave, $rconduct
				$conduct = number_format($students[$x]['conduct_q1'],$deciconducts);
				$subpar = (number_format($conduct,$decigrades) < $rconduct)? true:false;
			?>
			<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> " ><?php echo $conduct; ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['conduct_dg1']; ?> <?php endif; ?>
			</td>	
			<?php 
				$genave = number_format($students[$x]['ave_q1'],$decigenave);			
				$subpar = (number_format($genave,$decigrades) < $rgenave)? true:false;				
			?>
			<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> " ><?php echo $genave;  ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['ave_dg1']; ?> <?php endif; ?>			
			</td>	
			<td class="colshading center" >
				<?php echo ($students[$x]['rank_classroom_q1']==0)? '-': number_format($students[$x]['rank_classroom_q1'],$deciranks); ?>
			</td>
		</tr>
		
	<?php $iqtr = ($sem)? 6:5; ?>	
	<?php for($j=2;$j<=$qtr;$j++): ?>
	<?php $qq = 'q'.$j; ?>
		<tr>
			<td>&nbsp;</td> <td>&nbsp;</td>
			<td class="colshading" ><?php echo 'Q'.$j; ?></td>
		<?php for($i=0;$i<$num_subjects;$i++): ?>		
		
			<?php 
				$score  = (isset($row[$i][$qq]))? $row[$i][$qq] : 0;				
				$subpar = (number_format($score,$decigrades) < $rgrade)? true:false;
				
			?>	
		
				<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> "  >
				<?php echo number_format($score,$decigrades); ?>
				<?php if($is_k12): ?> <br /><?php echo (isset($row[$i]['dg'.$j]))? $row[$i]['dg'.$j] : 'N'; ?> <?php endif; ?> 
				</td>
		<?php endfor; ?>		
			<?php 
				$conduct = number_format($students[$x]['conduct_q'.$j],$deciconducts);
				$subpar = (number_format($conduct,$decigrades) < $rconduct)? true:false;
			
			?>
			<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> " ><?php echo $conduct; ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['conduct_dg'.$j]; ?> <?php endif; ?>						
			</td>
			<?php 
				$genave = number_format($students[$x]['ave_q'.$j],$decigenave);			
				$subpar = (number_format($genave,$decigrades) < $rgenave)? true:false;
				
			?>
			<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?>" ><?php echo $genave;  ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['ave_dg'.$j]; ?> <?php endif; ?>						
			</td>
			<td class="colshading center" ><?php echo ($students[$x]['rank_classroom_q'.$j]==0)? '-':number_format($students[$x]['rank_classroom_q'.$j],$deciranks); ?>
			</td>
		</tr>	
	<?php endfor; ?>	
	
<!-- fg -->	
<tr>
	<td colspan="2" >&nbsp;</td>
	<td>Ave</td>
	<?php for($i=0;$i<$num_subjects;$i++): ?>		
	
		<?php 
			$score  = (isset($row[$i]['q'.$iqtr]))? $row[$i]['q'.$iqtr] : 0;				
			$subpar = (number_format($score,$decigrades) < $rgrade)? true:false;
			
		?>	
	
			<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> "  >
			<?php echo number_format($score,$decigrades); ?>
			<?php if($is_k12): ?> <br /><?php echo (isset($row[$i]['dg'.$iqtr]))? $row[$i]['dg'.$iqtr] : 'N'; ?> <?php endif; ?> 
			</td>
	<?php endfor; ?>			
	
	<?php 
		$conduct = number_format($students[$x]['conduct_q'.$iqtr],$deciconducts);
		$subpar = (number_format($conduct,$decigrades) < $rconduct)? true:false;
	
	?>
	<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?> " ><?php echo $conduct; ?>
		<?php if($is_k12): ?> <?php echo $students[$x]['conduct_dg'.$iqtr]; ?> <?php endif; ?>						
	</td>
	<?php 
		$genave = number_format($students[$x]['ave_q'.$iqtr],$decigenave);			
		$subpar = (number_format($genave,$decigrades) < $rgenave)? true:false;
		
	?>
	<td class="colshading center <?php echo ($subpar)? 'red':NULL; ?>" ><?php echo $genave;  ?>
		<?php if($is_k12): ?> <?php echo $students[$x]['ave_dg'.$iqtr]; ?> <?php endif; ?>						
	</td>
	<td class="colshading center" ><?php echo ($students[$x]['rank_classroom_q'.$iqtr]==0)? '-':
		number_format($students[$x]['rank_classroom_q'.$iqtr],$deciranks); ?>
	</td>
	
</tr>
		
<?php $x++; // students index ?>
<?php endforeach; ?>

</tbody>
</table>



<!---------------------------------------------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<!---------------------------------------------------------------------------------------------->