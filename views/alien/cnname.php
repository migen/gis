<?php 
// pr($row);
?>

<h5>
	Chinese Name
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
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
	<tr><th>UP</th><td><?php echo $row['id']; echo ($row['id']!=$row['parent_id'])? '-'.$row['parent_id']:NULL; ?></td></tr>
	<tr><th>Name</th><td><?php echo $row['name']; ?></td></tr>
	<tr><th>Cn Name</th><td><?php echo $row['chinese_name']; ?></td></tr>
	<tr><th>Change Cn Name</th><td><input class="vc300" name="post[cnname]"
		value="<?php echo $row['chinese_name']; ?>" ></td></tr>
	<tr><th colspan="2" ><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');"  /></th></tr>		
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
	var url = gurl+'/alien/cnname/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

