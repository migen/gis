<h3>
	GIS Paymode SY<?php echo ($sy); ?> | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>

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
<tr><th>Level</th><td><?php echo $row['level']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td class="vc200" ><?php echo $row['studname']; ?></td></tr>
<tr><th>Paymode</th><td><?php echo $row['paymode']; ?></td></tr>
<tr><th>Change</th><td>
	<input type="hidden" name="summ[id]" value="<?php echo $row['pkid']; ?>" >
	<select name="summ[paymode_id]"   >
		<?php foreach($paymodes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($row['paymode_id']==$sel['id'])? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Save" ></th></tr>

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
