<h5>
	Setup Payments
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	| <a href="<?php echo URL.'id/tracer'; ?>">Tracer</a>
	| <a href="<?php echo URL.'setaxis/paymodes'; ?>">Setup Paymodes</a>
		
	
</h5>



<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>ECID
		<br /><input class="pdl05 vc80" id="iecid" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('ecid');" >										
	</th>
	<th>SCID</th>
	<th>FTID
		<br /><input class="pdl05 vc80" id="iftid" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('ftid');" >									
	</th>
	<th>Ptr(1)
		<br /><input class="pdl05 vc30" id="iptr" value="1" /><br />	
		<input type="button" value="All" onclick="populateColumn('ptr');" >							
	</th>
	<th>Amount
		<br /><input class="pdl05 vc80" id="iamt" /><br />	
		<input type="button" value="All" onclick="populateColumn('amt');" >								
	</th>
	<th>Orno</th>
	<th>Date
		<br /><input class="pdl05 vc80" id="idate" value="<?php echo $_SESSION['today']; ?>" /><br />	
		<input type="button" value="All" onclick="populateColumn('date');" >								
	</th>	
</tr>


<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td><?php echo $i+1; ?></td>
	<td><input id="ecid<?php echo $i; ?>" class="vc60 ecid" name="posts[<?php echo $i; ?>][ecid]" /></td>				
	<td><input id="scid<?php echo $i; ?>" class="vc60" name="posts[<?php echo $i; ?>][scid]" /></td>				
	<td><input id="ftid<?php echo $i; ?>" class="vc50 ftid" name="posts[<?php echo $i; ?>][ftid]" /></td>				
	<td><input id="ptr<?php echo $i; ?>" class="vc30 ptr" name="posts[<?php echo $i; ?>][ptr]" /></td>				
	<td><input id="amount<?php echo $i; ?>" class="vc80 amt" name="posts[<?php echo $i; ?>][amount]" /></td>				
	<td><input id="orno<?php echo $i; ?>" class="vc100 orno" name="posts[<?php echo $i; ?>][orno]" /></td>				
	<td><input id="date<?php echo $i; ?>" class="vc80 date" name="posts[<?php echo $i; ?>][date]" /></td>				
</tr>
<?php endfor; ?>			

</table>


<p>
	<input type="submit" name="submit" value="Submit"  />
</p>

</form>

<p><?php $this->shovel('numrows'); ?></p>


<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="ecid" >ECID</option>
	<option value="scid" >SCID</option>
	<option value="ftid" >FTID</option>
	<option value="ptr" >Pointer</option>
	<option value="amount" >Amount</option>
	<option value="date" >Date</option>
	<option value="orno" >Orno</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>






<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	// itago('clipboard');

})




</script>



