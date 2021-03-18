<?php 

	
?>

<h5>

	Edit Products (<?= $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>


</h5>



<div style="float:left;width:70%" >
<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc30" >ID</th>
	
	<th class="vc50" >Subtype</th>
	<th class="vc150" >Barcode</th>
	<th class="" >Product</th>
	<th class="vc50" >Price</th>
	<th class="vc50" >Combo</th>

	<th class="vc30" >RO<br />Lvl<br />
		<input class="pdl05 full" id="irolvl"  /><br />	
		<input class="full" type="button" value="All" onclick="populateColumn('rolvl');" >						
	</th>
	
	<th class="vc30" >RO<br />Qty<br />
		<input class="pdl05 full" id="iroqty"  /><br />	
		<input class="full" type="button" value="All" onclick="populateColumn('roqty');" >					
	</th>
	
	<?php for($i=0;$i<$numterminals;$i++): ?>
		<th class="vc30" >
			T<?php echo $i+1; ?><br />
			<?php echo $terminals[$i]['name']; ?><br />
		<input class="pdl05 full" id="it<?php echo $i+1; ?>"  /><br />	
		<input class="full" type="button" value="All" onclick="populateColumn('t<?php echo $i+1; ?>');" >								
			
		</th>		
	<?php endfor; ?>
	
<th class="vc30" >Lvl<br />
	<input class="pdl05 full" id="ilvl" placeholder="Lvl"  /><br />	
	<input class="full" type="button" value="All" onclick="populateColumn('lvl');" >			
</th>

<th class="vc30" >
	<input class="pdl05 full" id="iuom" placeholder="UOM"  /><br />	
	<input class="full" type="button" value="All" onclick="populateColumn('uom');" >			
</th>		

</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
			
	<td>
		<select name="posts[<?php echo $i; ?>][prodsubtype_id]" id="type<?php echo $i; ?>" >
			<option value="0" >Subtype</option>
			<?php foreach($prodsubtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$rows[$i]['prodsubtype_id'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	

	<?php $tab = 1000+$i; ?>			
	<td><input class="pdl05 full" name="posts[<?php echo $i; ?>][barcode]" id="barcode<?php echo $i; ?>" 
		value="<?php echo $rows[$i]['barcode']; ?>"  tabindex="<?php echo $tab; ?>" /></td>
	
		
	<?php $tab = 3000+$i; ?>			
	<td><input class="pdl05 full" name="posts[<?php echo $i; ?>][name]" id="product<?php echo $i; ?>" value="<?php echo $rows[$i]['name']; ?>" tabindex="<?php echo $tab; ?>" /></td>
		
	<?php $tab = 4000+$i; ?>			
	<td><input class="pdl05 full" name="posts[<?php echo $i; ?>][price]" id="price<?php echo $i; ?>" value="<?php echo $rows[$i]['price']; ?>" 	tabindex="<?php echo $tab; ?>" /></td>
	
	<?php $tab = 4500+$i; ?>			
	<td><input class="pdl05 full" name="posts[<?php echo $i; ?>][combo]" id="combo<?php echo $i; ?>" value="<?php echo $rows[$i]['combo']; ?>" 	tabindex="<?php echo $tab; ?>" /></td>	
		
	<?php $tab = 5000+$i; ?>			
	<td><input class="pdl05 full rolvl" name="posts[<?php echo $i; ?>][rolevel]" id="rolevel<?php echo $i; ?>" value="<?php echo $rows[$i]['rolevel']; ?>" tabindex="<?php echo $tab; ?>" /></td>
		
	<?php $tab = 6000+$i; ?>			
	<td><input class="pdl05 full roqty" name="posts[<?php echo $i; ?>][roqty]" id="roqty<?php echo $i; ?>" value="<?php echo $rows[$i]['roqty']; ?>" tabindex="<?php echo $tab; ?>" /></td>

	<?php for($t=1;$t<=$numterminals;$t++): ?>
	<td><input class="ti<?php echo $i; ?> pdl05 full t<?php echo $t; ?> " 
		name="posts[<?php echo $i; ?>][t<?php echo $t; ?>]" id="t<?php echo $t.$i; ?>" 
		value="<?php echo $rows[$i]['t'.$t]; ?>"  /></td>
	<?php endfor; ?>
	
	<?php $tab = 7000+$i; ?>			
	<td><input class="pdl05 full lvl" name="posts[<?php echo $i; ?>][level]" id="level<?php echo $i; ?>" 
		value="<?php echo $rows[$i]['level']; ?>" tabindex="<?php echo $tab; ?>" /></td>
		
		
		
	<?php $tab = 8000+$i; ?>			
	<td><input class="pdl05 full uom" name="posts[<?php echo $i; ?>][uom]" id="uom<?php echo $i; ?>" value="<?php echo $rows[$i]['uom']; ?>" tabindex="<?php echo $tab; ?>" /></td>

	<td><button onclick="tallyLevel(<?php echo $i; ?>);return false;" >Tally</button></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" />	
</tr>
<?php endfor; ?>
</table>


<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
	<button><a href="<?php echo URL.$_SESSION['url']; ?>" class="no-underline" >Cancel</a></button>	

</p>
</form>
</div>	<!-- products -->

<div style="width:50px;float:left;height:100px;" ></div>

<div class=" hd clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="barcode" >Barcode</option>
	<option value="type" >Type</option>
	<option value="code" >Code</option>
	<option value="product" >Product</option>
	<option value="price" >Price</option>
	<option value="rolevel" >RO Level</option>
	<option value="roqty" >RO Qty</option>
	<option value="level" >Level</option>
	<option value="uom" >Uom</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="hd" id="names" > </div>
<p class="clear ht100" ></p>




<script>

var gurl = 'http://<?php echo GURL; ?>';

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	itago('clipbpoard');
	
	
	
	
})
	
	
	
function tallyLevel(i){
	var total=0;
	$('.ti'+i).each(function(){
		total+=parseInt($(this).val());
	})
	$('#level'+i).val(total);

}	/* fxn */

	
	
	
		
		
</script>

