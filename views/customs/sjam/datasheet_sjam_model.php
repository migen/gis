<script>

var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';


$(function(){
	nextViaEnter();
	selectFocused();
	$('#names').hide();
	
})

function redirContact(ucid){
	var url = gurl+'/students/datasheet/'+ucid;	
	window.location = url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>



<?php 


debug($student);
$promlvl=$student['promlvl'];

?>

<h3>
	SJAM Datasheet | <?php $this->shovel('homelinks'); ?>
		
</h3>

<p class="brown" >
	Notes:<br />
	1. Birthdate - follow strict format: 2010-12-25 (i.e. Dec 25, 2010) <br />
	
</p>

<style>

.divleft{ float:left;width:40%; border:1px solid white; }


</style>

<?php if($srid!=RSTUD): ?>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<?php if(!isset($params) && ($srid!=RSTUD)){ exit; } ?>
<?php endif; ?>

<form method="POST" >
<div class="divleft" >
<table class="gis-table-bordered" >
<tr><th colspan=2>Profile Master Data</th></tr>
<?php for($i=0;$i<$profiles_count;$i++): ?>
	<?php 
		$key=$profiles_cols[$i];
		$label=ucfirst($key);
		$label=str_replace("_"," ",$label);
	
	?>
	<tr><th><?php echo $label; ?></th><td>
		<?php if(in_array($key,$text_array)): ?>
			<textarea cols=30 rows=5 name="profile[<?php echo $key; ?>]" ><?php echo $profile[$key]; ?></textarea>
		<?php else: ?>
			<input name="profile[<?php echo $key; ?>]" value="<?php echo $profile[$key]; ?>" >
		<?php endif; ?>					
	</td></tr>
<?php endfor; ?>
<tr><td colspan=2>Save &nbsp; <input type="submit" name="submit" value="Profile"  ></td></tr>
</table>

<div class="ht100" >&nbsp;</div>

</div>

</form>

<form method="POST" >
<div class="divleft" >
<table class="gis-table-bordered" >
<tr><th colspan=2>Custom Data</th></tr>
<tr><th>Date</th><td><input name="custom[date]" value="<?php echo $_SESSION['today']; ?>" ></td></tr>
<tr><th>Name</th><td><input name="custom[name]" value="<?php ; ?>" ></td></tr>
<tr><td colspan=2>Save &nbsp; <input type="submit" name="submit_custom" value="Custom"  ></td></tr>
</table>

<div class="ht100" >&nbsp;</div>

</div>


</form>


