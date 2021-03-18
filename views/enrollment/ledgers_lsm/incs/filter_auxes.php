<?php 
	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');

// pr($contacts[0]);	
	
?>


<script>

var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";

$(function(){

})

function fby(){
	var start = year+'-01-01';
	var end = year+'-12-31';
	$('#start').val(start);
	$('#end').val(end);
}

function fbm(){
	$('#start').val(year+'-'+month_id+'-01');
	$('#end').val(ldm);
}



</script>



<form method="GET" >	<!-- filter -->
<div style="width:25%;float:left;" >
<table class="gis-table-bordered table-fx table-altrow" >
	
	<tr><th colspan=2 >
		<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
		| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
	</th></tr>
	
	<tr><th>SY</th><td><input id="sy" class="pdl05 full" type="number" name="sy" 
		min="<?php echo $_SESSION['settings']['year_start']; ?>" max="<?php echo DBYR; ?>"
		value="<?php echo (isset($_POST['sy']))? $_POST['sy']:$_SESSION['sy']; ?>" /></td></tr>	
	<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="dateone" 
		value="<?php echo (isset($_POST['dateone']))? $_POST['dateone']:$_SESSION['today']; ?>" /></td></tr>
	<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="datetwo" 
		value="<?php echo (isset($_POST['datetwo']))? $_POST['datetwo']:$_SESSION['today']; ?>" /></td></tr>	
		
	<tr>
		<th>Tender</th>
		<td>
			<select class="full" name="paytype_id" >
				<option value="" >Any</option>
				<?php foreach($paytypes AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_POST['paytype_id']))? $_POST['paytype_id']:NULL;?> >
						<?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>

	<tr>
		<th>Fees</th>
		<td>
			<select class="full" name="feetype_id" >
				<option value="" >Any</option>
				<?php foreach($feetypes AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_POST['feetype_id']))? $_POST['feetype_id']:NULL;?> >
						<?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
		
	<tr>
		<th>Customer</th>
		<td>
			<select class="full" name="scid" >
				<option value="" >Any</option>
				<?php foreach($contacts AS $sel): ?>
					<option value="<?php echo $sel['parent_id']; ?>" ><?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	

</table>
</div>

<div class="half" >
<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'due','value'=>'Due Date'),
	array('key'=>'i.amount','value'=>'Amount'),
	array('key'=>'c.name','value'=>'Customer'),			
	array('key'=>'p.name','value'=>'Pay Type'),			
	array('key'=>'f.name','value'=>'Fee Type'),			
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'p.datetime'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="DESC">DESC</option>
			<option value="ASC" <?php echo (isset($_POST['order']) && $_POST['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
		</select>		
	</td></tr>
	<tr><th>Records / Page </th><td><input class="pdl05" type="number" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:LIMITS; ?>" /></td></tr>
	<tr><th>Page</th><td><input class="pdl05" type="number" name="page" 
		value="<?php echo (isset($_POST['page']))? $_POST['page']:1; ?>"	/></td></tr>

		
	<tr><th colspan=2 >
		<input type="submit" name="filter" value="Filter" />	
		<input type="submit" name="cancel" value="Clear" />					
	</th></tr>


</table>
</div>


</form>	<!-- filter -->

