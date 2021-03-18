<h3>
	Balances | <?php $this->shovel('homelinks'); ?>
<?php if($srid!=RSTUD): ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
	| <a href='<?php echo URL."payables/add/$scid/$sy&feetype_id=3"; ?>' >Add</a>
<?php endif; ?>	

</h3>


<?php 

$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";

// pr($student);

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

<table class="gis-table-bordered" >
<tr>
	<td><?php echo $student['scid']; ?></td>
	<td><?php echo $student['studcode']; ?></td>
	<td><?php echo $student['studname']; ?></td>
	<td><?php echo $student['classroom']; ?></td>
	<td class="b" ><?php echo number_format($student['balance'],2); ?></td>
</tr>
</table><br />


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>SY</th>
	<th>Feetype</th>
	<th>Amount</th>
	<th>Is<br />Paid</th>
<?php if($srid!=RSTUD): ?>
	<th></th>
<?php endif; ?>
	
</tr>
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php extract($rows[$i]); ?>
<?php $total+=$amount; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $sy; ?></td>
	<td><?php echo $feetype; ?></td>
	<td class="right" ><?php echo number_format($amount,2); ?></td>
	<td class="" ><?php echo $is_paid; ?></td>
<?php if($srid!=RSTUD): ?>
	<td><a href="<?php echo URL.'payables/edit/'.$pkid; ?>" >Edit</a></td>
<?php endif; ?>	
</tr>
<?php endfor; ?>
</table>
<br />
<h3>Total: <?php echo number_format($total,2); ?> </h3>

</form>
<?php endif; ?> 	<!-- scid -->

<?php $sy=$data['sy']; ?>

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
	var url = gurl+'/students/balances/'+id+'/'+sy;	
	window.location=url;
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
