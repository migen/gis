<?php 

// pr($classrooms);

$ya = $_SESSION['settings']['year_start'];
$yb = DBYR;
$sys = array();
for($i=$yb;$i>=$ya;$i--){
	array_push($sys,$i);
}


	
?>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){

})




</script>



<form method="GET" >	<!-- filter -->
<div style="width:25%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	
	<tr>
		<th>SY</th>
		<td>		
			<select class="full" name="sy" >
				<option value="" >Any</option>
				<?php foreach($sys AS $val): ?>
					<option <?php echo (isset($_GET['sy']))? $_GET['sy']:NULL;?> >
						<?php echo $val; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
		
	<tr>
		<th>Classrooms</th>
		<td>
			<select class="full" name="crid" >
				<option value="" >Any</option>
				<?php foreach($classrooms AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_GET['crid']))? $_GET['crid']:NULL;?> >
						<?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	
	<tr>
		<th>Level</th>
		<td>
			<select class="full" name="lvlid" >
				<option value="" >Any</option>
				<?php foreach($levels AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_GET['lvlid']))? $_GET['lvlid']:NULL;?> >
						<?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>

</table>
</div>

<div class="half" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'c.name','value'=>'Student'),			
	array('key'=>'c.is_male','value'=>'Male'),			
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_GET['sort']))? $_GET['sort']:'p.datetime'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="DESC">DESC</option>
			<option value="ASC" <?php echo (isset($_GET['order']) && $_GET['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
		</select>		
	</td></tr>

		
	<tr><th colspan=2 >
		<input type="submit" name="filter" value="Filter" />	
		<input type="submit" name="cancel" value="Clear" />					
	</th></tr>


</table>
</div>


</form>	<!-- filter -->

