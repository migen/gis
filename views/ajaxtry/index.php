xajax here

<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbg = PDBG;

switch($_POST['task']){

case "removeStudentFromClub":
	$scid=$_POST['scid'];
	$q = " UPDATE {$dbg}.05_summaries SET club_id=0 WHERE `scid`='$scid' LIMIT 1; ";
	$_SESSION['q']=$q;
	$db->querysoc($q);
	break;
	
default:
	break;


}	/* switch */



?>

<!----------------->


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy	 = "<?php echo $sy; ?>";
var home = "<?php echo 'clubs'; ?>";


$(function(){
	itago('clipboard');
	

})


/* json */
function removeStudentFromClub1(i,scid){
	var vurl 	= gurl + '/ajax/xclubs.php';	
	var task	= "removeStudentFromClub";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: "scid="+scid+"&task="+task,				
		success: function() { 			
			$('#btn-'+i).hide();
		}		  
    });				
	
}	/* fxn */


/* no json value returned here */
function removeStudentFromClub(i,scid){
	var vurl 	= gurl + '/ajax/xclubs.php';	
	var task	= "removeStudentFromClub";		
	$.ajax({
		url: vurl,type: "POST",data: "scid="+scid+"&task="+task,				
		success: function() { $('#btn-'+i).hide(); alert(1); }		  
    });					
	
}	/* fxn */


function redirContact(id){
	$('#names').hide();
	$('#id').val(id);
	var vurl=gurl+'/ajax/xplayers.php';	
	var task="xgetPlayerByID";		
	$.ajax({
		url: vurl,type:'POST',dataType:"json",async:true,data:'id='+id+'&task='+task,				
		success: function(s) { 
			$('#name').val(s.name); 
			alert(s.name);
		}		  
    });					
		

}	/* fxn */



</script>