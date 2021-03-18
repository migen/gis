<?php

// pr($_SESSION['q']);

?>

<h5>

	Roster
	<?php echo ($suppid)? ' - '.$supplier['name']:NULL; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" onclick="ilabas('batch');" >Batch</a>
	| <a class="u" id="btnExport" >Excel</a> 


</h5>

<div id="names" >names</div>

<?php 

$incs = SITE.'views/products/incs/assign_filter.php';
include_once($incs);




if($suppid){
	$incs = SITE.'views/products/incs/assign_table.php';
	include_once($incs);

} 


?>

<div class="ht50 clear"></div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var suppid = "<?php echo $suppid; ?>";

$(function(){
	excel();
	itago('batch');
	$('#names').hide();
	$('html').live('click',function(){
		$('#names').hide();
	});


})	/* fxn */


function redirLookup(prid){

	$('#prid').val(prid);	
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "xgetProductByPrid";	
		
	$.post(vurl,{task:task,prid:prid},function(s){	
		$('#part').val(s.name);		
		$('#cost').val(s.cost);		
		$('#barcode').val(s.barcode);		
	},'json');	


}	/* fxn */



function redirContact(ucid){
	var url = gurl + '/products/roster/' + ucid;		
	window.location = url;			
		
}


function xassignPS(){
	var prid = $('#prid').val();
	var cost = $('#cost').val();	
	var name = $('#part').val();	
	var barcode = $('#barcode').val();	
	// alert('prid: '+prid+', cost: '+cost+', suppid: '+suppid);

	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "xaddSupplier";			
	var pdata  = "task="+task+"&suppid="+suppid+"&cost="+cost+"&prid="+prid;

	$.ajax({
	  type: 'POST',url: vurl,data: pdata,
	  success:function(){
		$("#form")[0].reset();		
		$('#tblExport').append('<tr><td>'+prid+'</td><td>'+barcode+'</td><td>'+name+'</td><td class="right">'+cost+'</td><td></td></tr>');
		$('#part').focus();	  
	  } 
	});				

}	/* fxn */


function xdeleteSupplier(psid,i){

	// if (confirm('Sure?')){
	$('#tr'+i).remove();
	var vurl = gurl+'/ajax/xproducts.php';		
	var task = "xdeleteSupplier";			
	$.post(vurl,{task:task,psid:psid},function(){});		
	// }
	return false;
	

}	/* fxn */


</script>




<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
