<?php 
$sy=isset($sy)? $sy:DBYR;
?>

<h5>

	
	Purge Duplicate Contact (<?php echo $sy; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'misc/purger/'.(DBYR+1); ?>" ><?php echo DBYR+1; ?></a>				 	
	
</h5>

<h4 class="brown" >*Params[0] = SY</h4>

<div class="forty" >

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>Duplicate</th>
	<td>
		<input class="pdl05" id="part" name="name"  />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />
	</td>
</tr>	

</table>

</form>

<?php include_once('incs/notes_purger.php'); ?>


<div id="names" >names</div>

</div>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';
var sy = '<?php echo $sy; ?>';


$(function(){
	itago('bl');
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

	
})



function redirContact(ucid){
	if(confirm('DANGEROUS!!! Sure?')){
		var rurl = gurl+'/purge/one/'+ucid+'/'+sy;	
		window.location = rurl;			
	}
}	/* fxn */



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

