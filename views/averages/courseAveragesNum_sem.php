<?php 



/* @gcontroller-course */

$_SESSION['stats'] = NULL;
$decicard=isset($_GET['decicard'])?$_GET['decicard']:$_SESSION['settings']['decicard'];
$deptdeci=($course['department_id']==3)? $_SESSION['settings']['deciave_hs']:$_SESSION['settings']['deciave_gs'];
$deciave=$_SESSION['settings']['deciave'];
$deciave=isset($_GET['deciave'])?$_GET['deciave']:$deciave;

$dgids = buildArray($ratings,'dgid');	
$_SESSION['stats'] = initStats($dgids);
$aggregate = $course['is_aggregate'];
$decifg   = $_SESSION['settings']['decifg'];
$pg 	  = $_SESSION['settings']['passing_grade'];

$quarters=array();


	if($sem==1){
		$qbeg=1;
		$qend=2;
		$qave=5;
	} elseif($sem==2){
		$qbeg=3;
		$qend=4;		
		$qave=6;		
	}

$params="";
if(isset($_GET['decicard'])){ $params.="&decicard=".$_GET['decicard']; }
if(isset($_GET['deciave'])){ $params.="&deciave=".$_GET['deciave']; }


?>

<h5>
	Sem-<?php echo $sem; ?> Course Average Std
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" ondblclick="traceshd();" >SHD</span>
	| <a class="u" id="btnExport" >Excel</a> 
	<?php if($sem==1): ?>	
		| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr&sem=2{$params}"; ?>' >Sem-2</a> 		
	<?php else: ?>
		| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr&sem=1{$params}"; ?>' >Sem-1</a> 		
	<?php endif; ?>
	| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr{$params}"; ?>' >Non-Sem</a> 		


	
</h5>

<?php if(isset($_GET)): ?>
	<p class="screen" ><span><?php echo $params; ?></span></p>
<?php endif; ?>


<p><?php $this->shovel('hdpdiv'); ?></p>



<p>
<table class='table-fx gis-table-bordered'>
<tr class="hd" ><th class="" >Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>
</td></tr>
<?php if($admin): ?>
	<tr><th class="" >Teacher <span class="hd" >(<?php echo $course['tcid']; ?>)</span></th>
		<td class="" id="<?php echo $course['teacher_code']; ?>" 
		ondblclick="xgetidByCode('dbo','00_contacts',this.id);" ><?php echo $course['teacher']; ?>
		| <?php echo $course['teacher_code']; ?>
	</td></tr>
<?php endif; ?>
<tr><th class="vc100 " >Course<span class="hd" >(<?php echo $course['subject_id']; ?>)</span></th><td>
	<?php
		echo $course['level'].' - '.$data['course']['section'].' - ';	
		echo $course['label']; echo ($sem)? " <span class='f11' >(Sem - $sem)</span>":NULL; 
		echo ' ('.$course['code'].')';
	?>
	| <span class="b" >Status </span><?php echo ucfirst('Q'.$qtr); ?> - 
		<?php echo ($is_locked)? "Closed":"<span class='brown'>Open</span>"; ?>
	</td>
</tr>
</table>
</p>



<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" id="tblExport" >
<tr>
	<th>#</th>
	<th class="shd" >Gid</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Student</th>
	<?php 
		$quarters[$qave]['passed']=0; 
		$quarters[$qave]['failed']=0; 

	?>	
	<?php for($q=$qbeg;$q<=$qend;$q++): ?>
	<?php 
		$quarters[$q]['passed']=0; 
		$quarters[$q]['failed']=0; 
	?>
	
		<th class="center" ><?php echo "Q{$q}"; ?></th>
	<?php endfor; ?>
	<th class="shd" >Sum</th>
	<th class="shd" >Dvsor</th>
	<th>Ave<br><?php echo "Q{$qave}"; ?><br>(DB)</th>
	<th>Ave<br><?php echo "Q{$qave}"; ?><br>(Corrected)</th>
</tr>

<?php 
	$updated=true; 
?>
<?php foreach($grades as $i => $row): ?>
	<?php $ave=0; $sum=0; $dvsor=0; ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $row['gid']; ?></td>
		<td><?php echo $row['scid']; ?></td>
		<td><?php echo $row['student_code']; ?></td>		
		<td><?php echo $row['student']; ?></td>		
		<?php for($a=$qbeg;$a<=$qend;$a++): ?>
				<?php 
					${'qb'.$a} = $row['q'.$a]; 					
					if(${'qb'.$a}<$pg){
						$quarters[$a]['failed']++;				
					} else {
						$quarters[$a]['passed']++;							
					}
					
					
				?>
			<td class="center <?php echo (${'qb'.$a}<$pg)? 'bg-red':NULL; ?>" >
					<?php $cell = number_format(${'qb'.$a},$decicard); ?>
					<?php echo $cell; ?>
					<?php 
						$sum+=$cell;
						if($cell>0){ $dvsor++; }
					?>
			</td>	
		<?php endfor; ?>
		<td class="shd" ><?php echo $sum; ?></td>
		<td class="shd" ><?php echo $dvsor; ?></td>		
		<td><?php $dbave=number_format($row['q'.$qave],$deciave); echo $dbave; ?></td>
		<?php 
			if($row['q'.$qave]<$pg){ $quarters[$qave]['failed']++; 
			} else { $quarters[$qave]['passed']++; }
		?>
		
		
		<?php 
			$ctave=($sum>0 && $dvsor>0)? number_format(($sum/$dvsor),$deciave):0; 
		?>
		<td class="" >
			<?php if($dbave!=$ctave): ?>
				<?php 
					$updated=false;
				?>
			
<input class="bg-red text-white vc100" type="text" name="grades[<?php echo $i; ?>][fg]" value="<?php echo $ctave; ?>" >
<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $row['gid']; ?>" readonly />
<input type="hidden" name="grades[<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" readonly />
<input type="hidden" name="grades[<?php echo $i; ?>][dg]" value="" readonly />
				
			<?php endif; ?>
		</td>
		

		
		
	</tr>
<?php endforeach; ?>


<!-- statistics stats -->
<tr>
	<th class="shd" ></th>
	<th colspan="4" >Passed / Failed</th>
	<?php for($a=$qbeg;$a<=$qend;$a++): ?>
		<th>
			P: <?php echo $quarters[$a]['passed']; ?><br />
			<span class="red" >F: <?php echo $quarters[$a]['failed']; ?></span>
		</th>
	<?php endfor; ?>
		<th class="shd" ></th>	
		<th class="shd" ></th>	
		<th>
			P: <?php echo $quarters[$qave]['passed']; ?><br />
			<span class="red" >F: <?php echo $quarters[$qave]['failed']; ?></span>
		</th>	
	<td colspan="" ></td>
</tr>

</table>




<?php if($_SESSION['srid']!=RTEAC && !$updated): ?>
	<br /><input type="submit" name="submit" value="Save On"  />
<?php endif; ?>


<?php if($_SESSION['srid']==RTEAC && !$is_locked && !$updated): ?>
	<br /><input type="submit" name="submit" value="Save"  />
<?php endif; ?>



<input type="hidden" name="stats[<?php echo $dgid; ?>]" value="<?php echo $_SESSION['stats'][$dgid]; ?>"  >

</form>

<div class="ht100" ></div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var updated = "<?php echo $updated; ?>";

$(function(){ 
	hd(); 
	shd();
	$('#hdpdiv').hide();
	itago('sum');
	excel();
	if(!updated){ alert("Submit to Update Averages."); }
	
})


	
</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
