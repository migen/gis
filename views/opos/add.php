<?php 
$url=SITE.'views/customs/'.VCFOLDER.'/customs.php';
include_once($url);
$preapp=($pos_order=='append')? 1:0;

	
?>
<script type='text/javascript' src="<?php echo URL; ?>views/js/pos.js"></script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


<?php 
	$numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; 
	
	
?>


<script>
var gurl 	= 'http://<?php echo GURL; ?>';
var numrows = "<?php echo $numrows; ?>";	
var limits = "<?php echo $limits; ?>";
var preapp = "<?php echo $preapp; ?>";
var prow='';
var nr=0;


$(function(){
	hd();	
	nextViaEnter();		
	tabEnter('bc');			
	itago('more');
	itago('creditsales');
	// itago('numrows');
	$('html').live('click',function(){ $('#names').hide(); });

	$('#posbarcode').focus();
	
	$( "#posform" ).submit(function( event ) {
		tallyTotal();
	});	
	
	
})	/* fxn */




function redirContact(ucid){	
	var vurl = gurl+'/ajax/xgetContacts.php';		
	var task = "xgetContactByID";	
		
	$.post(vurl,{task:task,pcid:ucid},function(s){		
		$('#part').val(s.name);		
		$('#custpcid').val(s.parent_id);		
		tabEnter('bc');			
		
	},'json');	
	
}	/* fxn */



function addPosItem(){
	var barcode = $('#posbarcode').val();		
	// var qty = $('#posqty').val();		
	var qty = 1;		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByBarcode";
		
	$.post(vurl,{task:task,barcode:barcode},function(s){		
		prid=s.id;cost=s.cost;price=s.price;amount=qty*price;product=s.name;
		combo=s.combo;level=s.level;pocost=s.pocost;

		prow='<tr id="trow-'+nr+'"><td><input class="vc50" readonly name="positems['+nr+'][product_id]" value="'+prid+'"  /></td><td><input class="vc200" readonly value="'+product+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][cost]" value="'+cost+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][price]" value="'+price+'"  /></td><td><input id="'+nr+'" class="vc50" onchange="amt(this.id);return false;" name="positems['+nr+'][qty]" value="'+qty+'" type="number" /></td><td><input class="vc50 subtotal" readonly name="positems['+nr+'][amount]" value="'+amount+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][combo]" value="'+combo+'"  /></td><td onclick="deltrow('+nr+');"  class="u" >Del</td><input type="hidden" name="positems['+nr+'][pocost]" value="'+pocost+'"  /><input type="hidden" name="positems['+nr+'][level]" value="'+level+'"  /></tr>';
		if(preapp==1){	$('#posrows').append(prow);	
		} else { $('#posrows').prepend(prow); }
		
		
		nr++;			
		refresh();		
	},'json');	
	$('#posbarcode').val('');
	$('#posbarcode').focus();
	
}	/* fxn */



function xfindProductsByPart(){
	var part = $('#pospart').val();		
	var limits = 20;		
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
		combo=s.combo;level=s.level;pocost=s.pocost;
		prow='<tr id="trow-'+nr+'"><td><input class="vc50" readonly name="positems['+nr+'][product_id]" value="'+prid+'"  /></td><td><input class="vc200" readonly value="'+product+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][cost]" value="'+cost+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][price]" value="'+price+'"  /></td><td><input class="vc50" id="'+nr+'" onchange="amt(this.id);return false;" name="positems['+nr+'][qty]" value="'+qty+'" type="number"  /></td><td><input class="vc50 subtotal" readonly name="positems['+nr+'][amount]" value="'+amount+'"  /></td><td><input class="vc50" readonly name="positems['+nr+'][combo]" value="'+combo+'"  /></td><td onclick="deltrow('+nr+');"  class="u" >Del</td><input type="hidden" name="positems['+nr+'][pocost]" value="'+pocost+'"  /><input type="hidden" name="positems['+nr+'][level]" value="'+level+'"  /></tr>';
		// $('#posrows').append();
		if(preapp==1){	$('#posrows').append(prow);	
		} else { $('#posrows').prepend(prow); }
		
		nr++;			
		refresh();		
	},'json');	
	$('#posbarcode').val('');
	$('#pospart').val('');
	$('#posbarcode').focus();
	// refresh();
	
	
}	/* fxn */



function deltrow(i){
	$('#trow-'+i).remove();
	refresh();
	
}



function refresh(){		/* bill total */
	var total = 0.00;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});
	var cbi = $('input.subtotal').size();
	$('#total').val(total.toFixed(2));	
	$('#tender').val(total.toFixed(2));	
}


</script>

<h5>
	OPOS | Register Sale
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."invoices/orno"; ?>' >OR NO</a>	
	| <a href='<?php echo URL."npos"; ?>' >NPOS</a>	
	| <a href='<?php echo URL."cpos/add"; ?>' >Credits1</a>	
	| <span class="u" onclick="ilabas('more');" >More</span>
	
	| <span class="u" onclick="additem();" >Additem</span>
	
</h5>

<?php include_once('incs/find_orno.php'); ?>

<div style="width:70%;float:left;" >		<!-- pos screen -->

<form id="posform" method="POST" >

<?php 
	$incs="incs/pos_head.php";include_once($incs);

?>

<div style="width:30px;height:60px;float:left;" >&nbsp;</div>
<div class="clear" >&nbsp;</div>

<!-- positems below -->

<div style="width:36%;float:left" >
<table class="gis-table-bordered table-fx" >
<tr><th>Barcode</th><td><input id="posbarcode" onchange="addPosItem();return false;" /></td></tr>
<tr><th>Find</th><td>
	<input class="pdl05" id="pospart"  />		
	<input type="submit" name="auto" value="Filter" onclick="xfindProductsByPart();return false;" />
</td></tr>

</table>
</div>

<div style="width:52%;float:left" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Product</th><th>Cost</th><th>Price</th><th>Qty</th><th>Amount</th><th>Combo</th><th></th></tr>
<tbody id="posrows" ></tbody>
</table>
</div>

<div class="clear"><br /><input type="submit" name="submit" value="Submit"  /></div>

</form>




</div> <!-- pos screen -->



<div class="hd" id="names" >names</div>



