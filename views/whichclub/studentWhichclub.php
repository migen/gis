<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	
	// pr($data);

?>
<h3>
	Which Club | <?php $this->shovel('homelinks'); ?>


</h3>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>


<?php 

// pr($row);

?>

<?php if($row): ?>
	<?php 
		extract($row);	
	?>
	<table class="gis-table-bordered table-altrow table-fx" >
		<tr><th>Scid</th><td class="vc200" ><?php echo $scid; ?></td>
		<tr><th>ID No.</th><td><?php echo $studcode; ?></td>
		<tr><th>Student</th><td><?php echo $studname; ?></td>
		<tr><th>SY<?php echo $sy; ?></th><td><?php echo $club.' #'.$club_id; ?>
				&nbsp; <a href="<?php echo URL.'clubs/members/'.$club_id.DS.$sy; ?>" >View</a>	
		</td>
		<?php if(!empty($prevclub)): ?>
			<tr><th>Previous SY<?php echo $prevsy; ?></th><td><?php echo $prevclub.' #'.$prevclub_id; ?>
				&nbsp; <a href="<?php echo URL.'clubs/members/'.$prevclub_id.DS.$prevsy; ?>" >View</a>
			</td>
		<?php else: ?>
			<tr><th colspan=2>No club in previous school year.</td>
		<?php endif; ?>
	</tr>


	</table>


<?php endif; ?>



<div class="ht100" >&nbsp;</div>



<script>
let gurl = "http://<?php echo GURL; ?>";
let sy = "<?php echo $sy; ?>";
let dbcontacts = "<?php echo $dbcontacts; ?>";
let limit=20;

$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/whichclub/student/"+id+"/"+sy;
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

