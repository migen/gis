var gurl = gurl();
var controller = 'tuition';

function surchargeBalance(i,scold,balold){
	var scnew = $('#surcharge'+i).val();
	var scdiff = parseFloat(scnew)-parseFloat(scold);
	var balnew = balold-scdiff;	
	$('#balance'+i).val(balnew);
}	/* fxn */




function discAmount(i,disctype_id){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task = "discAmount";
	$.post(vurl,{task:task,disctype_id:disctype_id},function(s){
		$('#discount'+i).val(s.amount);
	},'json');	
}	/* fxn */


