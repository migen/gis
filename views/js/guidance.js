function xgetLastID(tbl,i){
	var vurl 	= gurl + '/' + home + '/xgetLastID/';	
	var dbtbl =  db + '.' + tbl;

	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'dbtbl='+dbtbl,						
		success: function(s) { 			
			$("#lid-"+i).val(s.numrows);
		}		  
    });				
} 	/* fxn */




function xcountStudentsByTeacher(tcid,i){
	var params  = dbg + '/' + dbm + '/' + tcid;
	var vurl 	= gurl + '/guidance/xcountStudentsByTeacher/'+params;	

	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		success: function(s) { 			
			$("#numasors-"+i).val(s.numrows);
		}		  
    });				
} 	/* fxn */


function xcountStudentsByTeachersAll(){
	$('.tbl').each(function(){
		xcountStudentsByTeacher(this.value,this.id);
	});
	
}
