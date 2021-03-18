<?php 

// pr($data);
// $bs=2015;
// pr($uniclassrooms);



?>


<h5>
	College SY<?php echo $sy; ?> | <?php $this->shovel('homelinks','College'); ?>
	| <a href='<?php echo URL."uniregister/add"; ?>'>Add</a>
	| <a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a>
	
	<?php if($scid): ?>
		| <a href='<?php echo URL."unistudents/edit/$scid"; ?>'>Edit</a>
	<?php endif; ?>
	

	
</h5>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>
<div id="names" >names</div>


<?php if($scid): ?>

<?php 
// pr($data);

?>


<table class="gis-table-bordered" >
	<tr>
		<td><?php echo $row['scid']; ?></td>
		<td><?php echo $row['studcode']; ?></td>
		<td><?php echo $row['student']; ?></td>	
		<?php if($role_id==RSTUD): ?>
			<td>R<?php echo $role_id; ?> BED </td>
		<?php else: ?>
			<td><?php echo (!empty($row['summcrid']))? $row['classroom'].' #'.$row['summcrid']:"Assign classroom."; ?> </td>	
		<?php endif; ?>
	</tr>
</table>
<br />
<form method="POST" >
<table class="gis-table-bordered table-altrow" >

<?php if(($role_id==8) && (empty($row['summscid']))): ?>
	<tr class="red" ><th>Initialized - Refresh Page</th></tr>
<?php endif; ?>	
<?php if($row['summscid']): ?>
	<tr><th>Level</th><th><input class="vc80" name="post[level_id]" value="<?php echo $row['level_id']; ?>" type="number"  /></th></tr>
	<tr><th>Classroom</th>
		<td><select name="post[crid]" class="vc200" >
	<option value=0 >Select One</option>
	<?php foreach($uniclassrooms AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['crid'])? 'selected':NULL; ?> >
		<?php echo $sel['name'].'  #'.$sel['id']; ?></option>
	<?php endforeach; ?>
	</select></td></tr>
	<tr><th>Graduating</th>
		<td><select name="post[is_graduating]" value="<?php echo $row['is_graduating']; ?>" class="vc80" min=0 max=1 type="number" />
		<option value=1 <?php echo ($row['is_graduating']==1)? 'selected':NULL; ?> >Yes</option>
		<option value=0 <?php echo ($row['is_graduating']!=1)? 'selected':NULL; ?> >No</option>
		</select></td>
	</tr>
	<tr><th>Old Student</th>
		<td><select name="post[is_old]" value="<?php echo $row['is_old']; ?>" class="vc80" min=0 max=1 type="number" />
		<option value=1 <?php echo ($row['is_old']==1)? 'selected':NULL; ?> >Yes</option>
		<option value=0 <?php echo ($row['is_old']!=1)? 'selected':NULL; ?> >No</option>
		</select></td>
	</tr>	
	<tr><th>Is Synced</th>
		<td><select name="post[is_synced]" value="<?php echo $row['is_synced']; ?>" class="vc80" min=0 max=1 type="number" />
		<option value=1 <?php echo ($row['is_synced']==1)? 'selected':NULL; ?> >Yes</option>
		<option value=0 <?php echo ($row['is_synced']!=1)? 'selected':NULL; ?> >No</option>
		</select></td>
	</tr>		
	
<?php endif; ?>
</table>
<p><input type="submit" name="update" value="Update" /></p>
</form>




<?php endif; ?>


<div class="clear ht50" ></div>





<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });
	
})

function redirContact(ucid){
	var url = gurl+'/uniregister/student/'+ucid;	
	window.location = url;		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
