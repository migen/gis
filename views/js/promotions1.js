
/* b - boy,g - girl,m - mixed */



function xeditSectioning(i,scid){
	var vurl = gurl + '/ajax/xsections.php';	
	var task = "xeditSectioning";
	var scid = $('input[name="students['+i+'][scid]"]').val();
	var is_active  = $('input[name="students['+i+'][is_active]"]').val();
	var sy  = $('input[name="students['+i+'][sy]"]').val();
	var crid = $('select[name="students['+i+'][crid]"]').val();
	var male  = $('input[name="students['+i+'][is_male]"]').val();
	var pdata  = "task="+task+"&scid="+scid+"&is_active="+is_active+"&sy="+sy+"&psy="+psy;
		pdata += "&crid="+crid+"&male="+male;
		
	$('#btn'+i).hide();	
	$.ajax({ 
		type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
}	




function same(cls,val){
	$('.'+cls).val(val);
}

function tally(cls,dv){
	var numcls=0;
	$('.'+cls).each(function(){
		if(this.value == dv) numcls+=1;		
	});
	$('.t'+cls).val(numcls);	
}

function tallyAll(cls){
	var numcls=0;
	$('.'+cls).each(function(){
		numcls+=1;		
	});
	$('.t'+cls).val(numcls);	
}


function sum(cls){
	var sumcls=0;
	$('.'+cls).each(function(){
		sumcls+=parseFloat(this.value);		
	});
	$('.t'+cls).val(sumcls);	
}


function ave(cls){
	var sumcls=0;
	var numcls=0;
	var avecls=0;
	$('.'+cls).each(function(){
		numcls++;
		sumcls+=parseInt(this.value);		
	});
	avecls = sumcls / numcls;
	$('.a'+cls).val(avecls.toFixed(2));	
}


function yearend(year){
	var ye = parseInt(year)+1;
	$('#yearend').text(ye);
}


function clsAdvi(sy){
	populateColumn('cr');
	setClassrooms(sy);	
}	

function setClassrooms(sy){	
	$('.cr').each(function(){
		thisAdvi(this.id,this.value,sy);
	})

}	



function thisAdvi(i,crid,sy){
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "clsAdvi";	
		
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&crid='+crid,				
		async: true,
		success: function(s) { 
			$('#advi'+i).val(s.acid);							
			$('#lvl'+i).val(s.level_id);		
		}		  
    });				

}	/* fxn */


function thisAdviPromote(i,crid,lvl){
	var vurl = gurl+'/ajax/xsections.php';		
	var task = "clsAdvi";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&crid='+crid,				
		async: true,
		success: function(s) { 
			$('#advi'+i).val(s.acid);							
			$('#lvl'+i).val(s.level_id);
			if(lvl==s.level_id){  $('#prom-'+i).val(0);
			} else { $('#prom-'+i).val(1); }			
		}		  
    });				

}	


function tallyProm(){
	alert('tall prom');
}

function tallyProm1(){
	// tally promoted
	// tally('iprob',1);
	tally('iprog',1);
	tally('iprom',1);
	
	// tally retained
	tally('oprob',0);
	tally('oprog',0);
	tally('oprom',0);	
	
	// tally retained
	tally('iregb',0);
	tally('iregg',0);
	tally('ireg',0);
	
	tallyAll('mle');
	tallyAll('grl');
	tallyAll('std');
	
	prepRatings();
	
}

function xRegular(i,val){
	var len = val.length;
	if(len>1){ $('#reg-'+i).val(0);	} 
	else { if($('#previnc-'+i).val()=='') { $('#reg-'+i).val(1); }	}
	
}


function prepRatings(){
	// Legend: ctbA - count boys dgA,cttA - count total dgA 
	var ctbA=0,ctbP=0,ctbAP=0,ctbD=0,ctbB=0;
	var ctgA=0,ctgP=0,ctgAP=0,ctgD=0,ctgB=0;
	var dg;

	// boys
	$('.dgb').each(function(){
		dg = $(this).text();
		if(dg=='a' || dg=='A'){ ctbA++; 
		} else if(dg=='p' || dg=='P'){ ctbP++; 
		} else if(dg=='ap' || dg=='AP'){ ctbAP++; 
		} else if(dg=='d' || dg=='D'){ ctbD++; 
		} else if(dg=='b' || dg=='B'){ ctbB++; }	
	});
	
	// girls
	$('.dgg').each(function(){
		dg = $(this).text();
		if(dg=='a' || dg=='A'){ ctgA++; 
		} else if(dg=='p' || dg=='P'){ ctgP++; 
		} else if(dg=='ap' || dg=='AP'){ ctgAP++; 
		} else if(dg=='d' || dg=='D'){ ctgD++; 
		} else if(dg=='b' || dg=='B'){ ctgB++; }	
	});
	
	
	var cttA  = ctbA  + ctgA;
	var cttP  = ctbP  + ctgP;
	var cttAP = ctbAP + ctgAP;
	var cttD  = ctbD  + ctgD;
	var cttB  = ctbB  + ctgB;
	
	
	$('.tdgbB').val(ctbB);
	$('.tdgbD').val(ctbD);
	$('.tdgbAP').val(ctbAP);
	$('.tdgbP').val(ctbP);
	$('.tdgbA').val(ctbA);

	$('.tdggB').val(ctgB);
	$('.tdggD').val(ctgD);
	$('.tdggAP').val(ctgAP);
	$('.tdggP').val(ctgP);
	$('.tdggA').val(ctgA);
	
	$('.tdgtB').val(cttB);
	$('.tdgtD').val(cttD);
	$('.tdgtAP').val(cttAP);
	$('.tdgtP').val(cttP);
	$('.tdgtA').val(cttA);
	

}



