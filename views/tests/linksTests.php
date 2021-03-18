<?php 

// pr($data);
$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";


?>


<h5>
	Tests Links | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'tests/links'; ?>">Links</a>
	| <a href="<?php echo URL.'tests/encrid'; ?>">Encrid</a>
	| <a href="<?php echo URL.'tests/ledger'; ?>">Ledger</a>
	


	
</h5>

<?php pr($data); ?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,5);return false;' />
		
	</td></tr>
	
</table></p>

<div id="names" >names</div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function axnFilter(id){
	var url = gurl+'/tests/links/'+id;	
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
