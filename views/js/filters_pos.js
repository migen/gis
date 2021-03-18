/* filter product by part onclick product from results */
function doProduct(prodid,rid){		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByID";	

	$.post(vurl,{task:task,prodid:prodid},function(s){		
		$('#type'+rid).val(s.prodtype_id);
		$('#barcode'+rid).val(s.barcode);
		$('input[name="positems['+rid+'][combo]"]').val(s.combo);			
		$('select[name="positems['+rid+'][product_id]"]').val(s.id);		
		$('input[name="positems['+rid+'][price]"]').val(s.price);		
		$('input[name="positems['+rid+'][amount]"]').val(s.price);		
		$('input[name="positems['+rid+'][qty]"]').val(1);		
		$('input[name="positems['+rid+'][io]"]').val(1);		
	},'json');		
		
}	/* fxn */	


function xgetProductByBarcode(rid){
	var barcode = $('#barcode'+rid).val();		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByBarcode";	
		
	$.post(vurl,{task:task,barcode:barcode},function(s){		
		$('#pcat'+rid).val(s.prodcategory_id);
		$('select[name="positems['+rid+'][product_id]"]').val(s.id);		
		$('input[name="positems['+rid+'][price]"]').val(s.price);		
		$('input[name="positems['+rid+'][amount]"]').val(s.price);		
		$('input[name="positems['+rid+'][qty]"]').val(1);		
		$('input[name="positems['+rid+'][io]"]').val(1);		
	},'json');	
	newrow();		
}	/* fxn */	


function xgetProductsByPart(rid){
	var part = $('#product'+rid).val();	
	
	var vurl = gurl+'/ajax/xpos.php';	
	var task = "xgetProductsByPart";
	
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
  content+='<p><span class="txt-blue b u" onclick="doProduct('+s[i].id+','+rid+');return false;" >'+s[i].name+'-'+s[i].barcode+'</span>-'+s[i].id+'</p>';
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

