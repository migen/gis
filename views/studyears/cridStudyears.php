<?php 
$dbtable=PDBG.'.`05_classrooms`';


?>


<h5>
	Studyears (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
	

</h5>



<?php 

	$this->shovel('filter_redirect'); 
		
?>	


<br />

<table class="gis-table-bordered table-altrow" >

<?php if(!isset($_GET['edit'])): ?>
	<tr>
		<th>#</th>
		<th>ID No.</th>
		<th>Student</th>
		<th>Beg SY</th>
		<th>End SY</th>
		<th></th>
	</tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['studcode']; ?></td>
		<td><?php echo $rows[$i]['student']; ?></td>
		<td><?php echo $rows[$i]['begsy']; ?></td>
		<td><?php echo $rows[$i]['endsy']; ?></td>
		<td><a href="<?php echo URL.'studyears/edit/'.$rows[$i]['scid']; ?>" >Edit</a></td>
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<tr>
		<th>#</th>
		<th>ID No.</th>
		<th>Student</th>
		<th>Beg SY<br />
			<input class="pdl05 vc50" id="ibeg" /><br />	
			<input type="button" value="All" onclick="populateColumn('beg');" >									
		</th>
		<th>End SY<br />
			<input class="pdl05 vc50" id="iend" /><br />	
			<input type="button" value="All" onclick="populateColumn('end');" >		
		</th>
		<th></th>
	</tr>
	<form method="POST" >
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['studcode']; ?></td>
		<td><?php echo $rows[$i]['student']; ?></td>
		<td><input class="vc50 beg pdl05"name="posts[<?php echo $i; ?>][begsy]" value="<?php echo $rows[$i]['begsy']; ?>" ></td>
		<td><input class="vc50 end pdl05" name="posts[<?php echo $i; ?>][endsy]" value="<?php echo $rows[$i]['endsy']; ?>" ></td>
		<td><a href="<?php echo URL.'studyears/edit/'.$rows[$i]['scid']; ?>" >Edit</a></td>
		
			<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>" >
	</tr>
	<?php endfor; ?>
	<tr><td colspan=6><input type="submit" name="submit" value="Save"  /></td></tr>
	</form>
<?php endif; ?>
		
</table>

<div class="ht50" ></div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var dbtable = "<?php echo $dbtable; ?>";
var limits = 20;

		
$(function(){
	// hd();	
	$('#hdpdiv').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});
	
	
})



function redirContact(pcid,rid){	
	$('input[name="posts['+rid+'][tcid]"]').val(pcid);		
}	/* fxn */


function axnFilter(id){	
	// $('input[name="posts['+rid+'][tcid]"]').val(pcid);		
	var url = gurl+'/studyears/crid/'+id;	
	window.location = url;			
}	/* fxn */



</script>



<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>







