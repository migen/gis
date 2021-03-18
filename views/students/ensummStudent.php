<h3>
	GIS Enrollment Summary | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."students/balances/$scid/$sy&feetype_id=3"; ?>' >Balances</a>
	
	
</h3>

<?php 


?>


<?php if($scid): ?>
<table class="gis-table-bordered" >
<tr>
	<td><?php echo $student['scid']; ?></td>
	<td><?php echo $student['birthdate']; ?></td>
	<td><?php echo $student['studcode']; ?></td>
	<td><?php echo $student['studname']; ?></td>
</tr>
</table>
<?php endif; ?>

<?php 

debug($data);

?>

<?php if($is_admin): ?>
	<!-- 1 - filter -->
	<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
	<div id="names" >names</div>
	<!-- 2 - add -->
	<?php if($scid): ?>	
		<form method="POST" >
			<table class="gis-table-bordered" >
				<tr><th>SY</th><td><input name="post[sy]" ></td>
					<th>Balance</th><td><input name="post[balance]" ></td>
					<th colspan= ><input type="submit" name="submit" value="Add" ></th>
				</tr>	
			</table>
		</form>	
	<?php endif; ?>	<!-- scid -->
	
<?php endif; ?>

<br />

<?php if($scid): ?>
<h4>Summaries</h4>
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>SY</th>
	<th class="vc250" >Classroom</th>
	<th>Balance</th>
	<?php if($is_admin): ?>
		<th></th>
	<?php endif; ?>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['balance'],2); ?></td>
	<?php if($is_admin): ?>
		<td><a href="<?php echo URL.'summ/edit/'.$rows[$i]['pkid']; ?>" >Edit</a></td>	
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>


<hr />

<!-- ensumm below -->
<h4>Enrollments</h4>
<?php // pr($ensumm[0]); ?>
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>SY</th>
	<th class="vc250" >Classroom</th>
	<?php if($is_admin): ?>
		<th></th>
	<?php endif; ?>	
</tr>
<?php for($i=0;$i<$ensumm_count;$i++): ?>
<tr>
	<td><?php echo $ensumm[$i]['sy']; ?></td>
	<td><?php echo $ensumm[$i]['classroom']; ?></td>
	<?php if($is_admin): ?>
		<td><a href="<?php echo URL.'ensumm/edit/'.$ensumm[$i]['enid']; ?>" >Edit</a></td>	
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>


<?php endif; ?>	<!-- scid -->


<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/students/ensumm/'+ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

