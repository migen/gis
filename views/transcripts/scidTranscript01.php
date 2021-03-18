<style>

.subwidth{ width:320px; }
.table-center th, .table-center td, .table-center td  input { text-align:center; }
.table-vcenter th, .table-vcenter td, .table-vcenter td { vertical-align:middle; }


</style>


<?php 
	$decicard=$_SESSION['settings']['decicard'];
	$attd_qtr=$_SESSION['settings']['attd_qtr'];
	$attd_qtr=false;
	
	// pr($data);
	
	
?>


<h5 class="" >
	Transcript | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'profiles/scid/'.$scid; ?>" >Profile</a>
	
	
</h5>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>

<?php 
	// pr($scid);
	// pr($classrooms);
	// exit;
?>

<?php if($scid): ?>
	<table class="gis-table-bordered table-altrow" >
		<tr><td><?php echo $student['code']; ?></td>
			<td><?php echo $student['name']; ?></td></tr>
	</table><br />
	
	<?php 
		
		$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
		$one=SITE."views/customs/{$sch}/profiles/{$sch}ProfileTranscript.php";$two="incs/profileTranscript.php";		
		// $incs=(is_readable($one))? $one:$two;include_once($incs); 
		include_once('studinfo.php');
	?>
	<br />

<?php for($y=0;$y<$iyears;$y++): ?>
	<table class="gis-table-bordered table-altrow table-center" >
		<?php
			$lvl=$classrooms[$y]['level_id'];$sy=$years[$y]['sy'];		
			$dept_id=2;$dept_id=($lvl<4)? 1:$dept_id;$dept_id=($lvl>9)? 3:$dept_id;
			$url="rcards/scid/$scid/$sy/4?tpl=$dept_id";
			$url=($lvl<14)? $url:"srcards/scid/$scid/$sy/4/2";
		 ?>
		<tr>
			<td><?php echo 'SY '.$sy.'-'.($sy+1); ?></td>
			<td><?php echo $classrooms[$y]['name']; ?></td>
			<td><?php echo $classrooms[$y]['adviser']; ?></td>
			<td><?php echo 'Lvl #'.$classrooms[$y]['level_id']; ?></td>
			<td><?php echo 'Dept #'.$dept_id; ?></td>
			<td><?php echo 'SY #'.$sy; ?></td>
			<td><a href="<?php echo WURL.'gis/'.$url; ?>" >Rcard</a></td>
		</tr>
	</table><br />

	<table class="gis-table-bordered table-altrow table-center" >
		<?php $count=$counts[$y]; ?>
		<tr>
			<th style="text-align:left;" >Subject</th>
			<th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>Final</th>
		</tr>
		<?php for($i=0;$i<$count;$i++): ?>
		<?php $is_num=($grades[$y][$i]['is_num']==1)? 1:0; ?>
			<?php if($is_num): ?>
				<tr>
					<td style="text-align:left;" class="subwidth" ><?php echo $grades[$y][$i]['label']; ?></td>
					<td><?php $q1=number_format($grades[$y][$i]['q1'],$decicard);echo $q1; ?></td>
					<td><?php $q2=number_format($grades[$y][$i]['q2'],$decicard);echo $q2; ?></td>
					<td><?php $q3=number_format($grades[$y][$i]['q3'],$decicard);echo $q3; ?></td>
					<td><?php $q4=number_format($grades[$y][$i]['q4'],$decicard);echo $q4; ?></td>
					<td><?php $q5=number_format($grades[$y][$i]['q5'],$decicard);echo $q5; ?></td>
				</tr>
			<?php else: ?>	
				<tr>
					<td style="text-align:left;" class="subwidth" ><?php echo $grades[$y][$i]['label']; ?></td>
					<td><?php $dg1=$grades[$y][$i]['dg1'];echo $dg1; ?></td>
					<td><?php $dg2=$grades[$y][$i]['dg2'];echo $dg2; ?></td>
					<td><?php $dg3=$grades[$y][$i]['dg3'];echo $dg3; ?></td>
					<td><?php $dg4=$grades[$y][$i]['dg4'];echo $dg4; ?></td>
					<td><?php $dg5=$grades[$y][$i]['dg5'];echo $dg5; ?></td>
				</tr>			
			<?php endif; ?>	
		<?php endfor; ?>			
	</table><br />

	<?php 
		$months=&$attdmonths[$y];$attendance=&$attendances[$y];	
		if($attd_qtr){ $incs="attd_qtr.php";include($incs); } else {
			$incs="attd_mos.php";include($incs); }
		
	?>		
	<p class='clear pagebreak'>&nbsp;</p>
<?php endfor; ?>	<!-- years loop -->
<?php endif; ?>	<!-- scid -->

<script>
var gurl="http://<?php echo GURL; ?>";
var limits='30';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url=gurl+'/transcripts/scid/'+ucid;	
	window.location=url;		
}


</script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
