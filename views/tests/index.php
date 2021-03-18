<?php 

	// pr($_SESSION['q']);
	// pr($data);
	// pr($ucis);
	

	
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
	var url 		= gurl + '/tests/tc/' + ucid;	
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
	Test
	| <a href="<?php echo URL.$home; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

			
</h5>



<form method="POST" >

<input class="pdl05" name="key" value="" placeholder="name" />

<input type="submit" name="submit" value="Update" />
<input type="submit" name="submit" value="Finalize" />




</form>





<div class="hd" id="names" > </div>
