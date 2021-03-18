
// min, max, js array, 
function cheapest(){	// mura
	var items = [800, 100, 500];	
	// $.each(items,function(index,value){ alert("index: "+index+", value: "+value); })	
	var x = Math.min.apply(Math,items);	
	alert("min value: "+parseInt(x));	
	
}

function df(){	// pos discount
	var rate=20;
	var items = $('tbody tr td .price');
	var prices = [];
	$.each(items,function(i){
		var product_id = $('input[name="items['+i+'][product_id]"]').val();		
		var price = $('input[name="items['+i+'][price]"]').val();		
		var name = $('input[name="items['+i+'][name]"]').val();		
		prices[i]=parseInt(price);

	})
		
	var hitprice = Math.min.apply(Math,prices);		
	var iof = prices.indexOf(Math.min.apply(Math,prices));	
	var i = numrows;
	var content="<tr><td><input class='vc50' value=1 name='items["+i+"][qty]' ></td>";
	var discname = $('input[name="items['+iof+'][name]"]').val();		
	var discprid = $('input[name="items['+iof+'][product_id]"]').val();		
	var discamt = rate/100*hitprice*-1;
	// alert("discname: "+discname+", discamt: "+discamt+", hitprice: "+hitprice+", iof: "+iof);	
	content+="<td>Discount "+discname+" <input name='items["+i+"][product_id]' value="+discprid+" > "+"</td>";
	content+="<td><input class='vc100' name='items["+i+"][amount]' value="+discamt+" ></td></tr>";
	$('.tbody').append(content);
	
}	/* fxn */


// input selector
function payfee(){
	$('.btnfeetypeid').change(function(){
		var j  = ($(this).val());
		var a = $('#pfee'+j).val();
		var b = $('#pdue'+j).val();
		var c = $('#pointer'+j).val();
		$('select[name="feetype_id"]').val(a);
		$('input[name="amount"]').val(parseFloat(b).toFixed(2));
		$('input[name="pointer"]').val(c);
		$('#calctotal').val(parseFloat(b).toFixed(2));
		
	})

}	/* fxn */
