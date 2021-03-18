<h5>
	GIS Parent Online Portal | <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="u" >SHD</span>
	

</h5>


<?php 

?>

<?php if($scid): ?>
	<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $student['code']; ?></td>
		<td><?php echo $student['name']; ?></td>
	</tr>
	</table>	
	<br />	
<?php endif; ?>
<?php if(!$user_is_student): ?>
<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var limits='20';

$(function(){
	$('#names').hide();
	
})

function redirContact(ucid){
	var url = gurl+'/students?scid='+ucid;	
	window.location=url;		
}




</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<?php if(!isset($_GET['scid']) && ($srid!=RSTUD)){ exit; } ?>
<?php endif; ?>


<table class="studhome accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('studhome');" >Student</th></tr>

	<tr><td class="vc250" >
		<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/links"; ?>' >Links</a>
		<?php endif; ?>
	</th></tr>
	<tr><td><a href='<?php echo URL."portals/pass/$scid"; ?>' >Change Password</a></td></tr>
	<tr><td><a href='<?php echo URL."students/ensumm/$scid"; ?>' >Enrollment Summary</a></td></tr>
	<tr><td><a href='<?php echo URL."students/datasheet/$scid"; ?>' target="_blank" >Datasheet</a></td></tr>
<?php if($scid): ?>
	<?php 
		$rcard_ctlr=($level_id<14)? 'rcards':'srcards'; 
		$rcget=$_SESSION['settings']['rcard_get'];
	?>
	<?php if($level_id<2): ?>
		<tr><td>
			<a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy/4?{$rcget}&tpl=5"; ?>' >PN Report Card</a>
			| <a target="_blank" href='<?php echo URL."frontcards/scid/$scid/$sy/$qtr?{$rcget}&tpl=5"; ?>' >Front</a>		
		</td></tr>	
	<?php elseif($level_id<14): ?>
		<tr><td><a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy/$qtr?{$rcget}&tpl=$dept_id"; ?>' >Report Card</a></td></tr>
	<?php else: ?>
		<?php 
			$half=($qtr<3)? 1:2;		
			$both=$_SESSION['settings']['srcard_both'];			
		?>
		<tr><td>
			<a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy/2/1?{$rcget}&both=$both"; ?>' >SHS Sem1</a>
			| <a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy/4/2?{$rcget}&both=$both"; ?>' >SHS Sem2</a>
		</td></tr>
	<?php endif; ?>
	
	
<?php else: ?>
	<tr><td><a href='<?php echo URL."students/enrollment/$scid"; ?>' >Enrollment</a>
		<?php if(!$user_is_student): ?>
			| <a href='<?php echo URL."students/sectioner/$scid"; ?>' >Sectioner</a>
		<?php endif; ?>	
	</td></tr>
<?php endif; ?>
	<tr><td>&nbsp;</td></tr>
	
</table>


