<?php 
	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$fdm = "$year-$month_id-01";
	$ldm  = date('Y-m-t');
	$today=$_SESSION['today'];

?>


<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>
var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var sy = "<?php echo DBYR; ?>";


</script>

<p>
<table class="gis-table-bordered" >
<tr><th>POID: <input id="poid" value=""  /></th>
<th><button onclick="redirPo();" >Go</button></th>
</tr>
</table>

</p>


<form id="form" method="GET" >
<table class="gis-table-bordered" >

<tr><th colspan="2" >
	<a class="txt-blue underline" onclick="fby();return false;" >Year</a>
	| <a class="txt-blue underline" onclick="fbm();return false;" >Month</a>
</th></tr>

<tr>
	<th>Supplier</th>
	<td>
		<select name="supplier" >
			<option value="0" >All</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>		
		</select>
	</td>
</tr>

<tr>
	<th>Reference</th>
	<td><input name="reference" /></td>
</tr>

<tr>
	<th>Invoice</th>
	<td><input name="invoice" /></td>
</tr>

<tr>
	<th>Balance</th>
	<td><input name="balance" value="0" /></td>
</tr>

<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="dateone" 
	value="<?php echo $today; ?>" /></td></tr>
<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="datetwo" 
	value="<?php  echo $today; ?>" /></td></tr>	
		
<tr><th>SY</th><td><input id="sy" class="pdl05 " type="number" name="sy" 
	value="<?php echo DBYR; ?>" /></td></tr>		
		
</table>

<br />
<br />
<!--------------------------------------------------------->

<table class="gis-table-bordered table-fx table-altrow" >

<?php $sorts = array(
	array('key'=>'po.date','value'=>'Date'),
	array('key'=>'po.total','value'=>'Total'),
	array('key'=>'po.balance','value'=>'Balance'),
	array('key'=>'c.name','value'=>'Supplier'),			
); ?>



	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_GET['sort']))? $_GET['sort']:'po.date'; ?>
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
	<tr><th>Records / Page </th><td><input class="pdl05" type="number" name="limits" 
		value="<?php echo (isset($_GET['limits']))? $_GET['limits']:LIMITS; ?>" /></td></tr>
	<tr><th>Page</th><td><input class="pdl05" type="number" name="page" 
		value="<?php echo (isset($_GET['page']))? $_GET['page']:1; ?>"	/></td></tr>

		
	<tr><th colspan=2 >
		<input type="submit" name="filter" value="Filter" accesskey="f" />	
		<input type="submit" name="cancel" value="Clear" onclick="$('#form')[0].reset();return false;" />					
	</th></tr>


</table>




</form>

<script type='text/javascript' src="<?php echo URL; ?>views/js/po.js"></script>
