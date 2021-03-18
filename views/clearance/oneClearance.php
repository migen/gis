<h5>
	Student Clearance Status
	| <?php $this->shovel('homelinks'); ?>

</h5>

<?php 
// pr($row);
?>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>


<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>SCID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['code']; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $row['classroom'].' #'.$row['crid']; ?></td></tr>
<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>Status (Active=1)</th><td><input name="post[is_active]" value="<?php echo $row['is_active']; ?>" type="number" min=0 max=1  /></td></tr>
</table>
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
<?php endif; ?>


<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo DBYR; ?>";
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/clearance/one/'+ucid;	
	window.location = url;		
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
