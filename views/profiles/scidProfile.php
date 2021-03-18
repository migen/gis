

<h5>
	Std Profile | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'contacts/edit/'.$scid; ?>" >Contact</a>
	
	| <?php if(!isset($_GET['print'])): ?>
		<a href="<?php echo URL.'profiles/scid/'.$scid.'&print'; ?>" >Print</a>
	<?php else: ?>
		<a href="<?php echo URL.'profiles/scid/'.$scid; ?>" >Edit</a>	
	<?php endif; ?>

	| <?php if($_SESSION['srid']==RMIS): ?>
		<a href="<?php echo URL.'contacts/ucis/'.$scid; ?>" >UCIS</a>
	<?php endif; ?>


<?php 
	$tables=array('cities','nationalities','occupations','religions');
?>
	<span> &nbsp; <select class="" onchange="jsredirect('lookups/profile/'+this.value);" >
		<option>Lookups</option>
		<?php foreach($tables AS $table): ?>
			<option ><?php echo $table; ?></option>
		<?php endforeach; ?>
	</select> &nbsp; </span>


</h5>

<?php 

if(isset($row)){ debug($row); }

?>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>


<?php if(isset($scid)): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Scid</th><td><?php echo $scid; ?></td></tr>
<?php foreach($row AS $k=>$v): ?>
<tr><th><?php echo ucfirst($k); ?></th>
<td><input class="pdl05" name="post[<?php echo $k; ?>]" value="<?php echo $v; ?>" ></td>
</tr>
<?php endforeach; ?>
<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>
<?php endif; ?>

<div class="ht100" ></div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var limits=100;

$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/profiles/scid/'+ucid;	
	window.location = url;		
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
