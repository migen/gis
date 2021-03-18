// var gurl = gurl();
var vurl = gurl();
var controller = 'pos';


$(function(){

});


function copier(val,id){
	$('input[name="'+id+'"]').val(val);
}	/* fxn */


function sgroup(val,rid){		/* subgroup */
	var stypeid = val;	
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "sgroup";	
	$.post(vurl,{task:task,stypeid:stypeid},function(s){
		var options = '<option>Choose one</option>';
		var cs = s.length;		
	    for (var a = 0; a < cs; a++) {
			options += '<option value="' + s[a].id + '">' + s[a].name + '</option>';
		}
var tdoptions="<select class='full' id='"+rid+"' name='positems["+rid+"][product_id]' onchange='afp(this.value,this.id);return false;'>"+options+"</select>";
		$('#tdproduct'+rid).html(tdoptions);	
		
	},'json');
	
}

function afp(x,i){		/* autofill price */
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "autofillprice";	
	
	$.post(vurl,{task:task,prodid:x},function(s){
		var presyo = s.price;
		var cost = s.cost;
		var combo = s.combo;
		alert(combo);
		$('#barcode'+i).val(s.barcode);				
		$('input[name="positems['+i+'][combo]"]').val(combo);		
		$('input[name="positems['+i+'][cost]"]').val(cost);		
		$('input[name="positems['+i+'][price]"]').val(presyo);		
		$('input[name="positems['+i+'][amount]"]').val(presyo);		
		$('input[name="positems['+i+'][qty]"]').val(1);				
		$('input[name="positems['+i+'][io]"]').val(1);		
		billTotal(i);		
	},'json');
}

function billTotal(i){		/* bill total */
	var ip = $('input[name="positems['+i+'][price]"]').val();
	var iq = $('input[name="positems['+i+'][qty]"]').val();	
	if(iq>999){ alert('Qty too big!'); }
		
	if(iq !== ''){
		var x = ip * iq;
		$('input[name="positems['+i+'][amount]"]').val(x.toFixed(2));		
	} 
	
	var total = 0;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});
	var cbi = $('input.subtotal').size();
	$('#cbi').val(cbi);
	$('#total').val(total.toFixed(2));	
	$('#tender').val(total.toFixed(2));	
	
}

function amt(i){	/* amount or item subtotal */
	billTotal(i);
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

/* filter product by part onclick product from results */
function doProduct(prodid,rid){		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByID";		
	
	$.post(vurl,{task:task,prodid:prodid},function(s){		
		$('#type'+rid).val(s.prodtype_id);
		$('#barcode'+rid).val(s.barcode);
		$('#prod'+rid).val(s.name);		
		$('input[name="positems['+rid+'][combo]"]').val(s.combo);			
		$('input[name="positems['+rid+'][product_id]"]').val(s.id);		
		$('input[name="positems['+rid+'][cost]"]').val(s.cost);		
		$('input[name="positems['+rid+'][price]"]').val(s.price);		
		$('input[name="positems['+rid+'][amount]"]').val(s.price);		
		$('input[name="positems['+rid+'][qty]"]').val(1);		
		$('input[name="positems['+rid+'][io]"]').val(1);				
		billTotal(rid);				
	},'json');		
	newrow();		
		
}	/* fxn */	

	

function xgetProductByBarcode(rid){
	var barcode = $('#barcode'+rid).val();		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByBarcode";
		
	$.post(vurl,{task:task,barcode:barcode},function(s){		
		$('#pcat'+rid).val(s.prodcategory_id);
		$('#prod'+rid).val(s.name);
		$('input[name="positems['+rid+'][combo]"]').val(s.combo);					
		$('input[name="positems['+rid+'][product_id]"]').val(s.id);		
		$('input[name="positems['+rid+'][cost]"]').val(s.cost);		
		$('input[name="positems['+rid+'][price]"]').val(s.price);		
		$('input[name="positems['+rid+'][amount]"]').val(s.price);		
		$('input[name="positems['+rid+'][qty]"]').val(1);		
		$('input[name="positems['+rid+'][io]"]').val(1);				
		billTotal(rid);		
	},'json');	
	newrow();		
	
	
}	/* fxn */

function xposProductsByPart(rid,limits=20){
	var part = $('#product'+rid).val();	
	
	var vurl = gurl+'/ajax/xpos.php';	
	var task = "xgetProductsByPart";
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
  content+='<p><span class="txt-blue b u" onclick="doProduct('+s[i].id+','+rid+');return false;" >'+s[i].code+'-'+s[i].name+'-'+s[i].barcode+'</span>-'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}

function xgetContactsByPart(){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactsByPart";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part,				
		async: true,
		success: function(s) { 
			// console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			console.log(s);
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].code+'</span> - '+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}

function xgetContactsByCode(){
	var part = $('#codes').val();	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactsByCode";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&part='+part,				
		async: true,
		success: function(s) { 
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			for (var i = 0; i < cs; i++) {			
				content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].code+'</span> - '+s[i].name+' - R'+s[i].role_id+'-P'+s[i].parent_id+'-U'+s[i].id+'</p>';
			}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}

function xgetContactByCode(){
	var scode 		= $('#scode').val();	
	var sy			= $('#sy').val();
	var fullname	= $('#fullname').val();
	var crid		= $('#crid').val();
	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
			
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+scode,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/students/sectioner/'+s.id+'/'+sy;
				window.location = rurl;
			} else {
				$('#checkBtn').show();				
				$('#sy').val(sy);
				$('#tbl-1').hide();
				alert('No record found.');
			}
			
		}		  
    });				
	
}	

function closeFilter(){
	$('#names').hide();
}

function newrow(){

var nr = $('tbody.children>tr').size();	
var rowcount = nr+1; 

$('tbody.children').append('<tr id="trow'+nr+'" ><td><u class="blue" rel="'+nr+'" onclick="deltrow('+nr+');" ></u></td><td>'+rowcount+'</td><td class="vc100" ><input type="text" class="full pdl05 bc" id="barcode'+nr+'" onchange="xgetProductByBarcode('+nr+')" /></td><td id="tdproduct'+nr+'"><input id="prod'+nr+'" class="full" readonly /></td><td class="vc50"><input id="'+nr+'" class="full right pdr05" name="positems['+nr+'][price]" readonly /></td><td class="vc50"><input id="'+nr+'" type="number" class="full right pdr05" name="positems['+nr+'][qty]" value="0" onchange="amt(this.id);return false;"></td><td class="vc50"><input class="subtotal right pdr05 full" name="positems['+nr+'][amount]" value="0.00" readonly /></td><td class="vc50" ><input class="full pdl05" id="product'+nr+'"  /><input type="submit" name="auto" value="Filter" onclick="xposProductsByPart('+nr+');return false;" /></td><td class="vc50"><input id="'+nr+'" class="full right pdr05" name="positems['+nr+'][combo]" readonly /><input id="prod'+nr+'" class="full" name="positems['+nr+'][product_id]" readonly /></td><td class="vc20" ><input class="full pdl05" name="positems['+nr+'][io]" value="0" readonly /><a class="txt-blue u" onclick="cancelPosrow('+nr+');" >Clr</a></td><td class="vc50"><input id="'+nr+'" class="full right pdr05" name="positems['+nr+'][cost]" readonly /></td></tr>');					

$('#barcode'+nr).focus();
numrows = nr+1;

};


function getChange(){
	var tender = $('#tender').val();
	var total = $('#total').val();
	var change = parseFloat(tender) - parseFloat(total);
	$('#change').val(change.toFixed(2));	
	
}	/* fxn */

function clearChange(){
	$('#change').val(0);		
}	/* fxn */

function tallyTotal(){
	var total = 0.00;	
	var discount = $('#discount').val();	
	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});
	total-=discount;
	$('#total').val(total.toFixed(2));	
	
}	/* fxn */

function changePaytype(paytype){
	var bank = $('#bank').val();
	if(bank>0){
		$('#paytype').val(paytype);		
	} else {
		$('#paytype').val(1);			
	}
}	/* fxn */


function cancelPosrow(i){
	$('input[name="positems['+i+'][io]"]').val(0);	
	$('input[name="positems['+i+'][product_id]"]').val(null);	
	$('input[name="positems['+i+'][amount]"]').val(0);	
	$('input[name="positems['+i+'][price]"]').val(null);	
	$('input[name="positems['+i+'][cost]"]').val(null);	
	$('input[name="positems['+i+'][qty]"]').val(0);	
	$('#product'+i).val(null);
	$('#barcode'+i).val(null);
	$('#prod'+i).val(null);
	refresh();
	$('#trow'+i).hide();

}