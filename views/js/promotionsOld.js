
function same(cls,val){
	$('.'+cls).val(val);
}

function tally(cls,val){
	var numcls=0;
	$('.'+cls).each(function(){
		if(this.value == val) numcls+=1;		
	});	
	$('.t'+cls).val(numcls);	
}


// !$.isNumeric(val)
function ave(cls){
	var sumcls=0;
	var numcls=0;
	var avecls=0;
	$('.'+cls).each(function(){
		numcls++;
		sumcls+=parseFloat(this.value);		
	});
	avecls = sumcls / numcls;
	if(!$.isNumeric(avecls)) avecls=0; 
	$('.a'+cls).val(avecls.toFixed(2));	
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



function yearend(year){
	var ye = parseInt(year)+1;
	$('#yearend').text(ye);
}


function clsAdvi(){
	populateColumn('cr');
	setClassrooms();	
}	// fxn

function setClassrooms(){	
	$('.cr').each(function(){
		thisAdvi(this.id,this.value);
	})

}	// fxn



function thisAdvi(i,crid){
	// var vurl 	= gurl + '/advisers/clsAdvi';		
	var vurl = gurl+'/ajax/xadvisers.php';		
	var task = "clsAdvi";
	
	// alert(vurl);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid+'&task='+task,				
		async: true,
		success: function(s) { 
			$('#advi'+i).val(s.acid);							
			$('#lvl'+i).val(s.level_id);							
		}		  
    });				

}	/* fxn */


function thisAdviPromote(i,crid,lvl){
	// var vurl 	= gurl + '/advisers/clsAdvi';		
	var vurl = gurl+'/ajax/xadvisers.php';		
	var task = "clsAdvi";
	
	// alert(vurl);
		
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'crid='+crid+'&task='+task,				
		async: true,
		success: function(s) { 
			$('#lvl'+i).val(s.level_id);
			if(lvl==s.level_id){  
				$('#prom-'+i).val(0);
				$('#bage-'+i).removeClass('pbage');
				$('#gage-'+i).removeClass('pgage');
				$('#bage-'+i).removeClass('pmage');
				$('#gage-'+i).removeClass('pmage');				
			} else { 
				$('#prom-'+i).val(1); 
				$('#bage-'+i).addClass('pbage');
				$('#gage-'+i).addClass('pgage');				
				$('#bage-'+i).addClass('pmage');
				$('#gage-'+i).addClass('pmage');								
			}			
		}		  
    });				

}	/* fxn */


function tallyUnitsTotal(i){
	var up = $('#unitsprev-'+i).val();
	var uc = $('#unitscurr-'+i).val();
	var ut = parseFloat(up) + parseFloat(uc);
	$('#unitstotal-'+i).val(ut);
}

function tallyProm0(){

	// tally promoted
	tally('mle',1);
	tally('grl',0);
	tally('stud',1);
			
	// tally promoted
	tally('iprob',1);
	tally('iprog',1);
	tally('iprom',1);
	
	// tally age
	sum('bage');
	sum('gage');
	sum('age');	
		
	sum('pbage');
	sum('pgage');
	sum('pmage');


	// tally age
	ave('bage');
	ave('gage');
	ave('age');	
		
	// tally age
	ave('pbage');
	ave('pgage');
	ave('pmage');
	
	
	
}


function tallyAge(){


}

function xRegular(i,val){
	var len = val.length;
	if(len>1){ $('#reg-'+i).val(0);	} 
	else { if($('#previnc-'+i).val()=='') { $('#reg-'+i).val(1); }	}
	
}




