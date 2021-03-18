<?php 
// pr($data);
// pr($_POST);
// pr($rows[2]);


?>
<div style="width:1600px;float:left;"  >
<form method="POST" >
<table class="gis-table-bordered table-fx"  >
<tr> 
	<th><input type="checkbox" id="chkAlla"  /></th>
	<th>#</th>
	<th>Multi</th>
	<th>Prid</th>
	<th class="" >Group
		<br />
		<select class="vc80" id="igrp"  >
			<option>Choose</option>
			<?php foreach($prodsubtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
		<input type="button" value="All" onclick="populateColumn('grp');" >						
	</th>	
	<th class="vc100" >Barode</th>
	<th class="vc100" >Comm</th>
	<th class="vc100" >Code</th>
	<th>Name</th>
	<th>Price</th>	
	<th>Combo</th>
	<th>Pri-Supp
		<select class="vc120" id="isupp" >
			<option value="0">Select All</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
		<input type="button" value="All" onclick="populateColumn('supp');" >						
	</th>
	<th>Cost</th>
	

	<th>ROlvl<br />
		<input class="pdl05 vc50" id="irolvl" /><br />	
		<input type="button" value="All" onclick="populateColumn('rolvl');" >						
	</th>
	<th>ROqty<br />
		<input class="pdl05 vc50" id="iroqty" /><br />	
		<input type="button" value="All" onclick="populateColumn('roqty');" >						
	</th>	

	<?php for($t=1;$t<=$nt;$t++): ?>
		<th class="tqty" ><?php echo "t{$t}"; ?><br />
			<input class="pdl05 vc40" id="it<?php echo $t; ?>" /><br />	
			<input type="button" value="All" onclick="populateColumn('t'+<?php echo $t; ?>);" >	
		</th>
	<?php endfor; ?>
	
	<th>Level<br />
		<input class="pdl05 vc50" id="ilevel" /><br />	
		<input type="button" value="All" onclick="populateColumn('level');" >						
	</th>		

	<th>Decimal<br />
		<input class="pdl05 vc50" type="number" min=0 max=1 id="ideci" value="0" /><br />	
		<input type="button" value="All" onclick="populateColumn('deci');" >						
	</th>			
	
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$prid=$rows[$i]['prid'];
?>
<tr class="<?php echo ($rows[$i]['level']<$rows[$i]['rolevel'])? 'bg-pink':NULL; ?>" >
	<td class="screen" ><input class="chka" type="checkbox" name="pos[<?php echo $i; ?>][is_selected]" value="1" 
		tabindex="2" /></td>
	<td><?php echo $i+1;  ?></td>
	<td><?php $multi = $rows[$i]['multi'];  ?>
		<a href="<?php echo URL.'products/view/'.$prid; ?>" ><?php echo ($multi)? 'Multi':'Add'; ?></a>
	</td>
	<td><?php echo $prid;  ?>
		<button id="csb<?php echo $i; ?>" onclick="xeditProduct(<?php echo $i.','.$prid; ?>);return false;" >
			Save</button>	
	</td>
	<td>
		<select id="grp<?php echo $i; ?>" name="posts[<?php echo $i; ?>][prodsubtype_id]" class="grp vc80" 
			tabindex="4" >
			<option value="0" >Choose</option>			
			<?php foreach($prodsubtypes AS $sel): ?>
				<option <?php echo ($sel['id']==$rows[$i]['prodsubtype_id'])? 'selected':NULL; ?>  
					value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td><input id="barcode<?php echo $i; ?>" name="posts[<?php echo $i; ?>][barcode]" class="vc100"
		value="<?php echo $rows[$i]['barcode'];?>" tabindex="6" /></td>
	<td><input id="comm<?php echo $i; ?>" name="posts[<?php echo $i; ?>][comm]" class="full"
		value="<?php echo $rows[$i]['comm'];?>" tabindex="8" /></td>		
	<td><input id="code<?php echo $i; ?>" name="posts[<?php echo $i; ?>][code]" class="full"
		value="<?php echo $rows[$i]['code'];?>" tabindex="10" /></td>				
	<td><input id="name<?php echo $i; ?>" name="posts[<?php echo $i; ?>][name]" class="vc200"
		value="<?php echo $rows[$i]['name'];?>" tabindex="12" /></td>
	<td><input id="price<?php echo $i; ?>" name="posts[<?php echo $i; ?>][price]" class="vc60 right"
		value="<?php echo $rows[$i]['price'];?>" tabindex="14" /></td>								
	<td><input id="combo<?php echo $i; ?>" name="posts[<?php echo $i; ?>][combo]" class="full"
		value="<?php echo $rows[$i]['combo'];?>" tabindex="16" /></td>

	<td>
		<?php $name = substr($rows[$i]['supplier'],0,16); ?>	
		<input class="vc120 pdl05" id="part<?php echo $i; ?>" value="<?php echo $name; ?>"  />		
		<input type="submit" name="auto" value="Find" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />	
		<input id="supp<?php echo $i; ?>" name="posts[<?php echo $i; ?>][suppid]" class="vc50 right supp"
			value="<?php echo $rows[$i]['psuppid'];?>" tabindex="20" />
	</td>								

	<input type="hidden" name="pos[<?php echo $i; ?>][cost]" value="<?php echo $rows[$i]['pcost'];?>" tabindex="22" />	
	<td><input id="cost<?php echo $i; ?>" name="posts[<?php echo $i; ?>][cost]" class="vc60 right"
		value="<?php echo $rows[$i]['pcost'];?>" tabindex="24" /></td>								
		
	<td><input id="rolvl<?php echo $i; ?>" name="posts[<?php echo $i; ?>][rolevel]" class="rolvl vc40"
		value="<?php echo $rows[$i]['rolevel'];?>" tabindex="26" /></td>

	<input type="hidden" name="pos[<?php echo $i; ?>][roqty]" value="<?php echo $rows[$i]['roqty'];?>" />			
	<td><input id="roqty<?php echo $i; ?>" name="posts[<?php echo $i; ?>][roqty]" class="roqty vc40"
		value="<?php echo $rows[$i]['roqty'];?>" tabindex="28" /></td>		

	<?php for($t=1;$t<=$nt;$t++): ?>	
	<?php $tabi=$t+30; ?>
	<td class="tqty" ><input id="t<?php echo $t.$i; ?>" name="posts[<?php echo $i; ?>][<?php echo 't'.$t; ?>]" 
		class="t<?php echo $t; ?> vc40" value="<?php echo $rows[$i]['t'.$t];?>" tabindex="<?php echo $tabi; ?>" /></td>	
	<?php endfor; ?>
		
	<td><input id="level<?php echo $i; ?>" name="posts[<?php echo $i; ?>][level]" class="level vc40" tabindex="42"
		value="<?php echo $rows[$i]['level'];?>" /></td>
		
	<td ><input class="center vc50 deci"  name="posts[<?php echo $i; ?>][is_decimal]" type="number" min=0 max=1
		value="<?php echo $rows[$i]['is_decimal']; ?>" /></td>

	<td><button id="csb<?php echo $i; ?>" onclick="xeditProduct(<?php echo $i.','.$prid; ?>);return false;" >
			Save</button> 
		<button><a class="txt-black" href="<?php echo URL.'products/view/'.$prid; ?>" >Edit</a></button>
	</td>		
	<input type="hidden" name="pos[<?php echo $i; ?>][product_id]" value="<?php echo $prid; ?>"  />		
	<input type="hidden" name="posts[<?php echo $i; ?>][product_id]" value="<?php echo $prid; ?>"  />		
	<input type="hidden" name="posts[<?php echo $i; ?>][prid]" value="<?php echo $prid; ?>"  />		
</tr>
<?php endfor; ?>
</table>


<br />
<p>

<input type="submit" name="update" value="Update All" onclick="return confirm('Sure?');"  />

	<button><a onclick="return confirm('Sure?');" class="no-underline txt-black"
		href="<?php echo URL.'invis/totalInventoryLevel?tmax=6'; ?>" >Sync / Total Inventory Level</a></button>

</p>



<div class="ht100" >&nbsp;</div>

</form>

</div> 	<!-- left -->



<div class="clipboard" style="width:20%;float:left;"  >
<p>
<select id="classbox" >
	<option value="grp" >Group</option>
	<option value="barcode" >Barode | SKU</option>
	<option value="comm" >Commodity Code</option>
	<option value="code" >Code</option>
	<option value="name" >Name</option>
	<option value="name" >Price</option>
	<option value="rolvl" >RO Level</option>
	<option value="roqty" >RO Qty</option>
	<option value="t1" >T1</option>
	<option value="t2" >T2</option>
	<option value="t3" >T3</option>
	<option value="t4" >T4</option>
	<option value="t5" >T5</option>
	<option value="t6" >T6</option>
	<option value="level" >Level</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>




<!------------------------------------------------------->
<script>

var gurl     = "http://<?php echo GURL; ?>";
var nt = "<?php echo $nt; ?>";



$(function(){
	itago('clipboard');
	itago('tqty');


})	/* fxn */

function toggleTqty(){
	$('.tqty').toggle();
}

function xeditProduct(i,prid){

	$('#csb'+i).hide();	

	var barcode = $('input[name="posts['+i+'][barcode]"]').val();
	var comm = $('input[name="posts['+i+'][comm]"]').val();
	var code = $('input[name="posts['+i+'][code]"]').val();
	var name = $('input[name="posts['+i+'][name]"]').val();
	var combo = $('input[name="posts['+i+'][combo]"]').val();	
	var level = $('input[name="posts['+i+'][level]"]').val();
	var rolevel = $('input[name="posts['+i+'][rolevel]"]').val();
	var roqty = $('input[name="posts['+i+'][roqty]"]').val();
	var suppid = $('input[name="posts['+i+'][suppid]"]').val();
	var price = $('input[name="posts['+i+'][price]"]').val();
	var cost = $('input[name="posts['+i+'][cost]"]').val();
	var grp = $('select[name="posts['+i+'][prodsubtype_id]"]').val();
	var t1 = $('input[name="posts['+i+'][t1]"]').val();
	var t2 = $('input[name="posts['+i+'][t2]"]').val();
	var t3 = $('input[name="posts['+i+'][t3]"]').val();
	var t4 = $('input[name="posts['+i+'][t4]"]').val();
	var t5 = $('input[name="posts['+i+'][t5]"]').val();
	var t6 = $('input[name="posts['+i+'][t6]"]').val();

	var vurl 	= gurl+'/ajax/xproducts.php';	
	var task	= "xeditProduct";

	var pdata = "task="+task+"&id="+prid+"&barcode="+barcode+"&comm="+comm+"&code="+code+"&name="+name+"&combo="+combo;
	pdata += "&t1="+t1+"&t2="+t2+"&t3="+t3+"&t4="+t4+"&t5="+t5+"&t6="+t6+"&level="+level;
	pdata += "&suppid="+suppid+"&price="+price+"&cost="+cost+"&rolevel="+rolevel+"&roqty="+roqty+"&prodsubtype_id="+grp;
			
	$.ajax({
		type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
}	/* fxn */


function redirContact(pcid,rid){	

	$('input[name="posts['+rid+'][suppid]"]').val(pcid);		
}	/* fxn */



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>


