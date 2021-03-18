<h3>
	Families | <?php $this->shovel('homelinks'); ?>
	
	<?php if($srid!=RSTUD): ?>
		| <a href='<?php echo URL."families/table"; ?>' >All</a>
	<?php endif; ?>
</h3>

<?php if($srid!=RSTUD): ?>
	Add convention - middle_name last_name, i.e. Cruz, John Santos - Family name - santo cruz
<?php endif; ?>


<?php 

	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbfamilies="{$dbo}.00_families";
	// pr($dbfamilies);

?>

<?php if($srid==RSTUD): ?>
<table class="gis-table-bordered" >
<tr>
	<th>ID</th>
	<th class="" >Status</th>
	<th class="vc200" >Name</th>
	<th></th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['pkid']; ?></td>
	<td><?php echo ($rows[$i]['is_finalized']==1)? 'Locked':'Open'; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'families/members/'.$rows[$i]['pkid']; ?>" >Siblings</a></td>
</tr>
<?php endfor; ?>
</table>
<?php else: ?>
	<p><table id="tbl-1" class="gis-table-bordered " >
		<tr>
			<th>ID</th>
			<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbfamilies,30);return false;' />		
			<input type="submit" name="auto" value="Add" onclick='saveData();return false;' />		
		</td></tr>
	</table></p>
<?php endif; ?>

<div id="names" >names</div>

<script>
var gurl = "http://<?php echo GURL; ?>";
var dbfamilies = "<?php echo $dbfamilies; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})	/* fxn */


function axnFilter(id){
	var url=gurl+"/families/members/"+id;
	window.location=url;
}	/* fxn */


function saveData(){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/axdata.php';	
	var task = "xsaveData";		
	var pdata='task='+task+'&name='+part+'&dbtable='+dbfamilies;

		
	$.ajax({
		url:vurl,dataType:"json",type:"POST",data:pdata,async:true,
		success: function() { 
			$('#part').val('');alert(part+' family added.'); 
		}		  
	});				
		
	
}	/* fxn */



</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>



