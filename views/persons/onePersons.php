

<h5>
	<span ondblclick="tracehd();" >Person</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					

</h5>


<p><?php $this->shovel('hdpdiv'); ?></p>


<table class="screen gis-table-bordered table-fx" >	
<tr>
	<td class="vc200" ><input name="name" id="part" class="pdl05 full" placeholder="Name" autofocus /></td>
	<td class="vc100" ><input type="submit" name="find" class="full" 
		onclick="xgetContactsByPart();return false;" value="Filter" /></td>
</tr>		
</table><br />


<div class="half" >

<table class="gis-table-bordered"  >
<tr><th><a href='<?php echo URL."photos/one/".$person['parent_id']; ?>' >Photo</a></th>
	<td></td></tr>
<tr><th>UCID</th><td><?php echo $person['contact_id']; ?></td></tr>
<tr><th>Person</th><td><?php echo $person['person']; ?></td></tr>
<tr class="hd" ><th>First</th><td><?php echo $person['first_name']; ?></td></tr>
<tr class="hd" ><th>Last</th><td><?php echo $person['last_name']; ?></td></tr>
<tr><th>Role</th><td><?php echo $person['role']; ?></td></tr>
<tr><th>Active</th><td><?php echo ($person['is_active']==1)?'Yes':'No'; ?></td></tr>
<tr><th>Cleared</th><td><?php echo ($person['is_cleared']==1)?'Yes':'No'; ?></td></tr>
<tr><th>Gender</th><td><?php echo ($person['is_male']==1)?'Male':'Female'; ?></td></tr>
<tr><th>SMS</th><td><?php echo $person['sms']; ?></td></tr>
<tr><th>Email</th><td><?php echo $person['email']; ?></td></tr>
<tr><th>Address</th><td><?php echo $person['address']; ?></td></tr>
<tr class="hd" ><th>Pass</th><td><?php echo $person['ctp']; ?></td></tr>



</table>

<div class="hd" ><?php pr($person); ?></div>

</div>

<div class="hd" id="names" > </div>



<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	






function redirContact(ucid){
	var url 		= gurl + '/persons/one/' + ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>