<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbstudbooks="{$dbg}.50_students_books";
	
	$editable=false;
	// $editable=true;
	
	// pr($data);

?>
<h3>
	<span ondblclick="traceshd();" class="u" >Student Booklist</span> | <?php $this->shovel('homelinks'); ?>
<?php if($scid && (!$student['booklist_finalized'])): ?>	
	| <a href='<?php echo URL."booklists/syncStudent/$scid"; ?>' >Sync</a>
<?php endif; ?>

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
	<div id="names" >names</div>
<?php endif; ?>



<?php if($scid): ?>

<?php 
$is_finalized=($student['booklist_finalized']==1)? true:false;

?>

<table class="gis-table-bordered" >
<tr>
	<td><?php echo $student['scid']; ?></td>
	<td><?php echo $student['code']; ?></td>
	<td><?php echo $student['name']; ?></td>
	<td><?php echo $student['classroom']; ?></td>
	<td class="b" ><?php echo $is_finalized? 'Finalized':'Open'; ?></td>
</tr>
</table><br />

<form method="POST" >

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th class="shd" >Pkid</th>
	<th class="shd" >Sem</th>
	<th>Subject</th>
	<th>Book</th>
	<th>Company</th>
	<th class="right" >Amount</th>
	<?php if($editable): ?>	
		<th></th>
	<?php endif; ?>	
</tr>

<?php if(($srid==RSTUD) && ($is_finalized)): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<?php $pkid=$rows[$i]['pkid']; ?>
	<tr id="trow-<?php echo $i; ?>" >
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $pkid; ?></td>
		<td><?php echo $rows[$i]['semester']; ?></td>
		<td><?php echo $rows[$i]['subjname']; ?></td>
		<td><?php echo $rows[$i]['book']; ?></td>
		<td><?php echo $rows[$i]['company']; ?></td>
		<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>		<td></td>		
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<?php $pkid=$rows[$i]['pkid']; ?>
	<tr id="trow-<?php echo $i; ?>" >
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $pkid; ?></td>
		<td class="shd" ><?php echo $rows[$i]['semester']; ?></td>
		<td><?php echo $rows[$i]['subjname']; ?></td>
		<td><?php echo $rows[$i]['book']; ?></td>
		<td><?php echo $rows[$i]['company']; ?></td>
		<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
		<?php if($editable): ?>
			<td>
				<input type="hidden" id="pkid-<?php echo $i; ?>" value="<?php echo $pkid; ?>" />		
				<input type="submit" value="Delete" onclick="xdelete(dbstudbooks,<?php echo $i; ?>);return false;" />
			</td>	
		<?php endif; ?>	
	</tr>
	<?php endfor; ?>
<?php endif; ?>	
		
</table>

<?php if($editable): ?>
	<?php if(($srid==RSTUD) && (!$is_finalized)): ?>
		<p><input type="submit" name="submit" value="Finalize" ></p>
	<?php endif; ?>


	<?php if($srid!=RSTUD): ?>
		<?php if($is_finalized): ?>
			<p><input type="submit" name="unlock" value="Unlock" ></p>
		<?php else: ?>
			<p><input type="submit" name="submit" value="Finalize On" ></p>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>	<!-- editable -->

</form>
<?php endif; ?>	<!-- scid -->

	
	




<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbstudbooks = "<?php echo $dbstudbooks; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	shd();
})




function axnFilter(id){
	var url=gurl+"/students/booklist/"+id+"/"+sy;
	window.location=url;
}




function xdelete(dbtable,i){
	var id=$('#pkid-'+i).val();

	if (confirm('Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";
		var pdata='task='+task+'&id='+id+'&dbtable='+dbtable;
		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  $('#trow-'+i).hide(); }		  
		});									
	}	


}	/* fxn */





</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

