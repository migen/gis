<style>
td.ivory{background:#F8F8F8;}
</style>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<?php 



$count = $data['num_students']; ?>		




<?php 

$num_hd=0;
foreach($courses AS $row){ if($row['on_reports']==0){ $num_hd++; }  }
$colspan=8+$num_courses-$num_hd;

$sx=($qtr==5)? "q1+q2":"q3+q4";
$decicard=isset($_GET['deci'])? $_GET['deci']:$_SESSION['settings']['decicard'];
$headrow="<tr><th></th><th colspan='2' class='shd' ><th></th>&nbsp;</th>";

foreach($courses AS $row){
	$class=($row['on_reports']==1)? NULL:'shd';
	$headrow.='<th class="'.$class.'" >'.$row['course_code'].'</th>';
}
$headrow.="<th>Gen<br />Ave</th><th>Cdt</th><th>Pres</th><th>Tard</th><th>Rank</th><th>BRank</th>";
$headrow.="<th class='hd' ></th><th class='hd' ></th><th class='hd' ></th></tr>";

$decigenave=($_SESSION['settings']['decigenave']);
$attdtype=($_SESSION['settings']['attd_qtr']!=1)? 1:2;
$cr=$data['classroom'];
$qtr=$data['qtr'];	
$size=isset($_GET['size'])? $_GET['size']:1;
$hidecode=isset($_GET['hidecode'])? true:false;
$get=sages($_GET);
// $get=str_replace("&deci=","",$get);	

?>


<h5 class="screen" >
	<span ondblclick="tracehd();"  >SJAM Sem Matrix (<?php echo $count; ?>)
	| <span class="u" ondblclick="tracehd();" >CRID#<?php echo $crid; ?></span>
	| <a href="<?php echo URL.$home; ?>">Home</a>
	
		
	| <a href="<?php echo URL.'classlists/classroom/'.$data['classroom']['id'].DS.$sy; ?>" />Classlist</a>	
	<?php $period=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly'; ?>
	| <a href="<?php echo URL.'attendance/'.$period.'/'.$data['classroom']['id'].DS.$sy; ?>" />Attendance</a>	
	| <a href='<?php echo URL."submissions/view/".$data['classroom']['id']."/$sy/$qtr"; ?>' />Submissions</a>	
	| <a href='<?php echo URL."summarizers/genave/".$classroom['id']."/$sy/$qtr"; ?>' />Summarizer</a>	
	| <a href='<?php echo URL."honors/records/".$classroom['id']; ?>' />Honors</a>	
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href='<?php echo URL."students/filter"; ?>' />Filter</a>		
	| <a href='<?php echo URL."mcr/view/".$data['classroom']['id']."/$sy"; ?>' />MCR</a>	
	<?php if($trait): ?>
		| <a href='<?php echo URL."cav/traits/".$trait['course_id']."/$sy/$qtr"; ?>' />Traits</a>		
	<?php endif; ?>
	<?php if($conduct): ?>
		| <a href='<?php echo URL."conducts/records/".$conduct['course_id']."/$sy/$qtr"; ?>' />Conducts</a>		
	<?php endif; ?>	

	<?php ?>
		| Deci
	<?php ?>
	
	<?php if($_SESSION['srid']==RMIS): ?>
		<br />
		<a href="<?php echo URL.'cav/matrix/'.$data['classroom']['id']; ?>" />CavMatrix</a>	
		| <a href="<?php echo URL.'rcards/crid/'.$data['classroom']['id']; ?>" />RCards</a>	
		| <a href="<?php echo URL.'reports/ecr/'.$data['classroom']['id'].DS.$sy.DS.$qtr; ?>" />ECR</a>	
		| <a href='<?php echo URL."reports/ccr/".$data['classroom']['id']."/$sy"; ?>' />CCR</a>	
		| <a href='<?php echo URL."reports/rcr/".$data['classroom']['id']."/$sy"; ?>' />RCR</a>	
		| <a href='<?php echo URL."mis/syncer"; ?>' />Syncer</a>	
		| <a href='<?php echo URL."classrooms/courses/".$classroom['id']; ?>' />ClsCrs</a>	
		| <a href='<?php echo URL."syncers/syncGrades/".$classroom['id']; ?>' />Sync</a>	
		| <a href='<?php echo URL."purge/outcastGrades/".$classroom['id']; ?>' />Purge Outcast</a>			
	<?php endif; ?>
		<span class="hd" >| <a href='<?php echo URL."syncers/syncGrades/".$classroom['id']; ?>' />Sync</a></span>
	<?php if($qtr>3): ?>
		| <a href='<?php echo URL."promotions/k12/$crid"; ?>' />Promotions</a>		
	<?php endif; ?>	
	
	<?php $sqtr=$_SESSION['qtr']; ?>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$sqtr"; ?>' >Q<?php echo $sqtr; ?></a>	
	
	<?php if($_GET['sem']==1): ?>
		| <a href='<?php echo URL."matrix/grades/$crid/$sy/6?sem=2"; ?>' >Sem2</a>	
	<?php else: ?>
		| <a href='<?php echo URL."matrix/grades/$crid/$sy/5?sem=1"; ?>' >Sem1</a>	
	<?php endif; ?>		
	
<?php if($classroom['level_id']>13): ?>
	<?php $get=str_replace('sem=','',$get); ?>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr?$get&sem=0"; ?>' >All</a>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr?$get&sem=1"; ?>' >Sem1</a>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr?$get&sem=2"; ?>' >Sem2</a>
<?php endif; ?>
	| <span class="u" onclick="pclass('shd');" >Show</span>
<form method="GET" style="display:inline; " >	
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
		<input type="submit" name="submit" value="Go" >	
		
<span class="hd" >
	<?php if($is_locked): ?>
		<a href='<?php echo URL."finalizers/openClassroom/".$cr['crid']."/$sy/$qtr"; ?>' > Unlock </a>
	<?php else: ?>
		<a href='<?php echo URL."finalizers/closeClassroom/".$cr['crid']."/$sy/$qtr"; ?>' > Lock </a>
	<?php endif; ?>						
</span>

</form>	
	
</h5>


<?php if(isset($_GET['debug'])){ pr($q); } ?>

<?php $this->shovel('hdpdiv'); ?>




<div class='' >

<div class="center clear"  ><?php $inc = 'incs/letterhead_logo_datetime_matrix.php'; include($inc); ?></div>



<br />

<table id="tblExport" class='gis-table-bordered table-fx' style="width:1200px;float:left;font-size:<?php echo $size; ?>em;" >
<tr class='bg-blue2'>
	<th>#</th>	
	<th class="shd" >SCID</th>
	<th class="shd" >ID No</th>
	<th>Adviser: <br /><?php echo $cr['adviser']; ?>
	Status: <?php echo ($is_locked)? "Locked":"Open";  ?>	
	</th>
	<!-- left to right,iterate thru subjects -->
	<?php $s=0; ?>
	<?php foreach($courses AS $row): ?>	
		<?php $s++; ?>
		<th class="center <?php echo ($s%2)?'bg-blue1':NULL; ?> <?php echo ($row['on_reports']==0)?'shd':NULL; ?> " >
			<?php echo $s.'<br />'; ?>
<a href='<?php echo URL."teachers/grades/".$row['course_id']; ?>'><?php echo $row['course_code']; ?></a><br />
			<span class="hd" ><?php echo $row['course_id'].'-'.$row['subject_id']; ?><br /></span>
				<?php if($row['supsubject_id']!=0): ?>
					<?php echo $row['course_weight'].'%'; ?>
				<?php endif; ?>			
			<span class="hd" ><?php echo $row['course_id']; ?></span>
			
			
			<span class="" ><?php echo ($row['is_aggregate'])? 'S#'.$row['subject_id']:NULL; ?><br /></span>
				<?php echo ($row['supsubject_id']>0)? 'P#'.$row['supsubject_id']:NULL; ?>
			
			
			
		</th>
	<?php endforeach; ?>
	
	<th class="center" >GAve<br />Q<?php echo $qtr; ?></th>
	<th class="center" >Cond<br />Q<?php echo $qtr; ?></th>
		
	<th class="ht100" ><span class="vertical" >Days 
	<?php // $sx_days_total=($qtr<4)? $months['q1_days_total']+$months['q2_days_total']:$months['q3_days_total']+$months['q4_days_total']; ?>
	<?php // $sx_days_total = ($sem==1)? $months['q1_days_total']+$months['q2_days_total']:$months['q3_days_total']+$months['q4_days_total']; ?>
	<?php $sx_days_total = ($sem==1)? $months['q1_days_total']+$months['q2_days_total']:$months['q3_days_total']+$months['q4_days_total']; ?>
	<br />(<?php echo $sx_days_total; ?>)</span>

	</th>
	<th class="ht100" ><span class="vertical" >Tardy</span></th>	
	<th class="ht100" ><span class="vertical" >Rank</span></th>	
	<th class="ht100" ><span class="vertical" >BRank</span></th>	
	<th class="hd" >SCID</th>
	<th class="hd" >Sum<br />ID</th>
	<th class="hd" >ID Number</th>	
</tr>

<tr><th colspan="<?php echo $colspan; ?>" >BOYS</th></tr>

<?php $courses = $data['courses']; ?>
<?php $it=0; ?>
<?php $ct=0; ?>

<?php for($is=0;$is<$count;$is++): ?> 	<!-- loop thru num_students,top down -->
<?php $it=$is+1; ?>
<?php $ct++; ?>
<?php $nb = count($grades[$is]); ?>
<?php if($nb == $num_courses): ?>
<tr>
	<td><a href="<?php echo URL.'rcards/scid/'.$students[$is]['scid']; ?>" ><?php echo $ct; ?></a></td>
	<td class="shd" ><?php echo $students[$is]['scid']; ?>
	<td class="shd" ><?php echo $students[$is]['code']; ?>
	<td><?php echo $students[$is]['student']; ?>
	</td>
	
	<?php for($ic=0;$ic<$num_courses;$ic++): ?> 	<!-- loop thru num_courses -->
		<td class="colshading center vcenter <?php echo ($ic%2)?'ivory':NULL; ?> <?php echo ($grades[$is][$ic]['on_reports']==0)?'shd':NULL; ?> " >
<?php $grade=($grades[$is][$ic]['is_num']==1)? number_format($grades[$is][$ic]['q'.$qtr],$decicard):$grades[$is][$ic]['dg'.$qtr]; echo $grade; ?>
		<br /></td>	
	<?php endfor; ?>								<!-- endloop columns num_courses -->
	<td class="vcenter" ><?php echo number_format($students[$is]['ave_q'.$qtr],$decigenave); ?></td>
	<td class="vcenter" ><?php echo $students[$is]['conduct_q'.$qtr].'<br />'.$students[$is]['conduct_dg'.$qtr]; ?></td>
	
<?php 

$sx_days_present=($sem==1)? $attd[$is]['q1_days_present']+$attd[$is]['q2_days_present']:$attd[$is]['q3_days_present']+$attd[$is]['q4_days_present']; 
$sx_days_tardy=($sem==1)? $attd[$is]['q1_days_tardy']+$attd[$is]['q2_days_tardy']:$attd[$is]['q3_days_tardy']+$attd[$is]['q4_days_tardy']; 

?>
	
	<td class="vcenter" ><?php echo $sx_days_present; ?></td>
	<td class="vcenter" ><?php echo $sx_days_tardy; ?></td>		
	<td class="vcenter" ><?php echo $students[$is]['rank_classroom_q'.$qtr]; ?></td>		
	<td class="vcenter" ><?php echo $students[$is]['rank_level_ave_q'.$qtr]; ?></td>			
	<td class="hd" ><?php echo $students[$is]['scid']; ?></td>
	<td class="hd" ><?php echo $students[$is]['sumid']; ?></td>
	<td class="hd" ><?php echo $students[$is]['student_code']; ?></td>	
	<td class="hd" ><a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid']; ?>' >Grades</a></td>
</tr>



<?php else: ?>
<tr><td class="red" colspan="<?php echo $num_courses+5; ?>" > Please check with Registrars / MIS to update 
		<a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid']; ?>' >Grades</a> of 
		<?php echo $students[$is]['student'].' with ID # '.$students[$is]['student_code']; ?> 	
</td></tr>
<?php endif; ?>

<?php if(isset($students[$it]['scid']) && ($students[$is]['is_male']!=$students[$it]['is_male'])): ?>
	<?php $ct=0; ?>
	<tr><th colspan="<?php echo $colspan; ?>" >GIRLS</th></tr>
	<?php echo $headrow; ?>
<?php endif; ?>	

<?php endfor; ?>								<!-- endloop row num_students -->

<?php echo $headrow; ?>
</table>

</div>

<div class="clear" style="height:100px; " >&nbsp;</div>

<?php 
	$one = SITE."views/customs/".VCFOLDER."/matrix_signatures.php";		
	if(is_readable($one)){ $inc=$one;
	} else { $inc="incs/matrix_signatures.php"; }
	include_once($inc);
?>


<!------------------------------------------------------------------------------------------------------------>
<script>

var hdpass 	= "<?php echo HDPASS; ?>";
var crid 	= "<?php echo $crid; ?>";
var gurl 	= 'http://<?php echo GURL; ?>';
var sy 	= "<?php echo DBYR; ?>";

$(function(){
	$('#hdpdiv').hide();
	hd();
	shd();
	// pclass('idno');
	excel();
	columnHighlighting();
	
})

function redirPage(){
	var qtr=$('#qtr').val();
	var url=gurl+'/matrix/grades/'+crid+'/'+sy+'/'+qtr;
	window.location=url;

}




</script>