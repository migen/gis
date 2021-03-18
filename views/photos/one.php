<?php 

// pr($data);


?>




<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var home = 'advisers';

$(function(){

	hd();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	




function redirContact(ucid){
	var url 		= gurl + '/photos/one/' + ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>


<!---------------------------------------------------------------------------------->

<?php 

// pr($contact);

?>


<h5>
	Photo
	| <a href="<?= URL.$home; ?>" >Home</a>
	<?= isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?= URL."contacts/ucis/$ucid/$sy"; ?>' >UCIS</a>
	| <a href='<?= URL."contacts/edit/$ucid/$sy"; ?>' >Edit</a>
	| <a href='<?= URL."img/getpic/$ucid"; ?>' >Download</a>
	
</h5>

<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>		
</table>


<br />

<table class="screen gis-table-bordered table-fx">

	<?php 
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'classroomPhotos';
		$this->shovel('redirect_classroom',$d); 	
	?>
</table>


<br />



<!---------------------------------------------------------------------------------->


<div class="half" >

<table class="gis-table-bordered table-fx table-altrow"  >
<tr><th></th><td><img src="data:image/jpeg;base64,<?= base64_encode($contact['photo']) ?>" width="150" border="0" /></td></tr>
<tr><th>Name</th><td><?= $contact['name'] ?></td></tr>
<tr><th>ID Number</th><td><?= $contact['code']; ?></td></tr>
<tr><th>Browse</th><td>
<form enctype="multipart/form-data" method="POST">
	<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
	<p><input type="file" name="file_upload" /></p>
	<p><input type="text" name="filename" class="pdl05 vc300" placeholder="Optional: rename" /></p>
	<p><input type="submit" name="submit" value="Upload" /></p>
</form>
</td></tr>

</table>

</div>

<div class="third hd" id="names" > </div>

