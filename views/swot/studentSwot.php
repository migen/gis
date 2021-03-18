<?php 

$deciave=isset($_GET['deciave'])? $_GET['deciave']:$_SESSION['settings']['deciave'];

// pr($qtr);
// pr($rows[0]);

?>

<h5>
	Student SWOT | <?php $this->shovel('homelinks'); ?>
	
</h5>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>


<div id="names" >names</div>


<?php if(!$scid) exit;  ?>


<table class="gis-table-bordered table-altrow center" >

<?php $studinfo=$student['name'].' | '.$student['classroom']; ?>

<tr class="left" >
<?php if($lvl<14): ?>
<th colspan=7 ><?php echo $studinfo; ?></th>
<?php else: ?>
<th colspan=9 ><?php echo $studinfo; ?></th>
<?php endif; ?>
</tr>

<tr>
	<th>#</th>
	<th class="vc300 left" >Subject</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
<?php if($lvl<14): ?>	
		<th>Ave</th>
<?php else: ?>		
		<th>Sem1<br />Ave</th>
		<th>Sem2<br />Ave</th>
		<th>Sem</th>
<?php endif; ?>		
	
</tr>

<?php if($lvl<14): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="left" ><?php echo $rows[$i]['subject']; ?></td>
		<td><?php echo $rows[$i]['q1']+0; ?></td>
		<td><?php echo $rows[$i]['q2']+0; ?></td>
		<td><?php echo $rows[$i]['q3']+0; ?></td>
		<td><?php echo $rows[$i]['q4']+0; ?></td>
		<th><?php echo number_format($rows[$i]['q5'],$deciave); ?></th>
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<?php $j=$i+1; ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="left" ><?php echo $rows[$i]['subject']; ?></td>
		<td><?php echo $rows[$i]['q1']+0; ?></td>
		<td><?php echo $rows[$i]['q2']+0; ?></td>
		<td><?php echo $rows[$i]['q3']+0; ?></td>
		<td><?php echo $rows[$i]['q4']+0; ?></td>
		<th><?php echo number_format($rows[$i]['q5'],$deciave); ?></th>
		<th><?php echo number_format($rows[$i]['q6'],$deciave); ?></th>
		<td><?php echo $rows[$i]['sem']; ?></td>
	</tr>
	<?php echo ($rows[$i]['sem']!=@$rows[$j]['sem'])? "<tr><td colspan=9>&nbsp;</td></tr>":NULL; ?>
	<?php endfor; ?>
<?php endif; ?>

</table>




<div class="ht100" ></div>


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';


$(function(){
	$('#names').hide();	
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/swot/student/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
