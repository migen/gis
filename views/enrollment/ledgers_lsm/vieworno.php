<script>




function printorno(orno){

	var vurl = gurl+'/ajax/xfees.php';	
	var task = "orno";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&orno='+orno,				
		async: true,
		success: function(s) { 
			console.log(s);
			var cs = s.length;
			content = '<table><tr><th>Fee</th><th>Amount</th></tr></table>';
			var ortotal=0;
			var od = $('#ordetails');			
for (var i = 0; i < cs; i++) {			
	ortotal+=parseFloat(s[i].amount);
	content += '<tr><td>'+s[i].feetype+'</td><td>'+s[i].amount+'</td></tr>';
}
			od.html(content);
			$('#ortotal').html(ortotal);
			PrintElem('#ornopage');						

		}		  
    });				
	
	
	
}	/* fxn */




</script>