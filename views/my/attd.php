<?php 

	// pr($_SESSION['q']);
	// pr($data);
	// pr($ucis);
	
	$readonly = ($is_employee)? false:true;			


	
?>


<style>
#names{ 
	padding-left:30px;
	width:500px;
    background-color: white;
    overflow: auto;	
    top: 120px;
    bottom: 20px;

}

</style>

<!-- ------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo $home; ?>';

$(function(){
	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	




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
			for (var i = 0; i < cs; i++) {			
				content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="redirContact(this.id);return false;" >'+s[i].code+'</span> - '+s[i].name+'</p>';
			}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}

function redirContact(ucid){
	var url 		= gurl + '/attendance/attd/' + ucid;	
	window.location = url;		
}

function closeFilter(){
	$('#names').hide();
}




</script>

<!------------------------------------------------------------------------------------------------->

<?php 


?>

<h5 class="screen" >
	Attendance 
	| <a href='<?php echo URL."attendance/attd/$ucid/$today"; ?>' >Date</a> 
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

			
</h5>



<?php if(is_null($ucid)){ exit; } ?>

<?php if($mis || $reg || $guid): ?>
<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>		
</table>
<?php endif; ?>



<div class="half" >
<?php 

// pr($data);

?>

<br />
<table class="gis-table-bordered table-fx table-altrow"  >
<tr><th class="vc120" >Name</th><td class="vc300" ><?php echo $user['fullname']; ?></td></tr>
<tr><th>ID Number</th><td><?php echo $user['code']; ?></td></tr>
<tr><th>Date</th><td><?php echo $date; ?></td></tr>
<tr><th>Role</th><td><?php echo $user['role']; ?></td></tr>
<tr><th>Time In</th><td><?php echo $attd['timein']; ?></td></tr>
<tr><th>Time Out</th><td><?php echo $attd['timeout']; ?></td></tr>

</table>
</div>

<div class="hd" id="names" > </div>
