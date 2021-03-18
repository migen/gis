<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<?php 

$count=$data['num_students']; ?>		


<?php 

$decicard=$_SESSION['settings']['decicard'];
$headrow="<tr><th></th><th colspan='2' class='idno' ><th></th>&nbsp;</th>";
foreach($courses AS $row){
	$headrow.="<th>".$row['course_code']."</th>";
}
$headrow.="<th>Gen<br />Ave</th><th>Cdt</th><th>Pres</th><th>Tard</th><th>Rank</th><th>BRank</th>";


$decigenave=($_SESSION['settings']['decigenave']);
$attdtype=($_SESSION['settings']['attd_qtr']!=1)? 1:2;
$qtr=$data['qtr'];	
$size=isset($_GET['size'])? $_GET['size']:1;
$hidecode=isset($_GET['hidecode'])? true:false;
$get=sages($_GET);
	

?>


<form method="GET" >
<h5 class="screen" >
	<span ondblclick="tracehd();"  >Honors Class Matrix (<?php echo $count; ?>)
	
		
	| <a href='<?php echo URL."matrix/grades/".$cr['id']."/$sy/$qtr"; ?>' />Matrix</a>	
	| <a href='<?php echo URL."spiral/crid/".$cr['id']."/$sy/$qtr"; ?>' />Spiral</a>	
	| <a href='<?php echo URL."summarizers/genave/".$cr['id']."/$sy/$qtr"; ?>' />Summarizer</a>	
	| <a href='<?php echo URL."honors/records/".$cr['id']; ?>' />Honors</a>	
	| <a class="u" id="btnExport" >Excel</a> 
	<?php if($trait): ?>
		| <a href='<?php echo URL."cav/traits/".$trait['course_id']."/$sy/$qtr"; ?>' />Traits</a>		
	<?php endif; ?>
	<?php if($conduct): ?>
		| <a href='<?php echo URL."conducts/records/".$conduct['course_id']."/$sy/$qtr"; ?>' />Conducts</a>		
	<?php endif; ?>	
	
			
<?php if($cr['level_id']>13): ?>
	<?php $get=str_replace('sem=','',$get); ?>
	| <a href='<?php echo URL."honors/clxmatrix/$crid/$sy/$qtr?$get&sem=0"; ?>' >All</a>
	| <a href='<?php echo URL."honors/clxmatrix/$crid/$sy/$qtr?$get&sem=1"; ?>' >Sem1</a>
	| <a href='<?php echo URL."honors/clxmatrix/$crid/$sy/$qtr?$get&sem=2"; ?>' >Sem2</a>
<?php endif; ?>
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
		<input type="submit" name="submit" value="Go" >	
	
</h5>
</form>	


<?php if(isset($_GET['debug'])){ pr($q); } ?>

<?php $this->shovel('hdpdiv'); ?>


<div class="screen" >
	<table class='gis-table-bordered table-fx'>
		<tr><th class='white headrow'>Classroom (Size) | Adviser</th><td class="" >
				<?php echo $cr['level'].' - '.$cr['section']; ?>
				<?php echo "($count)"; ?>
				<?php echo ' | '.$cr['adviser']; ?>		
			</td></tr>
		<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?>
| SY <input class="vc80" id="sy" value="<?php echo $sy; ?>" min="<?php echo $_SESSION['settings']['year_start']; ?>" 
max="<?php echo (DBYR+1); ?>" type="number" />
Q <input class="vc50" id="qtr" type="number" value="<?php echo $qtr; ?>" min=1 max=4 />
<button onclick="redirPage();" >Go</button>			
		
		</td></tr>
		<tr class="hd" ><th class='white bg-blue2' >Locking</th> 
			<th>
				<?php if($is_locked): ?>
					<a href='<?php echo URL."finalizers/openClassroom/".$cr['crid']."/$sy/$qtr"; ?>' > Unlock </a>
				<?php else: ?>
					<a href='<?php echo URL."finalizers/closeClassroom/".$cr['crid']."/$sy/$qtr"; ?>' > Lock </a>
				<?php endif; ?>				
			</th>
		</tr>
	</table>
</div>	<!-- table classroom details -->


<div> 	<!-- body -->

<div class="center clear"  ><?php  $d['page']="Honors Class Matrix";$this->shovel('letterhead_logo_datetime',$d); ?></div>



<br />

<table id="tblExport" class='gis-table-bordered table-fx' style="width:1200px;float:left;font-size:<?php echo $size; ?>em;" >
<tr class='bg-blue2'>
	<th>#</th>	
	<th class="idno" >SCID</th>
	<th class="idno" >ID No</th>
	<th>Student</th>
	<!-- left to right,iterate thru subjects -->
	<?php $s=0; ?>
	<?php foreach($courses AS $row): ?>	
		<?php $s++; ?>
		<th class='center'>
			<?php echo $s.'<br />'; ?>
<a href='<?php echo URL."teachers/grades/".$row['course_id']; ?>'><?php echo $row['course_code']; ?></a><br />
			<span class="hd" ><?php echo $row['course_id'].'-'.$row['subject_id']; ?><br /></span>
				<?php if($row['supsubject_id']!=0): ?>
					<?php echo $row['course_weight'].'%'; ?>
				<?php endif; ?>			
			<span class="hd" ><?php echo $row['course_id']; ?></span>
			
			
			<span class="" >
				<?php echo ($row['is_aggregate'])? 'S#'.$row['subject_id']:NULL; ?><br /></span>
				<?php echo ($row['supsubject_id']>0)? 'P#'.$row['supsubject_id']:NULL; ?><br /></span>
			
			
			
		</th>
	<?php endforeach; ?>
	
	<th class="center" >GAve<br />Q<?php echo $qtr; ?></th>
	<th class="center" >Cond<br />Q<?php echo $qtr; ?></th>
		<?php  
			if($attdtype==1){		
				$total_days=0;  	
				for($t=0;$t<$num_months;$t++){
					$mc=$month_names[$t]['code']; 
					$total_days+=$months[$mc.'_days_total'];			
				}  			
			} else {
				$total_days=$months["q{$qtr}_days_total"];
			}			
		?>		
		
	<th class="ht100" ><span class="vertical" >Days (<?php echo $total_days; ?>)</span></th>
	<th class="ht100" ><span class="vertical" >Tardy</span></th>	
	<th class="ht100" ><span class="vertical" >Rank</span></th>	
	<th class="ht100" ><span class="vertical" >BRank</span></th>	
	<th class="hd" >SCID</th>
	<th class="hd" >Sum<br />ID</th>
	<th class="hd" >ID Number</th>	
</tr>

<?php $courses = $data['courses']; ?>
<?php for($is=0;$is<$count;$is++): ?> 	<!-- loop thru num_students,top down -->

<?php $nb = count($grades[$is]); ?>
<?php if($nb == $num_courses): ?>
<tr>
	<td><a href="<?php echo URL.'rcards/scid/'.$students[$is]['scid']; ?>" ><?php echo $is+1; ?></a></td>
	<td class="idno" ><?php echo $students[$is]['scid']; ?>
	<td class="idno" ><?php echo $students[$is]['studcode']; ?>
	<td><?php echo $students[$is]['student']; ?>
	</td>
	
	<?php for($ic=0;$ic<$num_courses;$ic++): ?> 	<!-- loop thru num_courses -->
		<td class="colshading center vcenter" >
<?php  echo ($grades[$is][$ic]['is_num']==1)? number_format($grades[$is][$ic]['q'.$qtr],$decicard):$grades[$is][$ic]['dg'.$qtr]; ?>
		<br /></td>	
	<?php endfor; ?>								<!-- endloop columns num_courses -->
	<td class="vcenter" ><?php echo number_format($students[$is]['ave_q'.$qtr],$decigenave); ?></td>
	<td class="vcenter" ><?php echo $students[$is]['conduct_q'.$qtr].'<br />'.$students[$is]['conduct_dg'.$qtr]; ?></td>
	
	<?php 
		if($attdtype==1){
			$attd[$is]['total_present']=0; 
			$attd[$is]['total_tardy']=0; 	
			for($t=0;$t<$num_months;$t++){
				$mc=$month_names[$t]['code']; 
				$attd[$is]['total_present']+=$attd[$is][$mc.'_days_present'];
				$attd[$is]['total_tardy']+=$attd[$is][$mc.'_days_tardy'];	
			}		
		} else {		
			$attd[$is]['total_present'] = $attd[$is]['q'.$qtr.'_days_present'];
			$attd[$is]['total_tardy'] = $attd[$is]['q'.$qtr.'_days_tardy'];
		}
	?>
	
	<td class="vcenter" ><?php echo $attd[$is]['total_present']; ?></td>
	<td class="vcenter" ><?php echo $attd[$is]['total_tardy']; ?></td>		
	<td class="vcenter" ><?php echo $students[$is]['rank_classroom_q'.$qtr]; ?></td>		
	<td class="vcenter" ><?php echo $students[$is]['rank_level_ave_q'.$qtr]; ?></td>			
	<td class="hd" ><?php echo $students[$is]['scid']; ?></td>
	<td class="hd" ><?php echo $students[$is]['sumid']; ?></td>
	<td class="hd" ><?php echo $students[$is]['studcode']; ?></td>	
	<td class="hd" ><a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid']; ?>' >Grades</a></td>
	
</tr>

<?php else: ?>
<tr><td class="red" colspan="<?php echo $num_courses+5; ?>" > Please check with Registrars / MIS to update 
		<a href='<?php echo URL."gtools/msg/$crid/".$students[$is]['scid']; ?>' >Grades</a> of 
		<?php echo $students[$is]['student'].' with ID # '.$students[$is]['studcode']; ?> 
	
</td></tr>
<?php endif; ?>
<?php endfor; ?>								<!-- endloop row num_students -->

<?php echo $headrow; ?>
</table>

</div>	<!-- body -->

<div class="clear" style="height:100px; " >&nbsp;</div>

<div class="center" >	<!-- footer --> 
<table class="xgis-table-bordered" >
<tr>
	<th class="center vc200" >___<span class="u" ><?php echo $cr['adviser']; ?></span>___<br />Adviser</th>
	<th class="vc100" >&nbsp;</th>
	<th class="center vc200" ><?php echo '____________________________'; ?><br />Principal</th>
	<th class="vc100" >&nbsp;</th>
	<th class="center vc200" ><?php echo '____________________________'; ?><br />Registrar</th>
</tr>


</table></div>

<!------------------------------------------------------------------------------------------------------------>
<script>

var hdpass 	= "<?php echo HDPASS; ?>";
var crid 	= "<?php echo $crid; ?>";
var gurl 	= 'http://<?php echo GURL; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
	excel();
	columnHighlighting();
	
})

function redirPage(){
	var sy=$('#sy').val();
	var qtr=$('#qtr').val();
	var url=gurl+'/matrix/grades/'+crid+'/'+sy+'/'+qtr;
	window.location=url;

}




</script>