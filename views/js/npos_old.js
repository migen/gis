

$(document).on('click','.delLink',function(){		
	delLink = $(this);
	var id = delLink.attr('rel');	// alert(id);
	var cnfm = confirm ("WARNING! Confirm delete " + id + "?") ;		
	if(cnfm){
		delLink.parent().parent().remove();
		var url = gurl + '/' + controller +'/delLink/alter/'+ bid+'/'+id;
		// alert(url);
		$.post(url,function(x){
			return false;
		},'json');
		return false;					
	}
});


function sgroup(val,rid){		/* subgroup or item category */
	var url = gurl+'/bills/sgroup/'+val; 

	$.post(url,function(s){
		var options = '<option>Choose one</option>';
		var cs = s.length;		
		// console.log(s);
	    for (var a = 0; a < cs; a++) {
			options += '<option value="' + s[a].id + '">' + s[a].name + '</option>';
		}
		var tdoptions = "<select class='full' id='"+rid+"' name='data[Item]["+rid+"][product_id]' onchange='afp(this.value,this.id);return false;'>"+options+"</select>";
		$('#tdstock'+rid).html(tdoptions);		
	},'json');
	
}


function autocustomer(){
	var x = new Array();			
	$.ajax({
	  type: "POST",
	  url: gurl+controller+'/customers',
	  dataType: "json",
	  success: function (y) {
		c = y.length;
		for(var i in y){
			x.push(y[i].name);	 
		}
	  },
	  async: false
	});
	// console.log(x);
	$('input[name="data[Bill][customer_id]"]').autocomplete({
		source : x,
	});

}



function afp(x,i){		/* autofill price */
	var url = gurl+'/'+controller+'/stock/'+x;
	$.post(url,function(s){		
		// console.log(s);
		$('input[name="data[Item]['+i+'][price]"]').val(s.price);		
		$('input[name="data[Item]['+i+'][quantity]"]').val(1);		
		$('input[name="data[Item]['+i+'][amount]"]').val(s.price);		
		billTotal(i);
	},'json');
}


function billTotal0(i){		/* bill total */
	var ip = $('input[name="data[Item]['+i+'][price]"]').val();
	var iq = $('input[name="data[Item]['+i+'][quantity]"]').val();	
	// alert('price: '+ip+',qty: '+iq);
	
	if(iq !== ''){
		var x = ip * iq;		
		$('input[name="data[Item]['+i+'][amount]"]').val(x.toFixed(2));		
	} 
	var total = 0.00;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});
	var cbi = $('input.subtotal').size();
	$('#cbi').val(cbi);
	$('#total').val(total);	
	$("#balance").select();
	
}

function billTotal(i){		/* bill total */
	var ip = $('input[name="data[Item]['+i+'][price]"]').val();
	var iq = $('input[name="data[Item]['+i+'][quantity]"]').val();	
	var balance = $("#balance").val();
	
	if(iq !== ''){
		var x = ip * iq;		
		$('input[name="data[Item]['+i+'][amount]"]').val(x.toFixed(2));		
	} 
	var total = 0.00;	
	$.each($('.subtotal'),function(){
		total += parseFloat($(this).val());
	});
	var cbi = $('input.subtotal').size();
	$('#cbi').val(cbi);
	$('#total').val(total);	
	$("#balance").select();
	var outstanding = parseFloat(balance) - parseFloat(total);
	$("#outstanding").val(outstanding.toFixed(2));
	
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
	$('#total').val(total);	
}
