/* dbpanel */

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


function xcount(tbl,i){
	var vurl 	= gurl + '/' + home + '/xcount/';	
	var dbtbl =  db + '.' + tbl;

	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'dbtbl='+dbtbl,						
		success: function(s) { 			
			$("#ctid-"+i).val(s.numrows);
		}		  
    });				
} 	/* fxn */



function xcountAll(){
	$('.tbl').each(function(){
		xcount(this.value,this.id);
	});

}


function xlastIDAll(){
	$('.tbl').each(function(){
		xgetLastID(this.value,this.id);
	});

}


function gotoDB(val){
	var url = gurl+"/"+home+"/dbpanel/"+val;
	window.location.href = url;	
	
}


/* dbsetup */



function dbnewConfirm(){
	var dbnew = $('#dbnew').val();
	return confirm('Create '+dbnew+'?');
}


function xdiff(i){
	var ct1 = $('#ct1-'+i).text();
	var ct2 = $('#ct2-'+i).text();
	var diff = parseInt(ct2) - parseInt(ct1);
	$('#diff-'+i).text(diff);

	
} 	/* fxn */



function xdiffAll(){
	$('.row').each(function(){
		xdiff(this.id);
	});

}


// href='<?php echo URL."$home/tableBackup/$dbone/$dbtwo/$tbl"; ?>'



/* etc */


/* etc */



