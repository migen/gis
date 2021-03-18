<?php 

$order=$_SESSION['settings']['classlist_order'];
$sch=VCFOLDER;
$dbg=PDBG;$dbo=PDBO;

$q="SELECT o.*,c.name AS student,c.code AS studcode
	FROM {$dbg}.`05_summaries` AS summ
	INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
	LEFT JOIN {$dbg}.`50_offenses_{$sch}` AS o ON summ.scid=o.scid
	WHERE summ.crid='$crid' ORDER BY $order;";	
debug($q,"views/offenses/recordsOffenses");
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$count=count($rows);


?>

<style>
	tr.center > th, tr.center > td { text-align:center; }
	
</style>

<h5>
	Offenses (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if($_SESSION['srid']==RMIS): ?>	
		| <a href="<?php echo URL.'syncOffenses/crid/'.$crid; ?>" >Sync</a>
	<?php endif; ?>
	
	<?php if(isset($_GET['edit'])): ?>	
		| <a href="<?php echo URL.'offenses/records/'.$crid.DS.$sy.DS.$qtr; ?>" >View</a>
	<?php else: ?>
		| <a href="<?php echo URL.'offenses/records/'.$crid.DS.$sy.DS.$qtr.'&edit'; ?>" >Edit</a>
	<?php endif; ?>
	| <a href="<?php echo URL.'conducts/process/'.$crid.DS.$sy.DS.$qtr; ?>" >Conducts</a>
	| <a href="<?php echo URL.'offenses/sync/'.$crid; ?>" >Sync</a>
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr class="center" >
	<th>#</th>
	<th class="redder" >Scid</th>
	<th style="text-align:left;" >Student</th>
	<th>Minor
	<?php if(isset($_GET['edit'])): ?>
		<br /><input class="center vc50" id="iminor" placeholder="All" /><br />
		<button onclick="populateColumn('minor');return false;" >All</button>			
	<?php endif; ?>	
	</th>
	<th>Major A
	<?php if(isset($_GET['edit'])): ?>
		<br /><input type="text" class="vc50 center" id="imajora" placeholder="All" /><br />
		<button onclick="populateColumn('majora');return false;" >All</button>
	<?php endif; ?>	
	</th>
	<th>Major B
	<?php if(isset($_GET['edit'])): ?>
		<br /><input type="text" class="vc50 center" id="imajorb" placeholder="All" /><br />
		<button onclick="populateColumn('majorb');return false;" >All</button>
	<?php endif; ?>	
	</th>
</tr>
<?php if(!isset($_GET['edit'])): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['scid']; ?></td>
		<td style="text-align:left;" ><a href="<?php echo URL.'offenses/editStudentOffense/'.$rows[$i]['scid']; ?>" >
			<?php echo $rows[$i]['student']; ?></a></td>
		
		<td><?php echo $rows[$i]['q'.$qtr.'_minor']; ?></td>
		<td><?php echo $rows[$i]['q'.$qtr.'_major_a']; ?></td>
		<td><?php echo $rows[$i]['q'.$qtr.'_major_b']; ?></td>

	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['scid']; ?></td>
		<td style="text-align:left;" ><?php echo $rows[$i]['student']; ?></td>
		
		<td><input class="vc50 center minor" name="posts[<?php echo $i; ?>][q<?php echo $qtr; ?>_minor]" 
			value="<?php echo $rows[$i]['q'.$qtr.'_minor']; ?>" /></td>
		<td><input class="vc50 center majora" name="posts[<?php echo $i; ?>][q<?php echo $qtr; ?>_major_a]" 
			value="<?php echo $rows[$i]['q'.$qtr.'_major_a']; ?>" /></td>			
		<td><input class="vc50 center majorb" name="posts[<?php echo $i; ?>][q<?php echo $qtr; ?>_major_b]" 
			value="<?php echo $rows[$i]['q'.$qtr.'_major_b']; ?>" />
		<input class="vc50 center" name="posts[<?php echo $i; ?>][scid]" 
			value="<?php echo $rows[$i]['scid']; ?>" type="hidden" />										
		</td>				

	</tr>
	<?php endfor; ?>
<?php endif; ?>
</table>

<?php if(isset($_GET['edit'])): ?>
	<p><input type="submit" name="submit" value="Save" /></p>
<?php endif; ?>

</form>



<script>

$(function(){
	selectFocused();
	nextViaEnter();

})



</script>

