

<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';


$sch=VCFOLDER;
$ucfsch=ucfirst(VCFOLDER);
$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles/":"profiles/classroom/";	

?>

<h5 class="screen" >
	Std Cert CIR (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
<?php 
	// $d['sy']=$sy;$d['repage']="cir/index";
	// $this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<?php // pr($levels); ?>

<span class="b" >Level Honors</span> <select onchange="jsredirect('mca/locking/'+this.value);" class="vc150" >
<option >Select One</option>
<?php foreach($levels AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
	
&nbsp;&nbsp; 

<span class="b" >Level Conducts</span> <select onchange="jsredirect('mca/locking/'+this.value);" class="vc150" >
<option >Select One</option>
<?php foreach($levels AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>


<br /><br />
<table class="gis-table-bordered table-fx table-altrow table-fx-columns " >
<tr class="headrow" >
	<th>#</th>
	<th>Classlist (Size)</th>
	<th>Honors</th>
	<th>Conducts</th>
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc200" >
		<a target="blank" href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid'].DS.$sy; ?>" >		
			<?php echo $rows[$i]['classroom'].' ('.$rows[$i]['num_students'].')'; ?></a>
		<?php echo ($rows[$i]['level_id']>13)? '('.$rows[$i]['num'].')':NULL; ?>	
	</td>
<td><a href='<?php echo URL."submissions/view/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Honors</a></td>
<td><a href='<?php echo URL."spiral/crid/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Conducts</a></td>

<td><?php echo $rows[$i]['crid']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	// fxColumnHighlighting();	
})


</script>


