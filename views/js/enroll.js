
function removeCommas(str) {
    while (str.search(",") >= 0) {
        str = (str + "").replace(',', '');
    }
    return str;
};


function addAux(i){
	$('#addAuxBtn').hide();
	var scid = $('#scid'+i).val();
	var auxamt = $('#auxamt'+i).val();
	auxamt = removeCommas(auxamt)
	var due = $('#auxdue'+i).val();
	var auxtype = $('#auxtype'+i).val();
	var num = $('#num'+i).val();
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "addAux";
	
	if(auxtype>0){
		$.ajax({
			url: vurl,dataType: "json",type: 'POST',async: true,
			data: 'task='+task+'&scid='+scid+'&auxtype='+auxtype+'&sy='+sy+'&auxamt='+auxamt+'&due='+due+'&num='+num,
			success: function() { 			
				location.reload();
			}		  
		});						
	}	/* if */

}	/* fxn */



function auxThis(id){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "auxThis";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&id='+id+'&sy='+sy,		
		success: function(s) { 			
			var amt = 0;
			if(s.percentage>0){ amt = parseFloat(tuition)*s.percentage/100;
			} else { amt = s.amount; }		
			$('#auxamt0').val(parseFloat(amt).toFixed(2));			
		}		  
	});					
	
	
}	/* fxn */




function deleteTaux(tauxid,i,reload=true,sy){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "deleteTaux";
	$('#btndt'+i).hide();
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&tauxid='+tauxid+'&sy='+sy,		
		success: function() { }		  
	});				
	if(reload){ location.reload(); }

}	/* fxn */




function scidPaymode(i){
	var scid = $('#scid'+i).val();
	var pmid = $('#pmid'+i).val();
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "scidPaymode";
	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&scid='+scid+'&pmid='+pmid+'&sy='+sy,
		success: function() { 			
			location.reload();
		}		  
	});				
	
	
	
}	/* fxn */



