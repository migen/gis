<h5>
	Batch Shrinkages 
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'shrinkages/filter'; ?>">Filter</a>
	| <a href="<?php echo URL.'shrinkages/add'; ?>">Add</a>

	<?php // pr($supplier); ?>

	<?php // echo "REFNO: ".$refno; ?>
	
</h5>


<?php // if(empty($suppid)){ include_once('incs/supplier_filter.php'); } ?>


<div style="width:36%;float:left" >
<table class="gis-table-bordered table-fx" >
<tr><th>Barcode</th><td><input id="barcode" onchange="addItem();return false;" /></td></tr>
<tr><th>Find</th><td>
	<input class="pdl05" id="part"  />		
	<input type="submit" name="auto" value="Filter" onclick="xfindProductsByPart();return false;" />
</td></tr>

</table>

<br />
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Product</th>
<th class="" >Tml<br />
	<input class="pdl05 vc50" type="number" id="itml" value="1" /><br />	
	<input type="button" value="All" onclick="populateColumn('tml');" >					
</th>	

<th>Qty</th>
<th colspan="" class="center" > 
	<select id="itype" class='vc80'>	
		<option>Type</option>
		<?php foreach($sktypes as $sel): ?>
			<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name'].' #'.$sel['id']; ?> </option>
		<?php endforeach; ?>
	</select>				
	<br /> <input type="button" value="All" onclick="populateColumn('type');" >	
</th>		
<th class="" >Remarks<br />
	<input class="pdl05" id="irmks" /><br />	
	<input type="button" value="All" onclick="populateColumn('rmks');" >					
</th>	
<th></th></tr>
<tbody id="posrows" ></tbody>
</table>
<br />
</div>


<div class="b clear" >Reference: <input name="reference" value="<?php echo $refno; ?>" /></div>

<div class="clear"><br /><input type="submit" name="submit" value="Submit"  /></div>
</form>

<div class="hd" id="names" >names</div>










<script>

var gurl="http://<?php echo GURL; ?>";
var limits = "<?php echo '10'; ?>";
var nr=0;
var terminal=1;


$(function(){
	hd();	
	$('#barcode').focus();
	$('html').live('click',function(){ $('#names').hide(); });
		
	
})	/* fxn */




function deltrow(i){
	$('#trow-'+i).remove();
	
}


function addItem(){
	var barcode = $('#barcode').val();		
	var qty = 1;		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByBarcode";
			
	$.post(vurl,{task:task,barcode:barcode},function(s){		
		prid=s.id;cost=s.cost;price=s.price;amount=qty*price;product=s.name;
		
		$('#posrows').append('<tr id="trow-'+nr+'"><td><input class="vc50" readonly name="positems['+nr+'][product_id]" value="'+prid+'"  /></td><td><input class="vc200" readonly value="'+product+'"  /></td><td><input class="vc50 tml" name="positems['+nr+'][terminal]" value="'+terminal+'" type="number" /></td><td><input id="'+nr+'" class="vc50" name="positems['+nr+'][qty]" value="'+qty+'" type="number" /></td><td><select name="positems['+nr+'][sktype_id]" class="type" ><?php foreach($sktypes AS $sel): ?><option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option><?php endforeach; ?></select></td><td><input class="rmks" name="positems['+nr+'][remarks]" /></td><td onclick="deltrow('+nr+');"  class="u" >Del</td><input type="hidden" name="positems['+nr+'][cost]" value="'+cost+'"  /><input type="hidden" name="positems['+nr+'][price]" value="'+price+'"  /></tr>');	
		nr++;					
	},'json');	
	$('#barcode').val('');
	$('#barcode').focus();
	
}	/* fxn */



function xfindProductsByPart2(){
	var part = $('#part').val();		
	var vurl = gurl+'/ajax/xpos.php';	
	var task = "xgetProductsByPart";
	var pdata='task='+task+'&part='+part+'&limits='+limits;
	alert(pdata);

}

function xfindProductsByPart(){
	var part = $('#part').val();		
	var vurl = gurl+'/ajax/xpos.php';	
	var task = "xgetProductsByPart";
	var pdata='task='+task+'&part='+part+'&limits='+limits;
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&part='+part+'&limits='+limits,			
		success: function(s) { 
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			// console.log(s);
for (var i = 0; i < cs; i++) {			
  content+='<p><span class="txt-blue b u" onclick="addProduct('+s[i].id+');return false;" >'+s[i].code+'-'+s[i].name+'-'+s[i].barcode+'</span>-'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}


function addProduct(prid){
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByID";
	var qty = 1;		
	
	$.post(vurl,{task:task,prodid:prid},function(s){	
		prid=s.id;cost=s.cost;price=s.price;amount=qty*price;product=s.name;
		
		$('#posrows').append('<tr id="trow-'+nr+'"><td><input class="vc50" readonly name="positems['+nr+'][product_id]" value="'+prid+'"  /></td><td><input class="vc200" readonly value="'+product+'"  /></td><td><input class="vc50 tml" name="positems['+nr+'][terminal]" value="'+terminal+'" type="number" /></td><td><input id="'+nr+'" class="vc50" name="positems['+nr+'][qty]" value="'+qty+'" type="number" /></td><td><select name="positems['+nr+'][sktype_id]" class="type" ><?php foreach($sktypes AS $sel): ?><option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option><?php endforeach; ?></select></td><td><input class="rmks" name="positems['+nr+'][remarks]" /></td><td onclick="deltrow('+nr+');"  class="u" >Del</td><input type="hidden" name="positems['+nr+'][cost]" value="'+cost+'"  /><input type="hidden" name="positems['+nr+'][price]" value="'+price+'"  /></tr>');
		
		nr++;			
	},'json');	
	$('#barcode').val('');
	$('#part').val('');
	$('#barcode').focus();
	
	
}	/* fxn */



</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>

