<?php 

	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
// pr($rows[0]);
?>

<h3>
	<span class="" >Student Payments SY<?php echo $sy; ?></span> 
	<?php echo ($scid)? "($count)":NULL; ?> 
	<select class="tf20" onchange="jsredirect(`students/payments/${scid}/${this.value}`)" >
		<option value="<?php echo DBYR; ?>" 
			<?php echo ($sy==(DBYR))? 'selected':NULL; ?>
		><?php echo DBYR; ?></option>
		<?php if($_SESSION['settings']['sy_enrollment']>DBYR): ?>
			<option value="<?php echo (DBYR+1); ?>" 
				<?php echo ($sy==(DBYR+1))? 'selected':NULL; ?>
			><?php echo (DBYR+1); ?></option>
		
		<?php endif; ?>
	</select>
	
	| <?php $this->shovel('homelinks'); ?>
	
	
</h3>


<?php if($srid!=RSTUD): ?>
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />
	</td></tr>
</table></p>
<?php endif; ?>

<?php if($scid): ?>

<table class="gis-table-bordered" >
	<tr>
		<th>ID No.</th><td><?php echo $student['studcode']; ?></td>
		<th>Student</th><td><?php echo $student['studname']; ?></td>
	</tr>

</table><br />


<table class="gis-table-bordered" >
<tr>
	<th class="vc100" >SY</th>
	<th class="vc100" >Date</th>
	<th class="vc150" >Feetype</th>
	<th class="vc150 right" >Amount</th>
	<th class="vc100" >OR No</th>
	<th class="vc100" >Type</th>
	<th class="" ></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo str_pad($rows[$i]['orno'],5,'0',STR_PAD_LEFT); ?></td>
	<td><?php echo ($rows[$i]['in_tuition']==1)? 'Tuition':'Bill'; ?></td>
	<td><a href="<?php echo URL.'ornos/view/'.$rows[$i]['orno']; ?>" >Print OR</a></td>
	
</tr>
<?php endfor; ?>
</table>

<?php endif; ?>		<!-- scid -->


<div id="names" >names</div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var scid = "<?php echo $scid; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/students/payments/"+id;
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>


