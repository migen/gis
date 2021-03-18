<h5>
	Tuition Summary | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>


<?php if($scid): ?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Year</th><td><?php echo $row['sy']; ?></td></tr>
<tr><th>Scid</th><td><?php echo $row['scid']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['student']; ?></td></tr>
<tr><th>Assessed</th><td><?php echo $row['assessed']; ?></td></tr>
<tr><th>Addons</th><td><?php echo $row['addons']; ?></td></tr>
<tr><th>Paid</th><td><?php echo $row['paid']; ?></td></tr>
<tr><th>SY Balance</th><td><input name="tsum[balance]" value="<?php echo $row['balance']; ?>" ></td></tr>
<tr><th colspan=2 >Total</th></tr>
<tr><th>Total Balance</th><td><input name="tbal[balance]" value="<?php echo $row['tbalance']; ?>" ></td></tr>
</table>


<br /><input type="submit" name="submit" value="Save" />
</form>

<?php endif; ?>	<!-- scid -->



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='50';
// var lady=charmee();


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(id){
	var url = gurl+'/tsum/scid/'+id;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
