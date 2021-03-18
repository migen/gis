<?php 


?>


<h5>
	MIS Password
	| <a href="<?php echo URL; ?>students">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
</h5>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>



<?php if($ucid): ?>
<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<tr><td>UCID</td><td><input name="ucid" value="<?php echo $row['ucid']; ?>" readonly /></td></tr>
	<tr><td>Name</td><td><input name="name" value="<?php echo $row['name']; ?>" readonly /></td></tr>
	<tr><td>Clear Pass</td><td><input name="ctp" value="<?php echo $row['ctp']; ?>" /></td></tr>
	<tr><td colspan="2" ><input type="submit" name="submit" value="Submit" /></td></tr>
</tr>
</table>
</form>
<?php endif; ?>

<div id="names" >names</div>


<script>

var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });


})

function redirContact(ucid){
	var url = gurl+'/mgt/password/'+ucid;	
	window.location = url;		
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
