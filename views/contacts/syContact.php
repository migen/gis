<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
	
	// pr($data);

?>
<h3>
	Edit School Year | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."contacts/ucis"; ?>' >UCIS</a>


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


<form>
<table class="gis-table-bordered table-fx" >
<tr><th>Scid</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['code']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>SY</th><td><?php echo $row['sy']; ?></td></tr>
<tr><th>Change</th>
	<td><input type="number" name="sy" id="sy" value="<?php echo $row['sy']; ?>" ></td></tr>
<tr><td colspan="2" ><input type="submit" onclick="xupdate();" value="Update"  /></td></tr>
</table>

</form>

<script>
var gurl = "http://<?php echo GURL; ?>";
var ucid = "<?php echo $ucid; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/contacts/sy/"+id;
	window.location=url;
}


function xupdate(){
	var sy=$('#sy').val();			
	var vurl 	= gurl + '/ajax/xdata.php';	
	var task	= "xeditData";	
	var pdata = "task="+task+"&dbtable="+dbcontacts+"&id="+ucid+"&sy="+sy;

	$.ajax({type: 'POST',url: vurl,data: pdata,success:function(){
		location.reload();	
	} });				
	
	
}	/* fxn */







</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

