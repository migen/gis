<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';
// pr($attdlink);
// pr($classrooms[62]);

$psy=DBYR-1;

?>


<h5 class="screen" >
	<?php echo $psy; ?> SHS Classrooms (<?php echo $count; ?>)	
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'shs/levels'; ?>" >SHS Levels</a>
	| <a href="<?php echo URL.'shs/resetShsList'; ?>" >Reset Shs List</a>
	
</h5>

<form method="POST" >
<p><span class="b" >SY </span><input type="number" class="center vc100" id="sy" name="sy" value="<?php echo $psy; ?>" /></p>
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th><input type="checkbox" id="chkAlla"  /></th>
	<th>#</th>
	<th>Classroom</th>
	<th>Crid</th>
	<th></th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $crid=$rows[$i]['crid']; ?>
	<td><input type="checkbox" class="chka" name="posts[<?php echo $i; ?>][crid]" value="<?php echo $crid; ?>" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $crid; ?></td>
	<td><a href="<?php echo URL.'shs/genaveSummary/'.$rows[$i]['crid'].DS.$psy; ?>" >Genave</a></td>
	<td><a href="<?php echo URL.'foundation/crid/'.$rows[$i]['crid'].DS.$psy; ?>" >Foundation</a></td>

</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Combo" /></p>
</form>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	chkAllvar('a');
	

})


</script>


