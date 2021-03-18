<?php 

// pr($data);


?>



<h5>
	<a href="<?= URL.'mis'; ?>" > Home </a>
	<?= isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>


<p>


<table id="tbl-1" class="gis-table-bordered " >

<tr class="hd bg-blue2" ><th colspan="2" >HD Filter</th></tr>
<tr><th class="bg-gray3" >Name | Surname</th><td>
<input class="pdl05" id="part" autofocus  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />
</td></tr>

<tr><th class="bg-gray3" > ID Number</th><td>
<input class="pdl05" id="codes"  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" />
</td></tr>


</table></p>




<!---------------------------------------------------------------------------------->

<?php if($id): ?>

<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >
<tr><th>Name</th><td><?= $contact['name'] ?></td></tr>
<tr><th>ID Number | 
<a href='<?php echo URL."codename/one/".$contact['parent_id']; ?>' >Edit</a>
</th><td><?= $contact['code']; ?></td></tr>
<?php if($contact['code']!=$contact['account']): ?>
	<tr><th>Login</th><td><?= $contact['account']; ?></td></tr>
<?php endif; ?>
<tr><th>User-Pass</th><td><?= $contact['account'].'-'.$contact['ctp']; ?></td></tr>
<tr><th>Encrypted Password</th><td><?= $contact['pass']; ?></td></tr>
<tr><th>Clear Password</th><td><?= $contact['ctp']; ?></td></tr>
<tr><th>MD5 CTP</th><td><?= MD5($contact['ctp']); ?></td></tr>
<tr><th>New Pass</th><td><input name="data[newpass]" value="<?php echo $contact['ctp']; ?>" /></td></tr>
<tr><th>Confirm Pass</th><td><input name="data[newpass2]" value="<?php echo $contact['ctp']; ?>"  /></td></tr>
<tr><td colspan="2" class="center underline"  > <span onclick="tracehd();" >Etc</span> </td></tr>
<tbody class="" >

<tr class="" ><th>Login (Account)</th><td><input name="data[account]" value="<?php echo $contact['account']; ?>"   /></td></tr>
<tr class="" ><th>ID No (Code)</th><td><input name="data[code]" value="<?php echo $contact['code']; ?>"   /></td></tr>
<tr>
<th>TRP</th>
<td>
	<input class="vc50" type="text" name="data[title_id]" value="<?php echo $contact['title_id']; ?>" />
	<input class="vc50" type="text" name="data[role_id]" value="<?php echo $contact['role_id']; ?>" />
	<input class="vc50" type="text" name="data[privilege_id]" value="<?php echo $contact['privilege_id']; ?>" />
</td>
</tr>

</tbody>

</table>

<br />
<p>
	<input type="submit" name="submit" value="Update"   />
	<button><?= isset($_SERVER['HTTP_REFERER'])? '<a class="no-underline" href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?></button>				
</p>

</form>


<?php endif; ?>


<div class="hd" id="names" > </div>






<!------------------------------------------------------------------------------------------>


<script>
var gurl = 'http://<?php echo GURL; ?>';


$(function(){
	// alert(gurl+sy+home);
	// alert(gurl);
	hd();
	$('html').live('click',function(){
		$('#names').hide();
	});


})


function redirContact(ucid){
	var url 		= gurl + '/mgt/pass/' + ucid;	
	window.location = url;		
}



</script>



<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>