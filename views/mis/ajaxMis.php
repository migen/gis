<h3>
	MIS Ajax | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 
$dbo=PDBO;
$dbtable="{$dbo}.00_contacts";
pr($dbtable);
?>

<input id="part" autofocus >
<input onclick="xgetContactsByPart(20);" type="submit" name="submit" value="Filter" >

<button onclick='ajaxProcess("<?php echo $dbtable; ?>");' >Ajax Process</button>

<div id="names" >names</div>

<script>

var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";

$(function(){
	
	
})
 
	
function ajaxProcess(dbtable){
	var vurl=gurl+'/mis/ajaxProcess';	
	$.ajax({
		url:vurl,dataType:"json",type:"POST",async:true,
		data: 'dbtable='+dbtable,						
		success: function(s) { // console.log(s);
			$("#names").text(s.numrows);
		}		  
    });				
} 	/* fxn */



function redirContact(ucid){
	alert("redirContact: "+ucid);
	
}




</script>

<script src="<?php echo URL.'views/js/filters.js'; ?>" ></script>