function calcdiff(x,y,z){
	var a = parseFloat($('#'+x).val().replace(/,/g, ''));
	var b = parseFloat($('#'+y).val().replace(/,/g, ''));
	var c = parseFloat(a)-parseFloat(b);	
	$('#'+z).val(c.toFixed(2));	
}	/* fxn */


function calcsum(x,y,z){
	var a = parseFloat($('#'+x).val().replace(/,/g, ''));
	var b = parseFloat($('#'+y).val().replace(/,/g, ''));
	var c = parseFloat(a)+parseFloat(b);	
	$('#'+z).val(c.toFixed(2));	
}	/* fxn */

function calcproduct(x,y,z){
	var a = parseFloat($('#'+x).val().replace(/,/g, ''));
	var b = parseFloat($('#'+y).val().replace(/,/g, ''));
	var c = parseFloat(a)*parseFloat(b);	
	$('#'+z).val(c.toFixed(2));	
}	/* fxn */

function calcquotient(x,y,z){
	var a = parseFloat($('#'+x).val().replace(/,/g, ''));
	var b = parseFloat($('#'+y).val().replace(/,/g, ''));
	var c = parseFloat(a)/parseFloat(b);	
	$('#'+z).val(c.toFixed(2));	
}	/* fxn */

