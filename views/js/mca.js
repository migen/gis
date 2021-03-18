
function xyz(){
	alert('xyz');
}

/* mis-mca */
function xeditCq(i,supsubjid){
	// alert(sy);
	$('#csb'+i).hide();
	var sy = $('#sy').val();
	var qtr 	= $('#qtr').val();
	var crsid 	= $('#crsid'+i).val();
	var crid 	= $('#crid'+i).val();
	var cq1 	= $('#cq1'+i).val();
	var cq2 	= $('#cq2'+i).val();
	var cq3 	= $('#cq3'+i).val();
	var cq4 	= $('#cq4'+i).val();
	var cq5 	= $('#cq5'+i).val();
	var cq6 	= $('#cq6'+i).val();
	// var vurl = gurl + '/admins/xeditCq/'+crsid+'/'+crid+'/'+supsubjid;	
	var vurl = gurl+'/ajax/xmca.php';		
	var task = "xeditCq";
	var pdata = "task="+task+"&qtr="+qtr+"&cq1="+cq1+"&cq2="+cq2+"&cq3="+cq3+"&cq4="+cq4+"&cq5="+cq5+"&cq6="+cq6;
	pdata += "&crid="+crid+"&crsid="+crsid+"&supsubjid="+supsubjid+"&sy="+sy;

	$.ajax({
	  type: 'POST',url: vurl,data: pdata,success:function(){} 
	});				
	
}	




/* mca */

function xeditAq(i){
	$('#asb'+i).hide();
	var sy 	= $('#sy').val();
	var qtr 	= $('#qtr').val();
	var acrid 	= $('#acrid'+i).val();
	var aq1 	= $('#aq1'+i).val();
	var aq2 	= $('#aq2'+i).val();
	var aq3 	= $('#aq3'+i).val();
	var aq4 	= $('#aq4'+i).val();
	var aq5 	= $('#aq5'+i).val();
	var aq6 	= $('#aq6'+i).val();
	var vurl = gurl+'/ajax/xmca.php';		
	var task = "xeditAq";
	var pdata = "task="+task+"&qtr="+qtr+"&aq1="+aq1+"&aq2="+aq2+"&aq3="+aq3+"&aq4="+aq4+"&aq5="+aq5;
	pdata+="&aq6="+aq6+"&acrid="+acrid+"&sy="+sy;
	
	$.ajax({
	  type: 'POST',url: vurl,
	  data: pdata,	  	  			  
	  success:function(){} 
   });				
	
}	


function adminsxeditAq(i){
	$('#asb'+i).hide();
	var qtr 	= $('#qtr').val();
	var aqid 	= $('#aqid'+i).val();
	var aq1 	= $('#aq1'+i).val();
	var aq2 	= $('#aq2'+i).val();
	var aq3 	= $('#aq3'+i).val();
	var aq4 	= $('#aq4'+i).val();
	var aq5 	= $('#aq5'+i).val();
	var aq6 	= $('#aq6'+i).val();
	var vurl = gurl + '/admins/xeditAq/'+aqid;	
		
	// alert(vurl+','+aqid +','+aq1+','+aq2+','+aq3+','+aq4);

	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "qtr="+qtr+"&aq1="+aq1+"&aq2="+aq2+"&aq3="+aq3+"&aq4="+aq4+"&aq5="+aq5+"&aq6="+aq6,	  	  			  
	  success:function(){} 
   });				
	
}	



function xeditAttq(i){

	$('#attsb'+i).hide();
	var qtr 	= $('#qtr').val();
	var acrid 	= $('#acrid'+i).val();
	var attq1 	= $('#attq1'+i).val();
	var attq2 	= $('#attq2'+i).val();
	var attq3 	= $('#attq3'+i).val();
	var attq4 	= $('#attq4'+i).val();
	var attq5 	= $('#attq5'+i).val();
	var attq6 	= $('#attq6'+i).val();
	// var vurl = gurl + '/admins/xeditAttq';	
	var vurl = gurl+'/ajax/xmca.php';		
	var task = "xeditAttq";
	
$.ajax({
  type: 'POST',
  url: vurl,
  data: "task="+task+"&qtr="+qtr+"&attq1="+attq1+"&attq2="+attq2+"&attq3="+attq3+"&attq4="+attq4+"&attq5="+attq5+"&attq6="+attq6+"&acrid="+acrid,
  success:function(){} 
});				
	

}	



function xeditHonorLocking(i){
	$('#hsb'+i).hide();
	var acrid 	= $('#acrid'+i).val();
	var ifh 	= $('#ifh'+i).val();
	var vurl = gurl+'/ajax/xmca.php';		
	var task = "xeditHonorLocking";
		
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "task="+task+"&ifh="+ifh+"&acrid="+acrid,	  	  			  
	  success:function(){} 
   });				


}	




function xeditPromotionLocking(i){
	$('#psb'+i).hide();
	var acrid 	= $('#acrid'+i).val();
	var ifp 	= $('#ifp'+i).val();
	var vurl = gurl+'/ajax/xmca.php';		
	var task = "xeditPromotionLocking";
	
	
	$.ajax({
	  type: 'POST',
	  url: vurl,
	  data: "task="+task+"&ifp="+ifp+"&acrid="+acrid,	  	  			  
	  success:function(){} 
   });				

}	



