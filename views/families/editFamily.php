<?php 

	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbfamilies="{$dbo}.00_families";
	

?>


<h3>
	Edit Family | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'families'; ?>" >Families</a>

</h3>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbfamilies,30);return false;' />		
	</td></tr>
</table></p>

<div id="names" >names</div>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Change</th><td><input name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><td colspan=2><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" ></td></tr>
</table>
</form>

<script>
var gurl = "http://<?php echo GURL; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbfamilies = "<?php echo $dbfamilies; ?>";
var family_id = "<?php echo $family_id; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})


function axnFilter(id){
	var url=gurl+"/families/edit/"+id;
	window.location=url;
	
}	/* fxn */




</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

