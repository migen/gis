<?php 

	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
	$dbfamily_members="{$dbo}.00_family_members";
	

?>


<h3>
	Family Members (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'families'; ?>" >Families</a>

</h3>

<?php if($srid==RSTUD): ?>
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Add" onclick='addStudcode(dbcontacts);return false;' />		
	</td></tr>
</table></p>
<?php else: ?>
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
</table></p>
<div id="names" >names</div>


<?php endif; ?>


<h4>Family <?php echo $family['name']; ?></h4>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Member</th>
	<th>Birthdate</th>
<?php if($srid!=RSTUD): ?><td></td><?php endif; ?>	
</tr>


<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['member']; ?></td>
	<td><?php echo $rows[$i]['birthdate']; ?></td>
<?php if($srid!=RSTUD): ?>
<td><a href="<?php echo URL.'families/deleteMember/'.$rows[$i]['pkid']; ?>" >Delete</a></td>
<?php endif; ?>
<?php endfor; ?>
	
	
</table>


<script>
var gurl = "http://<?php echo GURL; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbfamily_members = "<?php echo $dbfamily_members; ?>";
var family_id = "<?php echo $family_id; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	enterStudcode(dbcontacts);
	
})	/* fxn */


function enterStudcode(dbtable){
    $('#part').bind("keydown",function(e) {
        if (e.which == 13) {
            e.preventDefault();
			var part=$('#part').val();
			var vurl = gurl+'/ajax/axdata.php';	
			var task = "xgetIdByCode";
			var pdata='task='+task+'&part='+part+'&dbtable='+dbtable;
			$.ajax({
				url:vurl,dataType:"json",type:"POST",
				data:pdata,async:true,
				success: function(s) {  
					var id=s.id;
					checkFamily(id);					

				}		  
			});												
        }
    });
	
}	/* fxn */

function addStudcode(dbtable){
	var part=$('#part').val();
	var vurl = gurl+'/ajax/axdata.php';	
	var task = "xgetIdByCode";
	var pdata='task='+task+'&part='+part+'&dbtable='+dbtable;
	$.ajax({
		url:vurl,dataType:"json",type:"POST",
		data:pdata,async:true,
		success: function(s) {  
			var id=s.id;
			checkFamily(id);					

		}		  
	});	
}	/* fxn */


function axnFilter(id){
		
	checkFamily(id);
	
}	/* fxn */


function checkFamily(id){
	var vurl = gurl+'/ajax/xfamilies.php';	
	var task = "exists";		
	var pdata='task='+task+'&dbtable='+dbfamily_members+'&scid='+id;

	$.ajax({
		url:vurl,dataType:"json",type:"POST",data:pdata,
		success: function(s) { 
			if(s.exists==true){
				alert('already belongs to family '+s.family+' #'+s.family_id);				
			} else {
				addToFamily(id);
			}
		}		  
	});				
	
	
}	/* fxn */


function addToFamily(id){
	var vurl = gurl+'/ajax/axdata.php';	
	var task = "xsaveData";		
	var pdata='task='+task+'&dbtable='+dbfamily_members+'&family_id='+family_id+'&scid='+id;

	$.ajax({
		url:vurl,dataType:"json",type:"POST",data:pdata,
		success: function() { 
			location.reload();
		}		  
	});				
	
	
}	/* fxn */



</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

