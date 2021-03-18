<?php 


/* 
legends:
1. iqt
2. 
> sqtr = start quarter for sem=2, then 3, default 1;
> eqtr = end quarter for sem=2, then 4,
3. numqtr = if sem, 2 AS divisor for aveValue;


*/



// $count = 2;
// $num_criteria=3;


$deciave=$_SESSION['settings']['deciave'];
// $qtr = isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
$sem = isset($_GET['sem'])? $_GET['sem']:false;
$aveqtr = 5;
$numqtr=$qtr;

$sqtr=1;
$eqtr=$qtr;
if($sem){ 
	$numqtr=2;
	if($sem==1){
		$sqtr=1;
		$eqtr=2;
	}		
	if($sem==2){
		$sqtr=3;
		$eqtr=4;
		$aveqtr=6;		
	}	
	if($sem==3){
		$sqtr=5;
		$eqtr=6;
		$aveqtr=7;		
	}		
	
}





?>


<h3>
	CAV MCR (Multirows)
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."cav/traits/$crs/$sy/$qtr"; ?>' >Traits</a> 		

</h3>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>

<br>

<form method="GET" >
<table class="gis-table-bordered" >
<tr>
	<td>Semester: 
		<select name="sem" class="vc100" >
			<option value=0>None</option>
			<option value=1 <?php echo ($sem==1)? 'selected':NULL; ?> >Sem 1</option>
			<option value=2 <?php echo ($sem==2)? 'selected':NULL; ?> >Sem 2</option>
			<option value=3 <?php echo ($sem==3)? 'selected':NULL; ?> >Sem Total</option>
		</select>	
	</td>
	<td>
		<input type="submit" value="Set" >
	</td>
</tr>
</table>
</form>

<br>

<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
	<tr>
		<th>#</th>
		<th>Scid</th>
		<th>Student</th>
		<th>Qtr</th>
		<?php for($j=0;$j<$num_criteria;$j++): ?>
			<th><div class="cricol" style="width:100px;" ><?php echo $criteria[$j]['criteria']; ?></div></th>
		<?php endfor; ?>		
	</tr>

<?php $k=0; ?>	<!-- replaces i-j for posts-index -->
<?php for($i=0;$i<$count;$i++): ?>	<!-- numstud -->
	<?php for($iq=$sqtr;$iq<=$eqtr;$iq++): ?>	<!-- numqtr -->
		<tr>
			<td><?php echo ($iq==$sqtr)? ($i+1):NULL; ?></td>			
			<td><?php echo ($iq==$sqtr)? ($rows[$i]['scid']):NULL; ?></td>
			<td><?php echo ($iq==$sqtr)? ($rows[$i]['student']):NULL; ?></td>
			<td><?php echo $iq; ?></td>		
			<?php for($j=0;$j<$num_criteria;$j++): ?>
				<?php 
					$sum[$i][$j]=isset($sum[$i][$j])? $sum[$i][$j]:0;
					$currGradeNum=$cavs[$i][$j]['q'.$iq];
					$currGradeDg=$cavs[$i][$j]['dg'.$iq];
					$sum[$i][$j]+=$currGradeNum;
				?>
				<td class="center" ><?php echo ($currGradeNum+0).'<br>'.$currGradeDg; ?></td>
			<?php endfor; ?>			
		</tr>
	<?php endfor; ?> <!-- numqtr -->
	
		
		<!-- average -->
		<tr>
			<th colspan=3>Average</th>			
			<th><?php echo $aveqtr; ?></th>
			<?php for($j=0;$j<$num_criteria;$j++): ?>
				<th class="center" >
					<?php 
					
						$ave[$i][$j]=number_format($sum[$i][$j]/$numqtr,$deciave);						
						$dbval=$cavs[$i][$j]['q'.$aveqtr]+0;
						$dbvalDg=$cavs[$i][$j]['dg'.$aveqtr];
						$ctval=$ave[$i][$j];
						$dg = rating($ctval,$ratings);	
					?>
					<?php if($dbval!=$ctval || $dg!=$dbvalDg): ?>
						<input type="hidden" class="vc100" name="posts[<?php echo $k; ?>][gid]" 
							value="<?php echo $cavs[$i][$j]['gid']; ?>" >
						<input class="vc100 center" name="posts[<?php echo $k; ?>][qave]" 
							value="<?php echo $ave[$i][$j]; ?>" ><br />
						<input class="vc100 center" name="posts[<?php echo $k; ?>][dgave]" 
							value="<?php echo $dg; ?>" >						
							
					<?php else: ?>		
						<?php echo $dbval.'<br>'.$dbvalDg; ?>						
					<?php endif; ?>		
						
				</th>
				<?php $k++; ?>				
			<?php endfor; ?>			
		</tr>	
<?php endfor; ?> <!-- numstud -->

</table>

<input class="vc50 center" type="hidden" name="aveqtr" value="<?php echo $aveqtr; ?>" >
<br>
<p><input type="submit" name="submit" value="Update" ></p>

</form>




<script>

var gurl = "http://<?php echo GURL; ?>";	
var crid	= "<?php echo $crid; ?>";
var crs	= "<?php echo $crs; ?>";
var sy   	= "<?php echo $sy; ?>";
var qtr 	= "<?php echo $qtr; ?>";
var ds 		= '/';

var numcri = <?php echo $num_criteria; ?>;


$(function(){	
	// let x = `crid: ${crid} | crs: ${crs} | sy: ${sy} | qtr: ${qtr}`; alert(x);
	nextViaEnter();	  
	
});


function redirCtype(){
	var url = gurl+"/cav/mcr/"+crid+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();	
	window.location = url;		
}	/* fxn */


</script>


