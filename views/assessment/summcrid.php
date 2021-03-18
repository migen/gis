<h5>
	<?php echo $pagetitle; ?>


</h5>

<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr><th>SCID</th><td><?php echo $scid; ?></td></tr>
<tr><th>Classlist</th><td>
<select name="crid"  >
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['summcrid'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?>
		</option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><td colspan="2" ><input type="submit" name="submit" value="Submit" /></td></tr>



</table>
</form>
<?php else: /*  scid */ ?>
<h5><a href="<?php echo URL.'assessment/assess'; ?>" >Assessment</a></h5>
<?php endif; /*  scid */ ?>
