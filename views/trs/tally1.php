<style>
tr.tallyhr > th,tr.tallyhr > td { background-color:#d3d3d3;color:blue;}

</style>

<?php 
	$deciconducts = $_SESSION['settings']['deciconducts'];

	// pr($grades[0]);
	
	
?>

<h5>
	<span class="u" onclick="tracehd();" >HD</span>
	Tally <span class="u" onclick="tracehd();return false;" >Traits</span> <?php echo "Q$qtr"; ?>
	| <?php echo $cr['name'];?>
	<span class="hd" >HD</span>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."cav/traits/$crsid/$sy/$qtr"; ?>' >Traits</a>	
<span class="hd" >
	| <a href='<?php echo URL."trs/cleanup/$crsid/$criteria_id/$sy/$qtr"; ?>' onclick="return confirm('Sure?');" >Cleanup</a>	
</span>
	
</h5>

<table class="gis-table-bordered hd" >
<tr><th>Crid#<?php echo $crid; ?></th><th>Crs#<?php echo $crsid; ?></th>
<td><?php foreach($teachers AS $row){ echo $row['tcid'].'-'.$row['teacher'].' ('.$row['label'].') | '; } ?></td>
</tr>
</table>


<p><?php $this->shovel('hdpdiv'); ?></p>

<p>Trait: <?php echo $criteria['code'].' ('.$criteria['name'].')'; ?></p>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>
	
function redirCtype(){
	var vurl = gurl+"/trs/tally/"+crs+ds+cri+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();
	window.location = vurl;		
}	/* fxn */
	
</script>


<br />

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="tallyhr" >
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<?php for($i=0;$i<$numteacs;$i++): ?>
		<th style="height:120px;" ><span class="vertical" ><?php echo $teachers[$i]['teacher']; ?></span></th>
	<?php endfor; ?>
	<th class="center" >DB</th>
	<th class="center" >Ave</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$numtrs=count($grades[$i]);
	$scid=$students[$i]['scid'];
	$total=0; 
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href='<?php echo URL."trs/scidCriteria/$crid/$criteria_id/$scid/$sy/$qtr"; ?>' ><?php echo $scid; ?></a></td>
	<td><?php echo $students[$i]['student']; // pr($grades[$i]); ?></td>
	
	
	<?php $k=0; ?>
	<?php foreach($grades[$i] AS $row): ?>
		<?php 
			$k=($row['grade']>0)? $k+1:$k; 
			$total+= $row['grade']; 
		?>	
		<td class="center" ><?php echo $row['grade']; ?></td>
	<?php endforeach; ?>
	<?php 
		$k=($k>0)?$k:1;	
		$ave=$total/$k;
	?>
	<td><?php echo $students[$i]['grade'].' | '.$students[$i]['dg']; ?></td>
	<td>
		<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?= $scid; ?>" />
		<input class="vc50 center" name="posts[<?php echo $i; ?>][ave]" 
			value="<?= number_format($ave,$deciconducts); ?>" tabindex="1" />
		<?php $dg = rating($students[$i]['grade'],$ratings); ?>
		<input class="vc30 center" name="posts[<?php echo $i; ?>][dg]" 
			value="<?= $dg; ?>" tabindex="2" />
	</td>
		
<?php if($numteacs<$numtrs): ?>		
	<?php $trstcids=buildArray($grades[$i],'tcid');  ?>
	<td>Refresh page!</td>	
	<?php deleteTrstally($db,$tcids,$trstcids,$crsid,$criteria_id,$scid);  ?>	
<?php elseif($numteacs>$numtrs): ?>		
	<?php $trstcids=buildArray($grades[$i],'tcid');  ?>
	<td>Refresh page!</td>	
	<?php addTrstally($db,$tcids,$trstcids,$crsid,$criteria_id,$scid);  ?>

<?php endif; ?>
	
</tr>
<?php endfor; ?>


</table>

<p>
	<input type="submit" name="tally" value="Tally" onclick="return confirm('Sure?');"  />
</p>


</form>


<script>

var gurl = 'http://<?php echo GURL; ?>';	
var crs	= '<?php echo $crsid; ?>';
var cri	= '<?php echo $criteria_id; ?>';
var sy   	= '<?php echo $sy; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var ds 		= '/';
var hdpass 	= '<?php echo HDPASS; ?>';


$(function(){
	hd();	
	$('#hdpdiv').hide();
	selectFocused();
	nextViaEnter();

})

</script>
