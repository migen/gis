<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbclassrooms="{$dbg}.05_classrooms";
	
	// pr($data);

?>
<h3>
	Tests Encrid | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tests/ledger"; ?>' >Ledger</a>
	| <a href='<?php echo URL."tests/links"; ?>' >Links</a>
	| <a href="<?php echo URL.'tests/ledger'; ?>">Ledger</a>


</h3>


<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Classrooms" onclick='getDataByTable(dbclassrooms,30);return false;' />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbclassrooms = "<?php echo $dbclassrooms; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/tests/encrid/"+id+"/"+sy;
	alert(url);
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

