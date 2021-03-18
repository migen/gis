<h3>
	Payables | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
	| <a href='<?php echo URL."payables/add/$scid/$sy&feetype_id=3"; ?>' >Add</a>
	| <a href='<?php echo URL."payables/add/$scid/$sy&all"; ?>' >All</a>

</h3>


<?php 

$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";

?>

<?php if($srid!=RSTUD): ?>
<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
	
</table></p>
<div id="names" >names</div>
<?php endif; ?>	<!-- !user_is_student -->


<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>SY</th>
	<th>Feetype</th>
	<th>Amount</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php extract($rows[$i]); ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $sy; ?></td>
	<td><?php echo $feetype; ?></td>
	<td class="right" ><?php echo number_format($amount,2); ?></td>
	<td><a href="<?php echo URL.'payables/edit/'.$pkid; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
</form>
<?php endif; ?> 	<!-- scid -->

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
	var url = gurl+'/students/paymode/'+id+'/'+sy;	
	window.location=url;
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
